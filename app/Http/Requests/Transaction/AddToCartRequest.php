<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'book_id' => 'required|exists:books,id',
            'type' => 'nullable|in:physical,digital',
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'ID buku harus diisi.',
            'book_id.exists' => 'Buku dengan ID tersebut tidak ditemukan.',
            'type.in' => 'Jenis buku harus physical atau digital.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal adalah 1.',
        ];
    }
}
