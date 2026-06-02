<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Proyek Kolaborasi Saya</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $collaborators->total() }} Proyek
        </span>
    </div>

    @if($collaborators->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($collaborators as $module)
                @php $book = $module->book; @endphp
                @if($book)
                <div class="bg-white border border-gray-100 rounded-[2rem] p-5 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300 group flex gap-5 relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-950 text-[9px] font-black px-4 py-1 rounded-bl-xl z-10 shadow-sm uppercase tracking-widest">
                        Bab {{ $module->chapter }}
                    </div>

                    <!-- Cover -->
                    <div class="relative shrink-0 w-24 aspect-[3/4] rounded-xl overflow-hidden shadow-md border border-gray-50 mt-2">
                        <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/120x160?text=No+Cover' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $book->title }}">
                    </div>

                    <!-- Info -->
                    <div class="flex flex-col grow justify-between py-1 pt-4">
                        <div>
                            <span class="px-2 py-0.5 bg-primary/10 text-primary text-[9px] font-black uppercase tracking-widest rounded-md mb-2 inline-block">
                                {{ $book->category?->name ?? 'Kolaborasi' }}
                            </span>
                            <h4 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-primary transition-colors">{{ $book->title }}</h4>
                            <p class="text-[10px] text-gray-500 font-bold mt-2 flex items-center gap-1.5">
                                <i class="ki-filled ki-users text-sm"></i> Kontribusi Bab: {{ $module->title }}
                            </p>
                        </div>
                        
                        <a href="{{ route('collaborationDetail', $book->slug) }}" class="w-full py-2.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg hover:bg-black transition-all active:scale-95 mt-4 flex items-center justify-center gap-2">
                            <i class="ki-filled ki-eye text-base"></i> Detail Proyek
                        </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $collaborators->links('landing.partials.pagination') }}
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ki-filled ki-users text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Proyek Kolaborasi</h3>
            <p class="text-gray-500 font-medium max-w-sm mx-auto mb-8">Anda belum bergabung dalam proyek kolaborasi penulisan buku. Ayo bergabung dengan penulis lain!</p>
            <a href="{{ route('collaboration') }}" class="px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all text-sm uppercase tracking-widest">Cari Proyek Kolaborasi</a>
        </div>
    @endif
</div>
