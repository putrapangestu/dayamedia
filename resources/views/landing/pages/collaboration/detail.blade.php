@extends('landing.layouts.app')

@section('content')
    <div class="kt-container-fixed py-6">
        <div class="flex flex-col gap-6">

            {{-- ===== BREADCRUMB ===== --}}
            <div class="flex items-center gap-1.5 text-sm">
                <a href="#" class="text-secondary-foreground hover:text-primary transition-colors">Beranda</a>
                <span class="text-muted-foreground">/</span>
                <a href="#" class="text-secondary-foreground hover:text-primary transition-colors">Buku Kolaborasi</a>
                <span class="text-muted-foreground">/</span>
                <span class="text-mono font-medium truncate max-w-[200px]">Pengantar Ilmu Komputer Modern</span>
            </div>

            {{-- ===== DETAIL UTAMA ===== --}}
            <div class="flex flex-col lg:flex-row gap-6 items-start">

                {{-- ===== KOLOM KIRI: Gambar ===== --}}
                <div class="w-full lg:w-[200px] shrink-0 mx-auto lg:mx-0 max-w-[200px]">
                    <div class="kt-card overflow-hidden border border-border shadow-none">
                        <img src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg"
                            alt="Cover Buku" class="w-full object-cover block" style="aspect-ratio: 3 / 4;" />
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
                                    [
                                        'icon' => 'ki-filled ki-user-edit',
                                        'label' => 'Penulis',
                                        'value' => 'Budi Santoso, Rina Marlina, Ahmad Fauzi',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-pencil',
                                        'label' => 'Editor',
                                        'value' => 'Dr. Hendra Wijaya, M.Kom',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-barcode',
                                        'label' => 'ISBN',
                                        'value' => '978-602-1234-56-7',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-category',
                                        'label' => 'Bahasa',
                                        'value' => 'Indonesia',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-calendar',
                                        'label' => 'Tahun Terbit',
                                        'value' => '2024',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-home-3',
                                        'label' => 'Penerbit',
                                        'value' => 'Penerbit Azzia',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-globe',
                                        'label' => 'Website',
                                        'value' => 'azzia.id/buku',
                                        'type' => 'link',
                                        'href' => 'https://azzia.id',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-package',
                                        'label' => 'Berat',
                                        'value' => '450 gram',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-book-open',
                                        'label' => 'Halaman',
                                        'value' => '384 halaman',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-tag',
                                        'label' => 'Kata Kunci',
                                        'value' => 'komputer, pemrograman, algoritma',
                                        'type' => 'text',
                                    ],
                                    [
                                        'icon' => 'ki-filled ki-search-list',
                                        'label' => 'Google Scholar',
                                        'value' => 'Lihat di Google Scholar',
                                        'type' => 'link',
                                        'href' => 'https://scholar.google.com',
                                    ],
                                ];
                                $total = count($info);
                            @endphp

                            @foreach ($info as $i => $item)
                                <div
                                    class="flex items-start gap-3 px-4 py-2.5 border-b border-border/40
                            {{ $i === $total - 1 && $total % 2 !== 0 ? 'sm:col-span-2' : '' }}
                            {{ $i >= $total - ($total % 2 === 0 ? 2 : 1) ? 'border-b-0' : '' }}
                            hover:bg-accent/20 transition-colors">
                                    <div
                                        class="w-6 h-6 rounded-md bg-primary/10 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="{{ $item['icon'] }} text-primary" style="font-size:11px;"></i>
                                    </div>
                                    <div class="flex flex-col gap-0.5 flex-1 min-w-0">
                                        <span
                                            class="text-[10px] uppercase tracking-wider text-muted-foreground font-medium leading-none">
                                            {{ $item['label'] }}
                                        </span>
                                        @if ($item['type'] === 'link')
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
                    <div class="kt-card border border-border py-2 flex flex-col gap-3">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">Timeline</h3>
                        </div>
                        <div class="kt-card-content">
                            <div class="flex flex-col">
                                <div class="flex items-start relative">
                                    <div
                                        class="w-9 start-0 top-9 absolute bottom-0 rtl:-translate-x-1/2 translate-x-1/2 border-s border-s-input">
                                    </div>
                                    <div
                                        class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-input size-9 text-secondary-foreground bg-primary text-white">
                                        <i class="ki-filled ki-people text-base">
                                        </i>
                                    </div>
                                    <div class="ps-2.5 mb-7 text-base grow">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-mono">
                                                Kolaborasi
                                            </div>
                                            <span class="text-xs text-secondary-foreground">
                                                0/13
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-start relative">
                                    <div
                                        class="w-9 start-0 top-9 absolute bottom-0 rtl:-translate-x-1/2 translate-x-1/2 border-s border-s-input">
                                    </div>
                                    <div
                                        class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-input size-9 text-secondary-foreground">
                                        <i class="ki-filled ki-people text-base">
                                        </i>
                                    </div>
                                    <div class="ps-2.5 mb-7 text-base grow">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-mono">
                                                Upload Naskah
                                            </div>
                                            <span class="text-xs text-secondary-foreground">
                                                0/13
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-start relative">
                                    <div
                                        class="w-9 start-0 top-9 absolute bottom-0 rtl:-translate-x-1/2 translate-x-1/2 border-s border-s-input">
                                    </div>
                                    <div
                                        class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-input size-9 text-secondary-foreground">
                                        <i class="ki-filled ki-people text-base">
                                        </i>
                                    </div>
                                    <div class="ps-2.5 mb-7 text-base grow">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-mono">
                                                Editing Naskah oleh Editor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-start relative">
                                    <div
                                        class="w-9 start-0 top-9 absolute bottom-0 rtl:-translate-x-1/2 translate-x-1/2 border-s border-s-input">
                                    </div>
                                    <div
                                        class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-input size-9 text-secondary-foreground">
                                        <i class="ki-filled ki-people text-base">
                                        </i>
                                    </div>
                                    <div class="ps-2.5 mb-7 text-base grow">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-mono">
                                                Input ISBN
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-start relative">
                                    <div
                                        class="w-9 start-0 top-9 absolute bottom-0 rtl:-translate-x-1/2 translate-x-1/2 border-s border-s-input">
                                    </div>
                                    <div
                                        class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-input size-9 text-secondary-foreground">
                                        <i class="ki-filled ki-people text-base">
                                        </i>
                                    </div>
                                    <div class="ps-2.5 mb-7 text-base grow">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-mono">
                                                Buku Publish
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex flex-wrap items-center gap-5 justify-between">
                <h3 class="text-lg text-mono font-semibold">
                    Bab/Modul Buku
                </h3>
            </div>
            <div class="grid grid-cols-1 gap-1">
                @for ($i = 1; $i <= 13; $i++)
                    <div class="kt-card p-4">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <i class="ki-filled ki-book text-primary text-base"></i>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="leading-none font-medium text-sm text-mono">
                                    Sistem Multi Derajat Kebebasan (MDOF)
                                </span>
                                <span class="text-xs text-muted-foreground font-normal">
                                    BAB 1
                                </span>
                            </div>
                        </div>
                        <button class="kt-btn kt-btn-primary">
                            Ambil Bagian Ini
                        </button>
                    </div>
                </div>
                @endfor
            </div>

            {{-- ===== BUKU SERUPA ===== --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="flex flex-wrap items-center gap-5 justify-between">
                        <h3 class="text-lg text-mono font-semibold">
                            Buku Kolaborasi Serupa
                        </h3>
                    </div>
                    <a href="#" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                        Lihat semua <i class="ki-filled ki-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                    @php
                        $similar = [
                            [
                                'title' => 'Algoritma & Struktur Data',
                                'author' => 'Budi Santoso',
                                'price_min' => 'Rp40.000',
                                'price_max' => 'Rp110.000',
                            ],
                            [
                                'title' => 'Pemrograman Python untuk Pemula',
                                'author' => 'Rina Marlina, dkk',
                                'price_min' => 'Rp35.000',
                                'price_max' => 'Rp95.000',
                            ],
                            [
                                'title' => 'Jaringan Komputer Terapan',
                                'author' => 'Ahmad Fauzi',
                                'price_min' => 'Rp50.000',
                                'price_max' => 'Rp130.000',
                            ],
                            [
                                'title' => 'Kecerdasan Buatan Modern',
                                'author' => 'Dr. Hendra Wijaya',
                                'price_min' => 'Rp55.000',
                                'price_max' => 'Rp145.000',
                            ],
                            [
                                'title' => 'Kecerdasan Buatan Modern',
                                'author' => 'Dr. Hendra Wijaya',
                                'price_min' => 'Rp55.000',
                                'price_max' => 'Rp145.000',
                            ],
                        ];
                    @endphp

                    @foreach ($similar as $book)
                        <div class="kt-card">
                            <div class="kt-card-content flex flex-col justify-between p-2.5 gap-3">
                                <div>
                                    {{-- Gambar --}}
                                    <div class="kt-card relative bg-accent/50 w-full mb-3 shadow-none overflow-hidden"
                                        data-kt-context-menu="true" data-kt-context-menu-trigger="true">
                                        <img alt="" class="w-full cursor-pointer object-cover block"
                                            style="aspect-ratio: 1 / 1.41;"
                                            data-kt-drawer-toggle="#drawers_shop_product_details"
                                            src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg" />
                                        <div class="kt-context-menu w-56 hidden" data-kt-context-menu-menu="true">
                                            <ul class="kt-context-menu-sub">
                                                <li><button class="kt-context-menu-link"
                                                        data-kt-context-menu-dismiss="true"
                                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                                        type="button">Quick View</button></li>
                                                <li><button class="kt-context-menu-link"
                                                        data-kt-context-menu-dismiss="true"
                                                        data-kt-drawer-toggle="#drawers_shop_cart" type="button">Add to
                                                        Cart</button></li>
                                                <li class="kt-context-menu-separator"></li>
                                                <li><button class="kt-context-menu-link"
                                                        data-kt-context-menu-dismiss="true" type="button">Add to
                                                        Wishlist</button></li>
                                            </ul>
                                        </div>
                                    </div>

                                    {{-- Judul 1 baris + elipsis --}}
                                    <a class="hover:text-primary text-sm font-medium text-mono px-2.5 block truncate"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        title="Cloud Shift Lightweight Runner Pro Edition" href="#">
                                        Cloud Shift Lightweight Runner Pro Edition
                                    </a>

                                    {{-- Penulis --}}
                                    <p class="text-xs text-muted-foreground px-2.5 mt-0.5 truncate">
                                        Penulis 0/13
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
                                        <a href="#" class="kt-btn kt-btn-outline kt-btn-sm flex-1"
                                            data-kt-drawer-toggle="#drawers_shop_product_details">
                                            <i class="ki-filled ki-eye"></i>
                                            Detail
                                        </a>
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
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
