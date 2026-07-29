@extends('landing.layouts.app')

@if(app()->environment('production'))
@push('meta')
@php
    // URL Halaman Landing Page Saat Ini
    $currentUrl = url()->current();
    // Pembersihan Teks HTML & Whitespace
    $rawDescription = trim(preg_replace('/\s+/', ' ', strip_tags($book->description ?? '')));
    // Abstrak Panjang (Maks 500 karakter, diakhiri kalimat utuh)
    $abstract = \Illuminate\Support\Str::limit($rawDescription, 500);
    if (str_ends_with($abstract, '...')) {
        $trimmed = substr($abstract, 0, -3);
        $lastPeriod = strrpos($trimmed, '.');
        if ($lastPeriod !== false && $lastPeriod > 200) {
            $abstract = substr($trimmed, 0, $lastPeriod + 1);
        } else {
            $abstract = preg_replace('/[^\w]+$/u', '', $trimmed) . '.';
        }
    }
    // Deskripsi Ringkas Meta / OG (Maks 180 karakter, diakhiri kalimat utuh)
    $cleanDescription = \Illuminate\Support\Str::limit($rawDescription, 180);
    if (str_ends_with($cleanDescription, '...')) {
        $trimmed = substr($cleanDescription, 0, -3);
        $lastPeriod = strrpos($trimmed, '.');
        if ($lastPeriod !== false && $lastPeriod > 80) {
            $cleanDescription = substr($trimmed, 0, $lastPeriod + 1);
        } else {
            $cleanDescription = preg_replace('/[^\w]+$/u', '', $trimmed) . '.';
        }
    }
    $editorName = $book->editor && $book->editor !== '-' ? $book->editor : ($book->bookEditors?->user?->full_name ?? null);
    $publisherName = $book->publisher ?: config('app.name', 'Penerbit Azzia');
    $isoLanguage = 'id';
    $ogImage = $book->cover ? asset('storage/' . $book->cover) : asset('assets/azzia-logo.png');

    $authorsArr = [];
    if (isset($authors) && count($authors) > 0) {
        $authorsArr = $authors;
    } elseif ($book->authors && $book->authors->count() > 0) {
        foreach ($book->authors as $author) {
            $name = $author->user->full_name ?? $author->author;
            if (!empty($name)) {
                $authorsArr[] = ['name' => $name];
            }
        }
    }
@endphp

<!-- 1. Title & Standard Meta Tags -->
<title>{{ $book->title }} - {{ $publisherName }}</title>
<meta name="robots" content="index, follow">
<meta name="description" content="{{ $cleanDescription }}">
<link rel="canonical" href="{{ $currentUrl }}">

<!-- 2. Google Scholar / Citation Metadata (Optimized for BOOK indexing to HTML) -->
<meta name="citation_title" content="{{ $book->title }}">
@if(count($authorsArr) > 0)
    @foreach($authorsArr as $author)
        @if(!empty($author['name']))
            <meta name="citation_author" content="{{ $author['name'] }}">
        @endif
    @endforeach
@endif
@if($editorName)
    <meta name="citation_editor" content="{{ $editorName }}">
@endif
<meta name="citation_publisher" content="{{ $publisherName }}">
@if($book->year_published)
    <meta name="citation_publication_date" content="{{ $book->year_published }}">
@endif
@if($book->code_isbn)
    <meta name="citation_isbn" content="{{ $book->code_isbn }}">
@endif
<meta name="citation_language" content="{{ $isoLanguage }}">
@if(!empty($abstract))
    <meta name="citation_abstract" content="{{ $abstract }}">
@endif
<!-- URL Pengarah Google Scholar ke Halaman HTML Full-Text/Landing Page -->
<meta name="citation_abstract_html_url" content="{{ $currentUrl }}">
<meta name="citation_fulltext_html_url" content="{{ $currentUrl }}">

<!-- 3. Dublin Core Metadata -->
<meta name="DC.title" content="{{ $book->title }}">
@if(count($authorsArr) > 0)
    @foreach($authorsArr as $author)
        @if(!empty($author['name']))
            <meta name="DC.creator" content="{{ $author['name'] }}">
        @endif
    @endforeach
@endif
@if($editorName)
    <meta name="DC.contributor" content="{{ $editorName }}">
@endif
<meta name="DC.publisher" content="{{ $publisherName }}">
@if($book->year_published)
    <meta name="DC.date" content="{{ $book->year_published }}">
