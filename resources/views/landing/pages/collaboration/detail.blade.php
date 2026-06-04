@extends('landing.layouts.app')

@section('title', $book->title . ' - Buku Kolaborasi Daya Media')

@section('content')
<div class="bg-gray-50/30 min-h-screen pb-20 pt-10">
    <div class="kt-container-fixed">
        
        {{-- ===== BREADCRUMB ===== --}}
        <div class="flex items-center gap-2 text-sm font-medium mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <a href="{{ route('collaboration') }}" class="text-gray-500 hover:text-primary transition-colors">Buku Kolaborasi</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <span class="text-gray-900 truncate max-w-[200px] sm:max-w-md">{{ $book->title }}</span>
        </div>

        {{-- ===== MAIN DETAIL SECTION ===== --}}
        <div class="bg-white rounded-[2.5rem] p-6 lg:p-10 border border-gray-100 shadow-sm mb-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {{-- Kiri: Cover Image --}}
                <div class="lg:col-span-3 flex flex-col items-center lg:items-start">
                    <div class="w-full max-w-[280px] lg:max-w-full">
                        <div class="relative bg-gray-50 rounded-2xl overflow-hidden aspect-[3/4] shadow-xl border border-gray-100">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/400x600?text=No+Cover' }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4 justify-center lg:justify-start">
                            <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wider rounded-lg border border-primary/20">
                                <i class="ki-filled ki-users mr-1"></i> Proyek Kolaborasi
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tengah: Info Buku --}}
                <div class="lg:col-span-5 flex flex-col">
                    <div class="mb-6">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary rounded-lg text-xs font-bold uppercase tracking-wider mb-4">
                            <i class="ki-filled ki-category"></i> {{ $book->category?->name ?? 'Uncategorized' }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight mb-2 tracking-tight">
                            {{ $book->title }}
                        </h1>
                    </div>

                    {{-- Spesifikasi Grid --}}
                    <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-1 mb-6">
                        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 bg-white rounded-t-2xl">
                            <i class="ki-filled ki-information-2 text-primary text-lg"></i>
                            <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Informasi Proyek</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            @php
                            $info = [
                                ['icon' => 'ki-pencil', 'label' => 'Editor/PIC', 'value' => $book->bookEditors?->user?->full_name ?? '-'],
                                ['icon' => 'ki-category', 'label' => 'Bahasa', 'value' => $book->language ?? 'Indonesia'],
                                ['icon' => 'ki-calendar', 'label' => 'Estimasi Terbit', 'value' => $book->year_published ?? '-'],
                                ['icon' => 'ki-home-3', 'label' => 'Penerbit', 'value' => $book->publisher ?? 'Daya Media Publisher'],
                            ];
                            @endphp

                            @foreach($info as $i => $item)
                            <div class="flex items-start gap-3 p-4 border-b border-gray-100 {{ $loop->last && $loop->iteration % 2 != 0 ? 'sm:col-span-2' : '' }}">
                                <div class="size-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 text-gray-400 shrink-0">
                                    <i class="ki-filled {{ $item['icon'] }}"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $item['label'] }}</p>
                                    <p class="text-sm font-bold text-gray-900 mt-1 leading-snug">{{ $item['value'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Kanan: Progress Timeline --}}
                <div class="lg:col-span-4">
                    <div class="bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-xl shadow-gray-200/50 sticky top-[100px]">
                        <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-2 border-b border-gray-100 pb-4">
                            <i class="ki-filled ki-time text-primary"></i> Timeline Proyek
                        </h3>

                        <div class="relative pl-4 space-y-6">
                            <!-- Timeline Line -->
                            <div class="absolute left-[1.35rem] top-2 bottom-6 w-0.5 bg-gray-200 z-0"></div>

                            <!-- Step 1 -->
                            <div class="relative z-10 flex items-start gap-4 group">
                                <div class="size-8 rounded-full bg-primary flex items-center justify-center text-white ring-4 ring-white shrink-0 mt-0.5 shadow-md">
                                    <i class="ki-filled ki-users text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">Pengumpulan Penulis</h4>
                                    <p class="text-xs font-bold text-primary mt-1 bg-primary/10 inline-block px-2 py-0.5 rounded-md">Slot Terisi: {{ $countAuthors }}/{{ $book->modules->count() }}</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative z-10 flex items-start gap-4 group">
                                <div class="size-8 rounded-full {{ $countAuthorUploads == $book->modules->count() ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center ring-4 ring-white shrink-0 mt-0.5 transition-colors">
                                    <i class="ki-filled ki-file-up text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold {{ $countAuthorUploads == $book->modules->count() ? 'text-gray-900 group-hover:text-primary' : 'text-gray-500' }} transition-colors">Upload Naskah</h4>
                                    <p class="text-xs font-medium text-gray-400 mt-1">Selesai: {{ $countAuthorUploads }}/{{ $book->modules->count() }}</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative z-10 flex items-start gap-4 group">
                                <div class="size-8 rounded-full {{ $checkEditing ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center ring-4 ring-white shrink-0 mt-0.5 transition-colors">
                                    <i class="ki-filled ki-pencil text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold {{ $checkEditing ? 'text-gray-900 group-hover:text-primary' : 'text-gray-500' }} transition-colors">Proses Editing</h4>
                                    <p class="text-xs font-medium text-gray-400 mt-1">Oleh Tim Editor Daya Media</p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="relative z-10 flex items-start gap-4 group">
                                <div class="size-8 rounded-full {{ $book->status == 'published' ? 'bg-green-500 text-white shadow-md' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center ring-4 ring-white shrink-0 mt-0.5 transition-colors">
                                    <i class="ki-filled ki-check-circle text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold {{ $book->status == 'published' ? 'text-gray-900 group-hover:text-green-500' : 'text-gray-500' }} transition-colors">Buku Terbit</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== DESKRIPSI PROYEK ===== --}}
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm mb-16">
            <div class="flex border-b border-gray-100 bg-gray-50/50 p-2 gap-2">
                <div class="px-6 py-3.5 text-sm font-black uppercase tracking-widest rounded-2xl bg-white shadow-sm border border-gray-100 text-primary">
                    <i class="ki-filled ki-file-text mr-2"></i> Deskripsi Proyek
                </div>
            </div>
            <div class="p-6 lg:p-10">
                <div class="prose prose-sm sm:prose-base max-w-none text-gray-600">
                    {!! $book->description !!}
                </div>
            </div>
        </div>

        {{-- ===== DAFTAR MODUL / BAB ===== --}}
        <div class="mb-16">
            <div class="flex items-end justify-between border-b border-gray-100 pb-5 mb-6">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Daftar Modul / Bab</h3>
                <span class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
                    Total: {{ $book->modules->count() }} Bab
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($book->modules as $module)
                    @php($lockStatus = $module->order_lock_status)
                    <div class="bg-white border {{ $lockStatus !== 'available' ? 'border-gray-200 opacity-75' : 'border-primary/20 hover:border-primary hover:shadow-lg hover:-translate-y-1' }} rounded-2xl p-5 transition-all duration-300 flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-100 px-2 py-1 rounded-md">Bab {{ $module->chapter }}</span>
                                @if($lockStatus === 'bought')
                                    <span class="text-xs font-bold text-red-500 flex items-center gap-1"><i class="ki-filled ki-cross-circle"></i> Sudah dibeli</span>
                                @elseif($lockStatus === 'pending')
                                    <span class="text-xs font-bold text-yellow-500 flex items-center gap-1"><i class="ki-filled ki-time"></i> Lagi dipesan</span>
                                @elseif($lockStatus === 'inactive')
                                    <span class="text-xs font-bold text-gray-400 flex items-center gap-1"><i class="ki-filled ki-cross-circle"></i> Tidak aktif</span>
                                @else
                                    <span class="text-xs font-bold text-green-500 flex items-center gap-1"><i class="ki-filled ki-check-circle"></i> Tersedia</span>
                                @endif
                            </div>
                            <h4 class="text-base font-bold text-gray-900 leading-snug mb-2">{{ $module->title }}</h4>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-lg font-black text-primary">Rp{{ number_format($module->price, 0, ',', '.') }}</span>
                            @if($lockStatus === 'available')
                                <button type="button" 
                                    class="checkout-module-btn px-5 py-2.5 bg-primary text-white text-xs font-black uppercase tracking-wider rounded-xl hover:bg-primary-dark shadow-md shadow-primary/20 transition-all active:scale-95 flex items-center gap-2"
                                    data-module-id="{{ $module->id }}"
                                    data-price="{{ $module->price }}"
                                    data-title="{{ $module->title }}">
                                    <span>Ambil Bagian</span>
                                    <i class="ki-filled ki-right text-base"></i>
                                </button>
                            @else
                                <span class="px-5 py-2.5 bg-gray-100 text-gray-400 text-xs font-black uppercase tracking-wider rounded-xl cursor-not-allowed">
                                    {{ $lockStatus === 'pending' ? 'Menunggu Bayar' : 'Terkunci' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== PRODUK SERUPA ===== --}}
        <div class="mb-10">
            <div class="flex items-end justify-between border-b border-gray-100 pb-5 mb-6">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Proyek Kolaborasi Serupa</h3>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
                {{-- To reuse the similar books logic from backend, assuming $similarBooks or another variable is passed. If not, keeping structural placeholder or fetching --}}
                @forelse(\App\Models\Book::with('authors.user', 'modules')->whereIn('status', ['open', 'editing'])->where('id', '!=', $book->id)->inRandomOrder()->limit(6)->get() as $item)
                    @include('landing.pages.home.partials.collab-card', ['book' => $item])
                @empty
                    <div class="col-span-full py-10 text-center text-gray-500 font-medium bg-white rounded-3xl border border-gray-100">
                        Tidak ada proyek serupa ditemukan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 8px; height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.checkout-module-btn').on('click', function(e) {
        e.preventDefault();

        @guest
            Swal.fire({
                title: 'Akses Terbatas',
                text: 'Anda harus login terlebih dahulu untuk mengambil bagian kolaborasi ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F172A',
                cancelButtonColor: '#f1f5f9',
                cancelButtonText: '<span style="color:#64748b">Batal</span>',
                confirmButtonText: 'Login Sekarang'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = '{{ route("login") }}';
            });
            return;
        @endguest

        const btn = $(this);
        const originalHtml = btn.html();
        const moduleId = btn.data('module-id');
        const price = btn.data('price');
        const title = btn.data('title');

        btn.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin text-lg"></i> Memproses...');

        $.ajax({
            url: '{{ route("checkout.process") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                total_price: price,
                items: [{
                    module_id: moduleId,
                    price: price,
                    quantity: 1,
                    title: title,
                    type: 'module'
                }]
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan.' });
                    btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memproses checkout. Silakan coba lagi.';
                Swal.fire({ icon: 'error', title: 'Error', text: message });
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>
@endpush
