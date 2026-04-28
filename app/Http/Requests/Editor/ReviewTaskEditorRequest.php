<?php

namespace App\Http\Requests\Editor;

use Illuminate\Foundation\Http\FormRequest;

class ReviewTaskEditorRequest extends FormRequest
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
            'file_status' => 'required|in:pending,approved,rejected,revision',
            'revision_notes' => 'nullable|string|max:1000',
            'file_revisi' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ];
    }

    public function messages(): array
    {
        return [
            'file_status.required' => 'Status file harus diisi.',
            'file_status.in' => 'Status file tidak valid.',

            'revision_notes.max' => 'Catatan revisi maksimal 1000 karakter.',

            'file_revisi.mimes' => 'Format file revisi harus PDF, DOC, atau DOCX.',
            'file_revisi.max' => 'Ukuran file revisi maksimal 10MB.',
        ];
    }
}
