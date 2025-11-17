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

    public function index()
    {
        // Ambil data, 'with' untuk eager loading (lebih cepat)
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Ambil semua kategori untuk mengisi dropdown di form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input (Tugas Controller) sesuai PDF [cite: 3353-3364]
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products', // SKU harus unik
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id', // Pastikan Kategori ada
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_current' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'storage_location' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        // 2. Serahkan "pekerjaan berat" ke Service
        $this->productService->store($validated);

        // 3. Kembalikan response
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
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'unique' di sini mengabaikan ID $product ini sendiri
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

        // 2. Serahkan "pekerjaan berat" ke Service
        $this->productService->update($validated, $product);

        // 3. Kembalikan response
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        try {
            // 1. Serahkan "pekerjaan berat" ke Service
            $this->productService->delete($product);
            
            return redirect()->route('products.index')
                            ->with('success', 'Produk berhasil dihapus.');
        
        } catch (\Exception $e) {
            // 2. Tangkap error dari Service (misal: "stok masih ada")
            return redirect()->route('products.index')
                            ->with('error', $e->getMessage());
        }
    }
}