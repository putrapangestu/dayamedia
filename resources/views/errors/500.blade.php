@extends('landing.layouts.auth')

@section('title', '500 - Terjadi Kesalahan')

@section('content')
    @include('errors.partials.page', [
        'statusCode' => 500,
        'eyebrow' => 'Gangguan sistem',
        'title' => 'Sistem belum bisa memproses permintaan',
        'message' => 'Ada kendala dari sisi server. Silakan coba beberapa saat lagi atau hubungi bantuan jika transaksi Anda sedang berjalan.',
        'icon' => 'ki-shield-cross',
        'tone' => 'rose',
    ])
@endsection
