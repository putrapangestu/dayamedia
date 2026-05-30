@extends('landing.layouts.app')

@if((config('app.env') ?? config('app.env')) === 'production')
@push('meta')
    <meta name="robots" content="index, follow">
    @php
        $offset = method_exists($books, 'currentPage') ? (($books->currentPage() - 1) * $books->perPage()) : 0;
        $listElements = [];
        foreach ($books as $idx => $b) {
            $authors = [];
            foreach ($b->authors as $a) {
                $name = $a->author ?? ($a->user->full_name ?? null);
                if (!empty($name)) {
                    $authors[] = ['@type' => 'Person', 'name' => $name];
                }
            }
            $editorName = $b->editor && $b->editor !== '-' ? $b->editor : ($b->bookEditors?->user?->full_name ?? null);
            $item = [
                '@type' => 'ListItem',
                'position' => $offset + $idx + 1,
                'url' => route('bookDetail', $b->slug),
                'item' => array_filter([
                    '@type' => 'Book',
                    'name' => $b->title,
                    'author' => $authors,
                    'editor' => $editorName ? ['@type' => 'Person', 'name' => $editorName] : null,
                    'image' => $b->cover ? asset('storage/' . $b->cover) : null,
                    'isbn' => $b->code_isbn ?: null,
                    'datePublished' => $b->year_published ?: null,
                    'publisher' => $b->publisher ?: config('app.name'),
                    'inLanguage' => $b->language ?: null,
                ], fn($v) => $v !== null),
            ];
            $listElements[] = $item;
        }
        $itemListSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Katalog Buku - Daya Media',
            'itemListOrder' => 'Ascending',
            'numberOfItems' => count($listElements),
            'itemListElement' => $listElements,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($itemListSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif

@section('content')
<div class="bg-gray-50/30 min-h-screen pb-20">
    <!-- Breadcrumb & Header -->
    <div class="py-10 bg-white border-b border-gray-100 mb-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="kt-container-fixed relative z-10">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight text-mono">Katalog Buku</h1>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
                    <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
                    <span class="text-gray-900">Katalog Buku</span>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="flex flex-col items-stretch gap-7">

            {{-- Search + Filter Button (mobile) --}}
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3 w-full">
                @if(request('category_id'))
                    @foreach((array)request('category_id') as $catId)
                        <input type="hidden" name="category_id[]" value="{{ $catId }}">
                    @endforeach
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="relative flex-grow w-full group">
                    <!-- Icon -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none z-10">
                        <i class="ki-filled ki-magnifier text-gray-400 text-xl group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <!-- Input -->
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari judul buku, penulis, penerbit..." 
                        class="block w-full !pl-14 !pr-32 !py-4.5 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                    <!-- Button -->
                    <div class="absolute inset-y-0 right-1.5 flex items-center z-10">
                        <button type="submit" class="bg-primary text-white font-black text-[10px] uppercase tracking-[0.15em] py-3 px-6 rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 active:scale-95">
                            Cari
                        </button>
                    </div>
                </div>
                <button type="button" class="lg:hidden kt-btn kt-btn-outline bg-white px-5 py-4 rounded-2xl shadow-sm border-gray-200" data-kt-drawer-toggle="#drawers_shop_filter">
                    <i class="ki-filled ki-filter"></i> Filter
                </button>
            </form>

            {{-- Layout utama --}}
            <div class="flex gap-8 items-start">

                {{-- ===== SIDEBAR FILTER (desktop) ===== --}}
                <aside class="hidden lg:flex flex-col gap-6 w-[260px] shrink-0 sticky top-[var(--header-height,100px)]">
                    <form action="{{ url()->current() }}" method="GET" id="desktop-filter-form">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        
                        <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-xl shadow-gray-200/40">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                                <div class="size-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                    <i class="ki-filled ki-filter text-lg"></i>
                                </div>
                                <h3 class="text-lg font-black text-gray-900">Filter</h3>
                            </div>

                            {{-- Kategori --}}
                            <div class="flex flex-col gap-4 mb-6">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori Buku</span>
                                <div class="flex flex-col gap-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($categories as $cat)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" class="peer w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all cursor-pointer" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} onchange="document.getElementById('desktop-filter-form').submit()">
                                            </div>
                                            <span class="text-sm font-bold text-gray-600 group-hover:text-primary transition-colors">{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('category_id') || request('search') || request('sort'))
                                <a href="{{ route('catalog') }}" class="w-full py-3 bg-red-50 text-red-600 font-bold text-sm rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                                    <i class="ki-filled ki-arrows-circle"></i> Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </aside>
                {{-- ===== END SIDEBAR ===== --}}

                {{-- ===== KONTEN PRODUK ===== --}}
                <div class="flex flex-col gap-6 flex-1 min-w-0">

                    {{-- Toolbar --}}
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm flex flex-wrap items-center justify-between gap-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            Menampilkan <span class="font-black text-gray-900">{{ $books->count() }}</span> dari <span class="font-black text-primary">{{ $books->total() }}</span> buku
                            @if(request('search')) untuk pencarian "<span class="italic font-bold text-gray-900">{{ request('search') }}</span>" @endif
                        </h3>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Urutkan</span>
                            <select class="kt-select kt-select-sm bg-gray-50 border-gray-100 rounded-xl text-sm font-bold w-[180px] focus:bg-white" onchange="window.location.href='{{ request()->fullUrlWithQuery(['sort' => '']) }}' + this.value">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    {{-- ===== GRID VIEW ===== --}}
                    @if($books->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                            @foreach ($books as $book)
                                <div class="bg-white border border-gray-100 rounded-3xl p-4 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 group flex flex-col h-full">
                                    {{-- Gambar --}}
                                    <div class="relative bg-gray-50 rounded-2xl overflow-hidden mb-4 aspect-[3/4] shadow-inner">
                                        <a href="{{ route('bookDetail', $book->slug) }}" class="block w-full h-full">
                                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/400x600?text=No+Cover' }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </a>
                                        {{-- Overlay Actions --}}
                                        <div class="absolute inset-x-0 bottom-0 p-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex justify-center gap-2">
                                            <button class="add-to-cart-btn size-10 bg-primary text-white rounded-xl flex items-center justify-center hover:bg-primary-dark shadow-lg transform active:scale-95 transition-all" data-book-id="{{ $book->id }}" title="Tambah ke Keranjang">
                                                <i class="ki-filled ki-handcart text-xl"></i>
                                            </button>
                                            <a href="{{ route('bookDetail', $book->slug) }}" class="size-10 bg-white text-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-100 shadow-lg transform active:scale-95 transition-all" title="Lihat Detail">
                                                <i class="ki-filled ki-eye text-xl"></i>
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex flex-col flex-grow">
                                        <a href="{{ route('bookDetail', $book->slug) }}" class="text-sm sm:text-base font-bold text-gray-900 leading-snug mb-1 group-hover:text-primary transition-colors line-clamp-2" title="{{ $book->title }}">
                                            {{ $book->title }}
                                        </a>
                                        <p class="text-xs text-gray-500 font-medium mb-3 line-clamp-1">
                                            @if ($book->authors->count() > 0)
                                                @php
                                                    $firstAuthor = $book->authors->first();
                                                    $firstName = $firstAuthor->author ?? ($firstAuthor->user->full_name ?? null);
                                                @endphp
                                                {{ $firstName }}{{ $book->authors->count() > 1 ? ', dkk.' : '' }}
                                            @else
                                                Penulis Tidak Diketahui
                                            @endif
                                        </p>

                                        {{-- Harga --}}
                                        <div class="mt-auto pt-3 border-t border-gray-50">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Mulai Dari</p>
                                            @php
                                                $collectPrice = [$book->price_physical, $book->price_digital];
                                                $minPrice = min($collectPrice);
                                                $maxPrice = max($collectPrice);
                                            @endphp
                                            <div class="flex flex-wrap items-baseline gap-1">
                                                <span class="text-base font-black text-primary">Rp{{ number_format($minPrice, 0, ',', '.') }}</span>
                                                @if($minPrice != $maxPrice)
                                                    <span class="text-xs font-bold text-gray-400">- Rp{{ number_format($maxPrice, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 rounded-3xl shadow-sm text-center">
                            <div class="size-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-6">
                                <i class="ki-filled ki-book text-5xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada buku ditemukan</h3>
                            <p class="text-gray-500 font-medium max-w-sm">Coba gunakan kata kunci lain atau hapus beberapa filter untuk menemukan buku yang Anda cari.</p>
                            @if(request('category_id') || request('search'))
                                <a href="{{ route('catalog') }}" class="mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all">Reset Pencarian</a>
                            @endif
                        </div>
                    @endif

                    {{-- ===== PAGINATION ===== --}}
                    <div class="mt-8 flex justify-center">
                        {{ $books->appends(request()->only('search', 'category_id', 'sort'))->links() }}
                    </div>

                </div>
                {{-- ===== END KONTEN PRODUK ===== --}}

            </div>
        </div>
    </div>
</div>

{{-- ===== DRAWER FILTER MOBILE ===== --}}
<div class="hidden kt-drawer kt-drawer-end flex-col w-[320px] max-w-[90%] bg-white shadow-2xl z-50" data-kt-drawer="true" data-kt-drawer-container="body" id="drawers_shop_filter">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
        <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
            <i class="ki-filled ki-filter text-primary"></i> Filter
        </h3>
        <button class="size-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-red-500 transition-colors" data-kt-drawer-dismiss="true">
            <i class="ki-filled ki-cross text-base"></i>
        </button>
    </div>
    <div class="p-5 flex-1 overflow-y-auto custom-scrollbar">
        <form action="{{ url()->current() }}" method="GET" id="mobile-filter-form" class="space-y-6">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

            <div class="flex flex-col gap-3">
                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori Buku</span>
                <div class="flex flex-col gap-3">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }}>
                            <span class="text-sm font-bold text-gray-600">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
    <div class="p-5 border-t border-gray-100 bg-white grid grid-cols-2 gap-3">
        <a href="{{ route('catalog') }}" class="py-3.5 bg-gray-100 text-gray-600 font-bold rounded-xl text-center hover:bg-gray-200 transition-colors">Reset</a>
        <button type="button" onclick="document.getElementById('mobile-filter-form').submit()" class="py-3.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-all text-center">Terapkan</button>
    </div>
</div>

<style>
    /* Custom Scrollbar for Filters */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #cbd5e1; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();

        @guest
            Swal.fire({
                title: 'Akses Terbatas',
                text: 'Anda harus login terlebih dahulu untuk menambahkan buku ke keranjang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F172A', // Using primary dark shade
                cancelButtonColor: '#f1f5f9',
                cancelButtonText: '<span style="color:#64748b">Batal</span>',
                confirmButtonText: 'Login Sekarang',
                customClass: {
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("login") }}';
                }
            });
            return;
        @endguest

        let button = $(this);
        let bookId = button.data('book-id');
        let originalIcon = button.html();

        button.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin text-xl"></i>');

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                book_id: bookId,
                type: 'digital' // Default type when adding from catalog
            },
            success: function(response) {
                button.html('<i class="ki-filled ki-check text-xl"></i>').removeClass('bg-primary hover:bg-primary-dark').addClass('bg-green-500 hover:bg-green-600');
                
                // Optional: Update cart counter in header if function exists
                if(typeof updateCartCount === 'function') updateCartCount();

                setTimeout(function() {
                    button.prop('disabled', false).html(originalIcon).removeClass('bg-green-500 hover:bg-green-600').addClass('bg-primary hover:bg-primary-dark');
                }, 2000);
            },
            error: function(xhr) {
                button.html('<i class="ki-filled ki-cross text-xl"></i>').removeClass('bg-primary hover:bg-primary-dark').addClass('bg-red-500 hover:bg-red-600');
                
                let errorMsg = xhr.responseJSON?.message || 'Gagal menambahkan ke keranjang';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                setTimeout(function() {
                    button.prop('disabled', false).html(originalIcon).removeClass('bg-red-500 hover:bg-red-600').addClass('bg-primary hover:bg-primary-dark');
                }, 2000);
            }
        });
    });
});
</script>
@endpush