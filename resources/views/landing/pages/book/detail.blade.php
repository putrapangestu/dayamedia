@extends('landing.layouts.app')

@section('content')
<div class="kt-container-fixed py-6">
    <div class="flex flex-col gap-6">

        {{-- ===== BREADCRUMB ===== --}}
        <div class="flex items-center gap-1.5 text-sm">
            <a href="#" class="text-secondary-foreground hover:text-primary transition-colors">Beranda</a>
            <span class="text-muted-foreground">/</span>
            <a href="#" class="text-secondary-foreground hover:text-primary transition-colors">Katalog</a>
            <span class="text-muted-foreground">/</span>
            <span class="text-mono font-medium truncate max-w-[200px]">Pengantar Ilmu Komputer Modern</span>
        </div>

        {{-- ===== DETAIL UTAMA ===== --}}
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ===== KOLOM KIRI: Gambar ===== --}}
            <div class="w-full lg:w-[200px] shrink-0 mx-auto lg:mx-0 max-w-[200px]">
                <div class="kt-card overflow-hidden border border-border shadow-none">
                    <img
                        src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg"
                        alt="Cover Buku"
                        class="w-full object-cover block"
                        style="aspect-ratio: 3 / 4;"
                    />
                </div>
                <div class="flex flex-wrap gap-1.5 mt-3">
                    <span class="kt-badge kt-badge-success kt-badge-outline rounded-full text-xs">Tersedia</span>
                    <span class="kt-badge kt-badge-info kt-badge-outline rounded-full text-xs">E-Book</span>
                    <span class="kt-badge kt-badge-warning kt-badge-outline rounded-full text-xs">Cetak</span>
                </div>
            </div>

            {{-- ===== KOLOM TENGAH: Info Buku ===== --}}
            <div class="flex flex-col gap-4 flex-1 min-w-0">

                {{-- Judul --}}
                <div>
                    <h1 class="text-lg lg:text-2xl font-semibold text-mono leading-snug">
                        Pengantar Ilmu Komputer Modern: Teori, Praktik, dan Penerapannya
                    </h1>
                    <p class="text-xs text-muted-foreground mt-1">
                        ISBN: <span class="font-medium text-secondary-foreground">978-602-1234-56-7</span>
                    </p>
                </div>

                {{-- Informasi Buku --}}
                <div class="kt-card border border-border overflow-hidden">
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b border-border bg-accent/30">
                        <i class="ki-filled ki-information-2 text-primary text-sm"></i>
                        <span class="text-xs font-semibold text-mono uppercase tracking-wider">Informasi Buku</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2">
                        @php
                        $info = [
                            ['icon' => 'ki-filled ki-user-edit',    'label' => 'Penulis',       'value' => 'Budi Santoso, Rina Marlina, Ahmad Fauzi', 'type' => 'text'],
                            ['icon' => 'ki-filled ki-pencil',       'label' => 'Editor',        'value' => 'Dr. Hendra Wijaya, M.Kom',                'type' => 'text'],
                            ['icon' => 'ki-filled ki-barcode',      'label' => 'ISBN',          'value' => '978-602-1234-56-7',                       'type' => 'text'],
                            ['icon' => 'ki-filled ki-category',     'label' => 'Bahasa',        'value' => 'Indonesia',                               'type' => 'text'],
                            ['icon' => 'ki-filled ki-calendar',     'label' => 'Tahun Terbit',  'value' => '2024',                                    'type' => 'text'],
                            ['icon' => 'ki-filled ki-home-3',       'label' => 'Penerbit',      'value' => 'Penerbit Azzia',                          'type' => 'text'],
                            ['icon' => 'ki-filled ki-globe',        'label' => 'Website',       'value' => 'azzia.id/buku',                           'type' => 'link', 'href' => 'https://azzia.id'],
                            ['icon' => 'ki-filled ki-package',      'label' => 'Berat',         'value' => '450 gram',                                'type' => 'text'],
                            ['icon' => 'ki-filled ki-book-open',    'label' => 'Halaman',       'value' => '384 halaman',                             'type' => 'text'],
                            ['icon' => 'ki-filled ki-tag',          'label' => 'Kata Kunci',    'value' => 'komputer, pemrograman, algoritma',        'type' => 'text'],
                            ['icon' => 'ki-filled ki-search-list',  'label' => 'Google Scholar','value' => 'Lihat di Google Scholar',                 'type' => 'link', 'href' => 'https://scholar.google.com'],
                        ];
                        $total = count($info);
                        @endphp

                        @foreach($info as $i => $item)
                        <div class="flex items-start gap-3 px-4 py-2.5 border-b border-border/40
                            {{ ($i === $total - 1 && $total % 2 !== 0) ? 'sm:col-span-2' : '' }}
                            {{ ($i >= $total - ($total % 2 === 0 ? 2 : 1)) ? 'border-b-0' : '' }}
                            hover:bg-accent/20 transition-colors">
                            <div class="w-6 h-6 rounded-md bg-primary/10 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="{{ $item['icon'] }} text-primary" style="font-size:11px;"></i>
                            </div>
                            <div class="flex flex-col gap-0.5 flex-1 min-w-0">
                                <span class="text-[10px] uppercase tracking-wider text-muted-foreground font-medium leading-none">
                                    {{ $item['label'] }}
                                </span>
                                @if($item['type'] === 'link')
                                <a href="{{ $item['href'] }}" target="_blank"
                                    class="text-xs font-medium text-primary hover:underline flex items-center gap-1 mt-0.5">
                                    {{ $item['value'] }}
                                    <i class="ki-filled ki-exit-right-corner text-[10px]"></i>
                                </a>
                                @else
                                <span class="text-xs font-medium text-secondary-foreground mt-0.5 leading-snug">
                                    {{ $item['value'] }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ===== KOLOM KANAN: Harga & Transaksi ===== --}}
            <div class="w-full lg:w-[260px] shrink-0 flex flex-col gap-4">

                {{-- Pilih Edisi --}}
                <div class="kt-card border border-border p-4 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-shop text-primary text-sm"></i>
                        <span class="text-xs font-semibold text-mono uppercase tracking-wider text-muted-foreground">Pilih Edisi</span>
                    </div>
                    <div class="flex flex-col gap-2" id="edisi-group">
                        <label class="cursor-pointer edisi-label" data-value="ebook">
                            <input class="hidden" name="tipe-beli" type="radio" value="ebook" checked />
                            <div class="edisi-box flex items-center justify-between p-3 rounded-lg border border-border
                                transition-all hover:border-primary/50 border-primary bg-primary/5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-info/10 flex items-center justify-center shrink-0">
                                        <i class="ki-filled ki-devices text-info text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-mono leading-none">E-Book</p>
                                        <p class="text-[10px] text-muted-foreground mt-0.5">Akses digital instan</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-mono">Rp45.000</span>
                            </div>
                        </label>

                        <label class="cursor-pointer edisi-label" data-value="cetak">
                            <input class="hidden" name="tipe-beli" type="radio" value="cetak" />
                            <div class="edisi-box flex items-center justify-between p-3 rounded-lg border border-border
                                transition-all hover:border-primary/50">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-warning/10 flex items-center justify-center shrink-0">
                                        <i class="ki-filled ki-book text-warning text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-mono leading-none">Buku Cetak</p>
                                        <p class="text-[10px] text-muted-foreground mt-0.5">Pre-order, dikirim</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-sm font-bold text-mono">Rp120.000</span>
                                    <span class="text-[10px] text-muted-foreground line-through">Rp150.000</span>
                                </div>
                            </div>
                        </label>

                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="kt-card border border-border p-4 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-basket text-primary text-sm"></i>
                        <span class="text-xs font-semibold text-mono uppercase tracking-wider text-muted-foreground">Jumlah</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="kt-btn kt-btn-outline kt-btn-icon kt-btn-sm" id="btn-minus">
                            <i class="ki-filled ki-minus"></i>
                        </button>
                        <input type="number" value="1" min="1"
                            class="kt-input w-14 text-center text-sm font-semibold"
                            id="qty-input" />
                        <button class="kt-btn kt-btn-outline kt-btn-icon kt-btn-sm" id="btn-plus">
                            <i class="ki-filled ki-plus"></i>
                        </button>
                    </div>

                    {{-- Aksi --}}
                    <button class="kt-btn kt-btn-primary w-full">
                        <i class="ki-filled ki-credit-card"></i>
                        Beli Sekarang
                    </button>
                    <div class="flex gap-2">
                        <button class="kt-btn kt-btn-outline flex-1">
                            <i class="ki-filled ki-handcart"></i>
                            Keranjang
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-icon">
                            <i class="ki-filled ki-heart"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        {{-- ===== TAB ABSTRAK & PREVIEW ===== --}}
        <div class="kt-card border border-border overflow-hidden">

            {{-- Tab Header --}}
            <div class="flex border-b border-border">
                <button onclick="openTab(event, 'tab-abstrak')"
                    class="tab-link active flex items-center gap-2 px-5 py-3.5 text-sm font-semibold
                    text-primary border-b-2 border-primary bg-primary/5 transition-all">
                    <i class="ki-filled ki-file-text text-sm"></i>
                    Abstrak / Deskripsi
                </button>
                <button onclick="openTab(event, 'tab-preview')"
                    class="tab-link flex items-center gap-2 px-5 py-3.5 text-sm font-medium
                    text-muted-foreground border-b-2 border-transparent hover:text-secondary-foreground hover:bg-accent/30 transition-all">
                    <i class="ki-filled ki-eye text-sm"></i>
                    Preview Buku
                </button>
            </div>

            {{-- Tab Abstrak --}}
            <div id="tab-abstrak" class="tab-content block">
                <div class="p-5 flex flex-col gap-5">

                    {{-- Deskripsi --}}
                    <div class="flex flex-col gap-3">
                        <p class="text-sm text-secondary-foreground leading-relaxed">
                            Buku ini merupakan panduan komprehensif bagi para pelajar, mahasiswa, dan praktisi yang ingin memahami dasar-dasar ilmu komputer secara modern. Disusun oleh para pakar di bidangnya, buku ini menyajikan teori yang solid disertai contoh-contoh praktis yang relevan dengan kebutuhan industri saat ini.
                        </p>
                        <p class="text-sm text-secondary-foreground leading-relaxed">
                            Pembahasan dimulai dari konsep fundamental seperti algoritma dan struktur data, dilanjutkan dengan topik-topik terkini seperti kecerdasan buatan, komputasi awan, dan keamanan siber.
                        </p>
                        <p class="text-sm text-secondary-foreground leading-relaxed">
                            Dengan bahasa yang lugas dan sistematis, buku ini cocok digunakan sebagai referensi utama maupun pelengkap dalam perkuliahan. Dilengkapi dengan indeks dan glosarium untuk memudahkan pencarian istilah teknis.
                        </p>
                    </div>

                    <div class="border-t border-border"></div>

                    {{-- Stat Cards --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @php
                        $stats = [
                            ['icon' => 'ki-filled ki-book-open',  'value' => '384',       'label' => 'Halaman'],
                            ['icon' => 'ki-filled ki-user',       'value' => '3',         'label' => 'Penulis'],
                            ['icon' => 'ki-filled ki-calendar',   'value' => '2024',      'label' => 'Tahun Terbit'],
                            ['icon' => 'ki-filled ki-category',   'value' => 'Indonesia', 'label' => 'Bahasa'],
                        ];
                        @endphp
                        @foreach($stats as $s)
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-accent/30 border border-border/50">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <i class="{{ $s['icon'] }} text-primary text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-mono leading-none">{{ $s['value'] }}</p>
                                <p class="text-[10px] text-muted-foreground mt-0.5">{{ $s['label'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-border"></div>

                    {{-- Kata Kunci --}}
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-1.5">
                            <i class="ki-filled ki-tag text-muted-foreground text-sm"></i>
                            <span class="text-xs font-semibold text-mono uppercase tracking-wider text-muted-foreground">Kata Kunci</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Ilmu Komputer','Algoritma','Pemrograman','Kecerdasan Buatan','Komputasi Awan','Keamanan Siber'] as $kw)
                            <span class="kt-badge kt-badge-outline rounded-full px-3 py-1 text-xs cursor-pointer
                                hover:bg-primary/5 hover:border-primary hover:text-primary transition-colors">
                                {{ $kw }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tab Preview --}}
            <div id="tab-preview" class="tab-content hidden">
                <div class="p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <i class="ki-filled ki-eye text-muted-foreground text-sm"></i>
                            <span class="text-xs font-semibold text-mono uppercase tracking-wider text-muted-foreground">Preview Halaman</span>
                        </div>
                        <span class="text-xs text-muted-foreground">8 dari 384 halaman</span>
                    </div>

                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
                        @for($i = 1; $i <= 8; $i++)
                        <div class="flex flex-col gap-1.5 group cursor-pointer">
                            <div class="kt-card overflow-hidden border border-border
                                group-hover:border-primary group-hover:shadow-md transition-all shadow-none">
                                <img
                                    src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg"
                                    alt="Hal {{ $i * 10 }}"
                                    class="w-full object-cover block group-hover:scale-105 transition-transform duration-300"
                                    style="aspect-ratio: 3 / 4;"
                                />
                            </div>
                            <span class="text-[10px] text-center text-muted-foreground">Hal. {{ $i * 10 }}</span>
                        </div>
                        @endfor
                    </div>

                    <div class="flex items-center justify-center gap-3 p-3 rounded-lg bg-accent/30 border border-border/50">
                        <i class="ki-filled ki-lock text-muted-foreground text-sm"></i>
                        <p class="text-xs text-muted-foreground">
                            Beli untuk akses penuh ke seluruh <span class="font-semibold text-mono">384 halaman</span>
                        </p>
                        <button class="kt-btn kt-btn-primary kt-btn-sm">
                            <i class="ki-filled ki-credit-card"></i>
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== BUKU SERUPA ===== --}}
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ki-filled ki-book text-primary text-sm"></i>
                    <h2 class="text-base font-bold text-mono">Buku Serupa</h2>
                </div>
                <a href="#" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    Lihat semua <i class="ki-filled ki-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                @php
                $similar = [
                    ['title' => 'Algoritma & Struktur Data',       'author' => 'Budi Santoso',      'price_min' => 'Rp40.000', 'price_max' => 'Rp110.000'],
                    ['title' => 'Pemrograman Python untuk Pemula', 'author' => 'Rina Marlina, dkk', 'price_min' => 'Rp35.000', 'price_max' => 'Rp95.000'],
                    ['title' => 'Jaringan Komputer Terapan',       'author' => 'Ahmad Fauzi',       'price_min' => 'Rp50.000', 'price_max' => 'Rp130.000'],
                    ['title' => 'Kecerdasan Buatan Modern',        'author' => 'Dr. Hendra Wijaya', 'price_min' => 'Rp55.000', 'price_max' => 'Rp145.000'],
                    ['title' => 'Kecerdasan Buatan Modern',        'author' => 'Dr. Hendra Wijaya', 'price_min' => 'Rp55.000', 'price_max' => 'Rp145.000'],
                ];
                @endphp

                @foreach($similar as $book)
                <div class="kt-card">
                            <div class="kt-card-content flex flex-col justify-between p-2.5 gap-3">
                                <div>
                                    {{-- Gambar --}}
                                    <div class="kt-card relative bg-accent/50 w-full mb-3 shadow-none overflow-hidden"
                                        data-kt-context-menu="true" data-kt-context-menu-trigger="true">
                                        <img
                                            alt=""
                                            class="w-full cursor-pointer object-cover block"
                                            style="aspect-ratio: 1 / 1.41;"
                                            data-kt-drawer-toggle="#drawers_shop_product_details"
                                            src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg"
                                        />
                                        <div class="kt-context-menu w-56 hidden" data-kt-context-menu-menu="true">
                                            <ul class="kt-context-menu-sub">
                                                <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" data-kt-drawer-toggle="#drawers_shop_product_details" type="button">Quick View</button></li>
                                                <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" data-kt-drawer-toggle="#drawers_shop_cart" type="button">Add to Cart</button></li>
                                                <li class="kt-context-menu-separator"></li>
                                                <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" type="button">Add to Wishlist</button></li>
                                            </ul>
                                        </div>
                                    </div>

                                    {{-- Judul 1 baris + elipsis --}}
                                    <a class="hover:text-primary text-sm font-medium text-mono px-2.5 block truncate"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        title="Cloud Shift Lightweight Runner Pro Edition"
                                        href="#">
                                        Cloud Shift Lightweight Runner Pro Edition
                                    </a>

                                    {{-- Penulis --}}
                                    <p class="text-xs text-muted-foreground px-2.5 mt-0.5 truncate">
                                        @php $authors = ['Budi Santoso', 'Rina Marlina', 'Ahmad Fauzi']; @endphp
                                        {{ $authors[0] }}{{ count($authors) > 1 ? ', dkk' : '' }}
                                    </p>
                                </div>

                                {{-- Harga + Tombol --}}
                                <div class="flex flex-col gap-2 px-2.5 pb-1">
                                    {{-- Harga --}}
                                    <p class="text-sm font-semibold text-mono">
                                        Rp10.000
                                        <span class="text-muted-foreground font-normal">-</span>
                                        Rp15.000
                                    </p>

                                    {{-- Tombol --}}
                                    <div class="flex items-center gap-1.5">
                                        <a href="#"
                                            class="kt-btn kt-btn-outline kt-btn-sm flex-1"
                                            data-kt-drawer-toggle="#drawers_shop_product_details">
                                            <i class="ki-filled ki-eye"></i>
                                            Detail
                                        </a>
                                        <button
                                            class="kt-btn kt-btn-primary kt-btn-sm"
                                            data-kt-drawer-toggle="#drawers_shop_cart">
                                            <i class="ki-filled ki-handcart"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
<script>
    document.querySelectorAll('.edisi-label').forEach(label => {
        label.addEventListener('click', () => {
            // Reset semua
            document.querySelectorAll('.edisi-label .edisi-box').forEach(box => {
                box.classList.remove('border-primary', 'bg-primary/5');
                box.classList.add('border-border');
            });
            // Aktifkan yang dipilih
            label.querySelector('.edisi-box').classList.add('border-primary', 'bg-primary/5');
            label.querySelector('.edisi-box').classList.remove('border-border');
            // Centang radio
            label.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
<script>
    const input = document.getElementById('qty-input');
    document.getElementById('btn-plus').addEventListener('click', () => {
        input.value = parseInt(input.value || 1) + 1;
    });
    document.getElementById('btn-minus').addEventListener('click', () => {
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });

    function openTab(evt, tabName) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });
        document.querySelectorAll('.tab-link').forEach(btn => {
            btn.classList.remove('text-primary', 'border-primary', 'font-semibold', 'bg-primary/5');
            btn.classList.add('text-muted-foreground', 'border-transparent', 'font-medium');
        });
        document.getElementById(tabName).classList.remove('hidden');
        document.getElementById(tabName).classList.add('block');
        evt.currentTarget.classList.add('text-primary', 'border-primary', 'font-semibold', 'bg-primary/5');
        evt.currentTarget.classList.remove('text-muted-foreground', 'border-transparent', 'font-medium');
    }
</script>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>

@endsection
