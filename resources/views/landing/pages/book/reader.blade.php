@extends('landing.layouts.app')

@section('title', 'Baca ' . $book->title . ' - Daya Media')

@push('meta')
<meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<style>
    /* Sembunyikan header & footer bawaan layout */
    body > div.flex.grow.flex-col > [role="content"] > #contentContainer,
    body > div.flex.grow.flex-col > div.kt-container-fixed,
    body [role="content"] > div.kt-container-fixed,
    body .kt-container-fixed:first-of-type {
        display: none !important;
    }
    body > div.flex.grow.flex-col > header,
    body header#header,
    body .kt-header,
    body [data-kt-header],
    body .footer,
    body footer {
        display: none !important;
    }

    /* Full screen reader */
    .ebook-reader-full {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        background: #111827;
        overflow: hidden;
    }

    /* Toolbar minimal */
    .reader-toolbar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 16px;
        background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 70%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .ebook-reader-full:hover .reader-toolbar,
    .reader-toolbar:focus-within {
        opacity: 1;
    }
    .reader-toolbar button,
    .reader-toolbar a {
        color: rgba(255,255,255,0.8);
        background: rgba(255,255,255,0.1);
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(4px);
    }
    .reader-toolbar button:hover,
    .reader-toolbar a:hover {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }
    .reader-toolbar .zoom-group {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .reader-toolbar .zoom-group span {
        min-width: 60px;
        text-align: center;
        color: rgba(255,255,255,0.9);
        font-size: 13px;
        font-weight: 700;
    }

    /* PDF container full */
    .pdf-viewport {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    .pdf-viewport::-webkit-scrollbar {
        width: 6px;
    }
    .pdf-viewport::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05);
    }
    .pdf-viewport::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
    }
    .pdf-viewport::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.35);
    }

    .pdf-viewport canvas {
        display: block;
        max-width: 100%;
        height: auto !important;
        margin: 0 auto 16px;
        border-radius: 4px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        background: #fff;
    }

    .pdf-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100%;
        color: rgba(255,255,255,0.6);
        gap: 16px;
    }
    .pdf-loading .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255,255,255,0.15);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .pdf-loading p {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
    }

    /* Anti-select & anti-context menu */
    .pdf-viewport {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    .pdf-viewport canvas {
        pointer-events: none;
        -webkit-touch-callout: none;
    }

    /* Responsive: di HP toolbar lebih kecil */
    @media (max-width: 640px) {
        .reader-toolbar {
            padding: 6px 10px;
        }
        .reader-toolbar button,
        .reader-toolbar a {
            padding: 4px 8px;
            font-size: 10px;
        }
        .reader-toolbar .zoom-group span {
            min-width: 44px;
            font-size: 11px;
        }
    }
</style>

<div class="ebook-reader-full" id="ebookReader">
    {{-- Toolbar minimal --}}
    <div class="reader-toolbar" id="readerToolbar">
        <div class="flex items-center gap-2">
            <a href="{{ route('bookDetail', $book->slug) }}" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
                Keluar
            </a>
        </div>
        <div class="zoom-group">
            <button id="zoom-out" title="Perkecil">−</button>
            <span id="zoom-percent">120%</span>
            <button id="zoom-in" title="Perbesar">+</button>
            <button id="reset-zoom" style="background:rgba(255,255,255,0.2);padding:4px 10px;">Reset</button>
        </div>
    </div>

    {{-- PDF viewport full --}}
    <div class="pdf-viewport" id="pdfViewport">
        <div class="pdf-loading" id="pdfLoading">
            <div class="spinner"></div>
            <p>Memuat E-Book</p>
        </div>
        <div id="pdfPagesContainer" class="mx-auto" style="max-width:100%;padding:16px 8px;"></div>
    </div>
</div>
@endsection

@push('js')
<script>
(function() {
    'use strict';

    // ─── Proteksi: disable context menu ───
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });

    // ─── Proteksi: disable devtools shortcuts ───
    document.addEventListener('keydown', function(e) {
        // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        if (e.key === 'F12' ||
            (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
            (e.ctrlKey && e.key === 'U')) {
            e.preventDefault();
            return false;
        }
    });

    // ─── Proteksi: deteksi DevTools via window size ───
    (function detectDevTools() {
        const threshold = 160;
        function check() {
            const w = window.outerWidth - window.innerWidth;
            const h = window.outerHeight - window.innerHeight;
            if (w > threshold || h > threshold) {
                document.body.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100vh;background:#111;color:#fff;font-family:sans-serif;text-align:center;padding:20px;"><div><h1 style="font-size:24px;margin-bottom:12px;">Akses Dibatasi</h1><p style="color:#999;">Alat pengembang terdeteksi. Silahkan tutup DevTools dan muat ulang halaman.</p></div></div>';
            }
        }
        setInterval(check, 1000);
    })();

    // ─── Proteksi: cegah drag & drop ───
    document.addEventListener('dragstart', function(e) { e.preventDefault(); });
    document.addEventListener('drop', function(e) { e.preventDefault(); });

    // ─── Inisialisasi PDF.js ───
    var script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
    script.onload = function() {
        initReader();
    };
    script.onerror = function() {
        document.getElementById('pdfLoading').innerHTML = '<p>Gagal memuat PDF viewer.</p>';
    };
    document.head.appendChild(script);

    function initReader() {
        var pdfjsLib = window.pdfjsLib;
        if (!pdfjsLib) {
            document.getElementById('pdfLoading').innerHTML = '<p>PDF viewer gagal dimuat.</p>';
            return;
        }

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        var url = '{{ $book->full_content ? route("book.file", [$book->slug, "full"]) . "?token=" . $readToken : "" }}';
        var container = document.getElementById('pdfPagesContainer');
        var loading = document.getElementById('pdfLoading');
        var zoomLabel = document.getElementById('zoom-percent');

        if (!url) {
            loading.innerHTML = '<p>File e-book belum tersedia.</p>';
            return;
        }

        var pdfDoc = null;
        var currentScale = 1.2;
        var renderToken = 0;

        function setZoomLabel() {
            zoomLabel.textContent = Math.round(currentScale * 100) + '%';
        }

        function renderAllPages() {
            if (!pdfDoc) return;
            var token = ++renderToken;
            setZoomLabel();
            container.innerHTML = '';

            for (var i = 1; i <= pdfDoc.numPages; i++) {
                (function(pageNum) {
                    var canvas = document.createElement('canvas');
                    container.appendChild(canvas);

                    pdfDoc.getPage(pageNum).then(function(page) {
                        if (token !== renderToken) return;
                        var viewport = page.getViewport({ scale: currentScale });
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport: viewport
                        });
                    });
                })(i);
            }
        }

        document.getElementById('zoom-in').addEventListener('click', function() {
            if (currentScale >= 2.5) return;
            currentScale = Math.round((currentScale + 0.2) * 100) / 100;
            renderAllPages();
        });

        document.getElementById('zoom-out').addEventListener('click', function() {
            if (currentScale <= 0.6) return;
            currentScale = Math.round((currentScale - 0.2) * 100) / 100;
            renderAllPages();
        });

        document.getElementById('reset-zoom').addEventListener('click', function() {
            currentScale = 1.2;
            renderAllPages();
        });

        setZoomLabel();
        pdfjsLib.getDocument({
            url: url,
            withCredentials: true
        }).promise.then(function(pdf) {
            pdfDoc = pdf;
            loading.remove();
            renderAllPages();
        }).catch(function() {
            loading.innerHTML = '<p>Gagal memuat file PDF.</p>';
        });
    }
})();
</script>
@endpush
