<?php

namespace App\Http\Requests\Master\Editor;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditorRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id',
            'phone_number' => 'nullable|min:10|max:15|unique:users,phone_number,NULL,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa format email.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.string' => 'Email harus berupa huruf',

            'full_name.required' => 'Nama lengkap harus diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            'full_name.string' => 'Nama lengkap harus berupa huruf.',

            'phone_number.unique' => 'Nomor telepon sudah terdaftar.',
            'phone_number.min' => 'Nomor telepon minimal 10 digit.',
            'phone_number.max' => 'Nomor telepon maksimal 15 digit.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.numeric' => 'Nomor telepon harus berupa angka.',
        ];
    }
}