@endif
@if($book->code_isbn)
    <meta name="DC.identifier" content="ISBN:{{ $book->code_isbn }}">
@endif
<meta name="DC.language" content="{{ $isoLanguage }}">

<!-- 4. Open Graph / Social Media -->
<meta property="og:title" content="{{ $book->title }}">
<meta property="og:description" content="{{ $cleanDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:type" content="book">
<meta property="og:site_name" content="{{ $publisherName }}">
@if(count($authorsArr) > 0)
    @foreach($authorsArr as $author)
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

<!-- 5. Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $book->title }}">
<meta name="twitter:description" content="{{ $cleanDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- 6. Structured Data Schema.org JSON-LD -->
@php
    $authorList = [];
    foreach ($authorsArr as $a) {
        if (!empty($a['name'])) {
            $authorList[] = ['@type' => 'Person', 'name' => $a['name']];
        }
    }
    $bookSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Book',
        'name' => $book->title,
        'author' => $authorList,
        'editor' => $editorName ? ['@type' => 'Person', 'name' => $editorName] : null,
        'isbn' => $book->code_isbn ?: null,
        'datePublished' => (string)($book->year_published ?: null),
        'publisher' => $publisherName,
        'inLanguage' => $isoLanguage,
        'image' => $ogImage,
        'url' => $currentUrl,
        'description' => $cleanDescription ?: null,
    ];
    $bookSchema = array_filter($bookSchema, function ($v) { return $v !== null; });
