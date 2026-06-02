<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Koleksi Buku Saya</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $bookHistories->total() }} Buku
        </span>
    </div>

    @if($bookHistories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($bookHistories as $history)
                @php $book = $history->book; @endphp
                @if($book)
                <div class="bg-white border border-gray-100 rounded-[2rem] p-5 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300 group flex gap-5">
                    <!-- Cover -->
                    <div class="relative shrink-0 w-24 aspect-[3/4] rounded-xl overflow-hidden shadow-md border border-gray-50">
                        <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://placehold.co/120x160?text=No+Cover' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $book->title }}">
                    </div>

                    <!-- Info -->
                    <div class="flex flex-col grow justify-between py-1">
                        <div>
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-400 text-[9px] font-black uppercase tracking-widest rounded-md mb-2 inline-block italic">
                                {{ $book->category?->name ?? 'Umum' }}
                            </span>
                            <h4 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-primary transition-colors">{{ $book->title }}</h4>
                            <p class="text-[10px] text-gray-400 font-medium mt-1 line-clamp-1">
                                @if ($book->authors->count() > 0)
                                    {{ $book->authors->count() > 1 ? $book->authors->first()->author ?? $book->authors->first()->user->full_name . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
                                @else - @endif
                            </p>
                        </div>
                        
                        <a href="{{ route('book.read', $book->slug) }}" class="w-full py-2.5 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 flex items-center justify-center gap-2 hover:bg-primary-dark transition-all active:scale-95 mt-3">
                            <i class="ki-filled ki-book-open text-base"></i> Baca Sekarang
                        </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $bookHistories->links('vendor.pagination.landing-pagination') }}
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ki-filled ki-book text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Koleksi Anda Kosong</h3>
            <p class="text-gray-500 font-medium max-w-sm mx-auto mb-8">Anda belum memiliki buku dalam koleksi. Ayo jelajahi katalog kami dan temukan bacaan menarik!</p>
            <a href="{{ route('catalog') }}" class="px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all">Jelajahi Katalog</a>
        </div>
    @endif
</div>
