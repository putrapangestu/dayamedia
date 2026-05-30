@extends('landing.layouts.app')

@section('title', 'Akun Saya - Daya Media')

@section('content')
{{-- FORCE 100% WIDTH AND HIDE OVERFLOW AT THE ROOT --}}
<div class="bg-gray-50/50 min-h-screen pb-20 flex flex-col w-full max-w-full overflow-x-hidden relative">

    {{-- ===== HEADER SECTION ===== --}}
    <div class="bg-white border-b border-gray-100 relative overflow-hidden w-full shrink-0">
        {{-- Background Ornaments --}}
        <div class="absolute top-0 right-0 size-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

        <div class="kt-container-fixed py-10 lg:py-16 relative z-10 w-full min-w-0">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16 w-full min-w-0">

                <!-- Avatar & Basic Info -->
                <div class="flex flex-col lg:flex-row items-center gap-6 flex-grow text-center lg:text-left min-w-0 w-full">
                    <div class="relative shrink-0">
                        <div class="size-28 sm:size-32 rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white transform lg:-rotate-3 bg-gray-50">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/dashboard/images/profile/user-1.jpg') }}"
                                 class="w-full h-full object-cover" alt="{{ $user->full_name }}">
                        </div>
                        <div class="absolute -bottom-2 -right-2 size-8 bg-green-500 border-4 border-white rounded-full shadow-lg"></div>
                    </div>

                    <div class="min-w-0 flex-1 w-full">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-lg text-[10px] font-black uppercase tracking-widest mb-3">
                            <i class="ki-filled ki-crown"></i> {{ $user->affiliateLevel?->name ?? 'Member' }}
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight leading-tight break-words">{{ $user->full_name }}</h1>
                        <p class="flex items-center justify-center lg:justify-start gap-2 text-gray-500 text-sm font-medium mt-1 truncate">
                            <i class="ki-filled ki-sms text-primary/50 shrink-0"></i>
                            <span class="truncate">{{ $user->email }}</span>
                        </p>
                    </div>
                </div>

                <!-- Fast Stats -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-12 w-full lg:w-auto border-t lg:border-t-0 lg:border-l border-gray-100 pt-8 lg:pt-0 lg:pl-12 shrink-0">
                    <div class="text-center min-w-0">
                        <p class="text-xl sm:text-2xl font-black text-gray-900 tracking-tighter">{{ $transactionCount }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Transaksi</p>
                    </div>
                    <div class="text-center border-y sm:border-y-0 sm:border-x border-gray-100 py-4 sm:py-0 sm:px-12 w-full sm:w-auto">
                        <p class="text-xl sm:text-2xl font-black text-gray-900 tracking-tighter">{{ $referralCount }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Referral</p>
                    </div>
                    <div class="text-center min-w-0">
                        <p class="text-xl sm:text-2xl font-black text-primary tracking-tighter">Rp{{ number_format($user->balance, 0, ',', '.') }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Saldo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STICKY TAB BAR (Refactored to Wrap Instead of Scroll) ===== --}}
    <div class="sticky top-[var(--header-height,100px)] z-20 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm w-full shrink-0">
        <div class="w-full max-w-7xl mx-auto px-4 py-2">
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-1 sm:gap-2" id="profile-tabs">
                @php
                    $tabs = [
                        ['id' => 'profile', 'label' => 'Profil', 'icon' => 'ki-user'],
                        ['id' => 'my-books', 'label' => 'Buku', 'icon' => 'ki-book'],
                        ['id' => 'collaborator', 'label' => 'Kolaborasi', 'icon' => 'ki-users'],
                        ['id' => 'transaction', 'label' => 'Transaksi', 'icon' => 'ki-handcart'],
                        ['id' => 'individual-books', 'label' => 'Penerbitan', 'icon' => 'ki-crown'],
                        ['id' => 'withdraw', 'label' => 'Withdraw', 'icon' => 'ki-wallet'],
                        ['id' => 'affiliate', 'label' => 'Afiliasi', 'icon' => 'ki-discount'],
                        ['id' => 'gallery', 'label' => 'Jaringan', 'icon' => 'ki-people'],
                        ['id' => 'document', 'label' => 'Berkas', 'icon' => 'ki-files'],
                    ];
                @endphp

                @foreach ($tabs as $index => $tab)
                    <button onclick="switchTab('{{ $tab['id'] }}')" 
                            id="tab-btn-{{ $tab['id'] }}"
                            class="tab-btn flex items-center gap-2 px-3 sm:px-5 py-2.5 sm:py-3.5 border-b-2 rounded-lg transition-all duration-300
                            {{ $index === 0 ? 'border-primary bg-primary/5 text-primary font-black' : 'border-transparent text-gray-400 hover:text-gray-900 font-bold hover:bg-gray-50' }}">
                        <i class="ki-filled {{ $tab['icon'] }} text-base shrink-0"></i>
                        <span class="text-[10px] sm:text-[11px] uppercase tracking-widest whitespace-nowrap">{{ $tab['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== MAIN CONTENT AREA ===== --}}
    <div class="w-full max-w-full overflow-x-hidden flex-grow">
        <div class="kt-container-fixed py-8 sm:py-12 w-full min-w-0">
            <div class="tab-content-container w-full min-w-0 overflow-hidden">
                <div id="tab-profile" class="tab-content transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.account-pane', ['user' => $user])
                </div>
                <div id="tab-my-books" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.my-books', ['bookHistories' => $bookHistories])
                </div>
                <div id="tab-collaborator" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.collaboration-history', ['collaborators' => $bookColaborators])
                </div>
                <div id="tab-transaction" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.transaction-history', ['transactions' => $transactions])
                </div>
                <div id="tab-withdraw" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.withdrawl-pane')
                </div>
                <div id="tab-affiliate" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.affiliate-royalty', ['commissionHistories' => $commissionHistories])
                </div>
                <div id="tab-gallery" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.refferal-pane', ['referrals' => $referrals])
                </div>
                <div id="tab-individual-books" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.individual-book-history', ['transactions' => $transactions])
                </div>
                <div id="tab-document" class="tab-content hidden transition-all duration-300 w-full min-w-0">
                    @include('landing.pages.account.components.document-pane', ['documents' => $documents])
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    /* Force internal tables and grids not to push parents */
    .tab-content-container * { min-width: 0; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const TAB_KEY = 'active_account_tab';

    function switchTab(tabId) {
        $('.tab-content').addClass('hidden opacity-0 translate-y-4');
        $('.tab-btn').removeClass('border-primary bg-primary/5 text-primary font-black').addClass('border-transparent text-gray-400 font-bold');

        const activeContent = $('#tab-' + tabId);
        if(activeContent.length) {
            activeContent.removeClass('hidden');
            setTimeout(() => { activeContent.removeClass('opacity-0 translate-y-4'); }, 50);
        }

        const activeBtn = $('#tab-btn-' + tabId);
        if(activeBtn.length) {
            activeBtn.addClass('border-primary bg-primary/5 text-primary font-black').removeClass('border-transparent text-gray-400 font-bold');
        }
        localStorage.setItem(TAB_KEY, tabId);
    }

    $(document).ready(function() {
        const savedTab = localStorage.getItem(TAB_KEY);
        if (savedTab && $('#tab-' + savedTab).length) {
            switchTab(savedTab);
        } else {
            switchTab('profile');
        }

        $('.link-referral').click(function(e) {
            e.preventDefault();
            const referral = $(this).data('referral');
            const link = '{{ route("register", ["ref" => ""]) }}' + referral;
            navigator.clipboard.writeText(link).then(() => {
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: 'Link referral berhasil disalin.',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
                });
            });
        });
    });
</script>
@endpush
