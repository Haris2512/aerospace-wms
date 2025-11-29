<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products', 
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id', 
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_current' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'storage_location' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $this->productService->store($validated);
        return redirect()->route('products.index')
            ->with('success', 'Produk (Komponen Dirgantara) berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_current' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'storage_location' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $this->productService->update($validated, $product);
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
}