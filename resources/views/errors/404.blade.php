@extends('landing.layouts.auth')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="relative flex grow flex-col items-center justify-center p-6 sm:p-10 overflow-hidden bg-white">
    
    <!-- Header / Logo -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10" alt="Daya Media Logo">
        </a>
    </div>

    <!-- Background Ornaments -->
    <div class="absolute top-0 right-0 size-[500px] bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 size-[400px] bg-secondary/5 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>

    <!-- Main Content -->
    <div class="relative z-10 text-center max-w-lg mx-auto">
        <div class="relative inline-block mb-12">
            <h1 class="text-[10rem] sm:text-[14rem] font-black text-primary leading-none opacity-[0.07] select-none">404</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="size-32 sm:size-40 rounded-[3rem] bg-white shadow-2xl border border-gray-50 flex items-center justify-center animate-float">
                    <i class="ki-filled ki-search-list text-6xl sm:text-7xl text-primary"></i>
                </div>
            </div>
        </div>

        <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-4">Ups! Halaman Hilang</h2>
        <p class="text-gray-500 font-medium text-lg mb-10 leading-relaxed px-4">
            Maaf, halaman yang Anda cari tidak dapat kami temukan atau mungkin telah berpindah alamat. Mari kembali ke jalur yang benar.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 px-4">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                <i class="ki-filled ki-home text-xl"></i>
                <span>Ke Beranda</span>
            </a>
            <a href="{{ route('catalog') }}" class="w-full sm:w-auto px-8 py-4 bg-gray-50 text-gray-700 font-black rounded-2xl border border-gray-100 hover:bg-white hover:border-primary/20 transition-all flex items-center justify-center gap-2">
                <i class="ki-filled ki-book text-xl"></i>
                <span>Cari Buku</span>
            </a>
        </div>
    </div>

    <!-- Help Text -->
    <div class="absolute bottom-8 text-center w-full px-6">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">
            Ada Masalah? <a href="https://wa.me/{{ getSetting('whatsapp_contact', '628123456789') }}" target="_blank" class="text-primary hover:underline">Hubungi Bantuan</a>
        </p>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(2deg); }
    }
    .animate-float { animation: float 5s ease-in-out infinite; }
</style>
@endsection
