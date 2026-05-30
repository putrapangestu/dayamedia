@extends('landing.layouts.auth')

@section('title', 'Masuk ke Akun - Daya Media')

@section('content')
<section class="relative flex grow items-center justify-center py-10 overflow-hidden bg-white">
    <!-- Logo Floating (Mobile only or corner) -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10" alt="Daya Media Logo">
        </a>
    </div>

    <!-- Ornamen Latar Belakang -->
    <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>

    <div class="kt-container-fixed w-full max-w-[1100px] relative z-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Sisi Kiri: Narasi & Ilustrasi (Hanya Desktop) -->
            <div class="hidden lg:flex lg:col-span-6 flex-col gap-8 pr-10">
                <div class="flex flex-col gap-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary w-fit">
                        PENERBIT DAYA MEDIA
                    </span>
                    <h2 class="text-4xl xl:text-5xl font-extrabold text-gray-900 leading-tight">
                        Wujudkan Karya <br/>
                        <span class="text-primary">Terbaik Anda</span> Bersama Kami.
                    </h2>
                    <p class="text-lg text-gray-500 font-medium max-w-[450px]">
                        Akses ribuan katalog buku, kelola royalti, dan bangun kolaborasi penulis dalam satu platform modern.
                    </p>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-primary/5 rounded-2xl -rotate-2"></div>
                    <img src="{{ asset('assets/dashboard/images/backgrounds/login-security.svg') }}" class="relative w-full max-w-[400px] animate-pulse-slow" alt="Daya Media Security">
                </div>
            </div>

            <!-- Sisi Kanan: Form Login -->
            <div class="lg:col-span-6 xl:col-span-5 xl:col-start-8">
                <div class="bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl p-8 sm:p-12 relative z-10">
                    <div class="mb-8 text-center lg:text-left">
                        <h1 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h1>
                        <p class="text-gray-500 text-sm mt-2">Silakan masuk menggunakan akun terdaftar Anda.</p>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl text-green-700 text-sm flex items-center gap-3">
                            <i class="ki-filled ki-check-circle text-lg"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl text-red-700 text-sm flex items-center gap-3">
                            <i class="ki-filled ki-information-2 text-lg"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                        @csrf
                        
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider ml-1">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="ki-filled ki-sms"></i>
                                </span>
                                <input type="email" name="email" class="kt-input w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="name@domain.com" required value="{{ old('email') }}">
                            </div>
                            @error('email') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between ml-1">
                                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Kata Sandi</label>
                                <a href="{{ route('password.forgot') }}" class="text-xs font-bold text-primary hover:text-primary-dark transition-all">Lupa?</a>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="ki-filled ki-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="kt-input w-full pl-11 pr-11 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="••••••••" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#password">
                                    <i class="ki-filled ki-eye"></i>
                                </button>
                            </div>
                            @error('password') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-2 ml-1">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 bg-gray-50">
                            <label for="remember" class="text-sm text-gray-600 font-medium cursor-pointer">Ingat saya di perangkat ini</label>
                        </div>

                        <button type="submit" class="kt-btn kt-btn-primary w-full py-4 mt-2 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Masuk Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-sm text-gray-500 font-medium">Belum memiliki akun?</span>
                            <a href="{{ route('register') }}" class="text-sm font-bold text-primary hover:underline ml-1">Daftar Member</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            const target = $(this).data('target');
            const input = $(target);
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('ki-eye').addClass('ki-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('ki-eye-slash').addClass('ki-eye');
            }
        });
    });
</script>
@endpush