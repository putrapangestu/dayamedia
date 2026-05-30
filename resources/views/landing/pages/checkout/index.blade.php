@extends('landing.layouts.app')

@section('title', 'Checkout - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20">
    <!-- Header -->
    <div class="py-10 bg-white border-b border-gray-100 mb-10">
        <div class="kt-container-fixed">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight text-mono">Checkout</h1>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
                    <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
                    <a href="{{ route('cart') }}" class="text-gray-500 hover:text-primary transition-colors">Keranjang</a>
                    <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
                    <span class="text-gray-900">Checkout</span>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Sisi Kiri: Detail Pesanan & Informasi -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- 1. Daftar Item -->
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <i class="ki-filled ki-handcart text-xl"></i>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Detail Pesanan</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest">Produk</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Tipe</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($items as $item)
                                    <tr class="group hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="size-14 shrink-0 rounded-lg overflow-hidden border border-gray-100 shadow-sm">
                                                    <img src="{{ isset($item['cover']) ? asset('storage/'.$item['cover']) : 'https://placehold.co/100x140?text=No+Cover' }}" 
                                                        alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-primary transition-colors">{{ $item['title'] }}</h4>
                                                    <p class="text-[11px] text-gray-400 font-medium mt-1 uppercase tracking-wider">
                                                        {{ isset($item['module_id']) ? 'Modul Pelatihan' : ($item['category_name'] ?? 'Kategori') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $item['type'] == 'digital' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                                {{ $item['type'] == 'digital' ? 'E-Book' : (isset($item['module_id']) ? 'Modul' : 'Cetak') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center text-sm font-bold text-gray-600">
                                            {{ $item['quantity'] }}x
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <span class="text-sm font-black text-gray-900">
                                                Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-medium italic">
                                            Tidak ada item dalam antrean checkout.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Informasi Pengiriman/Pengguna -->
                <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <i class="ki-filled ki-user text-xl"></i>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Informasi Pemesan</h2>
                    </div>

                    <form id="checkout-form" action="{{ route('order.book.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        
                        <!-- Nama (Readonly) -->
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                            <input type="text" value="{{ auth()->user()->full_name }}" readonly 
                                class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold text-gray-900 cursor-not-allowed">
                        </div>

                        <!-- WhatsApp (Readonly) -->
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">No. WhatsApp</label>
                            <input type="text" value="{{ auth()->user()->phone_number ?? '-' }}" readonly 
                                class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold text-gray-900 cursor-not-allowed">
                        </div>

                        <!-- Alamat (Textarea) -->
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1 flex items-center gap-2">
                                Alamat Pengiriman <span class="text-[10px] font-medium normal-case text-gray-400">(Wajib untuk buku cetak)</span>
                            </label>
                            <textarea name="address" rows="6" placeholder="Contoh: Jl. Merdeka No. 123, Kel. Kebon Jeruk, Kec. Palmerah, Jakarta Barat, 11530"
                                class="kt-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 placeholder:text-gray-300 min-h-[120px]">{{ auth()->user()->address }}</textarea>
                        </div>

                        <!-- Hidden Fields -->
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
                    </form>
                </div>
            </div>

            <!-- Sisi Kanan: Ringkasan & Checkout (Sticky) -->
            <div class="lg:col-span-4 lg:sticky lg:top-[var(--header-height,100px)]">
                <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/40 relative overflow-hidden">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 size-32 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                    
                    <h2 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-2">
                        Ringkasan Pembayaran
                    </h2>

                    <!-- Kode Promo Section -->
                    <div class="mb-8">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">Kupon Diskon</label>
                        <div class="flex gap-2 p-1.5 bg-gray-50 rounded-2xl border border-gray-100 group focus-within:border-primary/30 transition-all">
                            <input type="text" id="discount_code" name="promo_code" value="{{ $promoCode ?? '' }}" {{ $promoCode ? 'readonly' : '' }}
                                class="flex-grow bg-transparent border-none focus:ring-0 px-3 text-sm font-bold placeholder:text-gray-300 uppercase" placeholder="KODEPROMO">
                            
                            @if(!$promoCode)
                                <button type="button" id="apply-promo-btn" class="px-5 py-2.5 bg-primary text-white text-[11px] font-black uppercase rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">Apply</button>
                            @else
                                <button type="button" id="remove-promo-btn" class="px-5 py-2.5 bg-red-500 text-white text-[11px] font-black uppercase rounded-xl hover:bg-red-600 transition-all">Hapus</button>
                            @endif
                        </div>
                        <div id="promo-message" class="mt-3"></div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-500">Subtotal Pesanan</span>
                            <span class="font-bold text-gray-900" id="subtotal-display">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-500">Biaya Layanan (Admin)</span>
                            <span class="font-bold text-gray-900" id="admin-fee-display">Rp{{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Discount Row (Dynamic) -->
                        <div id="discount-row" class="flex justify-between text-sm {{ $discountAmount > 0 ? '' : 'hidden' }}">
                            <span class="font-medium text-green-500 flex items-center gap-1.5">
                                <i class="ki-filled ki-discount"></i> Diskon Promo
                            </span>
                            <span class="font-black text-green-600" id="discount-display">-Rp{{ number_format($discountAmount, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-6 border-t border-dashed border-gray-100 flex flex-col gap-1">
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Bayar</span>
                                <span class="text-3xl font-black text-primary tracking-tight" id="final-total-display">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Hint -->
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 mb-8 flex gap-4 items-center">
                        <div class="size-10 rounded-xl bg-white flex items-center justify-center text-primary shadow-sm border border-gray-50">
                            <i class="ki-filled ki-bank text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-0.5">Metode Bayar</p>
                            <p class="text-xs font-bold text-gray-900">Transfer Bank / Manual</p>
                        </div>
                    </div>

                    <button type="submit" form="checkout-form" id="complete-order-btn" class="w-full py-5 bg-primary text-white font-black rounded-[1.5rem] shadow-2xl shadow-primary/30 hover:scale-[1.03] active:scale-95 transition-all flex items-center justify-center gap-3 group text-lg">
                        <span>Konfirmasi & Bayar</span>
                        <i class="ki-filled ki-right text-2xl group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <p class="mt-6 text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="ki-filled ki-shield-tick text-green-500 text-base"></i> Transaksi Aman & Terenkripsi
                    </p>
                </div>
                
                <!-- Helper Tip -->
                <div class="mt-6 p-6 bg-yellow-50 rounded-[2rem] border border-yellow-100 flex gap-4 items-start shadow-sm">
                    <div class="size-10 rounded-full bg-white flex items-center justify-center text-yellow-600 shadow-sm shrink-0 border border-yellow-50">
                        <i class="ki-filled ki-information-2 text-xl"></i>
                    </div>
                    <p class="text-xs font-medium text-yellow-800 leading-relaxed">
                        Pastikan alamat sudah benar. Setelah menekan tombol bayar, Anda akan mendapatkan instruksi rekening tujuan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        let subtotal = {{ $subtotal }};
        let adminFee = {{ $adminFee }};
        let currentTotal = {{ $total }};

        function formatCurrency(number) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
        }

        // Apply promo code
        $('#apply-promo-btn').click(function() {
            const promoCode = $('#discount_code').val().trim();
            if (!promoCode) {
                Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Masukkan kode promo terlebih dahulu' });
                return;
            }

            const btn = $(this);
            btn.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin"></i>');

            $.ajax({
                url: '{{ route("checkout.apply-promo") }}',
                method: 'POST',
                data: { promo_code: promoCode, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        $('#promo-message').html('<div class="p-3 bg-green-50 border border-green-100 rounded-xl text-[11px] font-bold text-green-600 flex items-center gap-2 animate-bounce-slow"><i class="ki-filled ki-check-circle"></i> ' + response.message + '</div>');

                        const discount = response.discount;
                        const finalTotal = subtotal + adminFee - discount;

                        $('#discount-display').text('-' + formatCurrency(discount));
                        $('#final-total-display').text(formatCurrency(finalTotal));
                        $('#discount-row').removeClass('hidden');

                        // Update hidden fields
                        $('#discount-amount-field').val(discount);
                        $('#total-price').val(finalTotal);

                        // Update button state
                        $('#discount_code').prop('readonly', true);
                        btn.removeClass('bg-primary').addClass('bg-red-500').text('Hapus').attr('id', 'remove-promo-btn').prop('disabled', false);
                    } else {
                        $('#promo-message').html('<div class="p-3 bg-red-50 border border-red-100 rounded-xl text-[11px] font-bold text-red-500 flex items-center gap-2"><i class="ki-filled ki-information-2"></i> ' + response.message + '</div>');
                        btn.prop('disabled', false).text('Apply');
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Kode promo tidak valid atau kadaluarsa' });
                    btn.prop('disabled', false).text('Apply');
                }
            });
        });

        // Remove promo code
        $(document).on('click', '#remove-promo-btn', function() {
            const btn = $(this);
            $('#discount_code').val('').prop('readonly', false);
            btn.removeClass('bg-red-500').addClass('bg-primary').text('Apply').attr('id', 'apply-promo-btn');
            $('#discount-row').addClass('hidden');
            $('#promo-message').empty();

            const finalTotal = subtotal + adminFee;
            $('#final-total-display').text(formatCurrency(finalTotal));
            $('#total-price').val(finalTotal);
            $('#discount-amount-field').val(0);

            $.ajax({
                url: '{{ route("checkout.remove-promo") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' }
            });
        });

        // Checkout Form Submit
        $('#checkout-form').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $('#complete-order-btn');
            const originalContent = submitBtn.html();

            // Simple validation for address
            const address = $('textarea[name="address"]').val().trim();
            if (!address) {
                Swal.fire({ icon: 'warning', title: 'Alamat Kosong', text: 'Silakan isi alamat pengiriman terlebih dahulu.' });
                return;
            }

            submitBtn.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin text-2xl"></i> Memproses...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let transaction = response.data;
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Transaksi berhasil dibuat. Melanjutkan ke halaman pembayaran...",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('checkout.success', ':id') }}".replace(':id', transaction.transaction_code);
                    });
                },
                error: function(xhr) {
                    const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Gagal membuat transaksi.";
                    Swal.fire({ title: "Gagal!", text: message, icon: "error" });
                    submitBtn.prop('disabled', false).html(originalContent);
                }
            });
        });
    });
</script>
@endpush
