@extends('landing.layouts.app')

@php
    $manualEditor = trim((string) $book->editor);
    $editorName = $manualEditor !== '' && $manualEditor !== '-' ? $manualEditor : ($book->bookEditors?->user?->full_name ?? null);
    $abstract = \Illuminate\Support\Str::limit(trim(strip_tags($book->description)), 500);
    $canonicalUrl = route('bookDetail', $book->slug);
    $publishedDate = $book->year_published ? $book->year_published . '-01-01' : optional($book->published_at)->toDateString();
    $scholarPublicationDate = $book->year_published ?: optional($book->published_at)->format('Y/n/j');
@endphp

@push('meta')
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta name="robots" content="{{ app()->environment('production') ? 'index, follow, max-image-preview:large' : 'noindex, nofollow' }}">

    {{-- Google Scholar / Highwire Press --}}
    <meta name="citation_title" content="{{ $book->title }}">
    @if(isset($authors) && $authors->count() > 0)
        @foreach($authors as $author)
            @if(!empty($author['name']))
                <meta name="citation_author" content="{{ $author['name'] }}">
            @endif
        @endforeach
    @endif
    @if($editorName)
        <meta name="citation_editor" content="{{ $editorName }}">
    @endif
    @if($book->publisher)
        <meta name="citation_publisher" content="{{ $book->publisher }}">
    @else
        <meta name="citation_publisher" content="{{ config('app.name') }}">
    @endif
    @if($scholarPublicationDate)
        <meta name="citation_publication_date" content="{{ $scholarPublicationDate }}">
    @endif
    @if($book->code_isbn)
        <meta name="citation_isbn" content="{{ $book->code_isbn }}">
    @endif
    @if($book->language)
        <meta name="citation_language" content="{{ $book->language }}">
    @endif
    @if(!empty($abstract))
        <meta name="citation_abstract" content="{{ $abstract }}">
    @endif
    <meta name="citation_abstract_html_url" content="{{ $canonicalUrl }}">
    <meta name="citation_public_url" content="{{ $canonicalUrl }}">

    @php
        $authorList = [];
        if(isset($authors)) {
            foreach ($authors as $a) {
                if (!empty($a['name'])) {
                    $authorList[] = ['@type' => 'Person', 'name' => $a['name']];
                }
            }
        }
        $bookSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Book',
            'name' => $book->title,
            'author' => $authorList,
            'editor' => $editorName ? ['@type' => 'Person', 'name' => $editorName] : null,
            'isbn' => $book->code_isbn ?: null,
            'datePublished' => $publishedDate ?: null,
            'publisher' => $book->publisher ?: config('app.name'),
            'inLanguage' => $book->language ?: null,
            'image' => $book->cover ? asset('storage/' . $book->cover) : null,
            'url' => $canonicalUrl,
            'sameAs' => $book->google_scholar_url ?: null,
            'description' => $abstract ?: null,
            'bookFormat' => 'https://schema.org/EBook',
            'numberOfPages' => $book->pages ?: null,
        ];
        $bookSchema = array_filter($bookSchema, function ($v) { return $v !== null; });
    @endphp
    <script type="application/ld+json">{!! json_encode($bookSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@push('meta')
    @php
        $ogTitle = $book->title;
        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($book->description), 180);
        $ogImage = $book->cover ? asset('storage/' . $book->cover) : asset('assets/daya-media-logo.png');
        $ogUrl = url()->current();
    @endphp
    <meta name="description" content="{{ $ogDescription }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:type" content="book">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    @if(isset($authors) && $authors->count() > 0)
        @foreach($authors as $author)
            @if(!empty($author['name']))
                <meta property="book:author" content="{{ $author['name'] }}">
            @endif
        @endforeach
    @endif
    @if($book->code_isbn)
        <meta property="book:isbn" content="{{ $book->code_isbn }}">
    @endif
    @if($book->year_published)
        <meta property="book:release_date" content="{{ $book->year_published }}-01-01">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
@endpush

@section('content')
<div class="bg-gray-50/30 min-h-screen pb-20 pt-10">
    <div class="kt-container-fixed">
        
        {{-- ===== BREADCRUMB ===== --}}
        <div class="flex items-center gap-2 text-sm font-medium mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <a href="{{ route('catalog') }}" class="text-gray-500 hover:text-primary transition-colors">Katalog</a>
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
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-wider rounded-lg border border-green-100">
                                <i class="ki-filled ki-check-circle mr-1"></i> Tersedia
                            </span>
                            @if($book->price_digital > 0)
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider rounded-lg border border-blue-100">
                                    E-Book
                                </span>
                            @endif
                            @if($book->price_physical > 0)
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-black uppercase tracking-wider rounded-lg border border-yellow-100">
                                    Cetak
                                </span>
                            @endif
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
                        <p class="text-gray-500 font-medium">ISBN: <span class="font-bold text-gray-900">{{ $book->code_isbn ?? "-" }}</span></p>
                        @if($book->google_scholar_url)
                            <a href="{{ $book->google_scholar_url }}" target="_blank" rel="noopener"
                               class="mt-4 inline-flex items-center gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-2 text-xs font-black uppercase tracking-widest text-blue-700 hover:border-blue-300 hover:bg-white transition-all">
                                <i class="ki-filled ki-teacher text-base"></i>
                                Google Scholar
                            </a>
                        @endif
                    </div>

                    {{-- Spesifikasi Grid --}}
                    <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-1">
                        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 bg-white rounded-t-2xl">
                            <i class="ki-filled ki-information-2 text-primary text-lg"></i>
                            <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Informasi Buku</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            @php
                            $info = [
                                ['icon' => 'ki-user-edit', 'label' => 'Penulis', 'value' => $authors->take(3)->map(fn($a) => $a['name'])->implode(', ') . ($authors->count() > 3 ? '...' : '')],
                                ['icon' => 'ki-pencil', 'label' => 'Editor', 'value' => $editorName ?? '-'],
                                ['icon' => 'ki-world', 'label' => 'Bahasa', 'value' => $book->language ?? '-'],
                                ['icon' => 'ki-calendar', 'label' => 'Tahun Terbit', 'value' => $book->year_published ?? '-'],
                                ['icon' => 'ki-home-3', 'label' => 'Penerbit', 'value' => $book->publisher ?? '-'],
                                ['icon' => 'ki-package', 'label' => 'Berat', 'value' => number_format($book->weight ?? 0, 0, ',', '.') . ' Gram'],
                                ['icon' => 'ki-book-open', 'label' => 'Halaman', 'value' => number_format($book->pages ?? 0, 0, ',', '.') . ' Hal'],
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
                            @if($book->website)
                            <div class="flex items-start gap-3 p-4 sm:col-span-2">
                                <div class="size-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 text-gray-400 shrink-0">
                                    <i class="ki-filled ki-globe"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Website</p>
                                    <a href="{{ $book->website }}" target="_blank" class="text-sm font-bold text-primary hover:underline mt-1 break-all">{{ $book->website }}</a>
                                </div>
                            </div>
                            @endif
                            @if($book->google_scholar_url)
                            <div class="flex items-start gap-3 p-4 sm:col-span-2">
                                <div class="size-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 text-blue-500 shrink-0">
                                    <i class="ki-filled ki-teacher"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Google Scholar</p>
                                    <a href="{{ $book->google_scholar_url }}" target="_blank" rel="noopener" class="text-sm font-black text-blue-700 hover:underline mt-1 break-all">Lihat profil Scholar</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kanan: Transaksi --}}
                <div class="lg:col-span-4">
                    <div class="bg-white border-2 border-gray-100 rounded-3xl p-6 shadow-xl shadow-gray-200/50 sticky top-[100px]">
                        <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-2">
                            <i class="ki-filled ki-shop text-primary"></i> Pilih Edisi
                        </h3>

                        <div class="flex flex-col gap-3 mb-6" id="product-type-group">
                            @if($book->price_digital > 0)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="productType" value="digital" class="sr-only edition-radio" checked>
                                    <div class="edition-card flex items-center justify-between p-4 rounded-2xl border-2 bg-white text-gray-900 border-gray-100 transition-all duration-300 relative">
                                        <div class="flex items-center gap-3">
                                            <div class="edition-icon-container size-10 rounded-xl bg-info/10 text-info flex items-center justify-center transition-colors">
                                                <i class="ki-filled ki-devices text-xl edition-icon"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-black edition-title transition-colors">E-Book</p>
                                                <p class="text-[10px] font-bold uppercase tracking-wider edition-subtitle text-gray-500 transition-colors">Akses Digital</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg font-black edition-price text-primary transition-colors">Rp{{ number_format($book->price_digital, 0, ',', '.') }}</span>
                                            <i class="ki-filled ki-check-circle text-2xl edition-check opacity-0 scale-50 transition-all duration-300 text-primary"></i>
                                        </div>
                                    </div>
                                </label>
                            @endif

                            @if($book->price_physical > 0)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="productType" value="physical" class="sr-only edition-radio" {{ $book->price_digital <= 0 ? 'checked' : '' }}>
                                    <div class="edition-card flex items-center justify-between p-4 rounded-2xl border-2 bg-white text-gray-900 border-gray-100 transition-all duration-300 relative">
                                        <div class="flex items-center gap-3">
                                            <div class="edition-icon-container size-10 rounded-xl bg-warning/10 text-warning flex items-center justify-center transition-colors">
                                                <i class="ki-filled ki-book text-xl edition-icon"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold edition-title transition-colors">Buku Cetak</p>
                                                <p class="text-[10px] font-bold uppercase tracking-wider edition-subtitle text-gray-500 transition-colors">Fisik (Dikirim)</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg font-black edition-price text-primary transition-colors">Rp{{ number_format($book->price_physical, 0, ',', '.') }}</span>
                                            <i class="ki-filled ki-check-circle text-2xl edition-check opacity-0 scale-50 transition-all duration-300 text-primary"></i>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>

                        {{-- Kuantitas & Action --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="text-xs font-bold text-gray-500 ml-3 uppercase tracking-widest">Kuantitas</span>
                                <div class="flex items-center bg-white rounded-xl shadow-sm border border-gray-100 p-1">
                                    <button type="button" id="decreaseQty" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-50 text-gray-500 transition-colors">
                                        <i class="ki-filled ki-minus text-sm"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" readonly class="w-12 text-center text-sm font-black text-gray-900 border-none bg-transparent focus:ring-0 p-0">
                                    <button type="button" id="increaseQty" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-50 text-gray-500 transition-colors">
                                        <i class="ki-filled ki-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            @if($hasReadAccess ?? $hasPurchased)
                                <a href="{{ route('book.read', $book->slug) }}" class="w-full py-4 bg-green-500 text-white font-black rounded-2xl shadow-xl shadow-green-500/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2 text-base">
                                    <i class="ki-filled ki-book-open text-xl"></i> {{ $hasPurchased ? 'Baca E-Book Sekarang' : 'Baca Sebagai Penulis' }}
                                </a>
                            @endif
                            <div class="flex flex-col gap-3">
                                <button type="button" id="buy-now-btn" data-book-id="{{ $book->id }}" class="w-full py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:bg-primary-dark transition-all flex items-center justify-center gap-2 text-base">
                                    <i class="ki-filled ki-credit-card text-xl"></i> Beli Sekarang
                                </button>
                                <button type="button" id="add-to-cart-btn" data-book-id="{{ $book->id }}" class="w-full py-4 bg-white border-2 border-primary/20 text-primary font-black rounded-2xl hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                                    <i class="ki-filled ki-handcart text-xl"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TABS: ABSTRAK & PREVIEW ===== --}}
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm mb-16">
            <div class="flex border-b border-gray-100 bg-gray-50/50 p-2 gap-2 overflow-x-auto custom-scrollbar">
                <button onclick="switchTab('tab-description')" id="btn-tab-description" class="px-6 py-3.5 text-sm font-black uppercase tracking-widest rounded-2xl bg-white shadow-sm border border-gray-100 text-primary transition-all whitespace-nowrap">
                    <i class="ki-filled ki-file-text mr-2"></i> Abstrak / Deskripsi
                </button>
                <button onclick="switchTab('tab-preview')" id="btn-tab-preview" class="px-6 py-3.5 text-sm font-bold uppercase tracking-widest rounded-2xl text-gray-500 hover:text-gray-900 transition-all whitespace-nowrap">
                    <i class="ki-filled ki-eye mr-2"></i> Preview PDF
                </button>
            </div>

            <div class="p-6 lg:p-10">
                <!-- Deskripsi Tab -->
                <div id="tab-description" class="prose prose-sm sm:prose-base max-w-none text-gray-600">
                    {!! $book->description !!}
                </div>

                <!-- Preview Tab -->
                <div id="tab-preview" class="hidden">
                    @if($book->half_content)
                        <div class="flex flex-wrap justify-center gap-2 mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <button id="zoom-out" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-2">
                                <i class="ki-filled ki-minus"></i> Zoom Out
                            </button>
                            <span id="zoom-percent" class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-black w-20 text-center">150%</span>
                            <button id="zoom-in" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-2">
                                <i class="ki-filled ki-plus"></i> Zoom In
                            </button>
                            <button id="reset-zoom" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-bold hover:bg-black transition-colors">Reset</button>
                        </div>
                        <div id="pdf-container" class="bg-gray-200 rounded-2xl p-4 sm:p-8 overflow-y-auto max-h-[800px] border border-gray-300 shadow-inner custom-scrollbar">
                            <div id="pdf-pages-container" class="flex flex-col items-center gap-6"></div>
                        </div>
                    @else
                        <div class="py-20 text-center">
                            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mx-auto mb-4">
                                <i class="ki-filled ki-file text-4xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">Preview Tidak Tersedia</h4>
                            <p class="text-sm text-gray-500">File PDF preview belum diunggah untuk buku ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== PRODUK SERUPA ===== --}}
        <div class="mb-10">
            <div class="flex items-end justify-between border-b border-gray-100 pb-5 mb-6">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Produk Serupa</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @forelse($books as $item)
                    @include('landing.pages.home.partials.book-card', ['book' => $item])
                @empty
                    <div class="col-span-full py-10 text-center text-gray-500 font-medium bg-white rounded-3xl border border-gray-100">
                        Tidak ada buku serupa ditemukan.
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
    // TABS LOGIC
    function switchTab(tabId) {
        // Hide all
        $('#tab-description, #tab-preview').addClass('hidden');
        $('#btn-tab-description, #btn-tab-preview').removeClass('bg-white shadow-sm border-gray-100 text-primary font-black').addClass('text-gray-500 font-bold border-transparent');
        
        // Show active
        $('#' + tabId).removeClass('hidden');
        $('#btn-' + tabId).addClass('bg-white shadow-sm border-gray-100 text-primary font-black').removeClass('text-gray-500 font-bold border-transparent');

        // Trigger PDF render if preview tab
        if(tabId === 'tab-preview' && typeof renderAllPages === 'function' && $('#pdf-pages-container').is(':empty')) {
            renderAllPages();
        }
    }

    $(document).ready(function() {
        const TOKEN = '{{ csrf_token() }}';

        // Radio Button UI Logic
        function updateRadioUI() {
            $('.edition-card').removeClass('bg-primary border-primary shadow-xl shadow-primary/20').addClass('bg-white border-gray-100');
            $('.edition-title').removeClass('text-white').addClass('text-gray-900');
            $('.edition-subtitle').removeClass('text-white/80').addClass('text-gray-500');
            $('.edition-price').removeClass('text-white').addClass('text-primary');
            $('.edition-icon').removeClass('text-white');
            $('.edition-icon-container').removeClass('bg-white/20');
            $('.edition-check').removeClass('opacity-100 scale-100 text-white').addClass('opacity-0 scale-50 text-primary');

            let checkedRadio = $('input[name="productType"]:checked');
            if (checkedRadio.length > 0) {
                let activeCard = checkedRadio.closest('label').find('.edition-card');
                activeCard.removeClass('bg-white border-gray-100').addClass('bg-primary border-primary shadow-xl shadow-primary/20');
                activeCard.find('.edition-title').removeClass('text-gray-900').addClass('text-white');
                activeCard.find('.edition-subtitle').removeClass('text-gray-500').addClass('text-white/80');
                activeCard.find('.edition-price').removeClass('text-primary').addClass('text-white');
                activeCard.find('.edition-icon').addClass('text-white');
                activeCard.find('.edition-icon-container').addClass('bg-white/20');
                activeCard.find('.edition-check').removeClass('opacity-0 scale-50 text-primary').addClass('opacity-100 scale-100 text-white');
            }
        }

        $('input[name="productType"]').on('change', updateRadioUI);
        updateRadioUI();

        // QUANTITY LOGIC
        $('#increaseQty').click(function() {
            let qty = parseInt($('#quantity').val());
            $('#quantity').val(qty + 1);
        });
        $('#decreaseQty').click(function() {
            let qty = parseInt($('#quantity').val());
            if(qty > 1) $('#quantity').val(qty - 1);
        });

        // AJAX ADD TO CART
        function processAction(actionType) {
            @guest
                Swal.fire({
                    title: 'Akses Terbatas',
                    text: 'Anda harus login terlebih dahulu untuk melakukan transaksi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            @endguest

            const bookId = '{{ $book->id }}';
            const quantity = parseInt($('#quantity').val());
            const selectedType = $('input[name="productType"]:checked').val();
            const btnId = actionType === 'cart' ? '#add-to-cart-btn' : '#buy-now-btn';
            const btn = $(btnId);
            const originalHtml = btn.html();

            if(!selectedType) {
                Swal.fire({ icon: 'warning', title: 'Oops', text: 'Pilih edisi buku terlebih dahulu.' });
                return;
            }

            btn.prop('disabled', true).html('<i class="ki-filled ki-arrows-circle animate-spin text-xl"></i> Memproses...');

            if (actionType === 'cart') {
                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: { _token: TOKEN, book_id: bookId, quantity: quantity, type: selectedType },
                    success: function(res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
                        btn.prop('disabled', false).html(originalHtml);
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan' });
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            } else if (actionType === 'buy') {
                const price = selectedType === 'digital' ? {{ (int)$book->price_digital }} : {{ (int)$book->price_physical }};
                $.ajax({
                    url: '{{ route("checkout.process") }}',
                    method: 'POST',
                    data: {
                        _token: TOKEN,
                        items: [{ book_id: bookId, quantity: quantity, type: selectedType, price: price }],
                        total_price: price * quantity
                    },
                    success: function(res) {
                        if(res.success) window.location.href = res.redirect_url;
                        else Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat memproses checkout' });
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        }

        $('#add-to-cart-btn').click(function() { processAction('cart'); });
        $('#buy-now-btn').click(function() { processAction('buy'); });

        // PDF.js Logic
        @if($book->half_content)
            if (typeof pdfjsLib !== 'undefined') {
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                const url = '{{ route("book.preview-pdf", $book->slug) }}';
                let pdfDoc = null;
                let currentScale = 1.5;
                const container = document.getElementById('pdf-pages-container');

                window.renderAllPages = function() {
                    $('#zoom-percent').text(Math.round(currentScale * 100) + '%');
                    container.innerHTML = '';
                    for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                        const canvas = document.createElement('canvas');
                        canvas.className = 'rounded-xl shadow-lg border border-gray-200 bg-white max-w-full';
                        container.appendChild(canvas);
                        
                        pdfDoc.getPage(pageNum).then(page => {
                            const viewport = page.getViewport({ scale: currentScale });
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
                            page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport });
                        });
                    }
                }

                $('#zoom-in').click(() => { if (currentScale < 3.0) { currentScale += 0.25; renderAllPages(); } });
                $('#zoom-out').click(() => { if (currentScale > 0.5) { currentScale -= 0.25; renderAllPages(); } });
                $('#reset-zoom').click(() => { currentScale = 1.5; renderAllPages(); });

                pdfjsLib.getDocument(url).promise.then(pdf => {
                    pdfDoc = pdf;
                }).catch(err => {
                    container.innerHTML = '<p class="text-red-500 font-bold p-10">Gagal memuat file PDF.</p>';
                });
            }
        @endif
    });
</script>
@endpush
