<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- 1. Form Penarikan -->
    <div class="lg:col-span-5">
        <div class="bg-white border border-gray-100 rounded-[2.5rem] shadow-sm overflow-hidden sticky top-[180px]">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-4 bg-primary/[0.02]">
                <div class="size-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                    <i class="ki-filled ki-wallet text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-gray-900 tracking-tight">Tarik Saldo</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Cairkan royalti Anda ke rekening bank</p>
                </div>
            </div>

            <div class="p-8 space-y-6">
                <!-- Balance Info -->
                <div class="p-6 bg-primary rounded-3xl text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 size-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Saldo Tersedia</p>
                    <h2 class="text-3xl font-black tracking-tighter">Rp{{ number_format($user->balance, 0, ',', '.') }}</h2>
                </div>

                <form action="{{ route('withdraw.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jumlah Penarikan (Min. Rp50.000)</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors font-bold text-sm">Rp</span>
                            <input type="number" name="amount" required min="50000" max="{{ $user->balance }}"
                                class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-black focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="0">
                        </div>
                        @error('amount') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Bank & Nomor Rekening</label>
                        <textarea name="bank_info" rows="3" required
                            class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white transition-all" placeholder="Contoh: Bank BCA - 1234567890 (A.N Budi Santoso)"></textarea>
                        @error('bank_info') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-black rounded-2xl shadow-xl hover:bg-black transition-all flex items-center justify-center gap-2 group/btn active:scale-95">
                        <span>Ajukan Penarikan</span>
                        <i class="ki-filled ki-send text-xl group-hover/btn:translate-x-1 group-hover/btn:-translate-y-1 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. Riwayat Penarikan -->
    <div class="lg:col-span-7">
        <div class="bg-white border border-gray-100 rounded-[2.5rem] shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-4 bg-gray-50/50">
                <h3 class="text-lg font-black text-gray-900 tracking-tight">Riwayat Penarikan</h3>
            </div>
            
            @if($withdrawals->count() > 0)
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nominal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($withdrawals as $withdraw)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-bold text-gray-700">{{ $withdraw->created_at->format('d/m/Y') }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5 uppercase">{{ $withdraw->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-base font-black text-gray-900 tracking-tight">Rp{{ number_format($withdraw->amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-warning/10 text-warning border-warning/20',
                                                'success' => 'bg-green-100 text-green-600 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-600 border-red-200',
                                            ];
                                            $statusLabel = [
                                                'pending' => 'Menunggu',
                                                'success' => 'Berhasil',
                                                'rejected' => 'Ditolak',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border {{ $statusClasses[$withdraw->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ $statusLabel[$withdraw->status] ?? $withdraw->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-gray-50 flex justify-center">
                    {{ $withdrawals->links() }}
                </div>
            @else
                <div class="py-20 text-center">
                    <div class="size-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="ki-filled ki-time text-3xl"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada riwayat penarikan</p>
                </div>
            @endif
        </div>
    </div>
</div>
