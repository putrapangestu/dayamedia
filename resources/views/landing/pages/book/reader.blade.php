@extends('landing.layouts.app')

@section('title', 'Baca ' . $book->title . ' - Daya Media')

@section('content')
<div class="min-h-screen bg-[#f5f7fb]">
    <style>
        .ebook-reader-shell {
            background:
                linear-gradient(135deg, rgba(238, 18, 140, .08), transparent 28%),
                linear-gradient(315deg, rgba(16, 185, 129, .10), transparent 32%),
                #f5f7fb;
        }
        .ebook-pdf-stage {
            background: radial-gradient(circle at top, #475569 0, #1f2937 46%, #111827 100%);
        }
        .ebook-pdf-stage canvas {
            display: block;
            max-width: 100%;
            height: auto !important;
            margin: 0 auto 24px;
            border-radius: 12px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .32);
            background: #fff;
        }
    </style>

    <div class="ebook-reader-shell border-b border-gray-200">
        <div class="kt-container-fixed py-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <div class="mb-3 flex flex-wrap items-center gap-2 text-xs font-black uppercase tracking-widest text-gray-500">
                        <a href="{{ route('catalog') }}" class="hover:text-primary">Katalog</a>
                        <i class="ki-filled ki-right text-[10px]"></i>
                        <span>Baca E-Book</span>
                    </div>
                    <h1 class="text-2xl font-black leading-tight tracking-tight text-gray-950 lg:text-4xl">{{ $book->title }}</h1>
                    <p class="mt-2 flex flex-wrap items-center gap-2 text-sm font-bold text-gray-500">
                        <span>{{ $book->category?->name ?? 'Tanpa Kategori' }}</span>
                        <span class="text-gray-300">/</span>
                        <span>{{ $book->publisher ?? config('app.name') }}</span>
                        @if($book->year_published)
                            <span class="text-gray-300">/</span>
                            <span>{{ $book->year_published }}</span>
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('bookDetail', $book->slug) }}" class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 bg-white px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-700 shadow-sm transition hover:border-primary hover:text-primary">
                        <i class="ki-filled ki-left"></i> Detail Buku
                    </a>
                    <a href="{{ route('member') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gray-950 px-5 py-3 text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-gray-900/10 transition hover:bg-black">
                        <i class="ki-filled ki-user"></i> Akun Saya
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed py-8">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
            <aside class="space-y-5 xl:sticky xl:top-[90px] xl:self-start">
                <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm">
                    <div class="aspect-[3/4] bg-gray-100">
                        <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('assets/dashboard/images/products/product-1.jpg') }}"
                             alt="{{ $book->title }}"
                             class="h-full w-full object-cover">
                    </div>
                    <div class="p-5">
                        <h2 class="line-clamp-2 text-lg font-black text-gray-950">{{ $book->title }}</h2>
                        <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                            <div class="rounded-2xl bg-gray-50 p-3">
                                <p class="font-black uppercase tracking-widest text-gray-400">ISBN</p>
                                <p class="mt-1 font-bold text-gray-800">{{ $book->code_isbn ?? '-' }}</p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-3">
                                <p class="font-black uppercase tracking-widest text-gray-400">Halaman</p>
                                <p class="mt-1 font-bold text-gray-800">{{ number_format($book->pages ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($activeModules->count() > 0)
                    <div class="rounded-[2rem] border border-gray-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-4 text-xs font-black uppercase tracking-[0.22em] text-gray-400">Daftar Bab</h3>
                        <div class="space-y-2">
                            @foreach($activeModules as $module)
                                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-primary">BAB {{ $module->chapter }}</p>
                                    <p class="mt-1 text-sm font-black text-gray-900">{{ $module->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

            <section class="min-w-0 overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-xl shadow-gray-200/60">
                <div class="sticky top-[70px] z-10 flex flex-col gap-3 border-b border-gray-100 bg-white/95 p-4 backdrop-blur md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.24em] text-gray-400">Mode Baca</p>
                        <p id="reader-status" class="mt-1 text-sm font-bold text-gray-700">Menyiapkan dokumen...</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button id="zoom-out" type="button" class="size-10 rounded-xl border border-gray-200 bg-white text-gray-700 transition hover:bg-gray-50" title="Zoom Out">
                            <i class="ki-filled ki-minus"></i>
                        </button>
                        <span id="zoom-percent" class="min-w-20 rounded-xl bg-primary/10 px-4 py-2 text-center text-xs font-black text-primary">120%</span>
                        <button id="zoom-in" type="button" class="size-10 rounded-xl border border-gray-200 bg-white text-gray-700 transition hover:bg-gray-50" title="Zoom In">
                            <i class="ki-filled ki-plus"></i>
                        </button>
                        <button id="reset-zoom" type="button" class="rounded-xl bg-gray-950 px-4 py-2 text-xs font-black uppercase tracking-widest text-white transition hover:bg-black">Reset</button>
                    </div>
                </div>

                <div id="pdf-container" class="ebook-pdf-stage max-h-[calc(100vh-170px)] min-h-[620px] overflow-y-auto p-4 sm:p-8">
                    <div id="pdf-loading" class="flex min-h-[520px] flex-col items-center justify-center text-center text-white/80">
                        <div class="mb-5 size-14 animate-spin rounded-full border-4 border-white/20 border-t-white"></div>
                        <p class="text-sm font-black uppercase tracking-widest">Memuat E-Book</p>
                    </div>
                    <div id="pdf-pages-container" class="mx-auto max-w-full"></div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const url = '{{ $book->full_content ? asset("storage/" . $book->full_content) : "" }}';
    const pageContainer = document.getElementById('pdf-pages-container');
    const loading = document.getElementById('pdf-loading');
    const status = document.getElementById('reader-status');
    const zoomLabel = document.getElementById('zoom-percent');

    if (!url) {
        loading.innerHTML = '<p class="text-sm font-black uppercase tracking-widest">File e-book belum tersedia.</p>';
        status.textContent = 'File e-book belum tersedia.';
        return;
    }

    if (typeof pdfjsLib === 'undefined') {
        loading.innerHTML = '<p class="text-sm font-black uppercase tracking-widest">PDF viewer gagal dimuat.</p>';
        status.textContent = 'PDF viewer gagal dimuat.';
        return;
    }

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc = null;
    let currentScale = 1.2;
    let renderToken = 0;

    function setZoomLabel() {
        zoomLabel.textContent = Math.round(currentScale * 100) + '%';
    }

    function renderAllPages() {
        if (!pdfDoc) return;
        const token = ++renderToken;
        setZoomLabel();
        status.textContent = pdfDoc.numPages + ' halaman / zoom ' + Math.round(currentScale * 100) + '%';
        pageContainer.innerHTML = '';

        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            const canvas = document.createElement('canvas');
            canvas.setAttribute('aria-label', 'Halaman ' + pageNum);
            pageContainer.appendChild(canvas);

            pdfDoc.getPage(pageNum).then(function(page) {
                if (token !== renderToken) return;
                const viewport = page.getViewport({ scale: currentScale });
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                page.render({ canvasContext: context, viewport: viewport });
            });
        }
    }

    document.getElementById('zoom-in').addEventListener('click', function() {
        if (currentScale >= 2.5) return;
        currentScale += 0.2;
        renderAllPages();
    });

    document.getElementById('zoom-out').addEventListener('click', function() {
        if (currentScale <= 0.6) return;
        currentScale -= 0.2;
        renderAllPages();
    });

    document.getElementById('reset-zoom').addEventListener('click', function() {
        currentScale = 1.2;
        renderAllPages();
    });

    setZoomLabel();
    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        pdfDoc = pdf;
        loading.remove();
        renderAllPages();
    }).catch(function() {
        loading.innerHTML = '<p class="text-sm font-black uppercase tracking-widest">Gagal memuat file PDF.</p>';
        status.textContent = 'Gagal memuat file PDF.';
    });
});
</script>
@endpush
