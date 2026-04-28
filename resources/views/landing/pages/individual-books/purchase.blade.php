@extends('landing.layouts.app')

@section('content')
<div class="bg-light py-5" style="min-height: 100vh;">
    <div class="container" style="max-width: 1200px;">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('individual-books.packages') }}" class="btn btn-link text-decoration-none text-secondary d-inline-flex align-items-center p-0">
                <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                Kembali ke Daftar Paket
            </a>
        </div>

        <div class="row g-4">
            <!-- Left Column: Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom p-4">
                        <h1 class="h3 fw-bold text-dark mb-2">Konfigurasi Pesanan</h1>
                        <p class="text-muted mb-0">Sesuaikan paket Anda sebelum melanjutkan ke pembayaran.</p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('individual-books.purchase.store', $package) }}" method="POST" id="purchaseForm">
                            @csrf

                            <!-- Additional Authors Input -->
                            <div class="mb-4">
                                <label for="additionalAuthors" class="form-label fw-bold text-uppercase small text-secondary mb-3">
                                    Jumlah Penulis Tambahan
                                </label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                        <iconify-icon icon="solar:users-group-rounded-bold" class="text-secondary fs-5"></iconify-icon>
                                    </span>
                                    <input
                                        type="number"
                                        min="0"
                                        name="additional_authors_count"
                                        id="additionalAuthors"
                                        value="0"
                                        class="form-control border-start-0 rounded-end-3 ps-0"
                                        placeholder="0"
                                    />
                                </div>

                                @if($additionalAuthorPrice > 0)
                                    <div class="alert alert-info d-flex align-items-center mt-3 mb-0 border-0" style="background-color: #eff6ff; color: #1e40af;">
                                        <iconify-icon icon="solar:info-circle-bold" class="me-2 fs-5"></iconify-icon>
                                        <small>
                                            Biaya per penulis tambahan: <span class="fw-bold">Rp {{ number_format($additionalAuthorPrice, 0, ',', '.') }}</span>
                                        </small>
                                    </div>
                                @endif

                                <small class="text-muted fst-italic d-block mt-2">
                                    * Paket ini sudah termasuk {{ $package->max_authors_default }} penulis default.
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="promoCode" class="form-label fw-bold text-uppercase small text-secondary mb-3">
                                    Kode Promo (Opsional)
                                </label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                        <iconify-icon icon="solar:ticket-bold" class="text-secondary fs-5"></iconify-icon>
                                    </span>
                                    <input
                                        type="text"
                                        name="promo_code"
                                        id="promoCode"
                                        value="{{ old('promo_code') }}"
                                        class="form-control border-start-0 rounded-end-3 ps-0"
                                        placeholder="Masukkan kode promo"
                                    />
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-3">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center fw-bold rounded-3 shadow"
                                    style="padding: 1rem 1.5rem;"
                                >
                                    <iconify-icon icon="solar:cart-check-bold" class="me-2 fs-4"></iconify-icon>
                                    Lanjutkan ke Pembayaran
                                </button>
                                <p class="text-center text-muted small mt-3 mb-0">
                                    Dengan melanjutkan, Anda menyetujui syarat dan ketentuan penerbitan kami.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <!-- Summary Header -->
                    <div class="card-header bg-light border-bottom p-4">
                        <h3 class="h6 fw-bold text-dark mb-0">Ringkasan Pesanan</h3>
                    </div>

                    <!-- Summary Body -->
                    <div class="card-body p-4">
                        <!-- Package Details -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="fw-semibold text-dark mb-1">{{ $package->name }}</p>
                                <small class="text-muted">{{ $package->max_authors_default }} Penulis Default</small>
                            </div>
                            <p class="fw-bold text-dark mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        </div>

                        <!-- Additional Cost Row (Hidden by default) -->
                        <div id="additionalCostRow" class="d-none">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="fw-semibold text-dark mb-1">Penulis Tambahan</p>
                                    <small class="text-muted" id="additionalCountText">0 Penulis</small>
                                </div>
                                <p class="fw-bold text-dark mb-0" id="additionalCostText">Rp 0</p>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="border-top pt-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fw-bold text-dark mb-0">Total Harga</p>
                                <p class="h5 fw-bold text-primary mb-0" id="totalPriceText">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Package Benefits -->
                        {{-- <div class="pt-3">
                            <p class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.7rem; letter-spacing: 0.1em;">
                                Manfaat Paket:
                            </p>
                            <ul class="list-unstyled mb-0">
                                @foreach($package->benefits->take(5) as $benefit)
                                    <li class="d-flex align-items-start mb-2">
                                        <iconify-icon icon="solar:check-circle-bold" class="text-success me-2 flex-shrink-0" style="font-size: 1.1rem; margin-top: 2px;"></iconify-icon>
                                        <small class="text-secondary">{{ $benefit->benefit_name }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('additionalAuthors');
        const basePrice = {{ $package->price }};
        const additionalPrice = {{ $additionalAuthorPrice }};

        const additionalCostRow = document.getElementById('additionalCostRow');
        const additionalCountText = document.getElementById('additionalCountText');
        const additionalCostText = document.getElementById('additionalCostText');
        const totalPriceText = document.getElementById('totalPriceText');

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        input.addEventListener('input', function() {
            const count = parseInt(this.value) || 0;
            const additionalCost = count * additionalPrice;
            const total = basePrice + additionalCost;

            if (count > 0) {
                additionalCostRow.classList.remove('d-none');
                additionalCountText.innerText = count + ' Penulis';
                additionalCostText.innerText = formatRupiah(additionalCost);
            } else {
                additionalCostRow.classList.add('d-none');
            }

            totalPriceText.innerText = formatRupiah(total);
        });
    });
</script>
@endsection
