<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Riwayat Transaksi</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $transactions->total() }} Pesanan
        </span>
    </div>

    @if($transactions->count() > 0)
        <div class="bg-white border border-gray-100 rounded-[2.5rem] shadow-sm overflow-hidden w-full min-w-0">
            <div class="w-full overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">No. Invoice</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Pembayaran</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Status</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($transactions as $trx)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <span class="text-sm font-black text-gray-900 tracking-widest uppercase">{{ $trx->transaction_code }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-gray-500">
                                    {{ $trx->created_at->format('d/m/Y') }}
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $trx->created_at->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-base font-black text-primary tracking-tight">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning/10 text-warning border-warning/20',
                                            'paid' => 'bg-green-100 text-green-600 border-green-200',
                                            'completed' => 'bg-green-100 text-green-600 border-green-200',
                                            'canceled' => 'bg-red-100 text-red-600 border-red-200',
                                            'expired' => 'bg-gray-100 text-gray-600 border-gray-200'
                                        ];
                                        $statusLabel = [
                                            'pending' => $trx->payment_proof ? 'Menunggu Approval' : 'Menunggu Bayar',
                                            'paid' => 'Lunas',
                                            'completed' => 'Selesai',
                                            'canceled' => 'Dibatalkan',
                                            'expired' => 'Kadaluarsa'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border {{ $statusClasses[$trx->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $statusLabel[$trx->status] ?? $trx->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('checkout.success', $trx->transaction_code) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all active:scale-95 shadow-lg shadow-slate-900/10">
                                        <i class="ki-filled ki-eye text-base"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $transactions->links('vendor.pagination.landing-pagination') }}
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ki-filled ki-handcart text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Transaksi</h3>
            <p class="text-gray-500 font-medium max-w-sm mx-auto mb-8">Anda belum pernah melakukan pemesanan buku atau paket. Ayo mulai berkarya hari ini!</p>
            <a href="{{ route('catalog') }}" class="px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all text-sm uppercase tracking-widest">Belanja Sekarang</a>
        </div>
    @endif
</div>