@endphp
<script type="application/ld+json">{!! json_encode($bookSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif

@push('css')
@include('components.timeline-style')
    <style>
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

        .category-badge {
            background: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }

        .module-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef !important;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
            border-color: var(--bs-primary) !important;
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
                        <div class="mb-3">
                            <span class="category-badge mb-3">
                                <i class="ti ti-category-2 me-1"></i>{{ $book->category?->name }}
                            </span>
                            <h2 class="fw-bolder text-dark mb-1">{{ $book->title }}</h2>
                            <p class="text-muted fs-3 mb-0">ISBN: <span class="fw-semibold">{{ $book->code_isbn ?? "-" }}</span></p>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="bg-light fw-bolder text-dark" style="width: 30%;"><i class="ti ti-edit me-2 text-primary"></i>Penulis</td>
                                        <td class="text-dark">
                                            {{ $book->authors->take(3)->map(function($author) { return $author->user->full_name ?? $author->author; })->implode(', ') ?: '-' }}
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
                    </div>
                </div>
              </div>
            </div>
            <div class="card shadow-none border">
              <div class="card-body p-4">
                <h4 class="mb-4 fw-semibold">Timeline Penulisan</h4>
                <div class="timeline-horizontal">
                <!-- Step 1 -->
                <div class="timeline-item
                        @if ($countAuthors == $countActiveModules)
                            done
                        @else
                            active
                        @endif
                ">
                    <div class="timeline-circle">
                    <i class="ti ti-users"></i>
                    </div>
                    <div class="timeline-text">
                    <strong>Kolaborasi</strong>
                    <span>{{ $countAuthors }} / {{ $countActiveModules }}</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-item
                    @if ($book->status == 'published')
                        done
                    @elseif ($countActiveModules != $countAuthorUploads &&
                        $book->status == 'editing')
                        active
                    @elseif ($countActiveModules == $countAuthorUploads &&
                        $book->status == 'editing' || $book->status == 'published')
                        done
                    @else
                        disabled
                    @endif
                ">
                    <div class="timeline-circle">
                    <i class="ti ti-upload"></i>
                    </div>
                    <div class="timeline-text">
                    <strong>Upload Naskah</strong>
                    <span>{{ $countAuthorUploads }} / {{ $countActiveModules }}</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-item
                    @if ($book->status == 'published')
                        done
                    @elseif ($countActiveModules == $countAuthorUploads &&
                        $book->status == 'editing' && !$checkEditing)
                        active
                    @elseif (($book->status == 'published' || $checkEditing) && $countActiveModules == $countAuthorUploads)
                        done
                    @else
                        disabled
                    @endif
                ">
                    <div class="timeline-circle">
                    <i class="ti ti-edit"></i>
                    </div>
                    <div class="timeline-text">
                    <strong>Editing Naskah<br>Oleh Editor</strong>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="timeline-item
                    @if ($book->status == 'published')
                        done
                    @elseif ($book->status == 'editing' && $checkEditing && $countActiveModules == $countAuthorUploads)
                        active
                    @else
                        disabled
                    @endif
                ">
                    <div class="timeline-circle">
                    <i class="ti ti-file-text"></i>
                    </div>
                    <div class="timeline-text">
                    <strong>Input ISBN</strong>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="timeline-item
                    @if ($book->status == 'published')
                        done
                    @else
                        disabled
                    @endif
                ">
                    <div class="timeline-circle">
                    <i class="ti ti-book"></i>
                    </div>
                    <div class="timeline-text">
                    <strong>Buku Publish</strong>
                    </div>
                </div>
              </div>
              </div>
            </div>
            <div class="row g-4">
                @forelse ($book->modules as $module)
                    <div class="col-md-6 col-lg-4">
                        <div class="card module-card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="bg-primary-subtle rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="ti ti-book-2 fs-7 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-primary-subtle text-primary fw-bold">BAB {{ $module->chapter }}</span>
                                        </div>
                                        <h6 class="fw-bolder mb-0 text-dark lh-base text-truncate-2" style="min-height: 2.8em;">{{ $module->title }}</h6>
                                    </div>
                                </div>

                                @php
                                    $isBookPurchased = $module->transactionDetails->filter(function ($transactionDetail) {
                                        return $transactionDetail->transaction->status == 'paid' || $transactionDetail->transaction->status == 'pending';
                                    })->count() > 0;
                                @endphp

                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="ti ti-user fs-4 text-muted"></i>
                                        <span class="text-muted fs-2">
                                            @if($module->user_id || $isBookPurchased)
                                                {{ $module->user != null  ? 'Penulis: ' . $module->user->full_name
                                                : ($isBookPurchased ? 'Sudah Terisi' : 'Posisi Tersedia') }}
                                            @else
                                                Posisi Tersedia
                                            @endif
                                        </span>
                                    </div>
                                    <h4 class="fw-bolder text-primary mb-0">
                                        Rp {{ number_format($module->price, 0, ',', '.') }}
                                    </h4>
                                </div>

                                @if( $module->user_id || $isBookPurchased )
                                    <button class="btn btn-light w-100 rounded-pill fw-bold py-2 shadow-none" disabled>
                                        <i class="ti ti-lock me-1"></i> Sudah Terisi
                                    </button>
                                @else
                                    <button class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm checkout-btn"
                                        data-module-id="{{ $module->id }}"
                                        data-price="{{ $module->price }}"
                                        data-title="{{ $module->title }}">
                                        <i class="ti ti-plus me-1"></i> Ambil Bagian Ini
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="ti ti-book-off fs-10 text-muted mb-3 d-block"></i>
                            <p class="text-muted fs-4">Belum ada modul yang tersedia untuk buku ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="related-products pt-7">
              <h4 class="mb-3 fw-semibold">Related Products</h4>
              <div class="row">
                <div class="col-12">
                    <p class="text-center">No related products found.</p>
                    </div>
              </div>
            </div>
          </div>
        </div>
</div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.checkout-btn').on('click', function(e) {
            e.preventDefault();

            @guest
                Swal.fire({
                    title: 'Akses Terbatas',
                    text: 'Anda harus login terlebih dahulu untuk mengambil bagian kolaborasi ini.',
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

            const checkoutBtn = $(this);
            if (checkoutBtn.hasClass('disabled')) {
                return;
            }

            const moduleId = checkoutBtn.data('module-id');
            const price = checkoutBtn.data('price');
            const title = checkoutBtn.data('title');

            const originalBtnText = checkoutBtn.html();
            checkoutBtn.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...'
            ).addClass('disabled');

            const items = [];
            const total_price = price;
            items.push({
                module_id: moduleId,
                price: price,
                quantity: 1,
                title: title,
                type: 'module',
            });

            $.ajax({
                url: '{{ route("checkout.process") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    total_price: total_price,
                    items: items,
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message || 'Terjadi kesalahan.');
                        checkoutBtn.html(originalBtnText).removeClass('disabled');
                    }
                },
                error: function(xhr) {
                    alert('Gagal memproses checkout. Silakan coba lagi.');
                    console.error(xhr.responseText);
                    checkoutBtn.html(originalBtnText).removeClass('disabled');
                }
            });
        });
    });
</script>
@endpush
