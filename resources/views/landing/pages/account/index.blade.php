@extends('landing.layouts.app')

@section('content')
    <div class="kt-container-fixed" id="contentContainer">

        <style>
            .hero-bg {
                background-image: url('{{ asset('') }}assets/landing/media/images/2600x1200/bg-1.png');
            }

            .dark .hero-bg {
                background-image: url('{{ asset('') }}assets/landing/media/images/2600x1200/bg-1-dark.png');
            }
        </style>

        {{-- ===== HERO / PROFILE HEADER ===== --}}
        <div class="bg-center bg-cover bg-no-repeat hero-bg">
            <div class="kt-container-fixed">
                <div class="flex flex-col items-center gap-2 lg:gap-3.5 py-4 lg:pt-5 lg:pb-10">
                    <img class="rounded-full border-3 border-green-500 size-[100px] shrink-0"
                        src="{{ asset('') }}assets/landing/media/avatars/300-1.png" />
                    <div class="flex items-center gap-1.5">
                        <div class="text-lg leading-5 font-semibold text-mono">Jenny Klabber (Silver)</div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-1 lg:gap-4.5 text-sm">
                        <div class="flex gap-1.25 items-center">
                            <i class="ki-filled ki-abstract-41 text-muted-foreground text-sm"></i>
                            <span class="text-secondary-foreground font-medium">5 Transaksi</span>
                        </div>
                        <div class="flex gap-1.25 items-center">
                            <i class="ki-filled ki-geolocation text-muted-foreground text-sm"></i>
                            <span class="text-secondary-foreground font-medium">7 Refferal</span>
                        </div>
                        <div class="flex gap-1.25 items-center">
                            <i class="ki-filled ki-sms text-muted-foreground text-sm"></i>
                            <span class="text-secondary-foreground font-medium">2 Kontributor Bab</span>
                        </div>
                    </div>
                    <div class="flex justify-center gap-5">
                        <div class="flex flex-col items-center">
                            <h2 class="font-semibold text-3xl">Rp.200.000</h2>
                            <p class="text-muted">Saldo</p>
                        </div>
                        <div class="flex-grow border-l border-border"></div>
                        <div class="flex flex-col items-center">
                            <h2 class="font-semibold text-3xl">R2V6N9WX</h2>
                            <p class="text-muted">
                                Kode Referal
                                <a href="#" class="ms-1 link-referral" data-referral="R2V6N9WX">
                                    <i class="ki-filled ki-copy"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TAB NAVIGASI ===== --}}
        <div class="kt-container-fixed">
            <div class="border-b border-border mb-6 lg:mb-8">
                <div class="kt-scrollable-x-auto">
                    <div class="flex gap-0" id="profile-tabs">

                        @php
                            $tabs = [
                                ['id' => 'profil-saya', 'label' => 'Profil Saya'],
                                ['id' => 'buku-saya', 'label' => 'Buku Saya'],
                                ['id' => 'kolaborasi-bab', 'label' => 'Kolaborasi Bab'],
                                ['id' => 'transaksi', 'label' => 'Transaksi'],
                                ['id' => 'withdraw', 'label' => 'Withdraw'],
                                ['id' => 'affiliate', 'label' => 'Affiliate & Royalti'],
                                ['id' => 'member-referral', 'label' => 'Member Referral'],
                                ['id' => 'buku-individu', 'label' => 'Buku Individu'],
                                ['id' => 'dokumen', 'label' => 'Dokumen'],
                            ];
                        @endphp

                        @foreach ($tabs as $index => $tab)
                            <button onclick="switchTab('{{ $tab['id'] }}')" id="tab-btn-{{ $tab['id'] }}"
                                class="tab-btn px-3 lg:px-4 py-3 lg:py-4 text-sm font-medium text-nowrap border-b-2 transition-colors
                            {{ $index === 0
                                ? 'border-primary text-primary font-semibold'
                                : 'border-transparent text-secondary-foreground hover:text-primary hover:border-primary/50' }}">
                                {{ $tab['label'] }}
                            </button>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        {{-- ===== KONTEN TAB ===== --}}
        <div class="kt-container-fixed pb-10">

            {{-- Profil Saya --}}
            <div id="tab-profil-saya" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 p-5">

                    {{-- Form Informasi Pengguna --}}
                    <div class="kt-card">
                        <div class="card-header gap-2.5">
                            <div class="flex items-center gap-3 px-10 py-5">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                    <i class="ki-filled ki-user text-primary text-base"></i>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <h3 class="card-title">Informasi Pengguna</h3>
                                    <span class="text-xs text-muted-foreground">Perbarui data profil Anda</span>
                                </div>
                            </div>
                        </div>

                        <div class="border border-l border-border"></div>

                        <div class="card-body flex flex-col gap-5 py-5 px-10">

                            {{-- Foto Profil --}}
                            <div class="flex items-center gap-4">
                                <div class="relative shrink-0">
                                    <div id="avatar-preview"
                                        class="size-20 rounded-full bg-muted border border-border overflow-hidden flex items-center justify-center">
                                        <i class="ki-filled ki-user text-3xl text-muted-foreground"></i>
                                    </div>
                                    <label for="foto-profil"
                                        class="absolute bottom-0 -end-1 size-7 rounded-full bg-primary flex items-center justify-center cursor-pointer shadow-xs hover:bg-primary/90 transition">
                                        <i class="ki-filled ki-picture text-white text-xs"></i>
                                        <input type="file" id="foto-profil" name="foto_profil" accept="image/*"
                                            class="hidden" onchange="previewFotoProfil(this)">
                                    </label>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-medium text-mono">Foto Profil</span>
                                    <span class="text-xs text-muted-foreground">JPG, PNG, atau GIF. Maks. 2MB</span>
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="nama">Nama Lengkap</label>
                                <input class="kt-input" type="text" id="nama" name="nama"
                                    value="{{ old('nama', auth()->user()->nama ?? '') }}"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            {{-- Email --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="email">Email</label>
                                <input class="kt-input" type="email" id="email" name="email"
                                    value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="contoh@email.com">
                            </div>

                            {{-- No WhatsApp --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="whatsapp">No. WhatsApp</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon">+62</span>
                                    <input class="kt-input" type="tel" id="whatsapp" name="no_whatsapp"
                                        value="{{ old('no_whatsapp', auth()->user()->no_whatsapp ?? '') }}"
                                        placeholder="8xx xxxx xxxx">
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="alamat">Alamat</label>
                                <textarea class="kt-textarea" id="alamat" name="alamat" rows="3"
                                    placeholder="Masukkan alamat lengkap...">{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <div class="flex justify-end pt-1">
                                <button type="button" class="kt-btn kt-btn-primary">
                                    <i class="ki-filled ki-check"></i>
                                    Simpan Perubahan
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- Form Reset Password --}}
                    <div class="kt-card h-fit ">
                        <div class="card-header gap-2.5 px-10 py-5">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-yellow-50 flex items-center justify-center shrink-0">
                                    <i class="ki-filled ki-security-user text-yellow-500 text-base"></i>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <h3 class="card-title">Reset Password</h3>
                                    <span class="text-xs text-muted-foreground">Perbarui kata sandi akun Anda</span>
                                </div>
                            </div>
                        </div>

                        <div class="border border-l border-border"></div>

                        <div class="card-body flex flex-col gap-5 px-10 py-5">

                            {{-- Password Lama --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="pass-lama">Password Lama</label>
                                <div class="kt-input" data-toggle-password="true">
                                    <input type="password" id="pass-lama" name="password_lama"
                                        placeholder="Masukkan password lama">
                                    <button type="button" data-toggle-password-trigger="true">
                                        <i
                                            class="ki-outline ki-eye text-muted-foreground toggle-password-active:hidden"></i>
                                        <i
                                            class="ki-outline ki-eye-slash text-muted-foreground hidden toggle-password-active:block"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Password Baru --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="pass-baru">Password Baru</label>
                                <div class="kt-input" data-toggle-password="true">
                                    <input type="password" id="pass-baru" name="password_baru"
                                        placeholder="Masukkan password baru"
                                        oninput="checkStrength(this.value); checkMatch()">
                                    <button type="button" data-toggle-password-trigger="true">
                                        <i
                                            class="ki-outline ki-eye text-muted-foreground toggle-password-active:hidden"></i>
                                        <i
                                            class="ki-outline ki-eye-slash text-muted-foreground hidden toggle-password-active:block"></i>
                                    </button>
                                </div>
                                {{-- Strength Indicator --}}
                                <div class="flex gap-1.5 mt-1">
                                    <div id="str-bar-1"
                                        class="h-1 flex-1 rounded-full bg-muted transition-all duration-300"></div>
                                    <div id="str-bar-2"
                                        class="h-1 flex-1 rounded-full bg-muted transition-all duration-300"></div>
                                    <div id="str-bar-3"
                                        class="h-1 flex-1 rounded-full bg-muted transition-all duration-300"></div>
                                </div>
                                <p id="str-label" class="text-xs text-muted-foreground"></p>
                            </div>

                            {{-- Konfirmasi Password Baru --}}
                            <div class="flex flex-col gap-1.5">
                                <label class="kt-form-label" for="pass-konfirm">Konfirmasi Password Baru</label>
                                <div class="kt-input" data-toggle-password="true">
                                    <input type="password" id="pass-konfirm" name="password_konfirmasi"
                                        placeholder="Ulangi password baru" oninput="checkMatch()">
                                    <button type="button" data-toggle-password-trigger="true">
                                        <i
                                            class="ki-outline ki-eye text-muted-foreground toggle-password-active:hidden"></i>
                                        <i
                                            class="ki-outline ki-eye-slash text-muted-foreground hidden toggle-password-active:block"></i>
                                    </button>
                                </div>
                                <p id="match-label" class="text-xs text-muted-foreground"></p>
                            </div>

                            {{-- Submit --}}
                            <div class="flex justify-end pt-1">
                                <button type="button" class="kt-btn kt-btn-primary">
                                    <i class="ki-filled ki-lock"></i>
                                    Perbarui Password
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Buku Saya --}}
            <div id="tab-buku-saya" class="tab-content hidden">
                @include('landing.pages.account.components.my-books')
            </div>

            {{-- Kolaborasi Bab --}}
            <div id="tab-kolaborasi-bab" class="tab-content hidden">
                @include('landing.pages.account.components.collaboration-history')
            </div>

            {{-- Transaksi --}}
            <div id="tab-transaksi" class="tab-content hidden">
                @include('landing.pages.account.components.transaction-history')
            </div>

            {{-- Withdraw --}}
            <div id="tab-withdraw" class="tab-content hidden">
                @include('landing.pages.account.components.withdrawl-pane')
            </div>

            {{-- Affiliate & Royalti --}}
            <div id="tab-affiliate" class="tab-content hidden">
                @include('landing.pages.account.components.affiliate-royalty')
            </div>

            {{-- Member Referral --}}
            <div id="tab-member-referral" class="tab-content hidden">
                @include('landing.pages.account.components.refferal-pane')
            </div>

            {{-- Buku Individu --}}
            <div id="tab-buku-individu" class="tab-content hidden">
                @include('landing.pages.account.components.individual-book-history')
            </div>

            {{-- Dokumen --}}
            <div id="tab-dokumen" class="tab-content hidden">
                @include('landing.pages.account.components.document-pane')
            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        function previewFotoProfil(input) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
            };
            reader.readAsDataURL(file);
        }

        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const icon = document.getElementById(iconId);
            if (isPassword) {
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
            `;
            } else {
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            `;
            }
        }

        function checkStrength(val) {
            const bars = ['str-bar-1', 'str-bar-2', 'str-bar-3'];
            const label = document.getElementById('str-label');

            bars.forEach(id => {
                document.getElementById(id).style.background = '#f3f4f6';
            });

            if (!val) {
                label.textContent = '';
                return;
            }

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            score = Math.max(score, 1);

            const configs = [{
                    color: '#ef4444',
                    text: 'Lemah'
                },
                {
                    color: '#f59e0b',
                    text: 'Sedang'
                },
                {
                    color: '#22c55e',
                    text: 'Kuat'
                },
            ];

            for (let i = 0; i < score; i++) {
                document.getElementById(bars[i]).style.background = configs[score - 1].color;
            }

            label.textContent = configs[score - 1].text;
            label.style.color = configs[score - 1].color;
        }

        function checkMatch() {
            const baru = document.getElementById('pass-baru').value;
            const konfirm = document.getElementById('pass-konfirm').value;
            const label = document.getElementById('match-label');

            if (!konfirm) {
                label.textContent = '';
                return;
            }

            if (baru === konfirm) {
                label.textContent = 'Password cocok';
                label.style.color = '#22c55e';
            } else {
                label.textContent = 'Password tidak cocok';
                label.style.color = '#ef4444';
            }
        }
    </script>
    <script>
        const TAB_KEY = 'profile_active_tab';

        function switchTab(tabId) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });

            // Reset semua tombol tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-primary', 'text-primary', 'font-semibold');
                btn.classList.add('border-transparent', 'text-secondary-foreground');
            });

            // Tampilkan konten tab yang dipilih
            const content = document.getElementById('tab-' + tabId);
            if (content) content.classList.remove('hidden');

            // Aktifkan tombol tab yang dipilih
            const btn = document.getElementById('tab-btn-' + tabId);
            if (btn) {
                btn.classList.add('border-primary', 'text-primary', 'font-semibold');
                btn.classList.remove('border-transparent', 'text-secondary-foreground');
            }

            // Simpan ke localStorage
            localStorage.setItem(TAB_KEY, tabId);
        }

        // Restore tab dari localStorage saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            const saved = localStorage.getItem(TAB_KEY);
            if (saved && document.getElementById('tab-' + saved)) {
                switchTab(saved);
            }
        });
    </script>

    <script>
        // Copy referral link
        $(document).ready(function() {
            $('.link-referral').click(function(e) {
                e.preventDefault();
                const referral = $(this).data('referral');
                const link = '{{ route('register', ['ref' => '']) }}' + referral;
                navigator.clipboard.writeText(link).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Link referal berhasil disalin!',
                    });
                });
            });
        });
    </script>
@endpush
