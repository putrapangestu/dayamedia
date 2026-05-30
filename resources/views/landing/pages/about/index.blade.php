@extends('landing.layouts.app')

@section('title', 'Tentang Kami - Daya Media')

@section('content')
<div class="bg-white overflow-hidden">
    
    <!-- =========================================
         1. HERO SECTION
    ========================================== -->
    <section class="relative py-20 lg:py-32 bg-gray-50/50">
        <!-- Ornaments -->
        <div class="absolute top-0 right-0 size-[500px] bg-primary/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 size-[400px] bg-secondary/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

        <div class="kt-container-fixed relative z-10">
            <div class="max-w-[800px] mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-black uppercase tracking-[0.2em] mb-8 animate-bounce-slow">
                    <i class="ki-filled ki-subtitle text-base"></i> Mengenal Daya Media
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight leading-[1.1] mb-8">
                    Membangun Masa Depan <br/>
                    <span class="text-primary italic underline decoration-primary/20">Literasi Indonesia</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-500 font-medium leading-relaxed">
                    Daya Media hadir sebagai jembatan bagi para penulis untuk melahirkan karya hebat dan bagi pembaca untuk menemukan jendela dunia baru melalui teknologi modern.
                </p>
            </div>
        </div>
    </section>

    <!-- =========================================
         2. COMPANY STORY
    ========================================== -->
    <section class="py-20 lg:py-32">
        <div class="kt-container-fixed">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-[3rem] overflow-hidden shadow-2xl border-8 border-gray-50 group">
                        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1470&auto=format&fit=crop" 
                             alt="Daya Media Culture" class="w-full h-auto transform group-hover:scale-110 transition-transform duration-[3s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent opacity-60"></div>
                    </div>
                    <!-- Decorative Box -->
                    <div class="absolute -bottom-10 -right-10 bg-primary p-8 rounded-[2.5rem] shadow-2xl hidden md:block animate-float">
                        <i class="ki-filled ki-quote text-white text-5xl opacity-20 absolute top-4 right-4"></i>
                        <p class="text-white font-bold italic text-lg relative z-10">"Karya tulis adalah abadi."</p>
                    </div>
                </div>

                <div class="lg:col-span-6 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Siapa Kami?</h2>
                        <div class="w-20 h-1.5 bg-primary rounded-full"></div>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed font-medium">
                        Didirikan dengan semangat untuk mendemokratisasi dunia penerbitan, Daya Media telah bertransformasi dari sebuah komunitas kecil penulis menjadi platform penerbitan digital dan cetak terpadu di Indonesia.
                    </p>
                    <p class="text-gray-500 leading-relaxed font-medium">
                        Kami percaya bahwa setiap orang memiliki cerita yang layak untuk dibagikan. Dengan mengintegrasikan sistem kolaborasi yang transparan dan teknologi distribusi yang canggih, kami memastikan setiap naskah mendapatkan apresiasi yang semestinya.
                    </p>
                    <div class="grid grid-cols-2 gap-8 pt-4">
                        <div class="space-y-1">
                            <p class="text-3xl font-black text-primary tracking-tighter">5th+</p>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tahun Pengalaman</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-3xl font-black text-primary tracking-tighter">10k+</p>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pembaca Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================
         3. VISION & MISSION (High Impact)
    ========================================== -->
    <section class="py-20 lg:py-32 bg-[#0F172A] relative overflow-hidden">
        <!-- Glows -->
        <div class="absolute top-0 left-0 size-96 bg-primary/20 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 size-96 bg-secondary/10 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>

        <div class="kt-container-fixed relative z-10 text-center">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Vision -->
                <div class="p-10 lg:p-16 bg-white/5 backdrop-blur-sm border border-white/10 rounded-[3rem] text-left group hover:bg-white/10 transition-all duration-500">
                    <div class="size-16 rounded-2xl bg-primary flex items-center justify-center mb-8 shadow-xl shadow-primary/20 group-hover:scale-110 transition-transform">
                        <i class="ki-filled ki-eye text-white text-4xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-6 tracking-tight">Visi Kami</h3>
                    <p class="text-gray-400 text-lg leading-relaxed font-medium">
                        Menjadi ekosistem penerbitan nomor satu di Indonesia yang memberdayakan penulis melalui inovasi teknologi dan aksesibilitas tanpa batas.
                    </p>
                </div>

                <!-- Mission -->
                <div class="p-10 lg:p-16 bg-white/5 backdrop-blur-sm border border-white/10 rounded-[3rem] text-left group hover:bg-white/10 transition-all duration-500">
                    <div class="size-16 rounded-2xl bg-secondary flex items-center justify-center mb-8 shadow-xl shadow-secondary/20 group-hover:scale-110 transition-transform">
                        <i class="ki-filled ki-rocket text-white text-4xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-6 tracking-tight">Misi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <i class="ki-filled ki-check text-primary text-xl mt-1"></i>
                            <span class="text-gray-400 font-medium">Menyediakan platform kolaborasi penulis yang transparan.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="ki-filled ki-check text-primary text-xl mt-1"></i>
                            <span class="text-gray-400 font-medium">Meningkatkan kualitas naskah melalui proses editorial profesional.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="ki-filled ki-check text-primary text-xl mt-1"></i>
                            <span class="text-gray-400 font-medium">Memperluas jangkauan distribusi buku fisik dan digital.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================
         4. CORE VALUES
    ========================================== -->
    <section class="py-20 lg:py-32">
        <div class="kt-container-fixed text-center">
            <div class="max-w-[700px] mx-auto mb-16 px-4">
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4 tracking-tight">Nilai-Nilai Utama Kami</h2>
                <p class="text-gray-500 font-medium">Budaya kerja dan prinsip yang mendasari setiap keputusan kami di Daya Media.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
                <!-- Value 1 -->
                <div class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 group">
                    <div class="size-20 rounded-full bg-white flex items-center justify-center mx-auto mb-8 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="ki-filled ki-shield-tick text-4xl text-primary"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Integritas</h4>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Kejujuran dan transparansi dalam pengelolaan royalti dan hak cipta penulis.</p>
                </div>

                <!-- Value 2 -->
                <div class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 group">
                    <div class="size-20 rounded-full bg-white flex items-center justify-center mx-auto mb-8 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="ki-filled ki-abstract-24 text-4xl text-primary"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h4>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Terus beradaptasi dengan teknologi terbaru untuk mempermudah akses literasi.</p>
                </div>

                <!-- Value 3 -->
                <div class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 group">
                    <div class="size-20 rounded-full bg-white flex items-center justify-center mx-auto mb-8 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="ki-filled ki-people text-4xl text-primary"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Kolaborasi</h4>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Membangun komunitas yang solid untuk menciptakan karya yang lebih berdampak.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================
         5. JOIN CTA
    ========================================== -->
    <section class="py-20 lg:py-32 bg-primary relative overflow-hidden">
        <div class="absolute top-0 right-0 size-96 bg-white/10 rounded-full blur-[100px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="kt-container-fixed relative z-10">
            <div class="bg-white/10 backdrop-blur-md rounded-[3rem] p-10 lg:p-20 border border-white/20 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tight">Siap Memulai Perjalanan <br/> Berkarya Anda?</h2>
                <p class="text-primary-light text-lg mb-10 max-w-2xl mx-auto font-medium opacity-90 italic">"Genggam duniamu dengan tulisan, tebarkan inspirasi dengan karya."</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-primary font-black rounded-2xl shadow-2xl hover:scale-105 active:scale-95 transition-all text-lg">Daftar Menjadi Penulis</a>
                    <a href="{{ route('catalog') }}" class="px-10 py-5 bg-transparent border-2 border-white/30 text-white font-black rounded-2xl hover:bg-white/10 transition-all text-lg flex items-center justify-center gap-2">Jelajahi Katalog <i class="ki-filled ki-right text-2xl"></i></a>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-bounce-slow { animation: bounce 3s infinite; }
</style>
@endsection
