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
            'name' => 'Katalog Buku',
            'itemListOrder' => 'Ascending',
            'numberOfItems' => count($listElements),
            'itemListElement' => $listElements,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($itemListSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif

@section('content')
    <div class="main-wrapper overflow-hidden my-3">
        <div class="container">
            <div class="position-relative overflow-hidden">
                <div class="shop-part d-flex w-100">
                    <div class="card-body p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
                            <h5 class="fs-5 mb-0 d-none d-lg-block">Katalog Buku</h5>

                            <div class="d-flex align-items-center gap-2">
                                <button class="btn bg-primary-subtle text-primary" data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    <i class="ti ti-filter"></i> Filter
                                </button>

                                <select class="form-select w-auto" id="sort-select"
                                    onchange="window.location.href='{{ request()->fullUrlWithQuery(['sort' => '']) }}' + this.value">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama
                                    </option>
                                    {{-- <option value="published_latest" {{ request('sort') == 'published_latest' ? 'selected' : '' }}>Terbaru Tahun Terbit</option>
                                    <option value="published_oldest" {{ request('sort') == 'published_oldest' ? 'selected' : '' }}>Terlama Tahun Terbit</option> --}}
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                        Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                        Tertinggi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 g-md-4">
                            @forelse ($books as $book)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm h-100 mb-0">
                                        <div class="position-relative">
                                            <a href="{{ route('bookDetail', $book->slug) }}">
                                                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                                    class="card-img-top" alt="Book Cover"
                                                    style="aspect-ratio: 1 / 1.41; object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="card-body p-2 d-flex flex-column">
                                            <h6 class="fw-bolder mb-1" style="color: #2a3547; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $book->title }}</h6>
                                            <p class="text-muted mb-3 fs-2"
                                                style="font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                @if ($book->authors->count() > 0)
                                                    @php
                                                        $firstAuthor = $book->authors->first();
                                                        $firstName = $firstAuthor->author ?? ($firstAuthor->user->full_name ?? null);
                                                    @endphp
                                                    {{ $firstName }}{{ $book->authors->count() > 1 ? ', dkk.' : '' }}
                                                @else
                                                    -
                                                @endif
                                            </p>

                                            <div class="mt-auto">
                                                <div class="d-flex flex-column justify-content-between align-items-start mb-2">
                                                    <div class="flex-fill">
                                                        @php
                                                            $collectPrice = [$book->price_physical, $book->price_digital];
                                                            $minPrice = min($collectPrice);
                                                            $maxPrice = max($collectPrice);
                                                        @endphp
                                                        <h4 class="mb-0 fw-bolder fs-3" style="color: #255c83;">
                                                            Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                                            -
                                                            Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                                        <p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-primary w-100 add-to-cart-btn"
                                                    data-book-id="{{ $book->id }}">
                                                    <i class="ti ti-plus"></i> Keranjang
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center">No books found.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="row mt-3">
                            {{ $books->appends(request()->only('search', 'category_id'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-filter :categories="$categories" />
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.add-to-cart-btn').on('click', function(e) {
                    e.preventDefault();

                    @guest
                    // Jika pengguna belum login, arahkan ke halaman login
                    window.location.href = "{{ route('login') }}";
                    return;
                @endguest

                let button = $(this);
                let bookId = button.data('book-id');
                let originalText = button.html();

                // Menonaktifkan tombol dan menunjukkan status loading
                button.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        book_id: bookId
                    },
                    success: function(response) {
                        // Ganti teks tombol untuk memberikan feedback
                        button.html('<i class="ti ti-check"></i> Ditambahkan').removeClass(
                            'btn-outline-primary').addClass('btn-success');
                        updateCartCount();

                        // Kembalikan tombol ke keadaan semula setelah beberapa detik
                        setTimeout(function() {
                            button.prop('disabled', false).html(originalText).removeClass(
                                'btn-success').addClass('btn-outline-primary');
                        }, 2000);
                    },
                    error: function(xhr) {
                        // Tangani error, misalnya jika item gagal ditambahkan
                        button.html('<i class="ti ti-x"></i> Gagal').removeClass('btn-outline-primary')
                            .addClass('btn-danger');

                        // Kembalikan tombol ke keadaan semula setelah beberapa detik
                        setTimeout(function() {
                            button.prop('disabled', false).html(originalText).removeClass(
                                'btn-danger').addClass('btn-outline-primary');
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endpush
