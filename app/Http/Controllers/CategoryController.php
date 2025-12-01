<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService; 

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi input 
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        // 2. Serahkan logika bisnis ke Service
        $this->categoryService->store($validated);

        // 3. Kembalikan response
        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        // 2. Serahkan logika bisnis ke Service
        $this->categoryService->update($validated, $category);

        // 3. Kembalikan response
        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        try {
            $this->categoryService->delete($category);
            return redirect()->route('categories.index')
                            ->with('success', 'Kategori berhasil dihapus.');
        
        } catch (\Exception $e) {
            return redirect()->route('categories.index')
                            ->with('error', $e->getMessage());
        }
    }
}