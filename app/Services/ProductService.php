<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductService
{
    public function store(array $validatedData): Product
    {
        if (isset($validatedData['image_path'])) {
            $validatedData['image_path'] = $validatedData['image_path']->store('product_images', 'public');
        }
        return Product::create($validatedData);
    }
    public function getProductsWithFilters(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('stock_status')) {
            $status = $request->stock_status;

            if ($status === 'out_of_stock') {
                $query->where('stock_current', 0);
            } elseif ($status === 'low_stock') {
                $query->whereColumn('stock_current', '<=', 'stock_minimum')
                    ->where('stock_current', '>', 0);
            } elseif ($status === 'available') {
                $query->whereColumn('stock_current', '>', 'stock_minimum');
            }
        }

        $sort = $request->get('sort', 'created_at'); 
        $direction = $request->get('direction', 'desc');

        $allowedSorts = ['name', 'stock_current', 'created_at', 'price'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        return $query->paginate(10)->withQueryString(); 
    }

    public function update(array $validatedData, Product $product): Product
    {
        if (isset($validatedData['image_path'])) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validatedData['image_path'] = $validatedData['image_path']->store('product_images', 'public');
        }
        $product->update($validatedData);

        return $product;
    }

    public function delete(Product $product): void
    {
        if ($product->stock_current > 0) {
            throw new \Exception('Gagal! Produk ini masih memiliki stok (Stok Saat Ini: ' . $product->stock_current . ').');
        }
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
    }
}