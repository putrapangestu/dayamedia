@extends('landing.layouts.app')

@section('title', 'Beli Paket ' . $package->name . ' - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20 pt-10">
    <div class="kt-container-fixed">
        
        {{-- ===== BREADCRUMB ===== --}}
        <div class="flex items-center gap-2 text-sm font-medium mb-10">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <a href="{{ route('individual-books.packages') }}" class="text-gray-500 hover:text-primary transition-colors">Paket Buku</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <span class="text-gray-900">Checkout Paket</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Kiri: Detail Paket & Opsi -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Package Summary Card -->
                <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-crown text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 tracking-tight">{{ $package->name }}</h2>
                            <p class="text-sm font-medium text-gray-500">Anda sedang melakukan pemesanan paket penerbitan individu.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-3xl border border-gray-100 mb-8">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga Dasar Paket</p>
                            <p class="text-xl font-black text-gray-900">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kapasitas Penulis</p>
                            <p class="text-sm font-bold text-gray-700">Maks. {{ $package->max_authors_default }} Penulis (Bawaan)</p>
                        </div>
                    </div>

                    <form id="purchase-form" action="{{ route('individual-books.purchase.store', $package) }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Additional Authors Option -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Penulis Tambahan</h3>
                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-[9px] font-black uppercase rounded-md tracking-wider">Opsional</span>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">Jika naskah Anda ditulis oleh lebih dari {{ $package->max_authors_default }} orang, silakan tambahkan jumlah penulis di bawah ini.</p>
                            
                            <div class="flex items-center gap-4 p-5 bg-white border border-gray-100 rounded-2xl shadow-sm max-w-sm">
                                <div class="flex flex-col flex-1">
                                    <span class="text-xs font-bold text-gray-700 mb-1">Jumlah Orang</span>
                                    <span class="text-[10px] text-gray-400 font-medium italic">Rp{{ number_format($additionalAuthorPrice, 0, ',', '.') }} / penulis</span>
                                </div>
                                <div class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-100">
                                    <button type="button" onclick="changeExtraAuthors(-1)" class="size-8 flex items-center justify-center rounded-lg hover:bg-white text-gray-500 transition-all active:scale-90">
                                        <i class="ki-filled ki-minus text-xs"></i>
                                    </button>
                                    <input type="number" name="additional_authors_count" id="extra-authors" value="0" min="0" readonly
                                        class="w-12 text-center text-sm font-black bg-transparent border-none focus:ring-0">
                                    <button type="button" onclick="changeExtraAuthors(1)" class="size-8 flex items-center justify-center rounded-lg hover:bg-white text-gray-500 transition-all active:scale-90">
                                        <i class="ki-filled ki-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Info Pemesan (Read-only for consistency) -->
                        <div class="pt-8 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Pemesan</label>
                                <input type="text" value="{{ auth()->user()->full_name }}" readonly class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold text-gray-900 cursor-not-allowed">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">No. WhatsApp</label>
                                <input type="text" value="{{ auth()->user()->phone_number ?? '-' }}" readonly class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold text-gray-900 cursor-not-allowed">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Features Highlight -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex gap-4">
                        <div class="size-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-shield-tick text-xl"></i>
                        </div>
                        <p class="text-xs font-medium text-gray-500 leading-relaxed"><strong class="text-gray-900 block mb-1">Transaksi Aman</strong> Pembayaran diproses secara manual dengan verifikasi tim admin kami untuk menjamin keamanan.</p>
                    </div>
                    <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex gap-4">
                        <div class="size-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-message-question text-xl"></i>
                        </div>
                        <p class="text-xs font-medium text-gray-500 leading-relaxed"><strong class="text-gray-900 block mb-1">Butuh Bantuan?</strong> Tim support kami siap membantu jika Anda mengalami kesulitan dalam proses pemesanan.</p>
                    </div>
                </div>
            </div>

            <!-- Kanan: Summary & Pay -->
            <div class="lg:col-span-4 lg:sticky lg:top-[var(--header-height,100px)]">
                <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/40">
                    <h3 class="text-xl font-bold text-gray-900 mb-8">Ringkasan Biaya</h3>

                    <!-- Price Details -->
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-500">Harga Dasar Paket</span>
                            <span class="font-bold text-gray-900">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-500 italic">Penulis Tambahan (<span id="extra-count-text">0</span>)</span>
                            <span class="font-bold text-gray-900" id="extra-price-text">Rp0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-500">Biaya Layanan (Admin)</span>
                            <span class="font-bold text-gray-900">Rp{{ number_format(getAdminFeeTransaction(), 0, ',', '.') }}</span>
                        </div>

                        <!-- Promo (Optional, visual only for JS interaction) -->
                        <div class="pt-6 border-t border-gray-100">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block ml-1">Kupon Diskon</label>
                            <div class="flex gap-2">
                                <input type="text" form="purchase-form" name="promo_code" id="promo-code" class="flex-grow px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold uppercase placeholder:normal-case" placeholder="KODEPROMO">
                                <button type="button" onclick="applyPromo()" class="px-4 py-3 bg-gray-900 text-white text-[10px] font-black uppercase rounded-xl hover:bg-black transition-all">Apply</button>
                            </div>
                            <div id="promo-msg" class="mt-2"></div>
                        </div>

                        <div class="pt-6 mt-2 border-t-2 border-dashed border-gray-100">
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Bayar</span>
                                <span class="text-3xl font-black text-primary tracking-tighter" id="grand-total-display">Rp0</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" form="purchase-form" class="w-full py-5 bg-primary text-white font-black rounded-2xl shadow-2xl shadow-primary/30 hover:scale-[1.03] active:scale-95 transition-all flex items-center justify-center gap-3 text-lg group">
                        <span>Konfirmasi & Beli</span>
                        <i class="ki-filled ki-right text-2xl group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <p class="mt-6 text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="ki-filled ki-shield-tick text-green-500 text-base"></i> Transaksi 100% Aman
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const basePrice = {{ (int)$package->price }};
    const extraPricePerUnit = {{ (int)$additionalAuthorPrice }};
    const adminFee = {{ (int)getAdminFeeTransaction() }};
    let discount = 0;

    function formatCurrency(num) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
    }

    function changeExtraAuthors(val) {
        let input = document.getElementById('extra-authors');
        let current = parseInt(input.value);
        let next = current + val;
        if(next >= 0) {
            input.value = next;
            calculateTotal();
        }
    }

    function calculateTotal() {
        const extraCount = parseInt(document.getElementById('extra-authors').value);
        const totalExtraPrice = extraCount * extraPricePerUnit;
        const subtotal = basePrice + totalExtraPrice;
        const grandTotal = Math.max((subtotal + adminFee) - discount, 0);

        document.getElementById('extra-count-text').innerText = extraCount;
        document.getElementById('extra-price-text').innerText = formatCurrency(totalExtraPrice);
        document.getElementById('grand-total-display').innerText = formatCurrency(grandTotal);
    }

    function applyPromo() {
        const code = document.getElementById('promo-code').value.trim();
        if(!code) return;

        const extraCount = parseInt(document.getElementById('extra-authors').value);
        const subtotal = basePrice + (extraCount * extraPricePerUnit);

        $.ajax({
            url: '{{ route("checkout.apply-promo") }}', // Reuse standard promo logic if compatible
            method: 'POST',
            data: { promo_code: code, subtotal: subtotal, individual_package: 1, _token: '{{ csrf_token() }}' },
            success: function(res) {
                if(res.success) {
                    discount = res.discount;
                    document.getElementById('promo-msg').innerHTML = `<p class="text-[10px] font-bold text-green-600 bg-green-50 px-3 py-2 rounded-lg"><i class="ki-filled ki-check-circle"></i> Promo berhasil: ${res.message}</p>`;
                    document.getElementById('promo-code').readOnly = true;
                    calculateTotal();
                } else {
                    document.getElementById('promo-msg').innerHTML = `<p class="text-[10px] font-bold text-red-500 px-3 py-2 bg-red-50 rounded-lg"><i class="ki-filled ki-information-2"></i> ${res.message}</p>`;
                }
            },
            error: function() {
                document.getElementById('promo-msg').innerHTML = `<p class="text-[10px] font-bold text-red-500 px-3 py-2 bg-red-50 rounded-lg"><i class="ki-filled ki-information-2"></i> Kode promo tidak valid.</p>`;
            }
        });
    }

    // Initial calc
    calculateTotal();
</script>
@endpush
