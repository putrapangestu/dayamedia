@extends('landing.layouts.app')

@section('content')
<div class="kt-container-fixed">

    <div class="flex flex-col items-stretch gap-7">

        {{-- Search + Filter Button (mobile) --}}
        <div class="flex items-center gap-3 w-full">
            <div class="kt-input w-full">
                <i class="ki-filled ki-magnifier"></i>
                <input placeholder="Cari buku atau penulis, penerbit, atau kategori..." type="text" name="search"/>
                <span class="kt-badge kt-badge-outline -me-1.5">⌘ K</span>
            </div>
            <button class="lg:hidden kt-btn kt-btn-primary" data-kt-drawer-toggle="#drawers_shop_filter">
                <i class="ki-filled ki-filter"></i>
                Filter
            </button>
        </div>

        {{-- Layout utama --}}
        <div class="flex gap-6 items-start">

            {{-- ===== SIDEBAR FILTER (desktop) ===== --}}
            <aside class="hidden lg:flex flex-col gap-4 w-[220px] shrink-0">

                {{-- Kategori --}}
                <div class="kt-card p-4 flex flex-col gap-3">
                    <span class="text-sm font-medium text-mono">Kategori</span>
                    <div class="flex flex-col gap-2">
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input class="kt-checkbox kt-checkbox-sm" type="checkbox" value="{{ $cat->id }}" name="category_id[]"/>
                                <span class="text-sm text-secondary-foreground group-hover:text-mono transition-colors">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Reset --}}
                <button class="kt-btn kt-btn-outline w-full">
                    <i class="ki-filled ki-arrows-circle"></i>
                    Reset Filter
                </button>

            </aside>
            {{-- ===== END SIDEBAR ===== --}}

            {{-- ===== KONTEN PRODUK ===== --}}
            <div class="flex flex-col gap-5 flex-1 min-w-0">

                {{-- Toolbar --}}
                <div class="flex flex-wrap items-center gap-3 justify-between">
                    <h3 class="text-sm text-mono font-medium">
                        1 - 10 dari <span class="text-destructive font-semibold">{{ $books->total() }} hasil</span> {{ request()->search ? 'untuk "'. request()->search . '"' : '' }}
                    </h3>
                    <div class="flex items-center gap-2.5">
                        <select class="kt-select w-[160px] bg-background" data-kt-select="true" name="sort">
                            <option selected value="price_high">Harga Tertinggi</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                        </select>
                        <div class="kt-toggle-group" data-kt-tabs="true">
                            <a class="kt-btn kt-btn-icon active" data-kt-tab-toggle="#shop1_grids" href="#">
                                <i class="ki-filled ki-category"></i>
                            </a>
                            <a class="kt-btn kt-btn-icon" data-kt-tab-toggle="#shop1_lists" href="#">
                                <i class="ki-filled ki-row-horizontal"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ===== GRID VIEW ===== --}}
                <div id="shop1_grids">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-2">

                        @forelse ($books as $book)
                            {{-- Card 1 --}}
                            <div class="kt-card">
                                <div class="kt-card-content flex flex-col justify-between p-2.5 gap-3">
                                    <div>
                                        {{-- Gambar --}}
                                        <div class="kt-card relative bg-accent/50 w-full mb-3 shadow-none overflow-hidden"
                                            data-kt-context-menu="true" data-kt-context-menu-trigger="true">
                                            <img
                                                alt=""
                                                class="w-full cursor-pointer object-cover block"
                                                style="aspect-ratio: 1 / 1.41;"
                                                data-kt-drawer-toggle="#drawers_shop_product_details"
                                                src="{{ asset('storage/'. $book->cover) }}"
                                            />
                                            <div class="kt-context-menu w-56 hidden" data-kt-context-menu-menu="true">
                                                <ul class="kt-context-menu-sub">
                                                    <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" data-kt-drawer-toggle="#drawers_shop_product_details" type="button">Quick View</button></li>
                                                    <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" data-kt-drawer-toggle="#drawers_shop_cart" type="button">Add to Cart</button></li>
                                                    <li class="kt-context-menu-separator"></li>
                                                    <li><button class="kt-context-menu-link" data-kt-context-menu-dismiss="true" type="button">Add to Wishlist</button></li>
                                                </ul>
                                            </div>
                                        </div>

                                        {{-- Judul 1 baris + elipsis --}}
                                        <a class="hover:text-primary text-sm font-medium text-mono px-2.5 block truncate"
                                            data-kt-drawer-toggle="#drawers_shop_product_details"
                                            title="{{ $book->title }}"
                                            href="#">
                                            {{ $book->title }}
                                        </a>

                                        {{-- Penulis --}}
                                        <p class="text-xs text-muted-foreground px-2.5 mt-0.5 truncate">
                                            @if ($book->authors->count() > 0)
                                                @php
                                                    $firstAuthor = $book->authors->first();
                                                    $firstName = $firstAuthor->author ?? ($firstAuthor->user->full_name ?? null);
                                                @endphp
                                                {{ $firstName }}{{ $book->authors->count() > 1 ? ', dkk.' : '' }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Harga + Tombol --}}
                                    <div class="flex flex-col gap-2 px-2.5 pb-1">
                                        {{-- Harga --}}
                                        <p class="text-sm font-semibold text-mono">
                                            Rp. {{ number_format($book->price_digital, 2, '.', ',') }}
                                            <span class="text-muted-foreground font-normal">-</span>
                                            Rp. {{ number_format($book->price_physical, 2, '.', ',') }}
                                        </p>

                                        {{-- Tombol --}}
                                        <div class="flex items-center gap-1.5">
                                            <a href="{{ route('bookDetail', $book->slug) }}"
                                                class="kt-btn kt-btn-outline kt-btn-sm flex-1"
                                                data-kt-drawer-toggle="#drawers_shop_product_details">
                                                <i class="ki-filled ki-eye"></i>
                                                Detail
                                            </a>
                                            <button
                                                class="kt-btn kt-btn-primary kt-btn-sm"
                                                data-kt-drawer-toggle="#drawers_shop_cart">
                                                <i class="ki-filled ki-handcart"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
                {{-- ===== END GRID VIEW ===== --}}

                {{-- ===== LIST VIEW ===== --}}
                <div class="hidden" id="shop1_lists">
                    <div class="grid grid-cols-1 gap-5">

                        @foreach($books as $book)
                        <div class="kt-card">
                            <div class="kt-card-content flex items-center justify-between p-3 gap-4">

                                {{-- Gambar --}}
                                <div class="kt-card shrink-0 bg-accent/50 shadow-none overflow-hidden"
                                    style="width: 60px; aspect-ratio: 1 / 1.41;">
                                    <img
                                        alt="img"
                                        class="w-full h-full object-cover cursor-pointer block"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        src="{{ asset('storage/'. $book->cover) }}"
                                    />
                                </div>

                                {{-- Info tengah --}}
                                <div class="flex flex-col gap-1 flex-1 min-w-0">

                                    {{-- Judul --}}
                                    <a class="hover:text-primary text-sm font-medium text-mono truncate block"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        title="{{ $book->title }}"
                                        href="#">
                                        {{ $book->title }}
                                    </a>

                                    {{-- Penulis --}}
                                    <p class="text-xs text-muted-foreground truncate">
                                        @if ($book->authors->count() > 0)
                                            @php
                                                $firstAuthor = $book->authors->first();
                                                $firstName = $firstAuthor->author ?? ($firstAuthor->user->full_name ?? null);
                                            @endphp
                                            {{ $firstName }}{{ $book->authors->count() > 1 ? ', dkk.' : '' }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                    {{-- Meta: SKU, Brand, Kategori --}}
                                    <div class="flex items-center flex-wrap gap-x-3 gap-y-0.5 mt-0.5">
                                        <span class="text-xs text-secondary-foreground">
                                            ISBN: <span class="font-medium text-foreground">{{ $book->code_isbn }}</span>
                                        </span>
                                        <span class="text-xs text-secondary-foreground">
                                            Bahasa: <span class="font-medium text-foreground">{{ $book->language }}</span>
                                        </span>
                                        <span class="text-xs text-secondary-foreground">
                                            Kategori: <span class="font-medium text-foreground">{{ $book->category->name }}</span>
                                        </span>
                                    </div>

                                </div>

                                {{-- Harga + Tombol --}}
                                <div class="flex flex-col items-end gap-2 shrink-0">

                                    {{-- Harga --}}
                                    <div class="flex flex-col items-end">
                                        {{-- @if($book->price_digital)
                                            <span class="text-xs text-secondary-foreground line-through">Rp.{{ number_format($book->price_digital, 2, '.', ',') }}</span>
                                        @endif --}}
                                        <span class="text-sm font-semibold text-mono">{{ number_format($book->price_digital, 2, '.', ',') }}</span>
                                        @if(isset($book->price_physical))
                                            <span class="text-xs text-muted-foreground">s/d Rp.{{ number_format($book->price_physical, 2, '.', ',') }}</span>
                                        @endif
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('bookDetail', $book->slug) }}"
                                            class="kt-btn kt-btn-outline kt-btn-sm"
                                            data-kt-drawer-toggle="#drawers_shop_product_details">
                                            <i class="ki-filled ki-eye"></i>
                                            Detail
                                        </a>
                                        <button type="button" class="kt-btn kt-btn-primary kt-btn-sm shrink-0"
                                            data-kt-drawer-toggle="#drawers_shop_cart">
                                            <i class="ki-filled ki-handcart"></i>
                                            Keranjang
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                {{-- ===== END LIST VIEW ===== --}}

                {{-- ===== PAGINATION ===== --}}
                <div class="mt-6">
                    {{ $books->links() }}
                </div>

            </div>
            {{-- ===== END KONTEN PRODUK ===== --}}

    </form>
    </div>
