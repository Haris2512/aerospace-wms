<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest; 

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getProductsWithFilters($request);
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->store($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk (Komponen Dirgantara) berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'transactions' => function ($query) {
                $query->latest('transaction_date')->take(5);
            }
        ]);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($request->validated(), $product);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->delete($product);
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', $e->getMessage());
        }
    }

    public function printQr(Product $product)
    {
        return view('products.print-qr', compact('product'));
    }       
}