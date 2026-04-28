<?php

namespace App\Http\Requests\Master\Member;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvMemberRequest extends FormRequest
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
            'file' => 'required|mimes:csv,txt|max:51200', // 50MB max
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'Format file harus CSV atau TXT.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 50MB.',
        ];
    }
}
