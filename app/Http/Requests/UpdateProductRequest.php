<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil produk yang sedang diedit dari route
        $product = $this->route('product');

        return [
            'name' => 'required|string|max:255',
            // Ignore ID produk ini saat cek unique SKU
            'sku' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock_current' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'storage_location' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }
}