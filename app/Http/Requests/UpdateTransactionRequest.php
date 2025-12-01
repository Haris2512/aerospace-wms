<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_date' => 'required|date',
            'supplier_id' => 'required|required_if:type,incoming|exists:users,id',
            'customer_name' => 'nullable|required_if:type,outgoing|string|max:255',
            'notes' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('type')) {
            $this->merge([
                'type' => $this->route('transaction')->type
            ]);
        }
    }
}