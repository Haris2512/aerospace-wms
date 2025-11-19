<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestockOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Nanti bisa dibatasi hanya untuk role 'manager'
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:users,id', // Harus user yang valid
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            
            // Validasi Daftar Produk yang Dipesan
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}