@extends('landing.layouts.auth')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    @include('errors.partials.page', [
        'statusCode' => 404,
        'eyebrow' => 'Halaman tidak ditemukan',
        'title' => 'Alamat yang Anda buka tidak tersedia',
        'message' => 'Halaman mungkin sudah dipindahkan, dihapus, atau alamatnya tidak lengkap. Anda bisa kembali ke beranda atau mencari buku dari katalog.',
        'icon' => 'ki-search-list',
        'tone' => 'amber',
    ])
@endsection
