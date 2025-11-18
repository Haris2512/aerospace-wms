<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     * (Kita bisa tambahkan logika role 'staff' di sini nanti)
     */
    public function authorize(): bool
    {
        return true; // Izinkan dulu untuk sekarang
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        // PINDAHKAN SEMUA ATURAN DARI CONTROLLER KE SINI
        return [
            'type' => 'required|in:incoming,outgoing',
            'transaction_date' => 'required|date',
            'supplier_id' => 'nullable|required_if:type,incoming|exists:users,id',
            'customer_name' => 'nullable|required_if:type,outgoing|string|max:255',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}