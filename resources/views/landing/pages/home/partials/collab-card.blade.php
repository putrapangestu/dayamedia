<div class="bg-white border border-gray-100 rounded-2xl p-3 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 flex flex-col h-full relative overflow-hidden group">
    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-950 text-[10px] font-black px-3 py-1 rounded-bl-xl z-10 shadow-sm flex items-center gap-1">
        <i class="ki-filled ki-users text-xs"></i> {{ $book->authors->count() }}/{{ $book->modules->count() }}
    </div>
    <div class="relative bg-gray-50 rounded-xl overflow-hidden mb-4 aspect-[1/1.41] shadow-inner mt-2">
        <a href="{{ route('collaborationDetail', $book->slug) }}" class="block w-full h-full">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/400x600?text=No+Cover' }}" 
                 alt="{{ $book->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
    </div>
    <div class="flex flex-col flex-grow px-1 text-center">
        <a href="{{ route('collaborationDetail', $book->slug) }}" class="text-sm font-bold text-gray-900 leading-tight mb-2 group-hover:text-primary transition-colors line-clamp-2">
            {{ $book->title }}
        </a>
        <div class="mt-auto pt-3 border-t border-gray-50 flex flex-col items-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Mulai Dari</p>
            @php
                $collectPrice = $book->modules->count() > 0 ? $book->modules->pluck('price')->toArray() : [0];
            @endphp
            <span class="text-sm font-black text-primary italic">Rp{{ number_format(min($collectPrice), 0, ',', '.') }}</span>
        </div>
    </div>
</div>