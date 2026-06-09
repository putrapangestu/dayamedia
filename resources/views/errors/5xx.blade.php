@extends('landing.layouts.auth')

@php
    $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
@endphp

@section('title', $statusCode . ' - Gangguan Sistem')

@section('content')
    @include('errors.partials.page', [
        'statusCode' => $statusCode,
        'eyebrow' => 'Gangguan sistem',
        'title' => 'Layanan sedang tidak stabil',
        'message' => 'Server belum dapat menyelesaikan permintaan ini. Coba kembali beberapa saat lagi atau hubungi bantuan jika masalah berulang.',
        'icon' => 'ki-setting-2',
        'tone' => 'rose',
    ])
@endsection
