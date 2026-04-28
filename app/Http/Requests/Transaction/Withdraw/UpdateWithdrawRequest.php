<?php

namespace App\Http\Requests\Transaction\Withdraw;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWithdrawRequest extends FormRequest
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
            'status' => 'required|string',
            'note' => 'required_if:status,rejected|nullable|string',
            'proof' => 'required_if:status,accepted|nullable|file|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status penarikan harus diisi',
            'status.string' => 'Status penarikan harus berupa string',

            'note.required_if' => 'Catatan penarikan harus diisi jika statusnya ditolak',
            'note.string' => 'Catatan penarikan harus berupa string',

            'proof.required_if' => 'Bukti penarikan harus diunggah jika statusnya diterima',
            'proof.image' => 'Bukti penarikan harus berupa gambar',
            'proof.mimes' => 'Bukti penarikan harus berformat jpg, jpeg, png, atau pdf',
            'proof.max' => 'Bukti penarikan maksimal 2MB',
        ];
    }
}
