@extends('landing.layouts.app')

@section('title', 'Buku Kolaborasi - Daya Media')

@section('content')
<div class="bg-gray-50/30 min-h-screen pb-20 pt-10">
    <div class="kt-container-fixed">
        
        {{-- ===== BREADCRUMB & HEADER ===== --}}
        <div class="flex flex-col gap-2 mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight text-mono text-center sm:text-left">Gabung Menulis Bersama</h1>
            <div class="flex items-center justify-center sm:justify-start gap-2 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
                <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
                <span class="text-gray-900">Buku Kolaborasi</span>
            </div>
        </div>

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
                    <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none z-10">
                        <i class="ki-filled ki-magnifier text-gray-400 text-xl group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari buku kolaborasi atau topik..." 
                        class="block w-full !pl-14 !pr-32 !py-4.5 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
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
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori</span>
                                <div class="flex flex-col gap-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($categories as $cat)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" class="peer w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} onchange="document.getElementById('desktop-filter-form').submit()">
                                            <span class="text-sm font-bold text-gray-600 group-hover:text-primary transition-colors">{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('category_id') || request('search') || request('sort'))
                                <a href="{{ route('collaboration') }}" class="w-full py-3 bg-red-50 text-red-600 font-bold text-sm rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
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
                            Menampilkan <span class="font-black text-primary">{{ $books->total() }}</span> proyek kolaborasi
                        </h3>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Urutkan</span>
                            <select class="kt-select kt-select-sm bg-gray-50 border-gray-100 rounded-xl text-sm font-bold w-[180px] focus:bg-white" onchange="window.location.href='{{ request()->fullUrlWithQuery(['sort' => '']) }}' + this.value">
                                <option value="quota_high" {{ request('sort') == 'quota_high' ? 'selected' : '' }}>Slot Terbanyak</option>
                                <option value="quota_low" {{ request('sort') == 'quota_low' ? 'selected' : '' }}>Slot Tersisa</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            </select>
                        </div>
                    </div>

                    {{-- ===== GRID VIEW ===== --}}
                    @if($books->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                            @foreach ($books as $book)
                                @include('landing.pages.home.partials.collab-card', ['book' => $book])
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 rounded-3xl shadow-sm text-center">
                            <div class="size-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-6">
                                <i class="ki-filled ki-users text-5xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada proyek kolaborasi</h3>
                            <p class="text-gray-500 font-medium max-w-sm mx-auto">Saat ini tidak ada proyek kolaborasi yang sesuai dengan filter Anda.</p>
                            @if(request('category_id') || request('search'))
                                <a href="{{ route('collaboration') }}" class="mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all">Reset Pencarian</a>
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
                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori</span>
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
        <a href="{{ route('collaboration') }}" class="py-3.5 bg-gray-100 text-gray-600 font-bold rounded-xl text-center hover:bg-gray-200 transition-colors">Reset</a>
        <button type="button" onclick="document.getElementById('mobile-filter-form').submit()" class="py-3.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-all text-center">Terapkan</button>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #cbd5e1; }
</style>
@endsection
