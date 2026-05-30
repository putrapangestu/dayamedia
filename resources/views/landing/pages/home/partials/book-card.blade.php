<div class="bg-white border border-gray-100 rounded-2xl p-3 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 group flex flex-col h-full">
    <div class="relative bg-gray-50 rounded-xl overflow-hidden mb-4 aspect-[1/1.41] shadow-inner">
        <a href="{{ route('bookDetail', $book->slug) }}" class="block w-full h-full">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/400x600?text=No+Cover' }}" 
                 alt="{{ $book->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <div class="absolute inset-x-0 bottom-0 p-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 bg-gradient-to-t from-black/60 to-transparent flex justify-center text-white">
            <button class="add-to-cart-btn bg-primary hover:bg-primary-dark size-10 rounded-full flex items-center justify-center shadow-lg transform active:scale-95" data-book-id="{{ $book->id }}">
                <i class="ki-filled ki-handcart text-lg"></i>
            </button>
        </div>
    </div>
    <div class="flex flex-col flex-grow px-1">
        <a href="{{ route('bookDetail', $book->slug) }}" class="text-sm font-bold text-gray-900 leading-tight mb-1 group-hover:text-primary transition-colors line-clamp-2">
            {{ $book->title }}
        </a>
        <p class="text-[11px] text-gray-500 font-medium mb-3 line-clamp-1">
            @if ($book->authors->count() > 0)
                {{ $book->authors->count() > 1 ? $book->authors->first()->author ?? $book->authors->first()->user->full_name . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
            @else - @endif
        </p>
        <div class="mt-auto pt-3 border-t border-gray-50">
            @php
                $collectPrice = [$book->price_physical, $book->price_digital];
                $min = min($collectPrice);
                $max = max($collectPrice);
            @endphp
            <div class="flex flex-wrap items-baseline gap-1">
                <span class="text-sm font-black text-primary">Rp{{ number_format($min, 0, ',', '.') }}</span>
                @if($min != $max)
                    <span class="text-[10px] font-bold text-gray-400">- Rp{{ number_format($max, 0, ',', '.') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>