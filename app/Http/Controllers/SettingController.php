<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Setting;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use UploadTrait;

    public function adminFee(Request $request)
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.pages.settings.admin-fee', compact('settings'));
    }

    public function saveAdminFee(Request $request)
    {
        $request->validate([
            'withdrawal_fee' => 'required|numeric|min:0',
            'min_withdrawal_fee' => 'required|numeric|min:0',
            'transaction_fee' => 'required|numeric|min:0',
            'expired_time' => 'required|numeric|min:1',
            'individual_additional_author_price' => 'nullable|numeric|min:0',
            'bank_info' => 'required|string|max:255',
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
        ]);

        // Update or create settings
        Setting::updateOrCreate(['key' => 'withdrawal_fee'], ['value' => $request->withdrawal_fee]);
        Setting::updateOrCreate(['key' => 'min_withdrawal_fee'], ['value' => $request->min_withdrawal_fee]);
        Setting::updateOrCreate(['key' => 'transaction_fee'], ['value' => $request->transaction_fee]);
        Setting::updateOrCreate(['key' => 'expired_time'], ['value' => $request->expired_time]);
        if (! is_null($request->individual_additional_author_price)) {
            Setting::updateOrCreate(['key' => 'individual_additional_author_price'], ['value' => $request->individual_additional_author_price]);
        }
        Setting::updateOrCreate(['key' => 'bank_info'], ['value' => $request->bank_info]);
        Setting::updateOrCreate(['key' => 'bank_name'], ['value' => $request->bank_name]);
        Setting::updateOrCreate(['key' => 'bank_account'], ['value' => $request->bank_account]);

        return redirect()->back()->with('success', 'Pengaturan biaya admin berhasil disimpan.');
    }

    public function profile(Request $request)
    {
        return view('admin.pages.settings.profile');
    }

    public function document(Request $request)
    {
        $documents = Document::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.settings.documents', compact('documents'));
    }

    public function createDocument(Request $request)
    {
        $members = User::role('member')->get();

        return view('admin.pages.settings.create-document', compact('members'));
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,gif|max:5120',
            'member' => 'array',
            'member.*' => 'exists:users,id',
        ]);

        try {
            $filePath = $this->upload('documents', $request->file('file'));

            $document = Document::create([
                'name' => $request->name,
                'file_path' => $filePath,
            ]);

            $memberIds = collect($request->member)->filter()->values()->all();
            if (! empty($memberIds)) {
                $document->users()->sync($memberIds);
            }

            return redirect()->route('settings.documents')->with('success', 'Dokumen berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen: '.$th->getMessage());
        }
    }

    public function destroyDocument(Request $request, Document $document)
    {
        try {
            if ($document->file_path) {
                $this->remove($document->file_path);
            }
            $document->users()->detach();
            $document->delete();

            return redirect()->route('settings.documents')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->route('settings.documents')->with('error', 'Gagal menghapus dokumen: '.$th->getMessage());
        }
    }
}
