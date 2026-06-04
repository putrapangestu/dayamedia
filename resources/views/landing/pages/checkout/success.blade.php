@extends('landing.layouts.auth')

@section('title', 'Transaksi Berhasil - Daya Media')

@section('content')
<div class="bg-gray-50/30 min-h-screen py-10 lg:py-20 relative overflow-hidden flex flex-col justify-center">
    <!-- Logo Floating -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10" alt="Daya Media Logo">
        </a>
    </div>

    <!-- Background Decor (Primary Shades) -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl h-[800px] bg-primary/5 rounded-full blur-[120px] -z-10"></div>

    <div class="kt-container-fixed relative z-10 w-full">
        <div class="max-w-[850px] mx-auto">

            <!-- Success Header Card -->
            <div class="bg-white border border-gray-100 rounded-[3.5rem] shadow-2xl shadow-gray-200/50 overflow-hidden mb-10">

                <!-- Premium Header Design (Lead with Primary Color) -->
                <div class="relative bg-primary p-12 sm:p-20 text-center overflow-hidden">
                    <!-- Subtle Patterns & Glows -->
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, #ffffff 1.5px, transparent 1px); background-size: 30px 30px;"></div>
                    <div class="absolute -top-24 -left-24 size-80 bg-white/20 rounded-full blur-[60px] animate-pulse-slow"></div>
                    <div class="absolute top-1/2 -right-20 size-72 bg-black/10 rounded-full blur-[60px]"></div>

                    <div class="relative z-10">
                        <!-- Success Icon Container -->
                        <div class="inline-flex items-center justify-center size-28 bg-white rounded-[2.5rem] mb-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-500 group relative">
                            <div class="absolute inset-0 bg-white rounded-[2.5rem] animate-ping opacity-20"></div>
                            <div class="absolute inset-2 border-2 border-dashed border-primary/20 rounded-[2rem]"></div>
                            <i class="ki-filled ki-check text-6xl text-primary relative z-10"></i>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black text-white mb-6 tracking-tighter leading-tight">
                            Transaksi Berhasil <br class="hidden sm:block"/> Dibuat!
                        </h1>

                        <!-- Invoice Badge -->
                        <div class="inline-flex items-center gap-3 px-6 py-2.5 rounded-2xl bg-white text-primary shadow-xl">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">No. Invoice</span>
                            <span class="h-4 w-px bg-primary/20"></span>
                            <span class="text-sm font-black tracking-widest uppercase">{{ $transaction->transaction_code }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 sm:p-16 space-y-12">

                    <!-- 1. Detail Item (Missing section restored and enhanced) -->
                    <div class="space-y-6">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-3 ml-1">
                            <div class="size-2 bg-primary rounded-full"></div> Item Yang Dibeli
                        </h4>
                        <div class="bg-gray-50 border border-gray-100 rounded-[2rem] overflow-hidden shadow-inner">
                            <table class="w-full text-left">
                                <thead class="border-b border-gray-200/50 bg-gray-100/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Produk</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Tipe</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Harga</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white/50">
                                    @if($transaction->details->isNotEmpty())
                                        @foreach ($transaction->details as $detail)
                                            <tr>
                                                <td class="px-6 py-5">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-bold text-gray-900 line-clamp-1">
                                                            {{ $detail?->book?->title ?? $detail?->module?->book?->title ?? 'Tanpa Judul' }}
                                                        </span>
                                                        @if($detail->module)
                                                            <span class="text-[10px] text-gray-400 font-medium mt-1 italic">
                                                                {{ $detail->module->title }} | Bab {{ $detail->module->chapter }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter {{ $detail->type == 'physical' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                                        {{ $detail->type == 'physical' ? 'Physical' : 'E-Book' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                                    <span class="text-sm font-bold text-gray-900">
                                                        {{ $detail->quantity }}x Rp {{ number_format((int) $detail->price_book, 0, ',', '.') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @elseif($transaction->individualBookPackage)
                                        <tr>
                                            <td class="px-6 py-5">
                                                <span class="text-sm font-bold text-gray-900">
                                                    {{ $transaction->individualBookPackage->name }}
                                                </span>
                                                @if($transaction->additional_authors_count)
                                                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Penulis tambahan: {{ (int) $transaction->additional_authors_count }}</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-center">
                                                <span class="px-2 py-1 bg-primary/10 text-primary rounded-md text-[9px] font-black uppercase tracking-tighter italic">Paket Individu</span>
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($packageSubtotal, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Detailed Pricing Breakdown -->
                            <div class="p-6 bg-gray-100/50 flex flex-col gap-3">
                                <div class="flex justify-between text-xs font-bold text-gray-500">
                                    <span class="uppercase tracking-widest">Subtotal</span>
                                    <span>Rp {{ number_format($subtotalValue, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-bold text-green-500">
                                    <span class="uppercase tracking-widest">Diskon Promo</span>
                                    <span>-Rp {{ number_format((int) $transaction->discount_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-bold text-gray-500">
                                    <span class="uppercase tracking-widest">Biaya Admin</span>
                                    <span>Rp {{ number_format((int) $transaction->admin_fee, 0, ',', '.') }}</span>
                                </div>
                                <div class="pt-4 border-t border-gray-200 flex justify-between items-end">
                                    <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Total Bayar</span>
                                    <span class="text-2xl font-black text-primary tracking-tighter">Rp {{ number_format((int) $transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Countdown & Instructions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Countdown (Primary Theme) -->
                        <div class="bg-primary/5 rounded-[2.5rem] p-8 border border-primary/10 text-center relative overflow-hidden group h-full flex flex-col justify-center">
                            <h3 class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-4">Waktu Tersisa</h3>
                            <div class="flex items-center justify-center gap-4 sm:gap-6" id="countdown-timer">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl sm:text-4xl font-black text-primary tracking-tighter" id="days">00</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Hari</span>
                                </div>
                                <span class="text-2xl font-black text-primary/20 mb-6">:</span>
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl sm:text-4xl font-black text-primary tracking-tighter" id="hours">00</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Jam</span>
                                </div>
                                <span class="text-2xl font-black text-primary/20 mb-6">:</span>
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl sm:text-4xl font-black text-primary tracking-tighter" id="minutes">00</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Menit</span>
                                </div>
                            </div>
                            <p class="mt-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Bayar sebelum pesanan hangus.</p>
                        </div>

                        <!-- Instructions -->
                        <div class="bg-gray-50 rounded-[2.5rem] p-8 border border-gray-100 shadow-inner group">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Nama Bank Penerima</p>
                            <p class="text-base font-black text-gray-900 mb-6 flex items-center gap-2">
                                <i class="ki-filled ki-bank text-primary"></i> {{ $bankInfo['bank_name'] }}
                            </p>

                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Nomor Rekening</p>
                            <div class="flex items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-gray-200 mb-6 shadow-sm group-hover:border-primary/30 transition-colors">
                                <span class="text-xl font-black text-primary tracking-widest" id="acc-number">{{ $bankInfo['bank_account'] }}</span>
                                <button onclick="copyToClipboard('{{ $bankInfo['bank_account'] }}')" class="size-10 rounded-xl bg-primary text-white hover:bg-primary-dark transition-all flex items-center justify-center shadow-lg active:scale-90" title="Salin">
                                    <i class="ki-filled ki-copy text-base"></i>
                                </button>
                            </div>

                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-2 text-center sm:text-left">Atas Nama: <span class="text-gray-900 font-black ml-1 uppercase">{{ $bankInfo['bank_info'] }}</span></p>
                        </div>
                    </div>

                    <!-- 3. Form Upload Bukti -->
                    @if ($transaction->status == 'pending' && !$transaction->payment_proof)
                        <div class="pt-10 border-t border-gray-100">
                            <h4 class="text-xl font-black text-gray-900 mb-8 tracking-tight text-center sm:text-left">Konfirmasi Pembayaran</h4>
                            <form action="{{ route('account.transaction.upload-payment', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="payment_method" value="bank_transfer">

                                <div class="p-10 border-2 border-dashed border-gray-200 rounded-[3rem] hover:border-primary/50 hover:bg-primary/5 transition-all group text-center cursor-pointer relative shadow-inner">
                                    <input type="file" name="payment_proof" required class="absolute inset-0 opacity-0 cursor-pointer z-10" id="payment_proof_input" accept="image/*,application/pdf">
                                    <div class="space-y-4" id="upload-placeholder">
                                        <div class="size-20 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm group-hover:scale-110 transition-all duration-500">
                                            <i class="ki-filled ki-file-up text-5xl text-gray-300 group-hover:text-primary transition-colors"></i>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-700">Klik untuk upload bukti transfer</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Format JPG, PNG, PDF (Max 2MB)</p>
                                        </div>
                                    </div>
                                    <div class="hidden space-y-3" id="file-preview">
                                        <div class="size-20 bg-green-50 rounded-full flex items-center justify-center mx-auto shadow-sm">
                                            <i class="ki-filled ki-file-added text-5xl text-green-500"></i>
                                        </div>
                                        <p class="text-base font-black text-green-600 truncate max-w-xs mx-auto" id="file-name"></p>
                                        <button type="button" class="text-xs font-black text-red-500 uppercase tracking-widest hover:underline" onclick="resetUpload()">Ganti File</button>
                                    </div>
                                </div>

                                <button type="submit" class="w-full py-5 bg-gray-900 text-white font-black rounded-2xl shadow-2xl hover:bg-black transition-all flex items-center justify-center gap-3 text-lg group">
                                    <span>Kirim Bukti Pembayaran</span>
                                    <i class="ki-filled ki-send text-2xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Final Navigation -->
                    <div class="flex flex-col sm:flex-row gap-6 pt-4">
                        <a href="{{ route('home') }}" class="flex-1 py-5 bg-gray-100 text-gray-500 font-black uppercase tracking-widest text-[10px] rounded-2xl text-center hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                            <i class="ki-filled ki-home text-lg text-gray-400"></i> Beranda
                        </a>
                        <button type="button" class="paylater flex-1 py-5 border-2 border-primary text-primary font-black uppercase tracking-widest text-[10px] rounded-2xl hover:!bg-primary hover:!text-white transition-all flex items-center justify-center gap-2 group/btn">
                            <i class="ki-filled ki-receipt text-lg !text-inherit"></i> Riwayat Pesanan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Help -->
            <div class="text-center">
                <p class="text-sm text-gray-400 font-medium">Butuh panduan? <a href="https://wa.me/6281166012020" target="_blank" class="text-primary font-black hover:underline ml-1">WhatsApp Admin</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
    .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        Swal.fire({
            icon: 'success',
            title: 'Berhasil disalin!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            background: '#fff',
            color: '#2a3547'
        });
    }

    function resetUpload() {
        $('#payment_proof_input').val('');
        $('#upload-placeholder').removeClass('hidden');
        $('#file-preview').addClass('hidden');
    }

    $(document).ready(function() {
        $('#payment_proof_input').on('change', function() {
            const file = this.files[0];
            if (file) {
                $('#file-name').text(file.name);
                $('#upload-placeholder').addClass('hidden');
                $('#file-preview').removeClass('hidden');
            }
        });

        $('.paylater').click(function(e) {
            e.preventDefault();
            localStorage.setItem('activePill', '#pills-transaction');
            window.location.href = "{{ route('member') }}";
        });

        @if($transaction->expired_at)
            const expiredAt = new Date("{{ $transaction->expired_at }}").getTime();
            const countdown = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiredAt - now;

                if (distance < 0) {
                    clearInterval(countdown);
                    $('#days, #hours, #minutes, #seconds').text('00');
                    return;
                }

                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                $('#days').text(d.toString().padStart(2, '0'));
                $('#hours').text(h.toString().padStart(2, '0'));
                $('#minutes').text(m.toString().padStart(2, '0'));
            }, 1000);
        @endif
    });
</script>
@endpush
