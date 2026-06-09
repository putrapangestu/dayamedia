@extends('landing.layouts.auth')

@php
    $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 400;
@endphp

@section('title', $statusCode . ' - Permintaan Tidak Dapat Diproses')

@section('content')
    @include('errors.partials.page', [
        'statusCode' => $statusCode,
        'eyebrow' => 'Permintaan tidak tersedia',
        'title' => 'Kami tidak bisa membuka halaman ini',
        'message' => 'Permintaan ini tidak dapat diproses. Periksa kembali alamat halaman, status login, atau kembali ke katalog untuk melanjutkan.',
        'icon' => 'ki-information-2',
        'tone' => 'amber',
    ])
@endsection
