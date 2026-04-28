<?php

namespace App\Http\Requests\Master\Promo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromoRequest extends FormRequest
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
            // 'name' => 'required|string|max:255|unique:promos,name,'. $this->promo,
            'code' => 'required|string|max:255|unique:promos,code,'.$this->promo,
            'percentage' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'book_ids' => 'nullable|array',
            'book_ids.*' => 'uuid|exists:books,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'name.required' => 'Nama promo harus diisi.',
            // 'name.unique' => 'Nama promo sudah terdaftar.',

            'code.unique' => 'Kode promo sudah terdaftar.',

            'percentage.required' => 'Diskon promo harus diisi.',
            'percentage.integer' => 'Diskon promo harus berupa angka.',
            'percentage.min' => 'Diskon promo minimal 0.',

            'quantity.required' => 'Jumlah promo harus diisi.',
            'quantity.integer' => 'Jumlah promo harus berupa angka.',
            'quantity.min' => 'Jumlah promo minimal 0.',

            'start_date.required' => 'Tanggal mulai promo harus diisi.',
            'start_date.date' => 'Tanggal mulai promo harus berupa tanggal.',

            'description.string' => 'Deskripsi promo harus berupa teks.',

            'end_date.required' => 'Tanggal selesai promo harus diisi.',
            'end_date.date' => 'Tanggal selesai promo harus berupa tanggal.',
            'end_date.after_or_equal' => 'Tanggal selesai promo harus setelah atau sama dengan tanggal mulai promo.',
        ];
    }
}
