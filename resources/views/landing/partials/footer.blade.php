<footer class="relative overflow-hidden bg-[#111827] text-white">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/25 to-transparent"></div>
    <div class="absolute -right-24 -top-24 size-72 rounded-full bg-primary/20 blur-3xl"></div>
    <div class="absolute -left-24 bottom-0 size-72 rounded-full bg-emerald-400/10 blur-3xl"></div>

    <div class="kt-container-fixed relative z-10 py-12 lg:py-16">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="flex size-12 items-center justify-center rounded-2xl bg-white shadow-xl">
                        <img src="{{ asset('assets/azzia-logo.png') }}" alt="Daya Media" class="h-8 w-auto">
                    </span>
                    <span>
                        <span class="block text-xl font-black tracking-tight">Daya Media Nusantara</span>
                        <span class="block text-[10px] font-black uppercase tracking-[0.28em] text-white/45">Publishing Network</span>
                    </span>
                </a>
                <p class="mt-6 max-w-md text-sm font-medium leading-7 text-white/65">
                    Ruang penerbitan untuk penulis, akademisi, dan pembaca yang ingin mengelola karya buku digital maupun cetak dalam satu ekosistem.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('individual-books.packages') }}" class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-primary/20 transition-all hover:scale-[1.02]">
                        <i class="ki-filled ki-file-up"></i> Terbitkan Buku
                    </a>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 rounded-2xl border border-white/15 bg-white/5 px-5 py-3 text-xs font-black uppercase tracking-widest text-white transition-all hover:bg-white/10">
                        <i class="ki-filled ki-book"></i> Lihat Katalog
                    </a>
                </div>
            </div>

            <div class="lg:col-span-3">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Navigasi</h3>
                <nav class="mt-5 grid gap-3 text-sm font-bold text-white/70">
                    <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                    <a href="{{ route('catalog') }}" class="hover:text-white">Katalog Buku</a>
                    <a href="{{ route('collaboration') }}" class="hover:text-white">Buku Kolaborasi</a>
                    <a href="{{ route('publications') }}" class="hover:text-white">Publikasi</a>
                    <a href="{{ route('about') }}" class="hover:text-white">Tentang Kami</a>
                </nav>
            </div>

            <div class="lg:col-span-4">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Kontak Cepat</h3>
                <div class="mt-5 space-y-3">
                    <a href="https://wa.me/6281166012020" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition-all hover:bg-white/[0.07]">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-emerald-400/15 text-emerald-300">
                            <i class="ki-filled ki-whatsapp text-lg"></i>
                        </span>
                        <span>
                            <span class="block text-sm font-black">WhatsApp</span>
                            <span class="block text-xs font-medium text-white/50">Konsultasi penerbitan dan layanan buku</span>
                        </span>
                    </a>
                    <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-white/40">Member Area</p>
                        <p class="mt-1 text-sm font-bold text-white/75">Kelola transaksi, naskah, royalty, dan referral dari akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-white/10 pt-6 text-xs font-bold text-white/45 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ now()->year }} &copy; Daya Media Nusantara. All rights reserved.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-white">Daftar</a>
                <a href="{{ route('individual-books.packages') }}" class="hover:text-white">Paket Penerbitan</a>
            </div>
        </div>
    </div>
</footer>
