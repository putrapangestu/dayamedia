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
                        Keranjang
                    </h1>
                    <div class="flex items-center gap-1 text-sm">
                        <a class="text-secondary-foreground hover:text-primary" href="../../index.html">
                            Beranda
                        </a>
                        <span class="text-muted-foreground text-sm">
                            /
                        </span>
                        <span class="text-secondary-foreground">
                            Keranjang
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>
    <div class="kt-container-fixed">
        <div class="kt-card">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h3 class="kt-card-title">Keranjang</h3>
                    <p class="kt-card-description">Pilih buku yang ingin Anda beli.</p>
                </div>
                <div class="kt-card-toolbar">
                    <button class="kt-btn">
                        <i class="ti ti-shopping-cart"></i>
                        Beli Sekarang (0)
                    </button>
                </div>
            </div>

            <div class="kt-card-table">
                <table class="kt-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" class="kt-checkbox" />
                            </th>
                            <th>Buku</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="kt-checkbox" id="cb1" checked onchange="recalc()" />
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="https://placehold.co/48x60" alt="Ilmu Pendidikan"
                                        class="rounded-sm shrink-0" style="width:48px;height:60px;object-fit:cover;" />
                                    <div>
                                        <p class="font-medium text-sm mb-0">Ilmu Pendidikan</p>
                                        <p class="text-xs text-muted-foreground mt-0">Kategori: Pendidikan</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select class="kt-select kt-select-sm" style="width: 120px;">
                                    <option>E-Book</option>
                                    <option>Fisik</option>
                                </select>
                            </td>
                            <td>
                                <span class="font-medium text-sm">Rp.80.000</span>
                            </td>
                            <td>
                                <div class="kt-input flex items-center gap-0" style="width: fit-content;">
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost" onclick="changeQty(-1)" type="button">
                                        <i class="ki-filled ki-minus"></i>
                                    </button>
                                    <input type="number" id="qty1" value="1" min="1"
                                        class="text-center text-sm font-medium"
                                        style="width:40px;border:none;outline:none;background:transparent;"
                                        onchange="recalc()" />
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost" onclick="changeQty(1)" type="button">
                                        <i class="ki-filled ki-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span class="font-medium text-sm" id="subtotal1">Rp.80.000</span>
                            </td>
                            <td>
                                <button class="kt-btn kt-btn-sm kt-btn-destructive" type="button">
                                    <i class="ki-filled ki-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex items-center justify-end gap-6 px-5 py-4 border-t border-border">
                    <span class="font-medium text-sm">Total Harga:</span>
                    <span class="font-semibold text-sm" id="total">Rp.0</span>
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
                        const subtotalText = row.find('.item-subtotal').text().replace('Rp.', '').replace(
                            /\./g,
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
                    data: {
                        ...data,
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
