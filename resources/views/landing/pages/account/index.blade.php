@extends('landing.layouts.app')

@section('content')
    <div class="main-wrapper overflow-hidden">
        <div class="container py-3">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <img src="{{ asset('') }}assets/dashboard/images/backgrounds/profilebg.jpg" alt="modernize-img"
                        class="img-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-4 order-lg-1 order-2">
                            <div class="d-flex align-items-center justify-content-around m-4">
                                <div class="text-center">
                                    <i class="ti ti-file-description fs-6 d-block mb-2"></i>
                                    <h4 class="mb-0 lh-1">{{ $transactionCount }}</h4>
                                    <p class="mb-0 ">Transaksi</p>
                                </div>
                                <div class="text-center">
                                    <i class="ti ti-user-circle fs-6 d-block mb-2"></i>
                                    <h4 class="mb-0 lh-1">{{ $referralCount }}</h4>
                                    <p class="mb-0 ">Refferal</p>
                                </div>
                                <div class="text-center">
                                    <i class="ti ti-user-check fs-6 d-block mb-2"></i>
                                    <h4 class="mb-0 lh-1">{{ $collaborationCount }}</h4>
                                    <p class="mb-0 ">Kontributor Bab</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                            <div class="mt-n5">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="d-flex align-items-center justify-content-center round-110">
                                        <div
                                            class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/dashboard/images/profile/user-1.jpg') }}"
                                                alt="modernize-img" class="w-100 h-100">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="mb-0">{{ $user->full_name }}</h5>
                                    <p class="mb-0">{{ $user->affiliateLevel?->name ?? 'Member' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 order-last">
                            <div class="d-flex align-items-center justify-content-around m-4">
                                <div class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <h4 class="mb-0 lh-1">{{ $user->referral_code ?? '-' }}</h4>
                                        @if($user->referral_code)
                                            <button class="btn btn-sm btn-primary link-referral text-white" data-referral="{{ $user->referral_code }}" title="Salin Kode Referral">
                                                <i class="ti ti-link"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <p class="mb-0">Kode Referal</p>
                                </div>
                                <div class="text-center">
                                    <h4 class="mb-0 lh-1">Rp. {{ number_format($user->balance, 0, ',', '.') }}</h4>
                                    <p class="mb-0 ">Saldo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-pills user-profile-tab justify-content-end mt-2 bg-primary-subtle rounded-2 rounded-top-0"
                        id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6 active" id="pills-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="true">
                                <i class="ti ti-user-circle fs-5"></i>
                                <span class="d-none d-md-block">Profil Saya</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-my-books-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-my-books" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="true">
                                <i class="ti ti-books fs-5"></i>
                                <span class="d-none d-md-block">Buku Saya</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-collaborator-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-collaborator" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="true">
                                <i class="ti ti-users fs-5"></i>
                                <span class="d-none d-md-block">Kolaborator Bab</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-transaction-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-transaction" type="button" role="tab"
                                aria-controls="pills-transaction" aria-selected="true">
                                <i class="ti ti-shopping-cart fs-5"></i>
                                <span class="d-none d-md-block">Transaksi</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-withdraw-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-withdraw" type="button" role="tab"
                                aria-controls="pills-withdraw" aria-selected="false" tabindex="-1">
                                <i class="ti ti-wallet fs-5"></i>
                                <span class="d-none d-md-block">Withdraw</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-affiliate-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-affiliate" type="button" role="tab"
                                aria-controls="pills-affiliate" aria-selected="false" tabindex="-1">
                                <i class="ti ti-user-circle fs-5"></i>
                                <span class="d-none d-md-block">Affiliate & Royalti</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-gallery-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab"
                                aria-controls="pills-gallery" aria-selected="false" tabindex="-1">
                                <i class="ti ti-photo-plus fs-5"></i>
                                <span class="d-none d-md-block">Member Referal</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-individual-books-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-individual-books" type="button" role="tab"
                                aria-controls="pills-individual-books" aria-selected="false" tabindex="-1">
                                <i class="ti ti-book-2 fs-5"></i>
                                <span class="d-none d-md-block">Buku Individu</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link hstack gap-2 rounded-0 py-6" id="pills-document-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-document" type="button" role="tab"
                                aria-controls="pills-document" aria-selected="false" tabindex="-1">
                                <i class="ti ti-files fs-5"></i>
                                <span class="d-none d-md-block">Dokumen</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab" tabindex="0">
                    @include('landing.pages.account.components.account-pane', ['user' => $user])
                </div>
                <div class="tab-pane fade" id="pills-my-books" role="tabpanel"
                    aria-labelledby="pills-my-books-tab" tabindex="0">
                    @include('landing.pages.account.components.my-books', ['bookHistories' => $bookHistories])
                </div>
                <div class="tab-pane fade" id="pills-collaborator" role="tabpanel"
                    aria-labelledby="pills-collaborator-tab" tabindex="0">
                    @include('landing.pages.account.components.collaboration-history', ['collaborators' => $bookColaborators])
                </div>
                <div class="tab-pane fade" id="pills-transaction" role="tabpanel"
                    aria-labelledby="pills-transaction-tab" tabindex="0">
                    @include('landing.pages.account.components.transaction-history', ['transactions' => $transactions])
                </div>
                <div class="tab-pane fade" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab"
                    tabindex="0">
                    @include('landing.pages.account.components.withdrawl-pane')
                </div>
                <div class="tab-pane fade" id="pills-affiliate" role="tabpanel" aria-labelledby="pills-affiliate-tab"
                    tabindex="0">
                    @include('landing.pages.account.components.affiliate-royalty', ['commissionHistories' => $commissionHistories])
                </div>
                <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab"
                    tabindex="0">
                    @include('landing.pages.account.components.refferal-pane', ['referrals' => $referrals])
                </div>
                <div class="tab-pane fade" id="pills-individual-books" role="tabpanel" aria-labelledby="pills-individual-books-tab"
                    tabindex="0">
                    @include('landing.pages.account.components.individual-book-history', ['transactions' => $transactions])
                </div>
                <div class="tab-pane fade" id="pills-document" role="tabpanel" aria-labelledby="pills-document-tab"
                    tabindex="0">
                    @include('landing.pages.account.components.document-pane', ['documents' => $documents])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $(document).ready(function() {
            $('.link-referral').click(function() {
                const referral = $(this).data('referral');
                const link = '{{ route('register', ['ref' => '']) }}' + referral;
                navigator.clipboard.writeText(link);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Link referal berhasil disalin!',
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const triggerTabList = document.querySelectorAll('[data-bs-toggle="pill"]');

            // Ambil tab aktif dari localStorage
            const activeTab = localStorage.getItem('activePill');

            if (activeTab) {
                const someTabTriggerEl = document.querySelector(
                    `[data-bs-target="${activeTab}"]`
                );

                if (someTabTriggerEl) {
                    const tab = new bootstrap.Tab(someTabTriggerEl);
                    tab.show();
                }
            }

            // Simpan saat tab berubah
            triggerTabList.forEach(function (triggerEl) {
                triggerEl.addEventListener("shown.bs.tab", function (event) {
                    localStorage.setItem(
                        'activePill',
                        event.target.getAttribute("data-bs-target")
                    );
                });
            });

        });
        </script>
@endpush
