<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Menangani logika penyimpanan produk baru.
     *
     * @param array $validatedData Data dari $request->validate()
     * @return Product Model Produk yang baru dibuat
     */
    public function store(array $validatedData): Product
    {
        // 1. Cek jika user mengupload gambar
        if (isset($validatedData['image_path'])) {
            // Simpan gambar ke 'storage/app/public/product_images'
            $validatedData['image_path'] = $validatedData['image_path']->store('product_images', 'public');
        }

        // 2. Simpan data ke database
        return Product::create($validatedData);
    }

    /**
     * Menangani logika update produk.
     *
     * @param array $validatedData Data dari $request->validate()
     * @param Product $product Produk yang akan diupdate
     * @return Product Model Produk yang sudah diupdate
     */
    public function update(array $validatedData, Product $product): Product
    {
        // 1. Cek jika ada gambar BARU yang di-upload
        if (isset($validatedData['image_path'])) {
            // Hapus gambar LAMA dari storage, jika ada
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Simpan gambar baru
            $validatedData['image_path'] = $validatedData['image_path']->store('product_images', 'public');
        }

        // 2. Update data di database
        $product->update($validatedData);
        
        return $product;
    }

    /**
     * Menangani logika hapus produk.
     *
     * @param Product $product Produk yang akan dihapus
     * @return void
     * @throws \Exception Jika produk masih memiliki stok (sesuai PDF)
     */
    public function delete(Product $product): void
    {
        // 1. Validasi Sesuai PDF: "Sistem akan memberi warning jika produk masih memiliki stok." 
        if ($product->stock_current > 0) { 
            throw new \Exception('Gagal! Produk ini masih memiliki stok (Stok Saat Ini: ' . $product->stock_current . ').');
        }

        // 2. Hapus file gambar dari storage
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // 3. Hapus data dari database
        $product->delete();
    }
}