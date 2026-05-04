
@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden py-3" style="min-height: 80vh;">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-8 col-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
            <div class="mb-3 mb-sm-0">
              <h4 class="card-title fw-semibold">Checkout</h4>
              <p class="card-subtitle">List transaksi anda.</p>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
              <thead>
                <tr class="text-muted fw-semibold">
                  <th scope="col" class="ps-0">Buku</th>
                  <th scope="col">Jenis</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Kuantiti</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody class="border-top">
                @forelse ($items as $item)
                    <tr>
                        <td class="ps-0">
                            <div class="d-flex align-items-center">
                            <div class="me-2 pe-1">
                                <img src="{{ isset($item['cover']) ? asset('storage').'/'.$item['cover'] : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}" class="rounded-2" width="48" height="48" alt="modernize-img">
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $item['title'] }}</h6>
                                <p class="fs-2 mb-0 text-muted">Katerogi: {{ isset($item['module_id']) ? 'Modul' : $item['category_name'] }}</p>
                            </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge fw-semibold py-1 bg-success-subtle text-success">{{ $item['type'] == 'digital' ? 'E Book' : (isset($item['module_id']) ? 'Modul' : 'Cetak') }}</span>
                        </td>
                        <td>
                            <p class="mb-0 fs-3 text-dark">Rp.{{ number_format($item['price'], 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p class="mb-0 fs-3 text-dark">{{ $item['quantity'] }}</p>
                        </td>
                        <td>
                            <p class="mb-0 fs-3 text-dark fw-bolder">Rp.{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <p class="mb-0 fs-4 text-dark">Tidak ada buku dalam keranjang.</p>
                        </td>
                    </tr>
                @endforelse
                <tr>
                  <td colspan="4" class="fw-bolder text-end fs-4">Subtotal:</td>
                  <td class="fw-bolder fs-4" id="subtotal-display">Rp.{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td colspan="4" class="fw-bolder text-end fs-4">Biaya Admin:</td>
                  <td class="fw-bolder fs-4" id="admin-fee-display">Rp.{{ number_format($adminFee, 0, ',', '.') }}</td>
                </tr>
                <tr id="discount-row" class="{{ $discountAmount > 0 ? '' : 'd-none' }}">
                  <td colspan="4" class="fw-bolder text-end fs-4 text-success">Diskon:</td>
                  <td class="fw-bolder fs-4 text-success" id="discount-display">Rp.{{ number_format($discountAmount, 0, ',', '.') }}</td>
                </tr>
                <tr id="final-total-row">
                  <td colspan="4" class="fw-bolder text-end fs-4">Total Akhir:</td>
                  <td class="fw-bolder fs-4" id="final-total-display">Rp.{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                    <div class="mb-3 mb-sm-0">
                    <h4 class="card-title fw-semibold">Informasi</h4>
                    <p class="card-subtitle">Detail informasi pengguna.</p>
                    </div>
                </div>
                <form class="floating-labels mt-4 pt-2" action="{{ route('order.book.store') }}" method="POST" id="checkout-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                    <input type="text" class="form-control" id="name" value="{{ auth()->user()->full_name }}" readonly>
                    <span class="bar"></span>
                    <label for="input1">Nama</label>
                    </div>
                    <div class="form-group mb-4">
                    <input type="text" class="form-control" id="phone_number" value="{{ auth()->user()->phone_number ?? "-" }}" readonly>
                    <span class="bar"></span>
                    <label for="input2">No Whatsapp</label>
                    </div>
                    <div class="form-group mb-4">
                    <textarea class="form-control" rows="4" id="input7">
                    </textarea>
                    <span class="bar"></span>
                    <label for="input7">Alamat</label>
                    </div>
                    <div class="form-group mb-4">
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control" id="discount_code" name="promo_code" value="{{ $promoCode ?? '' }}" {{ $promoCode ? 'readonly' : '' }}>
                                <span class="bar"></span>
                                <label for="discount_code">Kode Promo (opsional)</label>
                            </div>
                            @if(!$promoCode)
                                <button type="button" class="btn btn-outline-primary" id="apply-promo-btn" style="height: 38px;">Apply</button>
                            @else
                                <button type="button" class="btn btn-outline-danger" id="remove-promo-btn" style="height: 38px;">Hapus</button>
                            @endif
                        </div>
                        <div id="promo-message" class="mt-2"></div>
                    </div>
                    @if($promoCode)
                        <div id="promo-discount" class="alert alert-success">
                            <strong>Diskon:</strong> <span id="discount-amount">Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <div id="promo-discount" class="alert alert-success d-none">
                            <strong>Diskon:</strong> <span id="discount-amount"></span>
                        </div>
                    @endif
                    {{-- <div class="mb-4">
                        <x-dropzone
                            name="payment_proof"
                            label=""
                            accept="image/*"
                            :maxSize="2"
                            :required="true"
                            helperText="Upload bukti pembayaran dengan jelas"
                        />
                    </div> --}}

                    <input type="hidden" name="total_price" value="{{ $total - ($discountAmount ?? 0) }}" id="total-price">
                    <input type="hidden" name="payment_method" value="bank_transfer">
                    <input type="hidden" name="discount_amount" value="{{ $discountAmount ?? 0 }}" id="discount-amount-field">
                    <input type="hidden" name="admin_fee" value="{{ $adminFee ?? 0 }}">

                    @foreach ($items as $index => $item)
                        @if (isset($item['module_id']))
                            <input type="hidden" name="transaction_details[{{ $index }}][module_id]" value="{{ $item['module_id'] }}">
                        @else
                            <input type="hidden" name="transaction_details[{{ $index }}][book_id]" value="{{ $item['book_id'] }}">
                        @endif
                        <input type="hidden" name="transaction_details[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                        <input type="hidden" name="transaction_details[{{ $index }}][price_book]" value="{{ $item['price'] }}">
                        <input type="hidden" name="transaction_details[{{ $index }}][price_discount]" value="0">
                        <input type="hidden" name="transaction_details[{{ $index }}][type]" value="{{ $item['type'] }}">
                    @endforeach

                    {{-- <button type="submit" class="btn btn-primary" id="complete-order-btn">
                        <i class="ti ti-check"></i> Selesaikan Pesanan
                    </button> --}}
                    <button class="btn btn-primary w-100" id="complete-order-btn">Checkout</button>
              </form>
            </div>
        </div>
    </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
    $('.floating-labels .form-control').on('focus blur', function (e) {
      $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');
  </script>

    {{-- Script untuk validasi form checkout --}}
    <script>
        $(document).ready(function() {
            let subtotal = {{ $subtotal }};
            let adminFee = {{ $adminFee }};
            let currentTotal = {{ $total }};

            // Apply promo code
            $('#apply-promo-btn').click(function() {
                const promoCode = $('#discount_code').val().trim();
                if (!promoCode) {
                    $('#promo-message').html('<div class="alert alert-warning">Masukkan kode promo</div>');
                    return;
                }

                $.ajax({
                    url: '{{ route("checkout.apply-promo") }}',
                    method: 'POST',
                    data: {
                        promo_code: promoCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#promo-message').html('<div class="alert alert-success">' + response.message + '</div>');

                            // Update discount display
                            const discount = response.discount;
                            const finalTotal = subtotal + adminFee - discount;

                            $('#discount-amount').text('Rp. ' + discount.toLocaleString('id-ID'));
                            $('#discount-display').text('Rp. ' + discount.toLocaleString('id-ID'));
                            $('#final-total-display').text('Rp. ' + finalTotal.toLocaleString('id-ID'));

                            // Update hidden fields
                            $('#discount-amount-field').val(discount);
                            $('#total-price').val(finalTotal);

                            // Show discount row
                            $('#discount-row').removeClass('d-none');
                            $('#promo-discount').removeClass('d-none');

                            // Disable promo code input and change button
                            $('#discount_code').prop('readonly', true);
                            $('#apply-promo-btn').removeClass('btn-outline-primary').addClass('btn-outline-danger').text('Hapus').attr('id', 'remove-promo-btn');
                        } else {
                            $('#promo-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        $('#promo-message').html('<div class="alert alert-danger">Kode promo tidak valid atau telah kadaluarsa</div>');
                    }
                });
            });

            // Remove promo code
            $(document).on('click', '#remove-promo-btn', function() {
                // Reset to original state
                $('#discount_code').val('').prop('readonly', false);
                $('#remove-promo-btn').removeClass('btn-outline-danger').addClass('btn-outline-primary').text('Apply').attr('id', 'apply-promo-btn');

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
                    url: '{{ route("checkout.remove-promo") }}',
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

                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...').addClass('disabled');

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

                                window.location.href = "{{ route('checkout.success', ':id') }}".replace(':id', transaction.transaction_code);
                            }
                        });
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Transaksi gagal dibuat. Silakan coba lagi.";
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
