@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden my-5">
    <div class="container py-5">
        <div class="d-flex flex-column align-items-center text-center py-5">
            <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                <iconify-icon icon="solar:history-bold-duotone" class="display-3"></iconify-icon>
            </div>
            <h1 class="fw-bolder mb-2 text-dark">Sesi Berakhir</h1>
            <p class="text-muted fs-4 mb-4" style="max-width: 600px;">
                Maaf, sesi Anda telah habis karena terlalu lama tidak ada aktivitas.<br>
                Silakan muat ulang halaman atau login kembali untuk melanjutkan.
            </p>
            <div class="d-flex gap-3 mt-2">
                <button onclick="window.location.reload()" class="btn btn-outline-primary px-4 py-2 fw-semibold rounded-3">
                    <i class="ti ti-reload me-1"></i> Muat Ulang Halaman
                </button>
                <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                    <i class="ti ti-login me-1"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
