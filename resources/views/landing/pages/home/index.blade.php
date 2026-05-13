@extends('landing.layouts.app')

@section('content')
    <!-- =========================================
         MOCK DATA (Hanya untuk tampilan sementara)
    ========================================== -->
    @php
        $books = [
            ['title' => 'Algoritma & Struktur Data', 'author' => 'Budi Santoso', 'price_min' => 'Rp40.000', 'price_max' => 'Rp110.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
            ['title' => 'Pemrograman Python', 'author' => 'Rina Marlina, dkk', 'price_min' => 'Rp35.000', 'price_max' => 'Rp95.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
            ['title' => 'Jaringan Komputer', 'author' => 'Ahmad Fauzi', 'price_min' => 'Rp50.000', 'price_max' => 'Rp130.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
            ['title' => 'Kecerdasan Buatan', 'author' => 'Dr. Hendra', 'price_min' => 'Rp55.000', 'price_max' => 'Rp145.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
            ['title' => 'UI/UX Design Masterclass', 'author' => 'Siska UI', 'price_min' => 'Rp75.000', 'price_max' => 'Rp200.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
            ['title' => 'Laravel untuk Pemula', 'author' => 'Dev Indo', 'price_min' => 'Rp60.000', 'price_max' => 'Rp150.000', 'cover' => 'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg'],
        ];
    @endphp

    <div class="kt-container-fixed pb-16">

        <!-- =========================================
             1. HERO SECTION
        ========================================== -->
        <div class="flex flex-col-reverse md:flex-row items-center min-h-[400px] md:h-[500px] gap-8 md:gap-10 mb-12 mt-6 md:mt-0">
            <div class="flex-1 flex flex-col gap-5 text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-medium w-fit mx-auto md:mx-0">
                    <i class="ki-filled ki-rocket text-base"></i> Platform Literasi Terbaik
                </div>
                <h2 class="text-4xl md:text-5xl font-semibold text-mono leading-tight">
                    Bersama Daya Media Nusantara, <br/>
                    <span class="text-primary">Jelajahi Dunia Buku</span>
                </h2>
                <p class="text-muted-foreground text-lg max-w-lg mx-auto md:mx-0">
                    Kami mendukung penulis untuk menjadi talenta yang berharga, dan membantu pembaca menemukan karya-karya terbaik dari penjuru negeri.
                </p>
                <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                    <button class="kt-btn kt-btn-primary kt-btn-lg">
                        Mulai Membaca <i class="ki-filled ki-arrow-right ms-2"></i>
                    </button>
                    <button class="kt-btn kt-btn-outline kt-btn-lg">
                        Daftar Penulis
                    </button>
                </div>
            </div>
            <div class="flex-1 flex justify-center md:justify-end">
                <img class="w-full max-w-[350px] md:max-w-[450px] object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500" src="{{ asset('assets/images/hero.avif') }}" alt="Hero Illustration">
            </div>
        </div>

        <!-- =========================================
             2. KEUNTUNGAN BERGABUNG (BENEFITS)
        ========================================== -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h3 class="text-2xl text-mono font-semibold">Keuntungan Bergabung Bersama Kami</h3>
                <p class="text-muted-foreground mt-2">Alasan mengapa ribuan pembaca dan penulis memilih kami.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="kt-card hover:border-primary transition-colors duration-300">
                    <div class="kt-card-content p-6 flex flex-col items-center text-center gap-4">
                        <div class="size-14 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-book-open text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-mono mb-1">Koleksi Lengkap</h4>
                            <p class="text-sm text-muted-foreground">Ribuan buku dari berbagai genre tersedia untuk Anda.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="kt-card hover:border-primary transition-colors duration-300">
                    <div class="kt-card-content p-6 flex flex-col items-center text-center gap-4">
                        <div class="size-14 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-discount text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-mono mb-1">Harga Terjangkau</h4>
                            <p class="text-sm text-muted-foreground">Dapatkan penawaran terbaik dan diskon setiap minggunya.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="kt-card hover:border-primary transition-colors duration-300">
                    <div class="kt-card-content p-6 flex flex-col items-center text-center gap-4">
                        <div class="size-14 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-delivery-time text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-mono mb-1">Pengiriman Cepat</h4>
                            <p class="text-sm text-muted-foreground">Bekerja sama dengan ekspedisi terpercaya di seluruh Indonesia.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="kt-card hover:border-primary transition-colors duration-300">
                    <div class="kt-card-content p-6 flex flex-col items-center text-center gap-4">
                        <div class="size-14 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-verify text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-mono mb-1">100% Original</h4>
                            <p class="text-sm text-muted-foreground">Kami menjamin keaslian setiap buku yang Anda beli.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================
             3. REKOMENDASI BUKU
        ========================================== -->
        <div class="flex flex-col gap-5 mb-12">
            <div class="flex items-center justify-between gap-4">
                <div class="flex flex-col gap-0.5">
                    <h3 class="text-xl md:text-2xl text-mono font-semibold">
                        Rekomendasi Buku
                    </h3>
                    <p class="text-muted text-sm">Pilihan rekomendasi buku terbaik untuk menemani waktu bacamu.</p>
                </div>
                <a href="#" class="text-xs md:text-sm font-semibold text-primary hover:underline flex items-center gap-1 whitespace-nowrap">
                    Lihat semua <i class="ki-filled ki-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 lg:gap-5">
                <div class="w-full lg:w-[220px] xl:w-[250px] flex-shrink-0">
                    <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="" class="w-full h-full lg:h-full object-cover rounded-md">
                </div>
                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
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

        <!-- =========================================
             4. BUKU TERBARU
        ========================================== -->
        <div class="flex flex-col gap-5 mb-12">
            <div class="flex items-center justify-between gap-4">
                <div class="flex flex-col gap-0.5">
                    <h3 class="text-xl md:text-2xl text-mono font-semibold">
                        Buku Terbaru
                    </h3>
                    <p class="text-muted text-sm">Rilisan baru dengan kualitas isi terbaik untuk pengalaman membaca yang istimewa. </p>
                </div>
                <a href="#" class="text-xs md:text-sm font-semibold text-primary hover:underline flex items-center gap-1 whitespace-nowrap">
                    Lihat semua <i class="ki-filled ki-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 lg:gap-5">
                <div class="w-full lg:w-[220px] xl:w-[250px] flex-shrink-0">
                    <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="" class="w-full h-full lg:h-full object-cover rounded-md">
                </div>
                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
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

        <!-- =========================================
             5. BUKU TERLARIS
        ========================================== -->
        <div class="flex flex-col gap-5 mb-12">
            <div class="flex items-center justify-between gap-4">
                <div class="flex flex-col gap-0.5">
                    <h3 class="text-xl md:text-2xl text-mono font-semibold">
                        Buku Terlaris
                    </h3>
                    <p class="text-muted text-sm">Buku unggulan dengan antusiasme pembaca yang luar biasa </p>
                </div>
                <a href="#" class="text-xs md:text-sm font-semibold text-primary hover:underline flex items-center gap-1 whitespace-nowrap">
                    Lihat semua <i class="ki-filled ki-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 lg:gap-5">
                <div class="w-full lg:w-[220px] xl:w-[250px] flex-shrink-0">
                    <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="" class="w-full h-full lg:h-full object-cover rounded-md">
                </div>
                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
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
@endsection
