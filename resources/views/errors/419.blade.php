@extends('landing.layouts.auth')

@section('title', '419 - Sesi Berakhir')

@section('content')
    @include('errors.partials.page', [
        'statusCode' => 419,
        'eyebrow' => 'Sesi berakhir',
        'title' => 'Form ini perlu dimuat ulang',
        'message' => 'Sesi keamanan halaman sudah kedaluwarsa. Muat ulang halaman, lalu ulangi proses yang sedang Anda kerjakan.',
        'icon' => 'ki-time',
        'tone' => 'blue',
        'secondaryAction' => [
            'label' => 'Muat Ulang',
            'url' => 'javascript:window.location.reload()',
            'icon' => 'ki-arrows-circle',
        ],
    ])
@endsection
