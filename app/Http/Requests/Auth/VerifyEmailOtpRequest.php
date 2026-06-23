<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:6', 'max:6', 'regex:/^[0-9]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode OTP wajib diisi.',
            'code.min' => 'Kode OTP harus 6 digit.',
            'code.max' => 'Kode OTP harus 6 digit.',
            'code.regex' => 'Kode OTP hanya boleh berisi angka.',
        ];
    }
}
