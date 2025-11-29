<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryService
{

    public function store(array $validatedData): Category
    {
        if (isset($validatedData['image_path'])) {
            $validatedData['image_path'] = $validatedData['image_path']->store('category_images', 'public');
        }

        return Category::create($validatedData);
    }

    public function update(array $validatedData, Category $category): Category
    {
        if (isset($validatedData['image_path'])) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $validatedData['image_path'] = $validatedData['image_path']->store('category_images', 'public');
        }

        $category->update($validatedData);
        
        return $category;
    }

    public function delete(Category $category): void
    {
        if ($category->products()->count() > 0) { 
            throw new \Exception('Gagal! Kategori ini masih memiliki produk terkait.');
        }

        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();
    }
}