<?php

namespace App\Http\Requests\Master\Book;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            'description' => 'nullable|string',
            'price_digital' => 'nullable|integer|min:0',
            'price_physical' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'code_isbn' => 'nullable|string|max:255|unique:books,code_isbn,NULL,id,deleted_at,NULL',
            'status' => 'required|string|in:open,editing,published,archived,closed',

            'author' => 'nullable|array',
            'author.*' => 'nullable|uuid|exists:users,id',

            'publisher' => 'nullable|string|max:255',
            'year_published' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:255',
            'pages' => 'nullable|integer|min:0',
            'weight' => 'nullable|integer|min:0',

            // File Upload
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'full_content' => 'nullable|file|mimes:pdf|max:51200',
            'half_content' => 'nullable|file|mimes:pdf|max:51200',

            // Foreign Key Relation
            'category_id' => 'required|uuid|exists:categories,id',

            'editor' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'google_scholar_url' => 'nullable|url|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku harus diisi.',
            'title.string' => 'Judul buku harus berupa string.',
            'title.max' => 'Judul buku maksimal 255 karakter.',

            'description.string' => 'Deskripsi buku harus berupa string.',

            // 'price_digital.required' => 'Harga digital buku harus diisi.',
            'price_digital.integer' => 'Harga digital buku harus berupa angka.',
            'price_digital.min' => 'Harga digital buku harus di atas 0.',

            // 'price_physical.required' => 'Harga Cetak buku harus diisi.',
            'price_physical.integer' => 'Harga Cetak buku harus berupa angka.',
            'price_physical.min' => 'Harga Cetak buku harus di atas 0.',

            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku harus di atas 0.',

            'code_isbn.required' => 'Kode ISBN buku harus diisi.',
            'code_isbn.string' => 'Kode ISBN buku harus berupa string.',
            'code_isbn.max' => 'Kode ISBN buku maksimal 255 karakter.',
            'code_isbn.unique' => 'Kode ISBN buku sudah terdaftar.',

            'status.required' => 'Status buku harus diisi.',
            'status.string' => 'Status buku harus berupa string.',
            'status.in' => 'Status buku tidak valid.',

            // 'author.required' => 'Penulis buku harus diisi.',
            'author.array' => 'Penulis buku harus berupa array.',

            // 'author.*.required' => 'Setiap penulis buku harus diisi.',
            'author.*.uuid' => 'Setiap penulis buku harus berupa UUID.',
            'author.*.exists' => 'Setiap penulis buku tidak valid.',

            // 'publisher.required' => 'Penerbit buku harus diisi.',
            'publisher.string' => 'Penerbit buku harus berupa string.',
            'publisher.max' => 'Penerbit buku maksimal 255 karakter.',

            // 'year_published.required' => 'Tahun terbit buku harus diisi.',
            'year_published.integer' => 'Tahun terbit buku harus berupa angka.',
            'year_published.min' => 'Tahun terbit buku harus di atas 0.',

            'language.string' => 'Bahasa buku harus berupa string.',
            'language.max' => 'Bahasa buku maksimal 255 karakter.',

            // 'pages.required' => 'Jumlah halaman buku harus diisi.',
            'pages.integer' => 'Jumlah halaman buku harus berupa angka.',
            'pages.min' => 'Jumlah halaman buku harus di atas 0.',

            // 'weight.required' => 'Bobot buku harus diisi.',
            'weight.integer' => 'Bobot buku harus berupa angka.',
            'weight.min' => 'Bobot buku harus di atas 0.',

            'cover.image' => 'Cover buku harus berupa gambar.',
            'cover.mimes' => 'Cover buku harus berupa file dengan tipe: jpeg, png, jpg, gif, svg.',
            'cover.max' => 'Cover buku maksimal 10MB.',

            'full_content.file' => 'Full content buku harus berupa file.',
            'full_content.mimes' => 'Full content buku harus berupa file dengan tipe: pdf.',
            'full_content.max' => 'Full content buku maksimal 50MB.',

            'half_content.file' => 'Half content buku harus berupa file.',
            'half_content.mimes' => 'Half content buku harus berupa file dengan tipe: pdf.',
            'half_content.max' => 'Half content buku maksimal 50MB.',

            'category_id.required' => 'Kategori buku harus diisi.',
            'category_id.uuid' => 'Kategori buku harus berupa UUID.',
            'category_id.exists' => 'Kategori buku tidak valid.',

            'editor.string' => 'Editor buku harus berupa string.',

            'website.string' => 'Website buku harus berupa string.',
            'website.max' => 'Website buku maksimal 255 karakter.',
            'google_scholar_url.url' => 'Link Google Scholar harus berupa URL yang valid.',
            'google_scholar_url.max' => 'Link Google Scholar maksimal 2048 karakter.',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->price_digital) {
            $this->merge(['price_digital' => 0]);
        }

        if (! $this->price_physical) {
            $this->merge(['price_physical' => 0]);
        }
    }
}
