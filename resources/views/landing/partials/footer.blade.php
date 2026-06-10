@php
    $adminWhatsapp = collect(explode(',', (string) (function_exists('getSetting') ? getSetting('admin_whatsapp', '') : '')))
        ->map(fn ($number) => trim($number))
        ->filter()
        ->values();
    $primaryWhatsapp = $adminWhatsapp->first() ?: '6281166012020';
    $secondaryWhatsapp = $adminWhatsapp->get(1) ?: '6282333390206';
    $contactEmail = function_exists('getSetting')
        ? (getSetting('payment_confirmation_email', null) ?: config('mail.from.address', 'penerbit@azzia.id'))
        : config('mail.from.address', 'penerbit@azzia.id');
    $address = 'Jl Bulutangkis No 16, Kel Pasar Merah Barat, Kec Medan Kota, Kota Medan 20217';
    $services = [
        ['label' => 'Penerbitan Buku Individu', 'url' => route('individual-books.packages')],
        ['label' => 'Buku Kolaborasi', 'url' => route('collaboration')],
        ['label' => 'Katalog E-Book & Cetak', 'url' => route('catalog')],
        ['label' => 'Konversi Karya Ilmiah', 'url' => 'https://wa.me/' . $primaryWhatsapp],
        ['label' => 'Pengurusan HAKI', 'url' => 'https://wa.me/' . $primaryWhatsapp],
        ['label' => 'Jasa Parafrase', 'url' => 'https://wa.me/' . $primaryWhatsapp],
    ];
@endphp

<footer id="site-footer" class="relative overflow-hidden bg-gray-950 text-white" style="display:block; background:#0f172a; color:#fff;">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/25 to-transparent"></div>
    <div class="absolute -right-24 -top-24 size-72 rounded-full bg-primary/20 blur-3xl"></div>
    <div class="absolute -left-24 bottom-0 size-72 rounded-full bg-emerald-400/10 blur-3xl"></div>

    <div class="kt-container-fixed relative z-10 py-12 lg:py-16">
        <div class="mb-10 flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/10 p-5 sm:flex-row sm:items-center sm:justify-between" style="background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12);">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/45">Informasi Website</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-white">Daya Media Nusantara</h2>
                <p class="mt-1 text-sm font-bold text-white/60">Penerbitan buku, katalog digital, kolaborasi penulis, royalty, dan referral.</p>
            </div>
            <a href="https://wa.me/{{ $primaryWhatsapp }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-950 shadow-xl transition-all hover:scale-[1.02]" style="background:#fff; color:#111827;">
                <i class="ki-filled ki-whatsapp"></i> Hubungi Admin
            </a>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
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
                    Platform penerbitan untuk penulis, akademisi, dan pembaca. Kelola penerbitan, distribusi buku cetak, akses e-book, royalty, dan referral dalam satu member area.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('individual-books.packages') }}" class="inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-primary/20 transition-all hover:scale-[1.02]">
                        <i class="ki-filled ki-file-up"></i> Terbitkan Buku
                    </a>
                    <a href="https://wa.me/{{ $primaryWhatsapp }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-2xl border border-white/15 bg-white/5 px-5 py-3 text-xs font-black uppercase tracking-widest text-white transition-all hover:bg-white/10">
                        <i class="ki-filled ki-whatsapp"></i> Konsultasi
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Menu</h3>
                <nav class="mt-5 grid gap-3 text-sm font-bold text-white/70">
                    <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                    <a href="{{ route('catalog') }}" class="hover:text-white">Katalog Buku</a>
                    <a href="{{ route('publications') }}" class="hover:text-white">Publikasi</a>
                    <a href="{{ route('about') }}" class="hover:text-white">Tentang Kami</a>
                    <a href="{{ route('login') }}" class="hover:text-white">Member Area</a>
                </nav>
            </div>

            <div class="lg:col-span-3">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Layanan</h3>
                <nav class="mt-5 grid gap-3 text-sm font-bold text-white/70">
                    @foreach($services as $service)
                        <a href="{{ $service['url'] }}" class="hover:text-white" @if(str_starts_with($service['url'], 'http')) target="_blank" rel="noopener" @endif>
                            {{ $service['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="lg:col-span-3">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40">Kontak & Website</h3>
                <div class="mt-5 space-y-3">
                    <a href="https://wa.me/{{ $primaryWhatsapp }}" target="_blank" rel="noopener" class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition-all hover:bg-white/[0.07]">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-emerald-400/15 text-emerald-300">
                            <i class="ki-filled ki-whatsapp text-lg"></i>
                        </span>
                        <span>
                            <span class="block text-sm font-black">WhatsApp Admin</span>
                            <span class="block text-xs font-medium text-white/55">+{{ $primaryWhatsapp }}</span>
                            @if($secondaryWhatsapp)
                                <span class="block text-xs font-medium text-white/45">+{{ $secondaryWhatsapp }}</span>
                            @endif
                        </span>
                    </a>
                    <a href="mailto:{{ $contactEmail }}" class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition-all hover:bg-white/[0.07]">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sky-400/15 text-sky-300">
                            <i class="ki-filled ki-sms text-lg"></i>
                        </span>
                        <span>
                            <span class="block text-sm font-black">Email</span>
                            <span class="block break-all text-xs font-medium text-white/55">{{ $contactEmail }}</span>
                        </span>
                    </a>
                    <div class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-400/15 text-amber-300">
                            <i class="ki-filled ki-geolocation text-lg"></i>
                        </span>
                        <span>
                            <span class="block text-sm font-black">Alamat</span>
                            <span class="block text-xs font-medium leading-5 text-white/55">{{ $address }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 grid gap-4 rounded-[2rem] border border-white/10 bg-white/[0.03] p-5 sm:grid-cols-3">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/35">Untuk Penulis</p>
                <p class="mt-1 text-sm font-bold text-white/70">Penerbitan, ISBN, editorial, royalty, dan distribusi.</p>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/35">Untuk Pembaca</p>
                <p class="mt-1 text-sm font-bold text-white/70">Akses e-book, buku cetak, preview, dan koleksi pribadi.</p>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/35">Untuk Affiliate</p>
                <p class="mt-1 text-sm font-bold text-white/70">Referral link, komisi, riwayat transaksi, dan withdraw.</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-white/10 pt-6 text-xs font-bold text-white/45 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ now()->year }} &copy; Daya Media Nusantara. All rights reserved.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-white">Daftar</a>
                <a href="{{ route('individual-books.packages') }}" class="hover:text-white">Paket Penerbitan</a>
                {{-- <a href="https://azzia.id/" target="_blank" rel="noopener" class="hover:text-white">Azzia.id</a> --}}
            </div>
        </div>
    </div>
</footer>
