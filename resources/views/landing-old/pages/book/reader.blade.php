@extends('landing.layouts.app')

@push('css')
    <style>
#pdf-container {
    background: #525659;
}

.pdf-page-canvas {
    background: white;
}
</style>
@endpush

@section('content')
<div class="main-wrapper overflow-hidden py-3" style="min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $book->title }}</h4>
                            <p class="mb-0 text-muted">
                                <i class="ti ti-book me-1"></i>{{ $book->category->name }}
                                <span class="mx-2">•</span>
                                <i class="ti ti-calendar me-1"></i>{{ $book->created_at->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('member') }}" class="btn btn-outline-primary">
                                <i class="ti ti-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center mb-4">
                                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('assets/dashboard/images/products/product-1.jpg') }}"
                                         alt="{{ $book->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 300px; width: 100%; object-fit: cover;">
                                </div>

                                <div class="card border-0 shadow-sm rounded-4 mb-4">
                                    <div class="card-body p-0">
                                        <div class="p-3 border-bottom">
                                            <h6 class="fw-bolder mb-0 text-dark d-flex align-items-center">
                                                <i class="ti ti-info-circle me-2 text-primary"></i> Informasi Buku
                                            </h6>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0 align-middle">
                                                <tbody>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3" style="width: 40%;">Editor</td>
                                                        <td class="fs-1 pe-3">{{ $book->bookEditors?->user?->full_name || $book->editor || '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">ISBN</td>
                                                        <td class="fs-1 pe-3">{{ $book->code_isbn ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Bahasa</td>
                                                        <td class="fs-1 pe-3">{{ $book->language ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Tahun</td>
                                                        <td class="fs-1 pe-3">{{ $book->year_published ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Penerbit</td>
                                                        <td class="fs-1 pe-3">{{ $book->publisher ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Website</td>
                                                        <td class="fs-1 pe-3 text-truncate">
                                                            @if($book->website)
                                                                <a href="{{ $book->website }}" target="_blank" class="text-primary text-decoration-underline">{{ $book->website }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Berat Buku</td>
                                                        <td class="fs-1 pe-3">{{ number_format($book->weight ?? 0, 0, ',', '.') }} Gram</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold fs-1 ps-3">Halaman</td>
                                                        <td class="fs-1 pe-3">{{ number_format($book->pages ?? 0, 0, ',', '.') }} Halaman</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="reader-container">
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

                                    @if($book->modules->where('is_active', true)->count() > 0)
                                        <div class="mt-4">
                                            <h6 class="fw-bold mb-3">Daftar Bab</h6>
                                            <div class="list-group">
                                                @foreach($book->modules->where('is_active', true)->sortBy('chapter') as $module)
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">BAB {{ $module->chapter }}: {{ $module->title }}</h6>
                                                            <small class="text-muted">{{ $module->description }}</small>
                                                        </div>
                                                        {{-- @if($module->file_path)
                                                            <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="ti ti-download me-1"></i>Download
                                                            </a>
                                                        @endif --}}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reader-content {
    max-height: 600px;
    overflow-y: auto;
    transition: font-size 0.3s ease;
}

.reader-content h1, .reader-content h2, .reader-content h3, .reader-content h4, .reader-content h5, .reader-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.reader-content p {
    margin-bottom: 1rem;
    text-align: justify;
}

.reader-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}
</style>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof pdfjsLib === 'undefined') return;

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const url = '{{ $book->full_content ? asset("storage/" . $book->full_content) : "" }}';
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

        renderAllPages();
    }).catch(err => {
        console.error('Error loading PDF:', err);
        container.innerHTML = '<p class="text-center text-danger">Gagal memuat PDF</p>';
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const content = document.getElementById('book-content');
    const fontDecrease = document.getElementById('font-decrease');
    const fontReset = document.getElementById('font-reset');
    const fontIncrease = document.getElementById('font-increase');

    let currentFontSize = 16;

    fontDecrease.addEventListener('click', function() {
        if (currentFontSize > 12) {
            currentFontSize -= 2;
            content.style.fontSize = currentFontSize + 'px';
        }
    });

    fontReset.addEventListener('click', function() {
        currentFontSize = 16;
        content.style.fontSize = currentFontSize + 'px';
    });

    fontIncrease.addEventListener('click', function() {
        if (currentFontSize < 24) {
            currentFontSize += 2;
            content.style.fontSize = currentFontSize + 'px';
        }
    });
});
</script>
@endpush
