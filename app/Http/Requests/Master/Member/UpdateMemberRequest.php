<?php

namespace App\Http\Requests\Master\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->member->id.',id,deleted_at,NULL',
            'job' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'phone_number' => 'nullable|min:10|max:15|unique:users,phone_number,'.$this->member->id.',id,deleted_at,NULL',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.string' => 'Nama lengkap harus berupa teks.',
            'full_name.required' => 'Nama lengkap harus diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',

            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Email harus berupa format email.',
            'email.required' => 'Email harus diisi.',
            'email.max' => 'Email maksimal 255 karakter.',

            'job.string' => 'Pekerjaan harus berupa teks.',
            'job.max' => 'Pekerjaan maksimal 255 karakter.',

            'degree.string' => 'Pendidikan harus berupa teks.',
            'degree.max' => 'Pendidikan maksimal 255 karakter.',

            'phone_number.min' => 'Nomor telepon minimal 10 digit.',
            'phone_number.max' => 'Nomor telepon maksimal 15 digit.',
            'phone_number.unique' => 'Nomor telepon ini sudah terdaftar.',
        ];
    }
}
