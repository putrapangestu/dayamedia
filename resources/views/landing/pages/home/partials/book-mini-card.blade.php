<div class="flex gap-4 items-center group p-2 hover:bg-gray-50 rounded-xl transition-colors">
    <div class="size-16 shrink-0 bg-gray-100 rounded-lg overflow-hidden shadow-sm">
        <a href="{{ route('bookDetail', $book->slug) }}">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/100x140?text=No+Cover' }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
        </a>
    </div>
    <div class="flex flex-col justify-center min-w-0">
        <a href="{{ route('bookDetail', $book->slug) }}" class="text-xs font-bold text-gray-900 line-clamp-2 group-hover:text-primary transition-colors leading-tight mb-1" title="{{ $book->title }}">
            {{ $book->title }}
        </a>
        <span class="text-[13px] font-black text-primary">
            Rp{{ number_format(min($book->price_physical, $book->price_digital), 0, ',', '.') }}
        </span>
    </div>
</div>