<?php

namespace App\Http\Requests\Editor;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileEditorRequest extends FormRequest
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
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
            'file_turnitin' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ];
    }

    public function messages(): array
    {
        return [
            'file_path.required' => 'File editor wajib diunggah.',
            'file_path.file' => 'File editor harus berupa file yang valid.',
            'file_path.mimes' => 'File editor harus berformat PDF, DOC, atau DOCX.',
            'file_path.max' => 'Ukuran file editor maksimal 10MB.',

            // 'file_turnitin.required' => 'File Turnitin wajib diunggah.',
            'file_turnitin.file' => 'File Turnitin harus berupa file yang valid.',
            'file_turnitin.mimes' => 'File Turnitin harus berformat PDF, DOC, atau DOCX.',
            'file_turnitin.max' => 'Ukuran file Turnitin maksimal 10MB.',
        ];
    }
}
