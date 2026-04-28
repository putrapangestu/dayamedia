
@extends('landing.layouts.app')

@if((config('app.env') ?? config('app.env')) === 'production')
@push('meta')
    <meta name="citation_title" content="{{ $book->title }}">
    @if(isset($authors) && $authors->count() > 0)
        @foreach($authors as $author)
            @if(!empty($author['name']))
                <meta name="citation_author" content="{{ $author['name'] }}">
            @endif
        @endforeach
    @endif
    @php
        $editorName = $book->editor && $book->editor !== '-' ? $book->editor : ($book->bookEditors?->user?->full_name ?? null);
    @endphp
    @if($editorName)
        <meta name="citation_editor" content="{{ $editorName }}">
    @endif
    <meta name="robots" content="index, follow">
    @if($book->publisher)
        <meta name="citation_publisher" content="{{ $book->publisher }}">
    @else
        <meta name="citation_publisher" content="{{ config('app.name') }}">
    @endif
    @if($book->year_published)
        <meta name="citation_publication_date" content="{{ $book->year_published }}">
    @endif
    @if($book->code_isbn)
        <meta name="citation_isbn" content="{{ $book->code_isbn }}">
    @endif
    @if($book->language)
        <meta name="citation_language" content="{{ $book->language }}">
    @endif
    @php
        $abstract = \Illuminate\Support\Str::limit(trim(strip_tags($book->description)), 500);
    @endphp
    @if(!empty($abstract))
        <meta name="citation_abstract" content="{{ $abstract }}">
    @endif
    <meta name="citation_abstract_html_url" content="{{ url()->current() }}">
    @if($book->half_content)
        <meta name="citation_pdf_url" content="{{ asset('storage/' . $book->half_content) }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="DC.title" content="{{ $book->title }}">
    @if(isset($authors) && $authors->count() > 0)
        @foreach($authors as $author)
            @if(!empty($author['name']))
                <meta name="DC.creator" content="{{ $author['name'] }}">
            @endif
        @endforeach
    @endif
    @if($editorName)
        <meta name="DC.contributor" content="{{ $editorName }}">
    @endif
    <meta name="DC.publisher" content="{{ $book->publisher ?? config('app.name') }}">
    @if($book->year_published)
        <meta name="DC.date" content="{{ $book->year_published }}">
    @endif
    @if($book->code_isbn)
        <meta name="DC.identifier" content="ISBN:{{ $book->code_isbn }}">
    @endif
    @if($book->language)
        <meta name="DC.language" content="{{ $book->language }}">
    @endif
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
            'datePublished' => $book->year_published ?: null,
            'publisher' => $book->publisher ?: config('app.name'),
            'inLanguage' => $book->language ?: null,
            'image' => $book->cover ? asset('storage/' . $book->cover) : null,
            'url' => url()->current(),
            'description' => $abstract ?: null,
        ];
        $bookSchema = array_filter($bookSchema, function ($v) { return $v !== null; });
    @endphp
    <script type="application/ld+json">{!! json_encode($bookSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif

@push('meta')
    @php
        $ogTitle = $book->title;
        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($book->description), 180);
        $ogImage = $book->cover ? asset('storage/' . $book->cover) : asset('assets/azzia-logo.png');
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

@push('css')
    <style>
        #pdf-container {
            background: #525659;
        }

        .pdf-page-canvas {
            background: white;
        }

        .book-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 0.75rem;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .info-item:hover {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: var(--bs-primary);
        }

        .info-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-weight: 700;
            color: #2a3547;
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .price-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            border-radius: 1rem;
            padding: 1.25rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .price-card.active {
            border-color: var(--bs-primary);
            background: rgba(var(--bs-primary-rgb), 0.03);
        }

        .author-card {
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 0.75rem;
            transition: all 0.2s ease;
            background: #fff;
        }

        .author-card:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .category-badge {
            background: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
<div class="main-wrapper overflow-hidden">
<div class="container">
          <div class="shop-detail">
            <div class="card shadow-none border">
              <div class="card-body p-4">
                <div class="row">
                        <div class="col-lg-4 d-flex align-items-stretch">
                            <img class="img-fluid rounded-xl" src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}" alt="furniture_img1" style="max-height: 500px; object-fit: cover;">
                        </div>
                        <div class="col-lg-8 d-flex flex-column align-items-stretch">
                            <div class="mb-2">
                                <span class="category-badge mb-3">
                                    <i class="ti ti-category-2 me-1"></i>{{ $book->category?->name }}
                                </span>
                                <h2 class="fw-bolder text-dark mb-1">{{ $book->title }}</h2>
                                <p class="text-muted fs-3 mb-0">ISBN: <span class="fw-semibold">{{ $book->code_isbn ?? "-" }}</span></p>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark" style="width: 30%;"><i class="ti ti-edit me-2 text-primary"></i>Penulis</td>
                                            <td class="text-dark">
                                                {{ $authors->take(3)->map(function($author) { return $author['name']; })->implode(', ') }}
                                                @if($authors->count() > 3)
                                                    <a href="#" class="ms-2 text-primary fs-2 fw-bold" data-bs-toggle="modal" data-bs-target="#bs-modal-author">Lihat Semua</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-user-check me-2 text-primary"></i>Editor</td>
                                            <td class="text-dark">{{ $book->editor && $book->editor !== '-' ? $book->editor : ($book->bookEditors?->user?->full_name ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-barcode me-2 text-primary"></i>ISBN</td>
                                            <td class="text-dark">{{ $book->code_isbn ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-world me-2 text-primary"></i>Bahasa</td>
                                            <td class="text-dark">{{ $book->language ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-calendar me-2 text-primary"></i>Tahun</td>
                                            <td class="text-dark">{{ $book->year_published ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-building-community me-2 text-primary"></i>Penerbit</td>
                                            <td class="text-dark">{{ $book->publisher ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-link me-2 text-primary"></i>Website</td>
                                            <td class="text-dark">
                                                @if($book->website)
                                                    <a href="{{ $book->website }}" target="_blank" class="text-primary text-decoration-underline text-truncate d-inline-block" style="max-width: 100%;">{{ $book->website }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-weight me-2 text-primary"></i>Berat Buku</td>
                                            <td class="text-dark">{{ number_format($book->weight ?? 0, 0, ',', '.') }} Gram</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-file-description me-2 text-primary"></i>Halaman</td>
                                            <td class="text-dark">{{ number_format($book->pages ?? 0, 0, ',', '.') }} Halaman</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light fw-bolder text-dark"><i class="ti ti-key me-2 text-primary"></i>Kata Kunci</td>
                                            <td class="text-dark">{{ $book->category?->name ?? "-" }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr class="my-4 opacity-50">

                            <div class="row g-4 mb-4">
                                <div class="col-12 col-md-4">
                                    <div class="price-card {{ $book->price_physical > 0 ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="ti ti-package fs-5 text-primary"></i>
                                            <span class="fs-2 fw-semibold text-uppercase text-muted">Buku Cetak</span>
                                        </div>
                                        <h3 class="text-primary fw-bolder mb-0">Rp.{{ number_format($book->price_physical, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="price-card {{ $book->price_digital > 0 ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="ti ti-device-tablet fs-5 text-primary"></i>
                                            <span class="fs-2 fw-semibold text-uppercase text-muted">E-Book</span>
                                        </div>
                                        <h3 class="text-primary fw-bolder mb-0">Rp.{{ number_format($book->price_digital, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                              <div class="col-12">
                                <h5 class="fw-bolder mb-3">
                                    <i class="ti ti-shopping-cart me-1 text-primary"></i> Transaksi
                                </h5>
                                <div class="d-flex flex-column flex-md-row gap-3 align-items-start align-items-md-center mb-4">
                                  <!-- Radio Button Group -->
                                  <div class="btn-group" role="group" aria-label="Product type selection">
                                    <input type="radio" class="btn-check" name="productType" id="ebook" checked autocomplete="off">
                                    <label class="btn btn-outline-primary px-4 py-2" for="ebook">
                                      <i class="ti ti-device-tablet me-1"></i> E-Book
                                    </label>

                                    <input type="radio" class="btn-check" name="productType" id="preorder" autocomplete="off">
                                    <label class="btn btn-outline-primary px-4 py-2" for="preorder">
                                      <i class="ti ti-package me-1"></i> Pre-Order
                                    </label>
                                  </div>

                                  <!-- Quantity Counter -->
                                  <div class="d-flex align-items-center bg-light rounded-pill p-1 border">
                                    <button type="button" class="btn btn-white rounded-circle shadow-none p-2 border-0" id="decreaseQty" style="width: 36px; height: 36px;">
                                      <i class="ti ti-minus fs-3"></i>
                                    </button>
                                    <input type="number" value="1" min="1" id="quantity" class="form-control text-center fw-bolder bg-transparent border-0 px-2" style="max-width: 60px;" readonly />
                                    <button type="button" class="btn btn-white rounded-circle shadow-none p-2 border-0" id="increaseQty" style="width: 36px; height: 36px;">
                                      <i class="ti ti-plus fs-3"></i>
                                    </button>
                                  </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                  @php
                                    $hasPurchased = auth()->check() ? \App\Models\Transaction::where('user_id', auth()->id())
                                        ->where('status', 'paid')
                                        ->whereHas('details', function ($query) use ($book) {
                                            $query->where('book_id', $book->id);
                                        })
                                        ->exists() : false;
                                  @endphp

                                  @if($hasPurchased)
                                    <a href="{{ route('book.read', $book->slug) }}" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                                      <i class="ti ti-book-open me-2 fs-5"></i> Baca E-Book Sekarang
                                    </a>
                                  @else
                                    <button type="button" class="btn btn-outline-primary btn-lg px-4 rounded-pill flex-grow-1 flex-md-grow-0" id="add-to-cart-btn" data-book-id="{{ $book->id }}">
                                      <i class="ti ti-shopping-cart me-2 fs-5"></i> Keranjang
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill flex-grow-1 flex-md-grow-0 shadow-sm" id="buy-now-btn" data-book-id="{{ $book->id }}">
                                      <i class="ti ti-credit-card me-2 fs-5"></i> Beli Sekarang
                                    </button>
                                  @endif
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
            <div class="card shadow-none border mt-3">
              <div class="card-body p-4">
                <ul class="nav nav-pills user-profile-tab border-bottom" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="true">
                      📝 Abstrak / Deskripsi
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false" tabindex="-1">
                      Preview Buku
                    </button>
                  </li>
                </ul>
                <div class="tab-content pt-4" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                    {{-- <h5 class="fs-5 mb-7">
                      Sed at diam elit. Vivamus tortor odio, pellentesque eu tincidunt a, aliquet sit amet lorem
                      pellentesque eu tincidunt a, aliquet sit amet lorem.
                    </h5>
                    <p class="mb-7">
                      Cras eget elit semper, congue sapien id, pellentesque diam. Nulla faucibus diam nec fermentum
                      ullamcorper. Praesent sed ipsum ut augue vestibulum malesuada. Duis
                      vitae volutpat odio. Integer sit amet elit ac justo sagittis dignissim.
                    </p>
                    <p class="mb-0">
                      Vivamus quis metus in nunc semper efficitur eget vitae diam. Proin justo diam, venenatis sit amet
                      eros in, iaculis auctor magna. Pellentesque sit amet accumsan urna, sit
                      amet pretium ipsum. Fusce condimentum venenatis mauris et luctus. Vestibulum ante ipsum primis in
                      faucibus orci luctus et ultrices posuere cubilia curae;
                    </p> --}}
                    <p class="mb-7">
                      {!! $book->description !!}
                    </p>
                  </div>
                  <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                        <div class="d-flex justify-content-center gap-2 mb-3 sticky-top bg-white py-2 shadow-sm rounded">
                            <button id="zoom-out" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-minus"></i> Zoom Out
                            </button>
                            <span id="zoom-percent" class="align-self-center fw-bold">150%</span>
                            <button id="zoom-in" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-plus"></i> Zoom In
                            </button>
                            <button id="reset-zoom" class="btn btn-sm btn-light">Reset</button>
                        </div>

                        <div id="pdf-container" style="overflow-y: auto; max-height: 600px; border: 1px solid #ddd;">
                            <div id="pdf-pages-container"></div>
                        </div>
                    </div>
                </div>
                </div>
              </div>
            </div>
            <div class="related-products pt-7">
              <h4 class="mb-3 fw-semibold">Produk Serupa</h4>
              <div class="row">
                @forelse($books as $item)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm h-100 mb-0">
                            <div class="position-relative">
                                <a href="{{ route('bookDetail', $item->slug) }}">
                                    <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                        class="card-img-top" alt="Book Cover"
                                        style="aspect-ratio: 1 / 1.41; object-fit: cover;">
                                </a>
                            </div>
                            <div class="card-body p-2 d-flex flex-column">
                                <h6 class="fw-bolder mb-1" style="color: #2a3547; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->title }}</h6>
                                <p class="text-muted mb-3 fs-2"
                                   style="font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    @if ($item->authors->count() > 0)
                                        @php
                                            $firstAuthor = $item->authors->first();
                                            $firstName = $firstAuthor->author ?? ($firstAuthor->user->full_name ?? null);
                                        @endphp
                                        {{ $firstName }}{{ $item->authors->count() > 1 ? ', dkk.' : '' }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex flex-column justify-content-between align-items-start mb-2">
                                        <div class="flex-fill">
                                            @php
                                                $collectPrice = [$item->price_physical, $item->price_digital];
                                                $minPrice = min($collectPrice);
                                                $maxPrice = max($collectPrice);
                                            @endphp
                                            <h4 class="mb-0 fw-bolder fs-3" style="color: #EE128C;">
                                                Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                                -
                                                Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                            <p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary w-100 add-to-cart-btn"
                                            data-book-id="{{ $item->id }}">
                                        <i class="ti ti-plus"></i> Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                    <p class="text-center">No related products found.</p>
                    </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
</div>

<div id="bs-modal-author" class="modal fade" tabindex="-1" aria-labelledby="bs-modal-author" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Penulis
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-uppercase fs-2 fw-bolder text-muted">No</th>
                                <th class="py-3 border-0 text-uppercase fs-2 fw-bolder text-muted">Nama Lengkap</th>
                                <th class="pe-4 py-3 border-0 text-uppercase fs-2 fw-bolder text-muted">Peran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($authors as $item)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="ti ti-user text-primary fs-4"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="pe-4">
                                        <span class="badge bg-primary-subtle text-primary fw-semibold rounded-pill px-3">Penulis</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted fst-italic">Tidak ada data penulis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-primary-subtle text-primary  waves-effect" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof pdfjsLib === 'undefined') return;

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const url = '{{ $book->half_content ? asset("storage/" . $book->half_content) : "" }}';
    if (!url) return;

    let pdfDoc = null;
    let currentScale = 1.5; // Skala awal
    const container = document.getElementById('pdf-pages-container');
    const zoomPercentDisplay = document.getElementById('zoom-percent');

    function renderAllPages() {
        // Tampilkan persentase zoom
        zoomPercentDisplay.textContent = Math.round(currentScale * 100) + '%';

        // Simpan posisi scroll sebelum render ulang (opsional)
        const currentScroll = document.getElementById('pdf-container').scrollTop;

        // Kosongkan container
        container.innerHTML = '';

        // Render setiap halaman
        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            const canvas = document.createElement('canvas');
            canvas.className = 'pdf-page-canvas';
            canvas.style.display = 'block';
            canvas.style.margin = '10px auto';
            canvas.style.border = '1px solid #ccc';
            canvas.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            canvas.style.maxWidth = '100%'; // Agar responsif di layar kecil
            canvas.style.height = 'auto';

            container.appendChild(canvas);
            renderPage(pageNum, canvas);
        }
    }

    function renderPage(num, canvas) {
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale: currentScale });
            const ctx = canvas.getContext('2d');

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            page.render(renderContext);
        });
    }

    // --- Kontrol Zoom ---
    document.getElementById('zoom-in').addEventListener('click', () => {
        if (currentScale >= 3.0) return; // Batas maksimal zoom
        currentScale += 0.25;
        renderAllPages();
    });

    document.getElementById('zoom-out').addEventListener('click', () => {
        if (currentScale <= 0.5) return; // Batas minimal zoom
        currentScale -= 0.25;
        renderAllPages();
    });

    document.getElementById('reset-zoom').addEventListener('click', () => {
        currentScale = 1.5;
        renderAllPages();
    });

    // Load PDF
    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;

        const previewTab = document.querySelector('#pills-reviews-tab');
        previewTab.addEventListener('shown.bs.tab', function () {
            if (container.innerHTML === '') {
                renderAllPages();
            }
        });

        if (previewTab.classList.contains('active')) {
            renderAllPages();
        }
    }).catch(err => {
        console.error('Error loading PDF:', err);
        container.innerHTML = '<p class="text-center text-danger">Gagal memuat PDF</p>';
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const quantityInput = document.getElementById('quantity');
  const decreaseBtn = document.getElementById('decreaseQty');
  const increaseBtn = document.getElementById('increaseQty');
  const addToCartBtn = document.getElementById('add-to-cart-btn');
  const buyNowBtn = document.getElementById('buy-now-btn');

  decreaseBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });

  increaseBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
  });

  // Add to Cart Function
  function addToCart(type = 'digital') {
    @guest
        Swal.fire({
            title: 'Akses Terbatas',
            text: 'Anda harus login terlebih dahulu untuk menambahkan buku ke keranjang.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5d87ff',
            cancelButtonColor: '#fa896b',
            confirmButtonText: 'Login Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("login") }}';
            }
        });
        return;
    @endguest

    const bookId = addToCartBtn.getAttribute('data-book-id');
    const quantity = parseInt(quantityInput.value);

    const originalContent = addToCartBtn.innerHTML;
    addToCartBtn.disabled = true;
    addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';

    $.ajax({
      url: '{{ route("cart.add") }}',
      method: 'POST',
      data: {
        book_id: bookId,
        quantity: quantity,
        type: type,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: response.message,
          showConfirmButton: false,
          timer: 1500
        });
        // Update cart count
        updateCartCount();
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menambahkan ke keranjang.'
        });
      },
      complete: function() {
        addToCartBtn.disabled = false;
        addToCartBtn.innerHTML = originalContent;
      }
    });
  }

  // Buy Now Function
  function buyNow(type = 'digital') {
    @guest
        Swal.fire({
            title: 'Akses Terbatas',
            text: 'Anda harus login terlebih dahulu untuk melakukan pembelian buku.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5d87ff',
            cancelButtonColor: '#fa896b',
            confirmButtonText: 'Login Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("login") }}';
            }
        });
        return;
    @endguest

    const bookId = buyNowBtn.getAttribute('data-book-id');
    const quantity = parseInt(quantityInput.value);

    const originalContent = buyNowBtn.innerHTML;
    buyNowBtn.disabled = true;
    buyNowBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';

    // Get price based on type
    let price = 0;
    if (type === 'digital') {
      price = {{ $book->price_digital }};
    } else {
      price = {{ $book->price_physical }};
    }

    // Process checkout directly
    $.ajax({
      url: '{{ route("checkout.process") }}',
      method: 'POST',
      data: {
        items: [{
          book_id: bookId,
          quantity: quantity,
          type: type,
          price: price
        }],
        total_price: price * quantity,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        if (response.success) {
          window.location.href = response.redirect_url;
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: response.message || 'Terjadi kesalahan saat memproses checkout.'
          });
          buyNowBtn.disabled = false;
          buyNowBtn.innerHTML = originalContent;
        }
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses checkout.'
        });
        buyNowBtn.disabled = false;
        buyNowBtn.innerHTML = originalContent;
      }
    });
  }

  addToCartBtn.addEventListener('click', function() {
    const isEbook = document.getElementById('ebook').checked;
    const type = isEbook ? 'digital' : 'physical';
    addToCart(type);
  });

  buyNowBtn.addEventListener('click', function() {
    const isEbook = document.getElementById('ebook').checked;
    const type = isEbook ? 'digital' : 'physical';
    buyNow(type);
  });

  // Handle related products add to cart
  $(document).on('click', '.add-to-cart-btn:not(#add-to-cart-btn)', function(e) {
    e.preventDefault();

    @guest
        Swal.fire({
            title: 'Akses Terbatas',
            text: 'Anda harus login terlebih dahulu untuk menambahkan buku ke keranjang.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5d87ff',
            cancelButtonColor: '#fa896b',
            confirmButtonText: 'Login Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("login") }}';
            }
        });
        return;
    @endguest

    let button = $(this);
    let bookId = button.data('book-id');
    let originalText = button.html();

    button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

    $.ajax({
        url: '{{ route('cart.add') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            book_id: bookId,
            type: 'digital' // Default to digital for quick add
        },
        success: function(response) {
            button.html('<i class="ti ti-check"></i>').removeClass('btn-outline-primary').addClass('btn-success');
            updateCartCount();
            setTimeout(function() {
                button.prop('disabled', false).html(originalText).removeClass('btn-success').addClass('btn-outline-primary');
            }, 2000);
        },
        error: function(xhr) {
            button.html('<i class="ti ti-x"></i>').removeClass('btn-outline-primary').addClass('btn-danger');
            setTimeout(function() {
                button.prop('disabled', false).html(originalText).removeClass('btn-danger').addClass('btn-outline-primary');
            }, 2000);
        }
    });
  });
});
</script>
@endpush
