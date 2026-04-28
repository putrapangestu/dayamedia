<?php

namespace App\Http\Requests\Transaction\Withdraw;

use Illuminate\Foundation\Http\FormRequest;

class CreateWithdrawRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1',
            'bank' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Jumlah penarikan harus diisi',
            'amount.numeric' => 'Jumlah penarikan harus berupa angka',
            'amount.min' => 'Jumlah penarikan harus minimal 1',

            'bank.required' => 'Bank penarikan harus diisi',
            'bank.string' => 'Bank penarikan harus berupa string',

            'account_number.required' => 'Nomor rekening penarikan harus diisi',
            'account_number.string' => 'Nomor rekening penarikan harus berupa string',

            'account_name.required' => 'Nama pemilik rekening penarikan harus diisi',
            'account_name.string' => 'Nama pemilik rekening penarikan harus berupa string',
        ];
    }
}
