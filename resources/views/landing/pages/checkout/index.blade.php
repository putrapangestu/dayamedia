@extends('landing.layouts.app')

@section('content')
    <div class="">
        <!-- Container -->
        <div class="kt-container-fixed">
            <div class="border-t border-border dark:border-coal-100">
            </div>
            <div class="flex items-center justify-between flex-wrap gap-2 la:gap-5 my-5">
                <div class="flex flex-col gap-1">
                    <h1 class="font-medium text-lg text-mono">
                        Checkout
                    </h1>
                    <div class="flex items-center gap-1 text-sm">
                        <a class="text-secondary-foreground hover:text-primary" href="../../index.html">
                            Beranda
                        </a>
                        <span class="text-muted-foreground text-sm">
                            /
                        </span>
                        <span class="text-secondary-foreground">
                            Checkout
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>
    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Kiri -->
            <div class="lg:col-span-2 flex flex-col gap-5">

                <!-- Tabel Checkout -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <div class="kt-card-heading">
                            <h3 class="kt-card-title">Checkout</h3>
                            <p class="kt-card-description">List transaksi anda.</p>
                        </div>
                    </div>
                    <div class="kt-card-table">
                        <table class="kt-table">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Kuantiti</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $items = [
                                        (object) [
                                            'book' => (object) [
                                                'title' => 'Ilmu Pendidikan',
                                                'cover_url' => 'https://placehold.co/48x60',
                                                'category' => (object) ['name' => 'Pendidikan'],
                                            ],
                                            'type' => 'digital',
                                            'price' => 80000,
                                            'quantity' => 1,
                                        ],
                                    ];
                                @endphp

                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}"
                                                    class="rounded-sm shrink-0"
                                                    style="width:48px;height:60px;object-fit:cover;" />
                                                <div>
                                                    <p class="font-medium text-sm mb-0">{{ $item->book->title }}</p>
                                                    <p class="text-xs text-muted-foreground mt-0">Katerogi:
                                                        {{ $item->book->category->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="kt-badge kt-badge-outline kt-badge-info">{{ $item->type === 'digital' ? 'E Book' : 'Fisik' }}</span>
                                        </td>
                                        <td class="text-sm">{{ 'Rp.' . number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-sm">{{ $item->quantity }}</td>
                                        <td class="font-medium text-sm">
                                            {{ 'Rp.' . number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Informasi Pengguna -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <div class="kt-card-heading">
                            <h3 class="kt-card-title">Informasi Pengguna</h3>
                            <p class="kt-card-description">Detail informasi pengguna dan kontak.</p>
                        </div>
                    </div>
                    <div class="kt-card-content flex flex-col gap-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm text-muted-foreground">Nama</span>
                            <span class="text-sm font-medium">{{ auth()->user()->full_name }}</span>
                            <div class="kt-separator"></div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm text-muted-foreground">No Whatsapp</span>
                            <span class="text-sm font-medium">{{ auth()->user()->phone ?? '-' }}</span>
                            <div class="kt-separator"></div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm text-muted-foreground">Alamat</span>
                            <span class="text-sm font-medium">{{ auth()->user()->address ?? '-' }}</span>
                            <div class="kt-separator"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kanan: Ringkasan Pesanan -->
            <div class="lg:col-span-1">
                <div class="kt-card">
                    <div class="kt-card-content flex flex-col gap-5">

                        <h3 class="kt-card-title">Ringkasan Pesanan</h3>

                        <!-- Metode Pembayaran -->
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-medium">Metode Pembayaran</span>
                            <div class="kt-card border-primary/10 bg-primary/5 cursor-pointer">
                                <div class="kt-card-content py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="kt-btn kt-btn-sm kt-btn-secondary kt-btn-icon rounded-lg shrink-0">
                                                <i class="ki-filled ki-bank text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-primary mb-0">Transfer Bank</p>
                                                <p class="text-xs text-muted-foreground mt-0">Virtual Account & Transfer</p>
                                            </div>
                                        </div>
                                        <i class="ti ti-circle-check text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kode Promo -->
                        <div class="kt-input-group">
                            <input type="text" class="kt-input" placeholder="Kode Promo (opsional)" id="promo-code" />
                            <button class="kt-btn kt-btn-outline" type="button" id="apply-promo-btn">Apply</button>
                        </div>

                        <!-- Rincian Harga -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Subtotal:</span>
                                <span class="text-sm font-medium"
                                    id="subtotal-display">{{ 'Rp.' . number_format(130000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Biaya Admin:</span>
                                <span class="text-sm font-medium"
                                    id="admin-fee-display">{{ 'Rp.' . number_format(10000, 0, ',', '.') }}</span>
                            </div>
                            <div class="kt-separator"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-base font-semibold">Total Akhir:</span>
                                <span class="text-base font-semibold text-primary"
                                    id="total-akhir-display">{{ 'Rp.' . number_format(140000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Tombol Checkout -->
                        <button class="kt-btn w-full" type="button" id="checkout-btn">
                            Checkout
                        </button>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js')
    <script>
        $('.floating-labels .form-control').on('focus blur', function(e) {
            $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    </script>

    {{-- Script untuk validasi form checkout --}}
    <script>
        $(document).ready(function() {
            let subtotal = 130000;
            let adminFee = 10000;
            let currentTotal = 140000;

            // Apply promo code
            $('#apply-promo-btn').click(function() {
                const promoCode = $('#discount_code').val().trim();
                if (!promoCode) {
                    $('#promo-message').html('<div class="alert alert-warning">Masukkan kode promo</div>');
                    return;
                }

                $.ajax({
                    url: '{{ route('checkout.apply-promo') }}',
                    method: 'POST',
                    data: {
                        promo_code: promoCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#promo-message').html('<div class="alert alert-success">' +
                                response.message + '</div>');

                            // Update discount display
                            const discount = response.discount;
                            const finalTotal = subtotal + adminFee - discount;

                            $('#discount-amount').text('Rp. ' + discount.toLocaleString(
                                'id-ID'));
                            $('#discount-display').text('Rp. ' + discount.toLocaleString(
                                'id-ID'));
                            $('#final-total-display').text('Rp. ' + finalTotal.toLocaleString(
                                'id-ID'));

                            // Update hidden fields
                            $('#discount-amount-field').val(discount);
                            $('#total-price').val(finalTotal);

                            // Show discount row
                            $('#discount-row').removeClass('d-none');
                            $('#promo-discount').removeClass('d-none');

                            // Disable promo code input and change button
                            $('#discount_code').prop('readonly', true);
                            $('#apply-promo-btn').removeClass('btn-outline-primary').addClass(
                                'btn-outline-danger').text('Hapus').attr('id',
                                'remove-promo-btn');
                        } else {
                            $('#promo-message').html('<div class="alert alert-danger">' +
                                response.message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        $('#promo-message').html(
                            '<div class="alert alert-danger">Kode promo tidak valid atau telah kadaluarsa</div>'
                        );
                    }
                });
            });

            // Remove promo code
            $(document).on('click', '#remove-promo-btn', function() {
                // Reset to original state
                $('#discount_code').val('').prop('readonly', false);
                $('#remove-promo-btn').removeClass('btn-outline-danger').addClass('btn-outline-primary')
                    .text('Apply').attr('id', 'apply-promo-btn');

                // Hide discount
                $('#discount-row').addClass('d-none');
                $('#promo-discount').addClass('d-none');
                $('#promo-message').empty();

                // Reset totals
                const finalTotal = subtotal + adminFee;
                $('#final-total-display').text('Rp. ' + finalTotal.toLocaleString('id-ID'));
                $('#total-price').val(finalTotal);
                $('#discount-amount-field').val(0);

                // Remove from session
                $.ajax({
                    url: '{{ route('checkout.remove-promo') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                });
            });

            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();

                const submitBtn = $('#complete-order-btn');
                const originalText = submitBtn.html();

                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...'
                ).addClass('disabled');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        let transaction = response.data
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Transaksi berhasil dibuat. Silakan periksa detail transaksi di profile Anda.",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {

                                window.location.href =
                                    "{{ route('checkout.success', ':id') }}".replace(
                                        ':id', transaction.transaction_code);
                            }
                        });
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message :
                            "Transaksi gagal dibuat. Silakan coba lagi.";
                        Swal.fire({
                            title: "Gagal!",
                            text: message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        console.error(xhr.responseText);
                        submitBtn.html(originalText).removeClass('disabled');
                    }
                });
            });
        });
    </script>
@endpush
