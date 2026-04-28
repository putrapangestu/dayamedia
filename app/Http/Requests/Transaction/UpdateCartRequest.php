<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'type' => 'nullable|in:physical,digital',
            'book_id' => 'required|exists:books,id',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Jumlah buku harus diisi.',
            'quantity.integer' => 'Jumlah buku harus berupa angka.',
            'quantity.min' => 'Jumlah buku minimal adalah 1.',

            'type.in' => 'Jenis buku harus physical atau digital.',

            'book_id.required' => 'ID buku harus diisi.',
            'book_id.exists' => 'Buku dengan ID tersebut tidak ditemukan.',
        ];
    }
}
