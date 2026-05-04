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
                        ['id' => 'profil-saya',      'label' => 'Profil Saya'],
                        ['id' => 'buku-saya',        'label' => 'Buku Saya'],
                        ['id' => 'kolaborasi-bab',   'label' => 'Kolaborasi Bab'],
                        ['id' => 'transaksi',        'label' => 'Transaksi'],
                        ['id' => 'withdraw',         'label' => 'Withdraw'],
                        ['id' => 'affiliate',        'label' => 'Affiliate & Royalti'],
                        ['id' => 'member-referral',  'label' => 'Member Referral'],
                        ['id' => 'buku-individu',    'label' => 'Buku Individu'],
                        ['id' => 'dokumen',          'label' => 'Dokumen'],
                    ];
                    @endphp

                    @foreach($tabs as $index => $tab)
                    <button
                        onclick="switchTab('{{ $tab['id'] }}')"
                        id="tab-btn-{{ $tab['id'] }}"
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
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Profil Saya</p>
            </div>
        </div>

        {{-- Buku Saya --}}
        <div id="tab-buku-saya" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Buku Saya</p>
            </div>
        </div>

        {{-- Kolaborasi Bab --}}
        <div id="tab-kolaborasi-bab" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Kolaborasi Bab</p>
            </div>
        </div>

        {{-- Transaksi --}}
        <div id="tab-transaksi" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Transaksi</p>
            </div>
        </div>

        {{-- Withdraw --}}
        <div id="tab-withdraw" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Withdraw</p>
            </div>
        </div>

        {{-- Affiliate & Royalti --}}
        <div id="tab-affiliate" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Affiliate & Royalti</p>
            </div>
        </div>

        {{-- Member Referral --}}
        <div id="tab-member-referral" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Member Referral</p>
            </div>
        </div>

        {{-- Buku Individu --}}
        <div id="tab-buku-individu" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Buku Individu</p>
            </div>
        </div>

        {{-- Dokumen --}}
        <div id="tab-dokumen" class="tab-content hidden">
            <div class="flex items-center justify-center min-h-[300px]">
                <p class="text-muted-foreground text-sm font-medium">Tab: Dokumen</p>
            </div>
        </div>

    </div>

</div>
@endsection

@push('js')
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
    document.addEventListener('DOMContentLoaded', function () {
        const saved = localStorage.getItem(TAB_KEY);
        if (saved && document.getElementById('tab-' + saved)) {
            switchTab(saved);
        }
    });
</script>

<script>
    // Copy referral link
    $(document).ready(function () {
        $('.link-referral').click(function (e) {
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
