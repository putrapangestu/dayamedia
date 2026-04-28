<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Master\Module\UploadFileModuleRequest;
use App\Models\Module;
use App\Models\Transaction;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use UploadTrait;

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $data = $request->validated();

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    $this->remove($user->photo);
                }
                $data['photo'] = $this->upload('user/photo', $request->file('photo'));
            }

            $user->update($data);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: '.$th->getMessage());
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->back()->with('success', 'Password berhasil direset.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal mereset password: '.$th->getMessage());
        }
    }

    public function uploadCollaborationFile(UploadFileModuleRequest $request, string $id)
    {
        try {
            $module = Module::findOrFail($id);

            if ($module->file_path) {
                $this->remove($module->file_path);
            }

            if ($module->file_path_turnitin) {
                $this->remove($module->file_path_turnitin);
            }

            $payload = [];
            if ($request->hasFile('file')) {
                $payload['file_path'] = $this->upload('module/'.$module->id.'/file', $request->file('file'));
            }

            if ($request->hasFile('turnitin_file')) {
                $payload['file_path_turnitin'] = $this->upload('module/'.$module->id.'/turnitin-file', $request->file('turnitin_file'));
            }

            $module->update($payload);

            return redirect()->back()->with('success', 'File berhasil diunggah.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal mengunggah file: '.$th->getMessage());
        }
    }

    public function uploadPaymentProof(Request $request, string $transaction)
    {
        try {
            $request->validate([
                'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'payment_method' => 'required|in:bank_transfer,e_wallet,qris',
            ]);

            $transaction = Transaction::where('id', $transaction)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->firstOrFail();

            if ($transaction->payment_proof) {
                $this->remove($transaction->payment_proof);
            }

            $paymentProof = $this->upload('payment-proof', $request->file('payment_proof'));

            $transaction->update([
                'payment_proof' => $paymentProof,
                'payment_method' => $request->payment_method,
            ]);

            $adminMessage = "Pembayaran baru dibuat oleh {$transaction->user->full_name}.\n"
                ."Kode Transaksi: {$transaction->transaction_code}\n"
                .'Total: Rp '.number_format($transaction->total_price, 0, ',', '.')."\n"
                .'Metode: '.strtoupper($transaction->payment_method)."\n"
                .'Mohon segera dilakukan verifikasi.';
            whatsapp_admin_notify($adminMessage, 2);
            email_admin_notify('Pembayaran Baru - Verifikasi Diperlukan', $adminMessage);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Silakan tunggu verifikasi dari admin.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal upload bukti pembayaran: '.$th->getMessage());
        }
    }
}
