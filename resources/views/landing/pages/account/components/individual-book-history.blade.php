<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Proyek Buku Individu</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $transactions->whereNotNull('individual_book_package_id')->count() }} Proyek
        </span>
    </div>

    @php
        $individualTrx = $transactions->whereNotNull('individual_book_package_id');
    @endphp

    @if($individualTrx->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($individualTrx as $trx)
                @php
                    $book = $trx->details?->first()?->book;
                    $module = $book?->modules?->first();
                    $isPublished = $book && $book->status === 'published';
                    $canUpload = $trx->status === 'paid' && $trx->individual_book_status === 'confirmed' && ! $isPublished;
                @endphp
                <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 group flex flex-col h-full relative overflow-hidden">
                    <!-- Package Info -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-lg mb-2 inline-block">
                                {{ $trx->individualBookPackage->name }}
                            </span>
                            <h4 class="text-base font-bold text-gray-900 leading-tight">Naskah Mandiri</h4>
                        </div>
                        <div class="text-right flex flex-col items-end gap-1.5">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning/10 text-warning border-warning/20',
                                    'paid' => 'bg-green-50 text-green-600 border-green-100',
                                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                                    'canceled' => 'bg-red-50 text-red-500 border-red-100',
                                    'expired' => 'bg-gray-100 text-gray-500 border-gray-200'
                                ];
                                $statusLabel = [
                                    'pending' => $trx->payment_proof ? 'Approval' : 'Menunggu Bayar',
                                    'paid' => 'Lunas',
                                    'completed' => 'Terbit',
                                    'canceled' => 'Batal',
                                    'expired' => 'Kadaluarsa'
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-wider border {{ $statusClasses[$trx->status] ?? 'bg-gray-50 text-gray-500' }}">
                                {{ $statusLabel[$trx->status] ?? $trx->status }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col grow gap-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">
                                <span>No. Transaksi</span>
                                <span class="text-gray-900">{{ $trx->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <span>Tgl Order</span>
                                <span class="text-gray-900">{{ $trx->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <!-- Published Status Detail -->
                        @if($book && $book->status == 'published')
                            <div class="p-4 bg-green-50 border border-green-100 rounded-2xl flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-white flex items-center justify-center text-green-600 shadow-sm border border-green-50 shrink-0">
                                    <i class="ki-filled ki-check-circle text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-green-700 uppercase tracking-widest">Status Terakhir</p>
                                    <p class="text-xs font-bold text-green-600">Buku Sudah Terbit</p>
                                </div>
                            </div>
                        @elseif($canUpload)
                            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-white flex items-center justify-center text-blue-600 shadow-sm border border-blue-50 shrink-0">
                                    <i class="ki-filled ki-time text-xl animate-spin-slow"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-700 uppercase tracking-widest">Status Terakhir</p>
                                    <p class="text-xs font-bold text-blue-600">Menunggu/Proses Editorial</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex gap-3">
                        @if($isPublished)
                            <span class="flex-grow py-3 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest rounded-xl border border-green-100 flex items-center justify-center gap-2 cursor-not-allowed">
                                <i class="ki-filled ki-check-circle text-base"></i> Sudah Terbit
                            </span>
                        @elseif($canUpload)
                            <a href="{{ route('individual-books.upload', $trx) }}" class="flex-grow py-3 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all flex items-center justify-center gap-2">
                                <i class="ki-filled ki-file-up text-base"></i> Upload Naskah
                            </a>
                        @elseif($trx->status == 'paid')
                            <span class="flex-grow py-3 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest rounded-xl border border-blue-100 flex items-center justify-center gap-2">
                                <i class="ki-filled ki-time text-base"></i> Menunggu Konfirmasi Admin
                            </span>
                        @else
                            <a href="{{ route('checkout.success', $trx->transaction_code) }}" class="flex-grow py-3 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all flex items-center justify-center gap-2">
                                <i class="ki-filled ki-receipt text-base"></i> Detail Bayar
                            </a>
                        @endif
                        @if($module?->file_path)
                            <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="px-4 py-3 bg-white border border-gray-200 text-gray-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-2">
                                <i class="ki-filled ki-eye text-base"></i> File
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ki-filled ki-crown text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Mulai Terbitkan Bukumu</h3>
            <p class="text-gray-500 font-medium max-w-sm mx-auto mb-8">Dapatkan dukungan penerbitan profesional mulai dari ISBN hingga distribusi cetak dan digital.</p>
            <a href="{{ route('individual-books.packages') }}" class="px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all text-sm uppercase tracking-widest">Lihat Paket Penerbitan</a>
        </div>
    @endif
</div>
