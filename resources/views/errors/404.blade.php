@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden my-5">
    <div class="container">
        <div class="d-flex flex-column align-items-center text-center">
            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 96px; height: 96px;">
                <span class="fs-3 fw-bolder">404</span>
            </div>
            <h1 class="fw-bolder mb-2">Halaman Tidak Ditemukan</h1>
            <p class="text-muted fs-4 mb-4">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}" class="btn btn-primary px-4"><i class="ti ti-home me-1"></i> Kembali ke Beranda</a>
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary px-4"><i class="ti ti-books me-1"></i> Lihat Katalog Buku</a>
            </div>
        </div>
    </div>
    </div>
@endsection

