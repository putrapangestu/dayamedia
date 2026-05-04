@extends('landing.layouts.app')

@section('content')
    <div class="main-wrapper overflow-hidden py-3" style="min-height: 80vh;">
        <div class="container">
            <div class="col-md-12 col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                            <div class="mb-3 mb-sm-0">
                                <h4 class="card-title fw-semibold">Keranjang</h4>
                                <p class="card-subtitle">Pilih buku yang ingin Anda beli.</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-primary disabled" id="checkout-btn">
                                    <i class="ti ti-shopping-cart-plus"></i> Beli Sekarang (<span
                                        id="selected-items-count">0</span>)
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0">
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th><input type="checkbox" class="form-check-input" id="select-all-checkbox"></th>
                                        <th scope="col" class="ps-0">Buku</th>
                                        <th scope="col">Jenis</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    @forelse ($carts as $cart)
                                        @if ($cart->book)
                                            <tr class="cart-item-row" data-cart-id="{{ $cart->id }}"
                                                data-price-digital="{{ $cart->book->price_digital }}"
                                                data-price-physical="{{ $cart->book->price_physical }}"
                                                data-book-id="{{ $cart->book_id }}">
                                                <td><input type="checkbox" class="form-check-input item-checkbox"></td>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2 pe-1">
                                                            <img src="{{ $cart->book->cover ? asset('storage/' . $cart->book->cover) : 'https://via.placeholder.com/48' }}"
                                                                class="rounded-2" width="48" height="48"
                                                                alt="book-cover">
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">{{ $cart->book->title }}</h6>
                                                            <p class="fs-2 mb-0 text-muted">Kategori:
                                                                {{ $cart->book->category?->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm book-type-select"
                                                        style="width: 120px;">
                                                        <option value="digital" {{ $cart->type == 'digital' ? 'selected' : '' }}>
                                                            E-Book</option>
                                                        <option value="physical"
                                                            {{ $cart->type == 'physical' ? 'selected' : '' }}>Cetak</option>
                                                    </select>
                                                </td>
                                                <td class="item-price">
                                                    Rp.{{ number_format($cart->type == 'digital' ? $cart->book->price_digital : $cart->book->price_physical, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group justify-content-center align-items-center"
                                                        role="group">
                                                        <button type="button"
                                                            class="btn btn-sm bg-primary-subtle text-primary quantity-btn"
                                                            data-action="decrease">
                                                            <i class="ti ti-minus"></i>
                                                        </button>
                                                        <input type="number" value="{{ $cart->quantity }}" min="1"
                                                            class="form-control form-control-sm text-center fw-bolder mx-2 quantity-input"
                                                            style="max-width: 60px;" readonly />
                                                        <button type="button"
                                                            class="btn btn-sm bg-primary-subtle text-primary quantity-btn"
                                                            data-action="increase">
                                                            <i class="ti ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="item-subtotal fw-bolder">
                                                    Rp.{{ number_format(($cart->type == 'digital' ? $cart->book->price_digital : $cart->book->price_physical) * $cart->quantity, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger remove-item-btn"><i
                                                            class="ti ti-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <h5 class="fw-semibold">Keranjang Anda Kosong</h5>
                                                <a href="{{ route('catalog') }}" class="btn btn-primary mt-2">Mulai
                                                    Belanja</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    @if ($carts->isNotEmpty())
                                        <tr>
                                            <td colspan="5" class="fw-bolder text-end fs-4 pt-4">Total Harga:</td>
                                            <td colspan="2" class="fw-bolder fs-4 pt-4" id="grand-total">Rp.0</td>
                                        </tr>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            const TOKEN = '{{ csrf_token() }}';

            function formatCurrency(number) {
                return 'Rp.' + new Intl.NumberFormat('id-ID').format(number);
            }

            function updateRowAndTotals(row) {
                const priceDigital = parseFloat(row.data('price-digital'));
                const pricePhysical = parseFloat(row.data('price-physical'));
                const type = row.find('.book-type-select').val();
                const quantity = parseInt(row.find('.quantity-input').val());

                const price = type === 'digital' ? priceDigital : pricePhysical;
                const subtotal = price * quantity;

                row.find('.item-price').text(formatCurrency(price));
                row.find('.item-subtotal').text(formatCurrency(subtotal));

                updateGrandTotal();
                // updateCartOnServer(row.data('cart-id'), {
                //     quantity: quantity,
                //     type: type
                // });
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                let selectedItemsCount = 0;

                $('.cart-item-row').each(function() {
                    const row = $(this);
                    const isChecked = row.find('.item-checkbox').is(':checked');

                    if (isChecked) {
                        selectedItemsCount++;
                        const subtotalText = row.find('.item-subtotal').text().replace('Rp.', '').replace(/\./g,
                            '');
                        grandTotal += parseInt(subtotalText, 10);
                    }
                });

                $('#grand-total').text(formatCurrency(grandTotal));
                $('#selected-items-count').text(selectedItemsCount);

                if (selectedItemsCount > 0) {
                    $('#checkout-btn').removeClass('disabled');
                } else {
                    $('#checkout-btn').addClass('disabled');
                }
            }

            function updateCartOnServer(cartId, data) {
                $.ajax({
                    url: `/cart/${cartId}`,
                    method: 'PUT',
                    data: { ...data,
                        _token: TOKEN
                    },
                    success: function(response) {
                        console.log('Cart updated on server.');
                    },
                    error: function() {
                        // Optionally notify user that server update failed
                        console.error('Failed to update cart on server.');
                    }
                });
            }

            // Event handler untuk tombol kuantitas
            $('.quantity-btn').on('click', function() {
                const action = $(this).data('action');
                const row = $(this).closest('.cart-item-row');
                const quantityInput = row.find('.quantity-input');
                let quantity = parseInt(quantityInput.val());

                if (action === 'increase') {
                    quantity++;
                } else if (action === 'decrease' && quantity > 1) {
                    quantity--;
                }

                quantityInput.val(quantity);
                updateRowAndTotals(row);
            });

            // Event handler untuk dropdown jenis buku
            $('.book-type-select').on('change', function() {
                const row = $(this).closest('.cart-item-row');
                updateRowAndTotals(row);
            });

            // Event handler untuk hapus item
            $('.remove-item-btn').on('click', function() {
                if (!confirm('Anda yakin ingin menghapus item ini?')) return;

                const row = $(this).closest('.cart-item-row');
                const cartId = row.data('cart-id');

                $.ajax({
                    url: `/cart/${cartId}`,
                    method: 'DELETE',
                    data: {
                        _token: TOKEN
                    },
                    success: function(response) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                            updateGrandTotal();
                            if ($('.cart-item-row').length === 0) {
                                location.reload(); // Reload jika keranjang jadi kosong
                            }
                        });
                    },
                    error: function() {
                        alert('Gagal menghapus item.');
                    }
                });
            });

            // Event handler untuk checkbox
            $('#select-all-checkbox, .item-checkbox').on('change', function() {
                if ($(this).is('#select-all-checkbox')) {
                    $('.item-checkbox').prop('checked', $(this).is(':checked'));
                }
                updateGrandTotal();
            });

            // Initial calculation on page load
            $('.item-checkbox').prop('checked', false);
            $('#select-all-checkbox').prop('checked', false);
            updateGrandTotal();


            // event handler untuk tombol checkout
            $('#checkout-btn').on('click', function(e) {
                e.preventDefault();

                if ($(this).hasClass('disabled')) {
                    return;
                }

                let items = [];
                let total_price = 0;

                $('.cart-item-row').each(function() {
                    const row = $(this);
                    if (row.find('.item-checkbox').is(':checked')) {
                        const type = row.find('.book-type-select').val();
                        const price = type === 'digital' ? parseFloat(row.data('price-digital')) :
                            parseFloat(row.data('price-physical'));
                        const quantity = parseInt(row.find('.quantity-input').val());

                        items.push({
                            book_id: row.data('book-id'),
                            quantity: quantity,
                            type: type,
                            price: price
                        });

                        total_price += price * quantity;
                    }
                });

                if (items.length === 0) {
                    alert('Pilih setidaknya satu buku untuk dibeli.');
                    return;
                }

                const checkoutBtn = $(this);
                const originalBtnText = checkoutBtn.html();
                checkoutBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...'
                    ).addClass('disabled');

                $.ajax({
                    url: '{{ route('checkout.process') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: items,
                        total_price: total_price
                    },
                    success: function(response) {
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        alert('Gagal memproses checkout. Silakan coba lagi.');
                        console.error(xhr.responseText);
                        checkoutBtn.html(originalBtnText).removeClass('disabled');
                    }
                });
            });
        });
    </script>
@endpush
