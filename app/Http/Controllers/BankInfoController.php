<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankInfoController extends Controller
{
    /**
     * Display bank information settings.
     */
    public function index()
    {
        return view('admin.pages.settings.bank-info');
    }

    /**
     * Update bank information settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bank_swift_code' => 'nullable|string|max:20',
            'bank_branch' => 'nullable|string|max:100',
            'bank_address' => 'nullable|string|max:255',
        ]);

        setting_set('bank_name', $request->bank_name, 'string', 'Nama Bank', 'payment');
        setting_set('bank_account_name', $request->bank_account_name, 'string', 'Nama Pemilik Rekening', 'payment');
        setting_set('bank_account_number', $request->bank_account_number, 'string', 'Nomor Rekening', 'payment');
        setting_set('bank_swift_code', $request->bank_swift_code, 'string', 'Kode SWIFT', 'payment');
        setting_set('bank_branch', $request->bank_branch, 'string', 'Cabang Bank', 'payment');
        setting_set('bank_address', $request->bank_address, 'string', 'Alamat Bank', 'payment');

        if ($request->hasFile('bank_qr_code')) {
            $qrCode = $request->file('bank_qr_code')->store('bank_qr_codes', 'public');
            setting_set('bank_qr_code', $qrCode, 'string', 'QR Code Bank', 'payment');
        }

        return redirect()->back()->with('success', 'Informasi rekening berhasil diperbarui.');
    }

    /**
     * Display bank information for users.
     */
    public function show()
    {
        $bankInfo = [
            'bank_name' => setting('bank_name', 'Bank Mandiri'),
            'bank_account_name' => setting('bank_account_name', 'PT Daya Media'),
            'bank_account_number' => setting('bank_account_number', '1234567890'),
            'bank_qr_code' => setting('bank_qr_code'),
            'bank_swift_code' => setting('bank_swift_code'),
            'bank_branch' => setting('bank_branch'),
            'bank_address' => setting('bank_address'),
        ];

        return response()->json($bankInfo);
    }
}
