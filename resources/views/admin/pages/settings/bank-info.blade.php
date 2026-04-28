@extends('admin.layouts.app')

@section('title', 'Informasi Rekening')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Informasi Rekening"
            description="Kelola informasi rekening bank untuk pembayaran"
            >
        </x-header-page>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.settings.bank-info.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('bank_name') is-invalid @enderror"
                                           id="bank_name"
                                           name="bank_name"
                                           value="{{ old('bank_name', setting('bank_name', 'Bank Mandiri')) }}"
                                           required>
                                    @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_account_name" class="form-label">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('bank_account_name') is-invalid @enderror"
                                           id="bank_account_name"
                                           name="bank_account_name"
                                           value="{{ old('bank_account_name', setting('bank_account_name', 'PT Azzia Indonesia')) }}"
                                           required>
                                    @error('bank_account_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_account_number" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('bank_account_number') is-invalid @enderror"
                                           id="bank_account_number"
                                           name="bank_account_number"
                                           value="{{ old('bank_account_number', setting('bank_account_number', '1234567890')) }}"
                                           required>
                                    @error('bank_account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_swift_code" class="form-label">Kode SWIFT (Opsional)</label>
                                    <input type="text"
                                           class="form-control @error('bank_swift_code') is-invalid @enderror"
                                           id="bank_swift_code"
                                           name="bank_swift_code"
                                           value="{{ old('bank_swift_code', setting('bank_swift_code')) }}">
                                    @error('bank_swift_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_branch" class="form-label">Cabang Bank (Opsional)</label>
                                    <input type="text"
                                           class="form-control @error('bank_branch') is-invalid @enderror"
                                           id="bank_branch"
                                           name="bank_branch"
                                           value="{{ old('bank_branch', setting('bank_branch')) }}">
                                    @error('bank_branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_address" class="form-label">Alamat Bank (Opsional)</label>
                                    <input type="text"
                                           class="form-control @error('bank_address') is-invalid @enderror"
                                           id="bank_address"
                                           name="bank_address"
                                           value="{{ old('bank_address', setting('bank_address')) }}">
                                    @error('bank_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="bank_qr_code" class="form-label">QR Code Bank (Opsional)</label>
                                    <input type="file"
                                           class="form-control @error('bank_qr_code') is-invalid @enderror"
                                           id="bank_qr_code"
                                           name="bank_qr_code"
                                           accept="image/*">
                                    @error('bank_qr_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, PNG (Max: 2MB)</small>

                                    @if(setting('bank_qr_code'))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . setting('bank_qr_code')) }}" alt="QR Code Bank" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.home') }}" class="btn bg-secondary-subtle text-secondary waves-effect">
                                    Batal
                                </a>
                                <button type="submit" class="btn bg-primary waves-effect text-white">
                                    Simpan Informasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Saat Ini</h5>
                        <div class="mb-3">
                            <strong>Nama Bank:</strong>
                            <span class="float-end">{{ setting('bank_name', 'Belum diatur') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Nama Rekening:</strong>
                            <span class="float-end">{{ setting('bank_account_name', 'Belum diatur') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>No. Rekening:</strong>
                            <span class="float-end">{{ setting('bank_account_number', 'Belum diatur') }}</span>
                        </div>
                        @if(setting('bank_qr_code'))
                        <div class="mb-3">
                            <strong>QR Code:</strong>
                            <div class="text-center mt-2">
                                <img src="{{ asset('storage/' . setting('bank_qr_code')) }}" alt="QR Code Bank" class="img-fluid">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
