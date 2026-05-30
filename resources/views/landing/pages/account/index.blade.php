@extends('landing.layouts.app')

@section('title', 'Akun Saya - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20">
    
    {{-- ===== PROFILE HEADER ===== --}}
    <div class="relative group">
        <!-- Cover Image -->
        <div class="h-48 sm:h-64 overflow-hidden relative">
            <img src="{{ asset('assets/dashboard/images/backgrounds/profilebg.jpg') }}" class="w-full h-full object-cover" alt="Profile Cover">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/30"></div>
        </div>

        <div class="kt-container-fixed relative -mt-16 sm:-mt-20 z-10">
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/40 p-6 sm:p-10 flex flex-col lg:flex-row items-center lg:items-end gap-6 sm:gap-10">
                
                <!-- Avatar -->
                <div class="relative shrink-0">
                    <div class="size-32 sm:size-40 rounded-full border-4 sm:border-8 border-white overflow-hidden shadow-2xl bg-gray-50">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/dashboard/images/profile/user-1.jpg') }}" 
                             class="w-full h-full object-cover" alt="{{ $user->full_name }}">
                    </div>
                    <div class="absolute bottom-2 right-2 size-8 bg-green-500 border-4 border-white rounded-full"></div>
                </div>

                <!-- Basic Info -->
                <div class="flex-grow text-center lg:text-left pb-2">
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-1">{{ $user->full_name }}</h1>
                    <div class="flex flex-wrap justify-center lg:justify-start items-center gap-3">
                        <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $user->affiliateLevel?->name ?? 'Member' }}
                        </span>
                        <span class="h-4 w-px bg-gray-200 hidden sm:block"></span>
                        <div class="flex items-center gap-1.5 text-gray-500 text-sm font-medium">
                            <i class="ki-filled ki-sms text-base"></i> {{ $user->email }}
                        </div>
                    </div>
                </div>

                <!-- Stats Summary -->
                <div class="flex flex-wrap justify-center gap-4 sm:gap-8 border-t lg:border-t-0 lg:border-l border-gray-100 pt-6 lg:pt-0 lg:pl-10 w-full lg:w-auto">
                    <div class="text-center">
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ $transactionCount }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ $referralCount }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Referral</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-primary tracking-tighter">Rp{{ number_format($user->balance, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Saldo Saya</p>
                    </div>
                </div>
            </div>

            <!-- Referral Code Float -->
            @if($user->referral_code)
            <div class="mt-6 flex flex-wrap items-center gap-4 bg-primary/5 border border-primary/10 p-4 rounded-2xl animate-pulse-slow">
                <i class="ki-filled ki-gift text-2xl text-primary"></i>
                <div class="flex-grow">
                    <p class="text-xs font-bold text-primary uppercase tracking-widest leading-none mb-1">Kode Referral Anda</p>
                    <p class="text-sm font-black text-gray-900 tracking-widest uppercase">{{ $user->referral_code }}</p>
                </div>
                <button type="button" class="link-referral px-6 py-2.5 bg-primary text-white text-[10px] font-black uppercase rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 flex items-center gap-2" data-referral="{{ $user->referral_code }}">
                    <i class="ki-filled ki-copy"></i> Salin Link
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== TAB NAVIGASI ===== --}}
    <div class="mt-10 lg:mt-16 sticky top-[var(--header-height,100px)] z-20 bg-white/80 backdrop-blur-md border-y border-gray-100 shadow-sm">
        <div class="kt-container-fixed">
            <div class="flex items-center overflow-x-auto custom-scrollbar no-scrollbar py-2 gap-2" id="profile-tabs">
                @php
                    $tabs = [
                        ['id' => 'profile', 'label' => 'Profil Saya', 'icon' => 'ki-user'],
                        ['id' => 'my-books', 'label' => 'Buku Saya', 'icon' => 'ki-book'],
                        ['id' => 'collaborator', 'label' => 'Kolaborasi Bab', 'icon' => 'ki-users'],
                        ['id' => 'transaction', 'label' => 'Riwayat Transaksi', 'icon' => 'ki-handcart'],
                        ['id' => 'individual-books', 'label' => 'Penerbitan Individu', 'icon' => 'ki-crown'],
                        ['id' => 'withdraw', 'label' => 'Tarik Saldo', 'icon' => 'ki-wallet'],
                        ['id' => 'affiliate', 'label' => 'Afiliasi & Royalti', 'icon' => 'ki-discount'],
                        ['id' => 'gallery', 'label' => 'Member Referral', 'icon' => 'ki-people'],
                        ['id' => 'document', 'label' => 'Dokumen', 'icon' => 'ki-files'],
                    ];
                @endphp

                @foreach ($tabs as $index => $tab)
                    <button onclick="switchTab('{{ $tab['id'] }}')" 
                            id="tab-btn-{{ $tab['id'] }}"
                            class="tab-btn flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-bold whitespace-nowrap transition-all duration-300
                            {{ $index === 0 ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <i class="ki-filled {{ $tab['icon'] }} text-lg"></i>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== TAB CONTENT ===== --}}
    <div class="kt-container-fixed py-10">
        <div class="tab-content-container">
            <div id="tab-profile" class="tab-content transition-all duration-300">
                @include('landing.pages.account.components.account-pane', ['user' => $user])
            </div>
            <div id="tab-my-books" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.my-books', ['bookHistories' => $bookHistories])
            </div>
            <div id="tab-collaborator" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.collaboration-history', ['collaborators' => $bookColaborators])
            </div>
            <div id="tab-transaction" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.transaction-history', ['transactions' => $transactions])
            </div>
            <div id="tab-withdraw" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.withdrawl-pane')
            </div>
            <div id="tab-affiliate" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.affiliate-royalty', ['commissionHistories' => $commissionHistories])
            </div>
            <div id="tab-gallery" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.refferal-pane', ['referrals' => $referrals])
            </div>
            <div id="tab-individual-books" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.individual-book-history', ['transactions' => $transactions])
            </div>
            <div id="tab-document" class="tab-content hidden transition-all duration-300">
                @include('landing.pages.account.components.document-pane', ['documents' => $documents])
            </div>
        </div>
    </div>

</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const TAB_KEY = 'active_account_tab';

    function switchTab(tabId) {
        // Hide all content with a slight fade
        $('.tab-content').addClass('hidden opacity-0 translate-y-4');
        
        // Reset all buttons
        $('.tab-btn').removeClass('bg-primary text-white shadow-lg shadow-primary/20').addClass('text-gray-500 hover:bg-gray-50');

        // Show selected content
        const activeContent = $('#tab-' + tabId);
        activeContent.removeClass('hidden');
        setTimeout(() => {
            activeContent.removeClass('opacity-0 translate-y-4');
        }, 50);

        // Activate button
        $('#tab-btn-' + tabId).addClass('bg-primary text-white shadow-lg shadow-primary/20').removeClass('text-gray-500 hover:bg-gray-50');

        // Store in local storage
        localStorage.setItem(TAB_KEY, tabId);
    }

    $(document).ready(function() {
        // Restore active tab
        const savedTab = localStorage.getItem(TAB_KEY);
        if (savedTab && $('#tab-' + savedTab).length) {
            switchTab(savedTab);
        } else {
            // Default to profile
            switchTab('profile');
        }

        // Copy referral link
        $('.link-referral').click(function(e) {
            e.preventDefault();
            const referral = $(this).data('referral');
            const link = '{{ route("register", ["ref" => ""]) }}' + referral;
            navigator.clipboard.writeText(link).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Link referral berhasil disalin ke clipboard.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        });
    });
</script>
@endpush
