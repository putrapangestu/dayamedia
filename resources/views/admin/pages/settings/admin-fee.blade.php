@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
        title="Biaya Admin"
        description="Pengaturan biaya admin di Azzia"
        >
        </x-header-page>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Pengaturan Biaya Admin</h6>
                            <p>Pengaturan biaya admin untuk transaksi dan penarikan dana.</p>
                        </div>
                        <div>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show me-2" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.settings.admin-fee.save') }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="withdrawal_fee" class="form-label">Biaya Admin Penarikan Dana (Rp)</label>
                                    <input type="number" class="form-control" id="withdrawal_fee" name="withdrawal_fee" 
                                           value="{{ old('withdrawal_fee', $settings['withdrawal_fee'] ?? 5000) }}" 
                                           placeholder="Masukkan biaya admin penarikan dana" step="100" min="0">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="min_withdrawal_fee" class="form-label">Minimum Penarikan Dana (Rp)</label>
                                    <input type="number" class="form-control" id="min_withdrawal_fee" name="min_withdrawal_fee" 
                                           value="{{ old('min_withdrawal_fee', $settings['min_withdrawal_fee'] ?? 50000) }}" 
                                           placeholder="Masukkan minimum penarikan dana" min="0">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="transaction_fee" class="form-label">Biaya Admin Transaksi (Rp)</label>
                                    <input type="number" class="form-control" id="transaction_fee" name="transaction_fee" 
                                           value="{{ old('transaction_fee', $settings['transaction_fee'] ?? 2000) }}" 
                                           placeholder="Masukkan biaya admin transaksi" step="100" min="0">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="individual_additional_author_price" class="form-label">Biaya Penulis Tambahan (Global) (Rp)</label>
                                    <input type="number" class="form-control" id="individual_additional_author_price" name="individual_additional_author_price" 
                                           value="{{ old('individual_additional_author_price', $settings['individual_additional_author_price'] ?? 0) }}" 
                                           placeholder="Masukkan biaya per penulis tambahan" step="100" min="0">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="expired_time" class="form-label">Batas Expired Transaksi (jam)</label>
                                    <input type="number" class="form-control" id="expired_time" name="expired_time" 
                                           value="{{ old('expired_time', $settings['expired_time'] ?? 24) }}" 
                                           placeholder="Masukkan batas expired transaksi" min="1">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="bank_info" class="form-label">Informasi Rekening</label>
                                    <input type="text" class="form-control" id="bank_info" name="bank_info" 
                                           value="{{ old('bank_info', $settings['bank_info'] ?? 'BCA') }}" 
                                           placeholder="Masukkan informasi rekening">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="bank_name" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" 
                                           value="{{ old('bank_name', $settings['bank_name'] ?? 'Bank Central Asia') }}" 
                                           placeholder="Masukkan nama bank">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="bank_account" class="form-label">Nomor Rekening Bank</label>
                                    <input type="text" class="form-control" id="bank_account" name="bank_account" 
                                           value="{{ old('bank_account', $settings['bank_account'] ?? '') }}" 
                                           placeholder="Masukkan nomor rekening bank">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
