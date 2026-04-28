<?php

namespace App\Http\Requests\Master\Affiliate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAffiliateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:affiliate_levels,name,'.$this->affiliate_order.',id,deleted_at,NULL',
            'percentage' => 'required|numeric|min:0|max:100',
            'min_earning' => 'required|numeric|min:0|unique:affiliate_levels,min_earning,'.$this->affiliate_order,
            'description' => 'nullable|string',
            'icon' => 'nullable|mimes:jpg,jpeg,png|max:2048',
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
            'name.required' => 'Nama level affiliate harus diisi.',
            'name.max' => 'Nama level affiliate maksimal 255 karakter.',
            'name.unique' => 'Nama level affiliate sudah terdaftar.',
            'name.string' => 'Nama level affiliate harus berupa teks.',

            'percentage.required' => 'Persentase level affiliate harus diisi.',
            'percentage.numeric' => 'Persentase level affiliate harus berupa angka.',
            'percentage.min' => 'Persentase level affiliate minimal 0.',
            'percentage.max' => 'Persentase level affiliate maksimal 100.',

            'min_earning.required' => 'Pendapatan minimum level affiliate harus diisi.',
            'min_earning.numeric' => 'Pendapatan minimum level affiliate harus berupa angka.',
            'min_earning.min' => 'Pendapatan minimum level affiliate minimal 1.',
            'min_earning.unique' => 'Pendapatan minimum level affiliate sudah terdaftar.',

            'description.string' => 'Deskripsi level affiliate harus berupa teks.',

            'icon.mimes' => 'Icon level affiliate harus berformat jpg, jpeg, atau png.',
            'icon.max' => 'Icon level affiliate maksimal 2MB.',
        ];
    }
}