</div>

{{-- ===== DRAWER FILTER MOBILE ===== --}}
<form action="{{ url()->current() }}" method="GET" class="hidden kt-drawer kt-drawer-end card flex-col max-w-[90%] w-[320px] top-5 bottom-5 end-5 rounded-xl border border-border"
    data-kt-drawer="true" data-kt-drawer-container="body" id="drawers_shop_filter">
    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
    <div class="kt-card-header ps-5 pr-2">
        <h3 class="kt-card-title">Filter</h3>
        <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost shrink-0" data-kt-drawer-dismiss="true">
            <i class="ki-filled ki-cross text-base"></i>
        </button>
    </div>
    <div class="kt-card-content px-0 pt-3.5 kt-scrollable-y-auto">

        {{-- Status --}}
        <div class="flex items-center gap-1 px-5 mb-3">
            <span class="text-sm font-medium text-mono">Status</span>
        </div>
        <div class="px-5">
            <div class="kt-toggle-group flex">
                <label class="kt-btn">All <input name="filter-date-range" type="radio" value="all" /></label>
                <label class="kt-btn">Sale <input checked name="filter-date-range" type="radio" value="sale" /></label>
                <label class="kt-btn">New <input name="filter-date-range" type="radio" value="new" /></label>
                <label class="kt-btn">Trend <input name="filter-date-range" type="radio" value="trend" /></label>
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-5"></div>

        {{-- Harga --}}
        <div class="flex flex-col gap-2.5 px-5">
            <span class="text-sm font-medium text-mono">Harga</span>
            <div class="kt-input-group">
                <span class="kt-input-addon kt-input-addon-icon"><i class="ki-filled ki-dollar"></i></span>
                <input class="kt-input" placeholder="Min" type="number" value="60" />
            </div>
            <div class="kt-input-group">
                <span class="kt-input-addon kt-input-addon-icon"><i class="ki-filled ki-dollar"></i></span>
                <input class="kt-input" placeholder="Max" type="number" value="170" />
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-5"></div>

        {{-- Kategori --}}
        <div class="flex flex-col gap-3 px-5">
            <span class="text-sm font-medium text-mono">Kategori</span>
            <div class="flex flex-wrap gap-2.5 mb-2">
                @foreach($categories as $cat)
                <label class="cursor-pointer">
                    <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" class="hidden peer" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} />
                    <span class="kt-badge kt-badge-outline rounded-full peer-checked:bg-primary peer-checked:text-primary-foreground hover:bg-primary hover:text-primary-foreground transition-colors">{{ $cat->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-3"></div>

        {{-- Brand --}}
        <div class="flex flex-col gap-3 px-5">
            <span class="text-sm font-medium text-mono">Brand</span>
            <div class="flex flex-col gap-2">
                @foreach(['Nike','Adidas','Puma','New Balance','Reebok','Timberland','Vans'] as $brand)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input class="kt-checkbox kt-checkbox-sm" type="checkbox" value="{{ $brand }}" />
                    <span class="text-sm text-secondary-foreground">{{ $brand }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-5"></div>

        {{-- Ukuran --}}
        <div class="flex flex-col gap-3 px-5">
            <span class="text-sm font-medium text-mono">Ukuran</span>
            <div class="flex flex-wrap gap-1.5">
                @foreach(['36','37','38','39','40','41','42','43','44','45'] as $size)
                <label class="cursor-pointer">
                    <input class="hidden peer" name="size-mobile" type="checkbox" value="{{ $size }}" />
                    <span class="peer-checked:bg-primary peer-checked:text-primary-foreground peer-checked:border-primary flex items-center justify-center w-9 h-9 text-xs border border-border rounded-md hover:border-primary transition-colors">{{ $size }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-5"></div>

        {{-- Warna --}}
        <div class="flex flex-col gap-3 px-5">
            <span class="text-sm font-medium text-mono">Warna</span>
            <div class="flex flex-wrap gap-2">
                @foreach([
                    ['bg-zinc-900','Hitam'],
                    ['bg-white border border-border','Putih'],
                    ['bg-red-500','Merah'],
                    ['bg-blue-500','Biru'],
                    ['bg-green-500','Hijau'],
                    ['bg-yellow-400','Kuning'],
                    ['bg-gray-400','Abu-abu'],
                    ['bg-orange-500','Orange'],
                ] as [$bg, $label])
                <label class="cursor-pointer" title="{{ $label }}">
                    <input class="hidden peer" name="color-mobile" type="checkbox" value="{{ $label }}" />
                    <span class="block w-7 h-7 rounded-full {{ $bg }} peer-checked:ring-2 peer-checked:ring-primary ring-offset-2 ring-offset-background hover:ring-2 hover:ring-primary/50 transition-all"></span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="border-b border-border mb-4 mt-5"></div>

        {{-- Rating --}}
        <div class="flex flex-col gap-3 px-5 lg:mb-10">
            <span class="text-sm font-medium text-mono">Rating</span>
            <div class="flex flex-col gap-2.5">
                @foreach([5,4,3,2,1] as $star)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input {{ $star === 5 ? 'checked' : '' }} class="kt-checkbox kt-checkbox-sm" type="checkbox" value="{{ $star }}" />
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="ki-solid ki-star text-xs {{ $i <= $star ? 'text-yellow-400' : 'text-muted-foreground' }}"></i>
                        @endfor
                    </div>
                    <span class="text-xs text-secondary-foreground">& ke atas</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>
    <div class="kt-card-footer grid grid-cols-2 gap-2.5">
        <a href="{{ url()->current() }}" class="kt-btn kt-btn-outline flex items-center justify-center">Reset</a>
        <button type="submit" class="kt-btn kt-btn-primary">Terapkan</button>
    </div>
</form>
{{-- ===== END DRAWER FILTER MOBILE ===== --}}

@endsection

@push('scripts')
<script>
    function addToCart(bookId) {
        // Sesuaikan "/cart/add" dengan URL sebenarnya dari router CartController@addToCart.
        // Contoh: const url = "{{ route('cart.add') }}";
        const url = '/cart/add';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                book_id: bookId,
                quantity: 1,
                type: 'digital' // ubah jika ingin dynamic type (digital/physical)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message); // Bisa diubah menggunakan Library Toast/SweetAlert
            } else if (data.error) {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
