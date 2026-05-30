@extends('landing.layouts.auth')

@section('title', 'Verifikasi Akun - Daya Media')

@section('content')
<section class="relative flex grow items-center justify-center py-10 overflow-hidden bg-white">
    <!-- Logo Floating -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10" alt="Daya Media Logo">
        </a>
    </div>

    <!-- Ornamen Latar Belakang -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[100px]"></div>

    <div class="kt-container-fixed w-full max-w-[550px] relative z-1">
        <div class="bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl p-8 sm:p-14 text-center">
            
            <!-- Icon Animasi -->
            <div class="inline-flex items-center justify-center size-24 bg-primary text-white rounded-full mb-8 shadow-xl shadow-primary/30 relative mx-auto">
                <span class="absolute inset-0 rounded-full bg-primary animate-ping opacity-20"></span>
                <i class="ki-filled ki-shield-tick text-5xl relative z-10"></i>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">Verifikasi Akun</h1>
            <p class="text-gray-500 font-medium leading-relaxed mb-1">
                Kami telah mengirimkan kode keamanan 6 digit ke nomor WhatsApp Anda:
            </p>
            <p class="font-bold text-gray-900 text-lg">******1234</p>

            <form action="#" method="POST" class="mt-8 flex flex-col gap-8">
                @csrf
                
                <div class="flex flex-col gap-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Masukkan Kode Keamanan</label>
                    <div class="flex items-center justify-center gap-2 sm:gap-4" id="otp-inputs">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" maxlength="1" 
                                class="otp-input kt-input w-12 h-16 sm:w-14 sm:h-20 text-center text-2xl font-black bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all shadow-sm"
                                pattern="\d*" inputmode="numeric">
                        @endfor
                    </div>
                    <input type="hidden" name="verification_code" id="verification_code">
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <button type="submit" class="kt-btn kt-btn-primary w-full py-4 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-base">
                        Verifikasi Akun Saya
                    </button>
                    
                    <p class="text-sm font-medium text-gray-500 mt-2 text-center">
                        Tidak menerima kode? 
                        <a href="javascript:void(0)" class="text-primary font-bold hover:underline decoration-2 underline-offset-4 ml-1">Kirim Ulang Kode</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const inputs = $('.otp-input');
        const hiddenInput = $('#verification_code');

        inputs.each(function(index) {
            $(this).on('keyup', function(e) {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < inputs.length - 1) {
                        inputs.eq(index + 1).focus();
                    }
                } else if (e.key === 'Backspace') {
                    if (index > 0) {
                        inputs.eq(index - 1).focus();
                    }
                }
                updateHiddenInput();
            });

            $(this).on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                updateHiddenInput();
            });
        });

        function updateHiddenInput() {
            let code = '';
            inputs.each(function() {
                code += $(this).val();
            });
            hiddenInput.val(code);
        }
    });
</script>
@endpush