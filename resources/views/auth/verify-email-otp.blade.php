@extends('landing.layouts.auth')

@section('title', 'Verifikasi Email - Daya Media')

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
            
            <!-- Alert Messages -->
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

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl text-red-700 text-sm text-left">
                    <ul class="mb-0 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Icon Animasi -->
            <div class="inline-flex items-center justify-center size-24 bg-primary text-white rounded-full mb-8 shadow-xl shadow-primary/30 relative mx-auto">
                <span class="absolute inset-0 rounded-full bg-primary animate-ping opacity-20"></span>
                <i class="ki-filled ki-shield-tick text-5xl relative z-10"></i>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">Verifikasi Email</h1>
            <p class="text-gray-500 font-medium leading-relaxed mb-1">
                Kode OTP telah dikirim ke email/WhatsApp Anda
            </p>

            <form action="{{ route('auth.verify-email-otp.post', $user) }}" method="POST" class="mt-8 flex flex-col gap-8">
                @csrf
                
                <div class="flex flex-col gap-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Kode OTP</label>
                    <div class="flex items-center justify-center gap-2 sm:gap-4" id="otp-inputs">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" maxlength="1" 
                                class="otp-input kt-input w-12 h-16 sm:w-14 sm:h-20 text-center text-2xl font-black bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all shadow-sm"
                                pattern="\d*" inputmode="numeric">
                        @endfor
                    </div>
                    <input type="hidden" name="code" id="code">
                    @error('code')
                        <span class="text-red-500 text-xs mt-2 text-center block">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-400 font-medium text-center">
                        Masukkan 6 digit kode OTP yang dikirim ke email/WhatsApp Anda
                    </p>
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <button type="submit" class="kt-btn kt-btn-primary w-full py-4 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-base">
                        Verifikasi Email
                    </button>
                    
                    <form action="{{ route('auth.resend-email-otp', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="kt-btn kt-btn-secondary w-full py-4 rounded-xl font-bold border border-gray-200 hover:bg-gray-50 active:scale-[0.98] transition-all text-base flex items-center justify-center gap-2">
                            <i class="ki-filled ki-arrows-circle text-lg"></i>
                            Kirim Ulang Kode OTP
                        </button>
                    </form>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-primary transition-colors">
                    <i class="ki-filled ki-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-400">
                Belum menerima kode? Periksa folder spam atau hubungi admin
            </p>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const inputs = $('.otp-input');
        const hiddenInput = $('#code');

        // Auto-focus first input
        inputs.first().focus();

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

                // Auto-submit when 6 digits entered
                if (hiddenInput.val().length === 6) {
                    $(this).closest('form').submit();
                }
            });

            $(this).on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                updateHiddenInput();
            });

            // Handle paste
            $(this).on('paste', function(e) {
                e.preventDefault();
                const paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').split('');
                inputs.each(function(i) {
                    if (i < digits.length) {
                        $(this).val(digits[i]);
                    }
                });
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

        // OTP Resend Countdown Timer
        const RESEND_TIMER_KEY = 'otp_resend_timer_email_verify';
        const RESEND_COOLDOWN = 300; // 5 minutes in seconds

        function initResendTimer() {
            const btn = $('button[type="submit"]:contains("Kirim Ulang")');
            const storedTime = localStorage.getItem(RESEND_TIMER_KEY);
            const now = Math.floor(Date.now() / 1000);

            if (storedTime) {
                const expiryTime = parseInt(storedTime);
                if (now < expiryTime) {
                    const remainingSeconds = expiryTime - now;
                    startCountdown(remainingSeconds);
                    return;
                } else {
                    localStorage.removeItem(RESEND_TIMER_KEY);
                }
            }

            btn.prop('disabled', false).html('<i class="ki-filled ki-arrows-circle text-lg"></i> Kirim Ulang Kode OTP');
        }

        function startCountdown(seconds) {
            const btn = $('button[type="submit"]:contains("Kirim Ulang")');
            let remaining = seconds;

            const updateDisplay = () => {
                if (remaining <= 0) {
                    localStorage.removeItem(RESEND_TIMER_KEY);
                    btn.prop('disabled', false).html('<i class="ki-filled ki-arrows-circle text-lg"></i> Kirim Ulang Kode OTP');
                    return;
                }

                const minutes = Math.floor(remaining / 60);
                const secs = remaining % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                btn.prop('disabled', true).html(`<i class="ki-filled ki-clock text-lg"></i> Kirim ulang dalam ${timeString}`);
                remaining--;
                setTimeout(updateDisplay, 1000);
            };

            updateDisplay();
        }

        // Handle resend click - set timer immediately
        $(document).on('click', 'button[type="submit"]:contains("Kirim Ulang")', function(e) {
            const btn = $(this);
            if (btn.prop('disabled')) {
                e.preventDefault();
                return;
            }

            // Set timer in localStorage
            const expiryTime = Math.floor(Date.now() / 1000) + RESEND_COOLDOWN;
            localStorage.setItem(RESEND_TIMER_KEY, expiryTime);

            // Start countdown immediately
            startCountdown(RESEND_COOLDOWN);
        });

        // Initialize timer on page load
        initResendTimer();
    });
</script>
@endpush
