@extends('landing.layouts.auth')

@section('title', 'Daftar Member - Daya Media')

@section('content')
<section class="relative flex grow items-center justify-center py-10 overflow-hidden bg-white">
    <!-- Logo Floating -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10" alt="Daya Media Logo">
        </a>
    </div>

    <!-- Ornamen Latar Belakang -->
    <div class="absolute top-0 right-0 -translate-y-1/2 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    
    <div class="kt-container-fixed w-full max-w-[1200px] relative z-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Sisi Kiri: Informasi Benefits (Hanya Desktop) -->
            <div class="hidden lg:flex lg:col-span-5 flex-col gap-10 pr-4">
                <div class="flex flex-col gap-4">
                    <h2 class="text-4xl font-extrabold text-gray-900 leading-tight">Gabung Menjadi <br/><span class="text-primary">Member Daya Media</span></h2>
                    <p class="text-gray-500 font-medium">Dapatkan akses eksklusif untuk menerbitkan karya Anda ke jangkauan yang lebih luas.</p>
                </div>
                
                <div class="flex flex-col gap-6">
                    @php
                        $benefits = [
                            ['icon' => 'ki-notification-status', 'title' => 'Update Status Real-time', 'desc' => 'Pantau proses editing hingga terbit secara transparan.'],
                            ['icon' => 'ki-wallet', 'title' => 'Transparansi Royalti', 'desc' => 'Dapatkan laporan penjualan yang jelas dan akurat.'],
                            ['icon' => 'ki-users', 'title' => 'Komunitas Penulis', 'desc' => 'Kolaborasi dengan ribuan penulis luar biasa lainnya.'],
                        ];
                    @endphp
                    @foreach($benefits as $b)
                    <div class="flex gap-4 p-5 bg-gray-50/50 border border-gray-100 rounded-2xl hover:border-primary/30 hover:bg-primary/5 transition-colors">
                        <div class="size-12 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-primary shrink-0">
                            <i class="ki-filled {{ $b['icon'] }} text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ $b['title'] }}</h4>
                            <p class="text-xs text-gray-500 font-medium mt-1">{{ $b['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sisi Kanan: Form Register -->
            <div class="lg:col-span-7 xl:col-span-6 xl:col-start-7">
                <div class="bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl p-8 sm:p-12 relative z-10">
                    <div class="mb-8 text-center lg:text-left">
                        <h1 class="text-2xl font-bold text-gray-900">Buat Akun Member</h1>
                        <p class="text-gray-500 text-sm mt-2">Lengkapi data diri Anda untuk memulai perjalanan berkarya.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-5">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" class="kt-input w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Budi Hartono" required value="{{ old('full_name') }}">
                                @error('full_name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" class="kt-input w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="name@email.com" required value="{{ old('email') }}">
                                @error('email') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="ki-filled ki-whatsapp"></i>
                                </span>
                                <input type="text" name="phone_number" id="phone_number" class="kt-input w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="08123456789" required value="{{ old('phone_number') }}">
                            </div>
                            @error('phone_number') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="kt-input w-full pl-4 pr-11 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="••••••••" required>
                                    <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#password">
                                        <i class="ki-filled ki-eye"></i>
                                    </button>
                                </div>
                                @error('password') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Konfirmasi <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="kt-input w-full pl-4 pr-11 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="••••••••" required>
                                    <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#password_confirmation">
                                        <i class="ki-filled ki-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-gray-700 uppercase ml-1 tracking-wider">Kode Referal (Opsional)</label>
                            <input type="text" name="referral_code" class="kt-input w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="123456" value="{{ old('referral_code', $referral_code) }}">
                        </div>

                        <button type="submit" class="kt-btn kt-btn-primary w-full py-4 mt-2 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Mulai Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-sm text-gray-500 font-medium">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-sm font-bold text-primary hover:underline ml-1">Masuk</a>
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

        $('#phone_number').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
    });
</script>
@endpush