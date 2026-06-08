<?php

namespace App\Http\Requests\Master\Module;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileModuleRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf,docx,doc|max:10240', // max 10MB
            'turnitin_file' => 'nullable|file|mimes:pdf|max:5120', // max 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File wajib diunggah.',
            'file.file' => 'Yang diunggah harus berupa file.',
            'file.mimes' => 'Format file tidak valid. Hanya diperbolehkan: pdf, docx, doc.',
            'file.max' => 'Ukuran file maksimal adalah 10MB.',

            'turnitin_file.file' => 'Yang diunggah harus berupa file.',
            'turnitin_file.mimes' => 'Format file tidak valid. Hanya diperbolehkan: pdf.',
            'turnitin_file.max' => 'Ukuran file maksimal adalah 5MB.',
        ];
    }
}
