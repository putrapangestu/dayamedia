@extends('landing.layouts.app')

@section('content')
    <!-- =========================================
         1. HERO SECTION
    ========================================== -->
    <section class="relative bg-primary overflow-hidden min-h-[500px] lg:h-[600px] flex items-center lg:items-end">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-white/5 skew-x-12 translate-x-1/4"></div>
        <div class="absolute -bottom-24 -left-24 size-96 bg-white/10 rounded-full blur-3xl"></div>

        <div class="kt-container-fixed relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center lg:items-end gap-10">
                <!-- Hero Content -->
                <div class="flex-1 text-center lg:text-left text-white py-12 lg:pb-24 lg:pt-0">
                    <h1 class="text-4xl md:text-5xl xl:text-6xl font-black leading-[1.1] mb-6">
                        Wujudkan Karya Impian & Perluas Wawasan Tanpa Batas!
                    </h1>
                    <p class="text-white/80 text-lg md:text-xl font-medium mb-10 max-w-2xl mx-auto lg:mx-0">
                        Platform terintegrasi untuk memiliki koleksi buku terbaik dan berkolaborasi menulis karya hebat bersama penulis profesional lainnya.
                    </p>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('catalog') }}" class="px-8 py-4 bg-[#FF8A00] hover:bg-[#E67C00] text-white font-bold rounded-full flex items-center gap-3 shadow-xl transition-all hover:scale-105">
                            Jelajahi Katalog <i class="ki-filled ki-handcart text-xl"></i>
                        </a>
                        <div class="relative group">
                            <a href="{{ route('collaboration') }}" class="px-8 py-4 bg-transparent border-2 border-white/30 hover:border-white text-white font-bold rounded-full flex items-center gap-3 transition-all">
                                Mulai Menulis <i class="ki-filled ki-pencil text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="flex-1 relative flex justify-center lg:justify-end self-end">
                    <div class="relative w-full max-w-[500px] flex items-end">
                        <!-- Abstract circles -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border border-white/20 rounded-full border-dashed animate-spin-slow"></div>
                        <div class="absolute top-10 right-10 size-6 bg-green-400 rounded-full animate-pulse"></div>
                        <div class="absolute bottom-20 left-0 size-10 bg-yellow-400 rounded-full animate-bounce-slow"></div>

                        <img src="{{ asset('assets/images/hero-2.png') }}"
                             alt="Daya Media"
                             class="relative z-10 w-full h-auto object-contain drop-shadow-2xl translate-y-2">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================
         2. FEATURES SECTION
    ========================================== -->
    <section class="bg-[#F8FDFA] py-12 border-b border-gray-100">
        <div class="kt-container-fixed">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-center gap-5">
                    <div class="size-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-primary border border-primary/10">
                        <i class="ki-filled ki-book-open text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900 mb-1">Koleksi Terlengkap</h4>
                        <p class="text-sm text-gray-500 font-medium leading-tight">Beragam genre dan topik buku berkualitas untuk menambah ilmu Anda.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-center gap-5 border-y md:border-y-0 md:border-x border-gray-100 py-6 md:py-0 md:px-8">
                    <div class="size-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-primary border border-primary/10">
                        <i class="ki-filled ki-users text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900 mb-1">Ruang Kolaborasi</h4>
                        <p class="text-sm text-gray-500 font-medium leading-tight">Daftarkan diri Anda untuk menulis bab buku bersama penulis lainnya.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-center gap-5 md:ps-8">
                    <div class="size-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-primary border border-primary/10">
                        <i class="ki-filled ki-flash-circle text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-900 mb-1">Proses Cepat</h4>
                        <p class="text-sm text-gray-500 font-medium leading-tight">Pilih, bayar, dan langsung nikmati akses baca atau akses menulis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="kt-container-fixed py-16">
        <!-- =========================================
             3. NEW RELEASE!
        ========================================== -->
        <div class="flex flex-col gap-6 mb-20">
            <div class="flex items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Terbitan Terbaru</h3>
                <a href="{{ route('catalog') }}" class="text-sm font-bold text-primary hover:underline">
                    Lihat Semua <i class="ki-filled ki-arrow-right text-base"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <!-- Featured Banner -->
                <div class="w-full lg:w-[200px] flex-shrink-0 relative group">
                    <img src="{{ asset('assets/images/new-release.jpeg') }}" alt="New Release" class="relative w-full h-full object-cover rounded-3xl shadow-lg border border-white transform group-hover:-translate-y-2 transition-transform duration-500">
                </div>

                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 xl:grid-cols-6 gap-5">
                    @forelse ($latestBooks as $book)
                        @include('landing.pages.home.partials.book-card', ['book' => $book])
                    @empty
                        <p class="col-span-full text-gray-400 font-medium text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200 italic">Belum ada rilis terbaru.</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-4">
                <span class="text-xs font-medium text-gray-400">Menampilkan {{ $latestBooks->count() }} buku</span>
            </div>
        </div>

        <!-- =========================================
             4. REKOMENDASI UNTUK-MU!
        ========================================== -->
        <div class="flex flex-col gap-6 mb-20">
            <div class="flex items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Rekomendasi Terbaik</h3>
                <a href="{{ route('catalog') }}" class="text-sm font-bold text-primary hover:underline">
                    Lihat Semua <i class="ki-filled ki-arrow-right text-base"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <div class="w-full lg:w-[200px] flex-shrink-0 relative group">
                    <img src="{{ asset('assets/images/recomend.png') }}" alt="Rekomendasi" class="relative w-full h-full object-cover rounded-3xl shadow-lg border border-white transform group-hover:-translate-y-2 transition-transform duration-500">
                </div>

                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 xl:grid-cols-6 gap-5">
                    @forelse ($recommendations as $book)
                        @include('landing.pages.home.partials.book-card', ['book' => $book])
                    @empty
                        <p class="col-span-full text-gray-400 font-medium text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200 italic">Belum ada rekomendasi.</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-4">
                <span class="text-xs font-medium text-gray-400">Menampilkan {{ $recommendations->count() }} buku</span>
            </div>
        </div>

        <!-- =========================================
             5. PALING POPULER
        ========================================== -->
        <div class="flex flex-col gap-6 mb-20">
            <div class="flex items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Karya Terlaris</h3>
                <a href="{{ route('catalog') }}" class="text-sm font-bold text-primary hover:underline">
                    Lihat Semua <i class="ki-filled ki-arrow-right text-base"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <div class="w-full lg:w-[200px] flex-shrink-0 relative group">
                    <img src="{{ asset('assets/images/most-sold.png') }}" alt="Populer" class="relative w-full h-full object-cover rounded-3xl shadow-lg border border-white transform group-hover:-translate-y-2 transition-transform duration-500">
                </div>

                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 xl:grid-cols-6 gap-5">
                    @forelse ($bestSellingBooks as $book)
                        @include('landing.pages.home.partials.book-card', ['book' => $book])
                    @empty
                        <p class="col-span-full text-gray-400 font-medium text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200 italic">Belum ada buku populer.</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-4">
                <span class="text-xs font-medium text-gray-400">Menampilkan {{ $bestSellingBooks->count() }} buku</span>
            </div>
        </div>

        <!-- =========================================
             6. MAU JADI PENULIS?
        ========================================== -->
        <div class="mb-24">
            <div class="bg-primary rounded-[3rem] p-8 lg:p-16 shadow-2xl relative overflow-hidden group">
                <!-- Abstract waves -->
                <div class="absolute inset-0 opacity-10 pointer-events-none group-hover:opacity-20 transition-opacity">
                    <svg class="w-full h-full" viewBox="0 0 1440 320" preserveAspectRatio="none">
                        <path fill="white" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,149.3C672,149,768,203,864,224C960,245,1056,235,1152,213.3C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                    <div class="max-w-2xl text-center lg:text-left text-white">
                        <h2 class="text-3xl md:text-5xl font-black mb-6">Punya Karya Terbaik? Terbitkan Naskah Anda Segera!</h2>
                        <p class="text-white/80 text-lg md:text-xl font-medium leading-relaxed">Jangan biarkan naskah anda hanya tersimpan rapi. Terbitkan segera bersama Daya Media Nusantara, dapatkan kesempatan publikasi dengan biaya terjangkat dan jaringan distribusi yang luas.</p>
                    </div>
                    <a href="{{ route('individual-books.packages') }}" class="px-12 py-6 bg-white text-primary font-black rounded-full shadow-2xl flex items-center gap-4 hover:scale-105 transition-all text-lg">
                        Terbitkan Sekarang <i class="ki-filled ki-arrow-right text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- =========================================
             7. CARA LANGGANAN
        ========================================== -->
        <div class="mb-10">
            <div class="text-center mb-16">
                <h3 class="text-3xl sm:text-5xl font-black text-gray-900 tracking-tight mb-6">Bagaimana Cara Kerja Daya Media?</h3>
                <p class="text-gray-500 text-lg md:text-xl font-medium">Langkah mudah untuk mulai membaca atau berkarya di platform kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                @php
                    $steps = [
                        ['id' => 1, 'icon' => 'ki-handcart', 'title' => 'Pilih Buku/Bab', 'desc' => 'Cari buku yang ingin Anda baca atau pilih bab dalam proyek kolaborasi yang ingin Anda tulis.'],
                        ['id' => 2, 'icon' => 'ki-wallet', 'title' => 'Selesaikan Pembayaran', 'desc' => 'Lakukan transaksi dengan beragam pilihan metode pembayaran yang aman dan praktis.'],
                        ['id' => 3, 'icon' => 'ki-book-open', 'title' => 'Mulai Akses', 'desc' => 'Dapatkan akses instan ke konten digital atau mulailah menulis naskah Anda di dashboard.'],
                        ['id' => 4, 'icon' => 'ki-medal-star', 'title' => 'Nikmati Hasilnya', 'desc' => 'Perkaya wawasan Anda dengan bacaan bermutu atau raih royalti dari setiap karya yang terjual.'],
                    ];
                @endphp
                @foreach($steps as $step)
                <div class="relative flex flex-col items-center text-center group">
                    <div class="size-24 rounded-[2rem] bg-primary/5 text-primary flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-xl shadow-primary/5 border border-primary/10">
                        <i class="ki-filled {{ $step['icon'] }} text-5xl"></i>
                        <span class="absolute -top-3 -right-3 size-10 bg-[#FF8A00] text-white font-black rounded-full flex items-center justify-center border-4 border-white text-lg shadow-lg">
                            {{ $step['id'] }}
                        </span>
                    </div>
                    <h4 class="text-xl font-extrabold text-gray-900 mb-4 group-hover:text-primary transition-colors">{{ $step['title'] }}</h4>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed px-4">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="bg-gray-900 py-20 relative overflow-hidden border-b border-white/10">
        <div class="absolute top-0 right-0 size-[600px] bg-primary/10 blur-[150px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="kt-container-fixed relative z-10 text-center">
            <h3 class="text-3xl md:text-4xl font-black text-white mb-6 italic">Mendukung Perjalanan Literasimu.</h3>
            <p class="text-gray-400 text-lg font-medium max-w-2xl mx-auto mb-12">Punya naskah yang ingin diterbitkan? Atau ingin berkolaborasi dengan komunitas kami? Hubungi tim kami sekarang.</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="https://wa.me/6281166012020" target="_blank" class="px-12 py-5 bg-[#25D366] hover:bg-[#20BD5A] text-white font-black rounded-2xl shadow-2xl shadow-green-500/20 flex items-center gap-3 transition-all hover:scale-105">
                    <i class="ki-filled ki-whatsapp text-3xl"></i> Hubungi WhatsApp
                </a>
            </div>
        </div>
    </section>

    <!-- Styles for custom animations -->
    <style>
        @keyframes spin-slow {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .animate-bounce-slow { animation: bounce 3s infinite; }
    </style>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();
        @guest window.location.href = "{{ route('login') }}"; return; @endguest

        let btn = $(this);
        let icon = btn.find('i');
        let originalClass = icon.attr('class');

        btn.prop('disabled', true);
        icon.attr('class', 'ki-filled ki-arrows-circle animate-spin text-lg');

        $.ajax({
            url: '{{ route('cart.add') }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', book_id: btn.data('book-id') },
            success: function() {
                icon.attr('class', 'ki-filled ki-check text-lg');
                btn.addClass('bg-green-500 border-green-500').removeClass('bg-primary border-primary');
                setTimeout(() => {
                    btn.prop('disabled', false);
                    icon.attr('class', originalClass);
                    btn.addClass('bg-primary border-primary').removeClass('bg-green-500 border-green-500');
                }, 2000);
            },
            error: function() {
                icon.attr('class', 'ki-filled ki-cross text-lg');
                btn.addClass('bg-red-500 border-red-500').removeClass('bg-primary border-primary');
                setTimeout(() => {
                    btn.prop('disabled', false);
                    icon.attr('class', originalClass);
                    btn.addClass('bg-primary border-primary').removeClass('bg-red-500 border-red-500');
                }, 2000);
            }
        });
    });
});
</script>
@endpush
