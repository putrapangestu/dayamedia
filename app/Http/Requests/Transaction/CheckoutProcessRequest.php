<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutProcessRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.book_id' => 'sometimes|exists:books,id',
            'items.*.module_id' => 'sometimes|exists:modules,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.type' => 'required|in:digital,physical,module',
            'items.*.price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Daftar item harus diisi.',
            'items.array' => 'Daftar item harus berupa array.',
            'items.min' => 'Daftar item minimal memiliki 1 item.',

            'items.*.book_id.sometimes' => 'ID buku harus diisi.',
            'items.*.book_id.exists' => 'Buku dengan ID tersebut tidak ditemukan.',

            'items.*.module_id.sometimes' => 'ID modul harus diisi.',
            'items.*.module_id.exists' => 'Modul dengan ID tersebut tidak ditemukan.',

            'items.*.quantity.required' => 'Jumlah harus diisi.',
            'items.*.quantity.integer' => 'Jumlah harus berupa angka.',
            'items.*.quantity.min' => 'Jumlah minimal adalah 1.',

            'items.*.type.required' => 'Jenis buku harus diisi.',
            'items.*.type.in' => 'Jenis buku harus digital, physical, atau module.',

            'items.*.price.required' => 'Harga buku harus diisi.',
            'items.*.price.numeric' => 'Harga buku harus berupa angka.',
            'items.*.price.min' => 'Harga buku minimal adalah 0.',
        ];
    }
}
