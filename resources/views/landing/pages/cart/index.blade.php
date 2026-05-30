@extends('landing.layouts.app')

@section('title', 'Keranjang Belanja - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20">
    <!-- Breadcrumb & Header -->
    <div class="py-10 bg-white border-b border-gray-100 mb-10">
        <div class="kt-container-fixed">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja</h1>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
                    <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
                    <span class="text-gray-900">Keranjang</span>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        @if($carts->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Sisi Kiri: Daftar Item -->
                <div class="lg:col-span-8 space-y-4">
                    <!-- Select All Header -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="select-all-checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                            <label for="select-all-checkbox" class="text-sm font-bold text-gray-700 cursor-pointer select-none">Pilih Semua Produk</label>
                        </div>
                        <button type="button" class="text-sm font-bold text-red-500 hover:text-red-600 transition-colors hidden" id="delete-selected">
                            Hapus Terpilih
                        </button>
                    </div>

                    <!-- List Produk -->
                    <div class="space-y-4">
                        @foreach ($carts as $cart)
                            @if ($cart->book)
                                <div class="cart-item-row bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 group" 
                                    data-cart-id="{{ $cart->id }}"
                                    data-price-digital="{{ $cart->book->price_digital }}"
                                    data-price-physical="{{ $cart->book->price_physical }}"
                                    data-book-id="{{ $cart->book_id }}">
                                    
                                    <div class="flex gap-4 sm:gap-6">
                                        <!-- Checkbox -->
                                        <div class="flex items-start pt-2">
                                            <input type="checkbox" class="item-checkbox w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer">
                                        </div>

                                        <!-- Cover Buku -->
                                        <div class="relative shrink-0">
                                            <div class="absolute inset-0 bg-primary/10 rounded-xl rotate-3 group-hover:rotate-6 transition-transform"></div>
                                            <img src="{{ $cart->book->cover ? asset('storage/' . $cart->book->cover) : 'https://placehold.co/120x160?text=No+Cover' }}" 
                                                class="relative w-24 sm:w-32 aspect-[3/4] object-cover rounded-xl shadow-sm border border-white" 
                                                alt="{{ $cart->book->title }}">
                                        </div>

                                        <!-- Info Detail -->
                                        <div class="flex flex-col grow gap-3">
                                            <div class="flex justify-between items-start gap-2">
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-2">
                                                        {{ $cart->book->title }}
                                                    </h3>
                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">
                                                        {{ $cart->book->category?->name ?? 'Tanpa Kategori' }}
                                                    </p>
                                                </div>
                                                <button type="button" class="remove-item-btn text-gray-300 hover:text-red-500 transition-colors p-1">
                                                    <i class="ki-filled ki-trash text-xl"></i>
                                                </button>
                                            </div>

                                            <!-- Opsi Jenis & Harga -->
                                            <div class="flex flex-wrap items-center justify-between gap-4 mt-auto">
                                                <div class="flex flex-col gap-2">
                                                    <select class="book-type-select kt-select kt-select-sm !w-40 h-10 !leading-none !text-xs font-bold bg-gray-50 border-gray-100 rounded-lg focus:bg-white transition-all">
                                                        <option value="digital" {{ $cart->type == 'digital' ? 'selected' : '' }}>E-Book (Digital)</option>
                                                        <option value="physical" {{ $cart->type == 'physical' ? 'selected' : '' }}>Buku Cetak</option>
                                                    </select>
                                                    <span class="item-price text-lg font-black text-primary">
                                                        Rp {{ number_format($cart->type == 'digital' ? $cart->book->price_digital : $cart->book->price_physical, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <!-- Quantity Control -->
                                                <div class="flex items-center bg-gray-50 border border-gray-100 rounded-xl p-1 shadow-inner">
                                                    <button type="button" class="quantity-btn size-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm text-gray-500 active:scale-90 transition-all" data-action="decrease">
                                                        <i class="ki-filled ki-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" value="{{ $cart->quantity }}" min="1" readonly
                                                        class="quantity-input w-10 text-center text-sm font-black bg-transparent border-none focus:ring-0">
                                                    <button type="button" class="quantity-btn size-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm text-gray-500 active:scale-90 transition-all" data-action="increase">
                                                        <i class="ki-filled ki-plus text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile Subtotal (Optional) -->
                                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-end">
                                        <span class="text-xs font-bold text-gray-400 uppercase mr-2 mt-1 text-right">Subtotal:</span>
                                        <span class="item-subtotal font-bold text-gray-900">
                                            Rp {{ number_format(($cart->type == 'digital' ? $cart->book->price_digital : $cart->book->price_physical) * $cart->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Sisi Kanan: Ringkasan Belanja (Sticky) -->
                <div class="lg:col-span-4 lg:sticky lg:top-[var(--header-height,100px)]">
                    <div class="bg-white border border-gray-100 rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm font-medium text-gray-500">
                                <span>Total Item</span>
                                <span id="selected-items-count" class="text-gray-900 font-bold">0</span>
                            </div>
                            <div class="flex justify-between text-sm font-medium text-gray-500">
                                <span>Total Harga</span>
                                <span id="grand-total-text" class="text-gray-900 font-bold">Rp 0</span>
                            </div>
                            <div class="pt-4 border-t border-gray-100 flex justify-between items-end">
                                <span class="text-base font-bold text-gray-900 uppercase">Subtotal</span>
                                <span id="grand-total" class="text-2xl font-black text-primary tracking-tight">Rp 0</span>
                            </div>
                        </div>

                        <!-- Promo Code (Ornamental for now) -->
                        <div class="relative mb-8 group">
                            <input type="text" class="w-full pl-4 pr-12 py-3.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all uppercase placeholder:normal-case font-bold" placeholder="Punya kode promo?">
                            <button class="absolute inset-y-0 right-0 px-4 text-primary font-bold text-xs uppercase hover:scale-110 transition-transform">Klaim</button>
                        </div>

                        <button type="button" id="checkout-btn" class="w-full kt-btn kt-btn-primary py-5 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:grayscale disabled:cursor-not-allowed">
                            <span>Lanjutkan ke Pembayaran</span>
                            <i class="ki-filled ki-right text-lg"></i>
                        </button>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <i class="ki-filled ki-shield-tick text-lg text-green-500"></i>
                            Pembayaran Aman & Terenkripsi
                        </div>
                    </div>

                    <!-- Ornament / Info tambahan -->
                    <div class="mt-6 p-6 bg-primary/5 rounded-2xl border border-primary/10 flex gap-4 items-center animate-pulse-slow">
                        <div class="size-10 rounded-full bg-white flex items-center justify-center text-primary shadow-sm">
                            <i class="ki-filled ki-delivery-2 text-xl"></i>
                        </div>
                        <p class="text-xs font-medium text-primary-dark">
                            <strong>Info Pengiriman:</strong> Buku cetak akan diproses 1-2 hari kerja setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="relative mb-10">
                    <div class="absolute inset-0 bg-primary/5 rounded-full scale-150 blur-3xl animate-pulse"></div>
                    <img src="{{ asset('assets/dashboard/images/backgrounds/login-security.svg') }}" class="relative w-64 opacity-50 grayscale" alt="Empty Cart">
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white border border-gray-100 rounded-2xl px-6 py-2 shadow-lg">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest">Kosong</span>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Wah, keranjangmu masih kosong</h2>
                <p class="text-gray-500 font-medium max-w-md mx-auto mb-8">
                    Yuk, cari buku menarik atau jasa penerbitan berkualitas untuk memulai perjalanan berkaryamu hari ini.
                </p>
                <a href="{{ route('catalog') }}" class="kt-btn kt-btn-primary px-10 py-4 rounded-xl font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                    Lihat Katalog Buku
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const TOKEN = '{{ csrf_token() }}';

        function formatCurrency(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
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
            
            // Sync with server if needed (throttled)
            updateCartOnServer(row.data('cart-id'), {
                quantity: quantity,
                type: type
            });
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            let selectedItemsCount = 0;

            $('.cart-item-row').each(function() {
                const row = $(this);
                const isChecked = row.find('.item-checkbox').is(':checked');

                if (isChecked) {
                    selectedItemsCount++;
                    const subtotalText = row.find('.item-subtotal').text().replace('Rp ', '').replace(/\./g, '');
                    grandTotal += parseInt(subtotalText, 10);
                }
            });

            $('#grand-total').text(formatCurrency(grandTotal));
            $('#grand-total-text').text(formatCurrency(grandTotal));
            $('#selected-items-count').text(selectedItemsCount);

            if (selectedItemsCount > 0) {
                $('#checkout-btn').prop('disabled', false);
                $('#delete-selected').removeClass('hidden');
            } else {
                $('#checkout-btn').prop('disabled', true);
                $('#delete-selected').addClass('hidden');
            }
        }

        function updateCartOnServer(cartId, data) {
            $.ajax({
                url: `/cart/${cartId}`,
                method: 'PUT',
                data: { ...data, _token: TOKEN },
                success: function(response) {
                    console.log('Cart sync success');
                }
            });
        }

        // Quantity Buttons
        $('.quantity-btn').on('click', function() {
            const action = $(this).data('action');
            const row = $(this).closest('.cart-item-row');
            const input = row.find('.quantity-input');
            let val = parseInt(input.val());

            if (action === 'increase') val++;
            else if (action === 'decrease' && val > 1) val--;

            input.val(val);
            updateRowAndTotals(row);
        });

        // Type Select
        $('.book-type-select').on('change', function() {
            const row = $(this).closest('.cart-item-row');
            updateRowAndTotals(row);
        });

        // Delete Item
        $('.remove-item-btn').on('click', function() {
            const row = $(this).closest('.cart-item-row');
            const cartId = row.data('cart-id');

            if (!confirm('Hapus buku ini dari keranjang?')) return;

            $.ajax({
                url: `/cart/${cartId}`,
                method: 'DELETE',
                data: { _token: TOKEN },
                success: function() {
                    row.addClass('opacity-0 scale-95 translate-x-10');
                    setTimeout(() => {
                        row.remove();
                        updateGrandTotal();
                        if ($('.cart-item-row').length === 0) location.reload();
                    }, 300);
                }
            });
        });

        // Checkbox Logic
        $('#select-all-checkbox').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox').prop('checked', isChecked);
            updateGrandTotal();
        });

        $('.item-checkbox').on('change', function() {
            updateGrandTotal();
            const allChecked = $('.item-checkbox:checked').length === $('.item-checkbox').length;
            $('#select-all-checkbox').prop('checked', allChecked);
        });

        // Initial State
        $('.item-checkbox').prop('checked', true);
        $('#select-all-checkbox').prop('checked', true);
        updateGrandTotal();

        // Checkout Process
        $('#checkout-btn').on('click', function(e) {
            e.preventDefault();
            
            let items = [];
            let total_price = 0;

            $('.cart-item-row').each(function() {
                const row = $(this);
                if (row.find('.item-checkbox').is(':checked')) {
                    const type = row.find('.book-type-select').val();
                    const price = type === 'digital' ? parseFloat(row.data('price-digital')) : parseFloat(row.data('price-physical'));
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

            const btn = $(this);
            btn.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin"></i> Memproses...');

            $.ajax({
                url: '{{ route('checkout.process') }}',
                method: 'POST',
                data: { _token: TOKEN, items: items, total_price: total_price },
                success: function(response) {
                    window.location.href = response.redirect_url;
                },
                error: function() {
                    alert('Gagal memproses pesanan.');
                    location.reload();
                }
            });
        });
    });
</script>
@endpush
