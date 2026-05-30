@extends('landing.layouts.app')

@section('content')
    <div class="kt-container-fixed pb-16">

        <!-- =========================================
             1. HERO SECTION (Client's Preferred Hero)
        ========================================== -->
        <div class="flex flex-col-reverse lg:flex-row items-center min-h-[500px] lg:h-[600px] gap-10 mb-16 mt-6 lg:mt-0">
            <div class="flex-1 flex flex-col gap-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-bold w-fit mx-auto lg:mx-0 animate-bounce-slow">
                    <i class="ki-filled ki-rocket text-base"></i> Selamat Datang di Daya Media
                </div>
                <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold text-gray-900 leading-[1.1] tracking-tight">
                    Tempat terbaik untuk <br/>
                    <span class="text-primary italic">Membaca, Menulis</span> <br class="hidden xl:block"/> 
                    & <span class="text-primary">Kolaborasi</span> Buku
                </h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-xl mx-auto lg:mx-0 font-medium leading-relaxed">
                    Daya Media adalah platform terpadu untuk membeli buku, menulis karya sendiri, dan berkolaborasi dengan penulis lain dalam satu ekosistem yang modern.
                </p>
                <div class="flex items-center justify-center lg:justify-start gap-4 mt-4">
                    <a href="{{ route('login') }}" class="kt-btn kt-btn-primary kt-btn-lg px-10 py-5 rounded-2xl font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                        Gabung Bersama Kami <i class="ki-filled ki-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Hero Image (Client's Preferred hero.avif) -->
            <div class="flex-1 w-full lg:w-auto flex justify-center lg:justify-end relative">
                <!-- Background Ornaments behind hero -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-primary/5 rounded-full blur-[100px] -z-10 animate-pulse-slow"></div>
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-yellow-400/20 rounded-full blur-2xl animate-bounce-slow"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-secondary/20 rounded-full blur-2xl animate-pulse"></div>

                <div class="relative group animate-float">
                    <img src="{{ asset('assets/images/hero.avif') }}" 
                         alt="Daya Media Platform" 
                         class="w-full max-w-[450px] xl:max-w-[550px] h-auto object-contain drop-shadow-[0_20px_50px_rgba(var(--primary-rgb),0.3)] group-hover:scale-105 transition-transform duration-700">
                    
                    <!-- Additional Decorative Floating Cards -->
                    <div class="absolute top-1/4 -left-6 bg-white border border-gray-100 p-3 rounded-2xl shadow-xl animate-float-slow hidden xl:flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="ki-filled ki-check text-base"></i>
                        </div>
                        <span class="text-[10px] font-black text-gray-900 uppercase tracking-wider">ISBN Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================
             2. KEUNTUNGAN BERGABUNG
        ========================================== -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <span class="text-primary font-bold text-sm uppercase tracking-widest mb-3 block">Ekosistem Penulis</span>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Bangun Karya, Kelola Royalti, Raih Penghasilan</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $features = [
                        ['icon' => 'ki-users', 'title' => 'Kolaborasi Penulis', 'desc' => 'Menulis buku bersama penulis lain secara terstruktur.'],
                        ['icon' => 'ki-wallet', 'title' => 'Royalti Otomatis', 'desc' => 'Pembagian royalti otomatis sesuai kontribusi penulis.'],
                        ['icon' => 'ki-abstract-26', 'title' => 'Program Afiliasi', 'desc' => 'Dapatkan komisi dengan mempromosikan buku.'],
                        ['icon' => 'ki-chart-line-up', 'title' => 'Dashboard Analytics', 'desc' => 'Pantau penjualan dan performa secara real-time.'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300 group text-center">
                    <div class="size-16 rounded-2xl bg-gray-50 text-primary flex items-center justify-center mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                        <i class="ki-filled {{ $f['icon'] }} text-4xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $f['title'] }}</h4>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- =========================================
             3. REKOMENDASI BUKU (Restored Banner)
        ========================================== -->
        <div class="flex flex-col gap-6 mb-20">
            <div class="flex items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <div class="flex flex-col gap-1">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Rekomendasi Buku</h3>
                    <p class="text-gray-500 text-sm font-medium">Temukan buku pilihan terbaik berdasarkan minat dan tren.</p>
                </div>
                <a href="{{ route('catalog') }}" class="hidden sm:flex items-center gap-1 text-sm font-bold text-primary hover:underline">
                    Lihat Semua <i class="ki-filled ki-arrow-right text-base"></i>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <!-- Restored Side Banner -->
                <div class="w-full lg:w-[260px] flex-shrink-0 relative group">
                    <div class="absolute inset-0 bg-primary rounded-3xl rotate-2 group-hover:rotate-0 transition-transform duration-500 shadow-xl opacity-10"></div>
                    <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="Featured" class="relative w-full h-full object-cover rounded-3xl shadow-lg border border-white transform group-hover:-translate-y-2 transition-transform duration-500">
                </div>
                
                <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
                    @forelse ($recommendations as $book)
                        @include('landing.pages.home.partials.book-card', ['book' => $book])
                    @empty
                        <p class="col-span-full text-gray-400 font-medium text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200 italic">Belum ada rekomendasi buku.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- =========================================
             4. PAKET BUKU INDIVIDU (Light Gray Background)
        ========================================== -->
        <div class="mb-20 relative">
            <div class="absolute inset-y-0 -inset-x-4 sm:-inset-x-10 lg:-inset-x-20 bg-gray-100/70 rounded-[4rem] -z-10 overflow-hidden">
                <div class="absolute top-0 right-0 size-96 bg-primary/10 blur-[100px] rounded-full translate-x-1/3 -translate-y-1/3"></div>
                <div class="absolute bottom-0 left-0 size-96 bg-primary/5 blur-[80px] rounded-full -translate-x-1/3 translate-y-1/3"></div>
            </div>
            
            <div class="py-16 px-4">
                <div class="text-center mb-12">
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">Paket Penerbitan Individu</h3>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto font-medium">Wujudkan karya impian Anda dengan dukungan penerbitan profesional kelas dunia.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($individualPackages as $package)
                        <div class="bg-white border border-gray-200 rounded-[2.5rem] p-8 flex flex-col hover:border-primary/30 shadow-sm hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 group relative">
                            <div class="flex justify-between items-start mb-8">
                                <h4 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $package->name }}</h4>
                                <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">
                                    {{ $package->max_authors_default }} Penulis
                                </span>
                            </div>
                            
                            <div class="mb-8">
                                <span class="text-sm font-bold text-gray-400">Mulai dari</span>
                                <div class="text-3xl font-black text-primary tracking-tight mt-1">
                                    Rp{{ number_format($package->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <ul class="space-y-4 mb-10 flex-grow">
                                @foreach($package->benefits->take(5) as $benefit)
                                    <li class="flex items-start gap-3">
                                        <i class="ki-filled ki-check-circle text-green-500 text-xl"></i>
                                        <span class="text-sm font-medium text-gray-600 transition-colors">{{ $benefit->benefit_name }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ route('individual-books.purchase', $package) }}" class="w-full py-4 bg-primary text-white font-bold rounded-2xl text-center shadow-lg shadow-primary/20 hover:scale-[1.03] active:scale-95 transition-all">
                                Pilih Paket
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- =========================================
             5. BUKU TERBARU & TERLARIS (Restored Banners)
        ========================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
            <!-- Terbaru -->
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-5">
                    <h3 class="text-2xl font-black text-gray-900">Rilisan Terbaru</h3>
                    <a href="{{ route('catalog') }}" class="text-sm font-bold text-primary hover:underline">Semua</a>
                </div>
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-full sm:w-48 shrink-0">
                         <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="New" class="w-full h-full object-cover rounded-3xl shadow-md border-4 border-gray-50">
                    </div>
                    <div class="flex-grow grid grid-cols-2 gap-4">
                        @foreach ($latestBooks->take(4) as $book)
                            @include('landing.pages.home.partials.book-mini-card', ['book' => $book])
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Terlaris -->
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-5">
                    <h3 class="text-2xl font-black text-gray-900">Buku Terlaris</h3>
                    <a href="{{ route('catalog') }}" class="text-sm font-bold text-primary hover:underline">Semua</a>
                </div>
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-full sm:w-48 shrink-0">
                         <img src="https://www.bukuloka.com/_app/immutable/assets/new-release-1.quzve9Cc.png" alt="Best" class="w-full h-full object-cover rounded-3xl shadow-md border-4 border-gray-50">
                    </div>
                    <div class="flex-grow grid grid-cols-2 gap-4">
                        @foreach ($bestSellingBooks->take(4) as $book)
                            @include('landing.pages.home.partials.book-mini-card', ['book' => $book])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================
             6. BUKU KOLABORASI
        ========================================== -->
        <div class="flex flex-col gap-6 mb-16">
            <div class="flex items-end justify-between border-b border-gray-100 pb-5">
                <div class="flex flex-col gap-1">
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">Gabung Menulis Bersama</h3>
                    <p class="text-gray-500 text-sm font-medium">Buku kolaborasi yang sedang mencari penulis berbakat.</p>
                </div>
                <a href="{{ route('collaboration') }}" class="text-sm font-bold text-primary hover:underline whitespace-nowrap">
                    Lihat Semua <i class="ki-filled ki-arrow-right text-base"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
                @foreach ($books as $book)
                    @include('landing.pages.home.partials.collab-card', ['book' => $book])
                @endforeach
            </div>
        </div>

    </div>

    <!-- Restored & Enhanced CTA -->
    <section class="bg-gray-900 py-16 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_top_right,rgba(var(--primary-rgb),0.15),transparent_50%)]"></div>
        <div class="kt-container-fixed relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="text-center lg:text-left">
                    <h3 class="text-3xl font-black text-white mb-4 italic">Mendukung Perjalanan Literasimu.</h3>
                    <p class="text-gray-400 text-lg font-medium max-w-xl">Punya naskah yang ingin diterbitkan? Atau ingin berkolaborasi dengan komunitas kami? Hubungi tim kami sekarang.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://wa.me/6282333390205" target="_blank" class="px-10 py-5 bg-green-500 hover:bg-green-600 text-white font-black rounded-2xl shadow-2xl shadow-green-500/20 flex items-center gap-3 transition-all hover:scale-105">
                        <i class="ki-filled ki-whatsapp text-3xl"></i> Hubungi WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Style for animations -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
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