<?php

namespace App\Http\Requests\Master\Module;

use Illuminate\Foundation\Http\FormRequest;

class CreateModuleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'chapter' => 'required|integer',
            'days' => 'nullable|integer',
            'deadline_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'deadline_type' => 'nullable|in:days,date',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'user_id' => 'nullable|uuid|exists:users,id',
            'book_id' => 'required|uuid|exists:books,id',
            'file' => 'nullable|file|mimes:docx,doc|max:10240', // max 10MB
            'turnitin_file' => 'nullable|file|mimes:pdf|max:5120', // max 5MB
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
            'title.required' => 'Judul harus diisi',
            'title.max' => 'Judul harus kurang dari 255 karakter',
            'title.string' => 'Judul harus berupa string',

            'days.integer' => 'Hari harus berupa integer',

            'chapter.required' => 'Bab harus diisi',
            'chapter.integer' => 'Bab harus berupa integer',

            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga harus lebih dari 0',

            'user_id.uuid' => 'User tidak valid',
            'user_id.exists' => 'User tidak ditemukan',

            'description.string' => 'Deskripsi harus berupa string',

            'book_id.required' => 'Buku harus diisi',
            'book_id.uuid' => 'Buku tidak valid',
            'book_id.exists' => 'Buku tidak ditemukan',

            'file.mimes' => 'File harus berupa DOCX, atau DOC',
            'file.max' => 'File harus kurang dari 10MB',

            'turnitin_file.mimes' => 'File Turnitin harus berupa PDF',
            'turnitin_file.max' => 'File Turnitin harus kurang dari 5MB',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->deadline_date) {
            $this->merge(['deadline' => $this->deadline_date]);
        }
    }
}
