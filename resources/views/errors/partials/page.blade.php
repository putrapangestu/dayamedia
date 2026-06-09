@php
    $palette = [
        'amber' => [
            'surface' => 'bg-amber-50',
            'text' => 'text-amber-700',
            'border' => 'border-amber-200',
            'marker' => 'bg-amber-400',
        ],
        'blue' => [
            'surface' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'marker' => 'bg-blue-500',
        ],
        'rose' => [
            'surface' => 'bg-rose-50',
            'text' => 'text-rose-700',
            'border' => 'border-rose-200',
            'marker' => 'bg-rose-500',
        ],
    ];
    $theme = $palette[$tone ?? 'amber'] ?? $palette['amber'];
    $primaryAction = $primaryAction ?? [
        'label' => 'Ke Beranda',
        'url' => route('home'),
        'icon' => 'ki-home',
    ];
    $secondaryAction = $secondaryAction ?? [
        'label' => 'Lihat Katalog',
        'url' => route('catalog'),
        'icon' => 'ki-book-open',
    ];
@endphp

<section class="relative min-h-[calc(100vh-220px)] overflow-hidden bg-[#f7f9f8]">
    <div class="absolute inset-0 opacity-[0.55]" aria-hidden="true"
         style="background-image: linear-gradient(#dfe7e3 1px, transparent 1px), linear-gradient(90deg, #dfe7e3 1px, transparent 1px); background-size: 36px 36px;">
    </div>

    <div class="relative mx-auto flex min-h-[calc(100vh-220px)] w-full max-w-6xl items-center px-5 py-12 sm:px-8 lg:px-10">
        <div class="grid w-full items-center gap-10 lg:grid-cols-[0.82fr_1fr]">
            <div class="hidden lg:block">
                <div class="relative h-[420px] rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="absolute left-10 top-10 h-72 w-48 rotate-[-7deg] rounded-md border border-slate-200 bg-slate-50 shadow-xl"></div>
                    <div class="absolute left-24 top-20 h-72 w-48 rotate-[5deg] rounded-md border border-slate-200 bg-white shadow-xl">
                        <div class="h-10 border-b border-slate-200 {{ $theme['surface'] }}"></div>
                        <div class="space-y-3 p-7">
                            <div class="h-3 w-24 rounded-full bg-slate-200"></div>
                            <div class="h-3 w-32 rounded-full bg-slate-200"></div>
                            <div class="h-3 w-20 rounded-full bg-slate-200"></div>
                        </div>
                    </div>
                    <div class="absolute bottom-10 left-12 right-12 flex items-center justify-between border-t border-slate-200 pt-6">
                        <span class="text-[11px] font-black uppercase tracking-[0.28em] text-slate-400">Daya Media</span>
                        <span class="h-2 w-16 rounded-full {{ $theme['marker'] }}"></span>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-7 shadow-sm sm:p-10 lg:p-12">
                <a href="{{ route('home') }}" class="mb-10 inline-flex items-center">
                    <img src="{{ asset('assets/azzia-logo.png') }}" class="h-10 w-auto" alt="Daya Media">
                </a>

                <div class="mb-8 inline-flex items-center gap-3 rounded-full border px-4 py-2 {{ $theme['border'] }} {{ $theme['surface'] }} {{ $theme['text'] }}">
                    <i class="ki-filled {{ $icon ?? 'ki-information-2' }} text-lg"></i>
                    <span class="text-[11px] font-black uppercase tracking-[0.22em]">{{ $eyebrow }}</span>
                </div>

                <div class="mb-6 flex items-end gap-5">
                    <span class="text-7xl font-black leading-none text-slate-950 sm:text-8xl">{{ $statusCode }}</span>
                    <span class="mb-3 h-2 w-20 rounded-full {{ $theme['marker'] }}"></span>
                </div>

                <h1 class="max-w-2xl text-3xl font-black leading-tight text-slate-950 sm:text-5xl">{{ $title }}</h1>
                <p class="mt-5 max-w-xl text-base font-medium leading-8 text-slate-600 sm:text-lg">{{ $message }}</p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $primaryAction['url'] }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-950 px-6 py-4 text-sm font-black uppercase tracking-widest text-white transition hover:bg-slate-800">
                        <i class="ki-filled {{ $primaryAction['icon'] }}"></i>
                        {{ $primaryAction['label'] }}
                    </a>
                    <a href="{{ $secondaryAction['url'] }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-6 py-4 text-sm font-black uppercase tracking-widest text-slate-700 transition hover:border-slate-400">
                        <i class="ki-filled {{ $secondaryAction['icon'] }}"></i>
                        {{ $secondaryAction['label'] }}
                    </a>
                </div>

                <div class="mt-8 border-t border-slate-200 pt-5 text-sm font-semibold text-slate-500">
                    Butuh bantuan? <a href="https://wa.me/{{ getSetting('whatsapp_contact', '628123456789') }}" target="_blank" class="{{ $theme['text'] }} hover:underline">Hubungi admin</a>
                </div>
            </div>
        </div>
    </div>
</section>
