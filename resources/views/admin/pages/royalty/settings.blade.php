@extends('admin.layouts.app')

@section('title', 'Pengaturan Royalty')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Pengaturan Royalty"
            description="Kelola pengaturan royalty dan referral"
            :breadcrumbs="[
                ['title' => 'Royalty', 'url' => route('admin.royalty.index')],
                ['title' => 'Pengaturan', 'url' => '#']
            ]"
            >
        </x-header-page>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.royalty.settings.update') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="royalty_percentage" class="form-label">Persentase Royalty <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('royalty_percentage') is-invalid @enderror" 
                                               id="royalty_percentage" 
                                               name="royalty_percentage" 
                                               value="{{ old('royalty_percentage', setting('royalty_percentage', 10)) }}" 
                                               min="0" 
                                               max="100" 
                                               step="0.01" 
                                               required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('royalty_percentage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Persentase royalty untuk author/editor</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="referral_percentage" class="form-label">Persentase Referral <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('referral_percentage') is-invalid @enderror" 
                                               id="referral_percentage" 
                                               name="referral_percentage" 
                                               value="{{ old('referral_percentage', setting('referral_percentage', 5)) }}" 
                                               min="0" 
                                               max="100" 
                                               step="0.01" 
                                               required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('referral_percentage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Persentase referral untuk user yang mereferensikan</small>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="min_withdrawal" class="form-label">Minimum Penarikan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" 
                                               class="form-control @error('min_withdrawal') is-invalid @enderror" 
                                               id="min_withdrawal" 
                                               name="min_withdrawal" 
                                               value="{{ old('min_withdrawal', setting('min_withdrawal', 50000)) }}" 
                                               min="0" 
                                               step="1000" 
                                               required>
                                    </div>
                                    @error('min_withdrawal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Minimum jumlah untuk penarikan royalty</small>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="payment_terms" class="form-label">Syarat Pembayaran</label>
                                    <textarea class="form-control @error('payment_terms') is-invalid @enderror" 
                                              id="payment_terms" 
                                              name="payment_terms" 
                                              rows="4" 
                                              placeholder="Masukkan syarat dan ketentuan pembayaran royalty...">{{ old('payment_terms', setting('payment_terms', '')) }}</textarea>
                                    @error('payment_terms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.royalty.index') }}" class="btn bg-secondary-subtle text-secondary waves-effect">
                                    Batal
                                </a>
                                <button type="submit" class="btn bg-primary waves-effect text-white">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi</h5>
                        <div class="mb-3">
                            <strong>Total Royalty Terbayar:</strong>
                            <span class="float-end text-success">
                                Rp. {{ number_format($royaltyStats['paid_royalty'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Total Royalty Pending:</strong>
                            <span class="float-end text-warning">
                                Rp. {{ number_format($royaltyStats['pending_royalty'], 0, ',', '.') }}
                            </span>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <strong>Total Referral Terbayar:</strong>
                            <span class="float-end text-success">
                                Rp. {{ number_format($royaltyStats['paid_referral'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Total Referral Pending:</strong>
                            <span class="float-end text-warning">
                                Rp. {{ number_format($royaltyStats['pending_referral'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
