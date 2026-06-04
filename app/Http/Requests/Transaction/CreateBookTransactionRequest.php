<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookTransactionRequest extends FormRequest
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
            'total_price' => 'required|min:1',
            // 'status' => 'required|in:ongoing,completed,canceled',
            'payment_method' => 'nullable',
            // 'transaction_code' => 'required|string|unique:transactions,transaction_code',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'promo_code' => 'nullable|string|max:50',
            'discount_amount' => 'nullable|min:0',
            'admin_fee' => 'nullable|min:0',

            'transaction_details' => 'required|array',
            'transaction_details.*.book_id' => 'sometimes|exists:books,id',
            'transaction_details.*.module_id' => 'sometimes|exists:modules,id',
            'transaction_details.*.quantity' => 'required|integer|min:1',
            'transaction_details.*.price_book' => 'required|integer|min:1',
            'transaction_details.*.price_discount' => 'nullable|integer|min:0',
            'transaction_details.*.type' => 'nullable|in:physical,digital,module',
        ];
    }

    public function messages(): array
    {
        return [
            // 'user_id.required' => 'ID pengguna harus diisi.',
            // 'user_id.exists' => 'Pengguna dengan ID tersebut tidak ditemukan.',

            'total_price.required' => 'Total harga harus diisi.',
            'total_price.integer' => 'Total harga harus berupa angka.',
            'total_price.min' => 'Total harga minimal adalah 1.',

            // 'status.required' => 'Status transaksi harus diisi.',
            // 'status.in' => 'Status transaksi harus ongoing, completed, atau canceled.',

            // 'payment_method.required' => 'Metode pembayaran harus diisi.',
            // 'payment_method.in' => 'Metode pembayaran harus bank_transfer atau credit_card.',

            // 'transaction_code.required' => 'Kode transaksi harus diisi.',
            // 'transaction_code.string' => 'Kode transaksi harus berupa string.',
            // 'transaction_code.unique' => 'Kode transaksi sudah digunakan.',

            // 'payment_proof.required' => 'Bukti pembayaran harus diisi.',
            'payment_proof.file' => 'Bukti pembayaran harus berupa file.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berupa file jpg, jpeg, png, atau pdf.',
            'payment_proof.max' => 'Bukti pembayaran maksimal 2MB.',

            'transaction_details.required' => 'Detail transaksi harus diisi.',
            'transaction_details.array' => 'Detail transaksi harus berupa array.',

            'transaction_details.*.book_id.sometimes' => 'buku harus diisi.',
            'transaction_details.*.book_id.exists' => 'Buku tersebut tidak ditemukan.',

            'transaction_details.*.module_id.sometimes' => 'modul harus diisi.',
            'transaction_details.*.module_id.exists' => 'Modul tersebut tidak ditemukan.',

            'transaction_details.*.quantity.required' => 'Jumlah buku harus diisi.',
            'transaction_details.*.quantity.integer' => 'Jumlah buku harus berupa angka.',
            'transaction_details.*.quantity.min' => 'Jumlah buku minimal adalah 1.',

            'transaction_details.*.type.in' => 'Jenis buku harus physical atau digital.',
        ];
    }
}
