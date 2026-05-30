@extends('landing.layouts.app')

@section('title', 'Paket Buku Individu - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20 pt-10 lg:pt-20">
    <div class="kt-container-fixed">

        <!-- Header -->
        <div class="text-center max-w-[800px] mx-auto mb-16 px-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-black uppercase tracking-[0.2em] mb-6 animate-bounce-slow">
                <i class="ki-filled ki-crown text-base"></i> Paket Penerbitan
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-6 leading-tight">
                Pilih Paket Buku <span class="text-primary italic">Individu</span> Anda
            </h1>
            <p class="text-gray-500 text-lg font-medium leading-relaxed">
                Wujudkan karya impian Anda dengan dukungan penerbitan profesional. Pilih paket yang paling sesuai dengan visi dan jangkauan karya Anda.
            </p>
        </div>

        <!-- Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20 px-4">
            @forelse($packages as $package)
                <div class="bg-white border border-gray-100 rounded-[3rem] p-8 lg:p-10 flex flex-col shadow-sm hover:shadow-2xl hover:border-primary/30 transition-all duration-500 group relative overflow-hidden h-full">
                    <!-- Top Decor -->
                    <div class="absolute top-0 left-0 w-full h-2 bg-primary transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>

                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 group-hover:text-primary transition-colors">{{ $package->name }}</h3>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary rounded-lg text-[10px] font-black uppercase tracking-widest mt-2">
                                {{ $package->max_authors_default }} Penulis
                            </span>
                        </div>
                        @if($loop->iteration == 2)
                            <span class="px-4 py-1 bg-yellow-400 text-yellow-950 text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-yellow-400/20">Populer</span>
                        @endif
                    </div>

                    <div class="mb-10">
                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">Mulai Dari</span>
                        <div class="text-4xl font-black text-primary tracking-tight">
                            Rp{{ number_format($package->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="space-y-4 mb-12 flex-grow">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Keuntungan Paket:</p>
                        <ul class="flex flex-col gap-4">
                            @foreach($package->benefits as $benefit)
                                <li class="flex items-start gap-3 group/item">
                                    <div class="size-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center shrink-0 mt-0.5 group-hover/item:bg-green-500 group-hover/item:text-white transition-all">
                                        <i class="ki-filled ki-check text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm font-bold text-gray-700 block leading-tight">{{ $benefit->benefit_name }}</span>
                                        @if($benefit->benefit_value)
                                            <small class="text-[11px] text-gray-400 font-medium mt-0.5 block leading-none italic">{{ $benefit->benefit_value }}</small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ route('individual-books.purchase', $package) }}"
                       class="w-full py-4.5 bg-gray-900 text-white font-black rounded-2xl text-center shadow-xl hover:bg-primary transition-all flex items-center justify-center gap-2 group/btn">
                        <span>Pilih Paket Ini</span>
                        <i class="ki-filled ki-right text-xl group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
                    <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ki-filled ki-package text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada paket tersedia</h3>
                    <p class="text-gray-500 font-medium">Silakan hubungi admin kami untuk informasi lebih lanjut mengenai paket penerbitan.</p>
                </div>
            @endforelse
        </div>

        <!-- Trust Section -->
        <div class="bg-white border border-gray-100 rounded-[4rem] p-10 lg:p-20 shadow-xl shadow-gray-200/40 relative overflow-hidden">
            <!-- Ornaments -->
            <div class="absolute top-0 right-0 size-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-6 space-y-10 relative z-10">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-tight">
                        Mengapa Menerbitkan <br class="hidden sm:block"/> di <span class="text-primary underline decoration-primary/20">Daya Media?</span>
                    </h2>

                    <div class="space-y-8">
                        <div class="flex gap-5 group">
                            <div class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0 shadow-lg shadow-primary/5 group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                <i class="ki-filled ki-time text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Proses Cepat & Profesional</h4>
                                <p class="text-gray-500 text-sm font-medium leading-relaxed">Tim editorial berpengalaman kami akan membantu seluruh alur kerja penerbitan Anda dengan standar industri yang tinggi.</p>
                            </div>
                        </div>

                        <div class="flex gap-5 group">
                            <div class="size-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shrink-0 shadow-lg shadow-green-500/5 group-hover:bg-green-600 group-hover:text-white transition-all duration-500">
                                <i class="ki-filled ki-barcode text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">ISBN & Barcode Resmi</h4>
                                <p class="text-gray-500 text-sm font-medium leading-relaxed">Setiap naskah yang lolos kurasi akan mendapatkan nomor ISBN resmi dan barcode internasional untuk legalitas distribusi.</p>
                            </div>
                        </div>

                        <div class="flex gap-5 group">
                            <div class="size-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                <i class="ki-filled ki-geolocation text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Jangkauan Pemasaran Luas</h4>
                                <p class="text-gray-500 text-sm font-medium leading-relaxed">Buku Anda akan tersedia di berbagai toko buku digital ternama dan dapat dipesan dalam versi cetak ke seluruh penjuru negeri.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white group">
                        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800"
                             alt="Publishing Process" class="w-full h-auto group-hover:scale-110 transition-transform duration-[2s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>

                    <!-- Stats Float -->
                    <div class="absolute -bottom-10 -left-10 bg-white p-8 rounded-[2rem] shadow-2xl border border-gray-100 hidden sm:block animate-float">
                        <p class="text-primary font-black text-4xl mb-1 tracking-tighter">1000+</p>
                        <p class="text-gray-400 text-xs font-black uppercase tracking-widest">Karya Terbit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float { animation: float 5s ease-in-out infinite; }
</style>
@endsection
