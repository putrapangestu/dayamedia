@extends('landing.layouts.app')

@section('content')
<div class="kt-container-fixed">

    <div class="flex flex-col items-stretch gap-7">

        {{-- Search + Filter Button (mobile) --}}
        <div class="flex items-center gap-3 w-full">
            <div class="kt-input w-full">
                <i class="ki-filled ki-magnifier"></i>
                <input placeholder="Cari produk..." type="text" value="Nike" />
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
                        @foreach(['Sneakers','Running Shoes','Boots','Golf','Sandals','Work Shoes','Casual Wear','Outdoor Gear','Sportswear','Basketball','Loafers','Winter'] as $cat)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="kt-checkbox kt-checkbox-sm" type="checkbox" value="{{ $cat }}" />
                            <span class="text-sm text-secondary-foreground group-hover:text-mono transition-colors">{{ $cat }}</span>
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
                        1 - 12 dari <span class="text-destructive font-semibold">280 hasil</span> untuk "Nike"
                    </h3>
                    <div class="flex items-center gap-2.5">
                        <select class="kt-select w-[160px] bg-background" data-kt-select="true">
                            <option selected value="1">Harga Tertinggi</option>
                            <option value="2">Harga Terendah</option>
                            <option value="3">Rating Tertinggi</option>
                            <option value="4">Terbaru</option>
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

                        @for ($i = 1; $i <= 12; $i++)
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
                                            src="https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg"
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
                                        title="Cloud Shift Lightweight Runner Pro Edition"
                                        href="#">
                                        Cloud Shift Lightweight Runner Pro Edition
                                    </a>

                                    {{-- Penulis --}}
                                    <p class="text-xs text-muted-foreground px-2.5 mt-0.5 truncate">
                                        Penulis 0/13
                                    </p>
                                </div>

                                {{-- Harga + Tombol --}}
                                <div class="flex flex-col gap-2 px-2.5 pb-1">
                                    {{-- Harga --}}
                                    <p class="text-sm font-semibold text-mono">
                                        Rp10.000
                                        <span class="text-muted-foreground font-normal">-</span>
                                        Rp15.000
                                    </p>

                                    {{-- Tombol --}}
                                    <div class="flex items-center gap-1.5">
                                        <a href="#"
                                            class="kt-btn kt-btn-outline kt-btn-sm flex-1"
                                            data-kt-drawer-toggle="#drawers_shop_product_details">
                                            <i class="ki-filled ki-eye"></i>
                                            Detail
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                {{-- ===== END GRID VIEW ===== --}}

                {{-- ===== LIST VIEW ===== --}}
                <div class="hidden" id="shop1_lists">
                    <div class="grid grid-cols-1 gap-5">

                        @php
                        $listProducts = [
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Cloud Shift Lightweight Runner Pro Edition','rating'=>'5.0','sku'=>'SH-001-BLK-42','brand'=>'Nike','cat'=>'Sneakers','old'=>'','price'=>'$99.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Titan Edge High Impact Stability Lightweight Trainers','rating'=>'3.5','sku'=>'SNK-XY-WHT-10','brand'=>'Adidas','cat'=>'Running Shoes','old'=>'','price'=>'$65.99'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Wave Strike Dynamic Boost Sneaker','rating'=>'4.7','sku'=>'BT-A1-YLW-8','brand'=>'Timberland','cat'=>'Boots','old'=>'','price'=>'$120.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Wave Strike Dynamic Boost Sneaker','rating'=>'3.2','sku'=>'SD-Z9-BRN-39','brand'=>'Birkenstock','cat'=>'Sandals','old'=>'$179.00','price'=>'$140.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Cloud Shift Lightweight Runner Pro Edition','rating'=>'4.1','sku'=>'WRK-77-BLK-9','brand'=>'Dr. Martens','cat'=>'Work Shoes','old'=>'$140.00','price'=>'$99.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Titan Edge High Impact Stability Lightweight Trainers','rating'=>'3.5','sku'=>'SNK-555-GRY-11','brand'=>'New Balance','cat'=>'Sneakers','old'=>'','price'=>'$65.99'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Velocity Boost Xtreme High Shock Absorbers','rating'=>'4.9','sku'=>'BT-777-BLK-9','brand'=>'UGG','cat'=>'Boots','old'=>'','price'=>'$110.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Wave Strike Dynamic Boost Sneaker','rating'=>'4.7','sku'=>'BT-A1-YLW-8','brand'=>'Timberland','cat'=>'Boots','old'=>'','price'=>'$120.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Titan Edge High Impact Stability Lightweight Trainers','rating'=>'3.5','sku'=>'WRK-333-GRN-10','brand'=>'Caterpillar','cat'=>'Work Shoes','old'=>'$110.00','price'=>'$46.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Wave Strike Dynamic Boost Sneaker','rating'=>'4.7','sku'=>'SNK-888-RED-42','brand'=>'Reebok','cat'=>'Sneakers','old'=>'','price'=>'$120.00'],
                            ['img'=>'https://azzia.id/storage/book/cover/tR5UGfQnem2mthYFC1LkVjXHOAs6exhKUAdrpt4L.jpg','name'=>'Velocity Boost Xtreme High Shock Absorbers','rating'=>'4.9','sku'=>'BT-444-BRN-7','brand'=>'Columbia','cat'=>'Hiking Boots','old'=>'','price'=>'$110.00'],
                        ];
                        @endphp

                        @foreach($listProducts as $p)
                        <div class="kt-card">
                            <div class="kt-card-content flex items-center justify-between p-3 gap-4">

                                {{-- Gambar --}}
                                <div class="kt-card shrink-0 bg-accent/50 shadow-none overflow-hidden"
                                    style="width: 60px; aspect-ratio: 1 / 1.41;">
                                    <img
                                        alt="img"
                                        class="w-full h-full object-cover cursor-pointer block"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        src="{{ $p['img'] }}"
                                    />
                                </div>

                                {{-- Info tengah --}}
                                <div class="flex flex-col gap-1 flex-1 min-w-0">

                                    {{-- Judul --}}
                                    <a class="hover:text-primary text-sm font-medium text-mono truncate block"
                                        data-kt-drawer-toggle="#drawers_shop_product_details"
                                        title="{{ $p['name'] }}"
                                        href="#">
                                        {{ $p['name'] }}
                                    </a>

                                    {{-- Penulis --}}
                                    <p class="text-xs text-muted-foreground truncate">
                                        @php $authors = ['Budi Santoso', 'Rina Marlina', 'Ahmad Fauzi']; @endphp
                                        {{ $authors[0] }}{{ count($authors) > 1 ? ', dkk' : '' }}
                                    </p>

                                    {{-- Meta: SKU, Brand, Kategori --}}
                                    <div class="flex items-center flex-wrap gap-x-3 gap-y-0.5 mt-0.5">
                                        <span class="text-xs text-secondary-foreground">
                                            SKU: <span class="font-medium text-foreground">{{ $p['sku'] }}</span>
                                        </span>
                                        <span class="text-xs text-secondary-foreground">
                                            Brand: <span class="font-medium text-foreground">{{ $p['brand'] }}</span>
                                        </span>
                                        <span class="text-xs text-secondary-foreground">
                                            Kategori: <span class="font-medium text-foreground">{{ $p['cat'] }}</span>
                                        </span>
                                    </div>

                                </div>

                                {{-- Harga + Tombol --}}
                                <div class="flex flex-col items-end gap-2 shrink-0">

                                    {{-- Harga --}}
                                    <div class="flex flex-col items-end">
                                        @if($p['old'])
                                        <span class="text-xs text-secondary-foreground line-through">{{ $p['old'] }}</span>
                                        @endif
                                        <span class="text-sm font-semibold text-mono">{{ $p['price'] }}</span>
                                        @if(isset($p['price_max']))
                                        <span class="text-xs text-muted-foreground">s/d {{ $p['price_max'] }}</span>
                                        @endif
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="flex items-center gap-1.5">
                                        <a href="#"
                                            class="kt-btn kt-btn-outline kt-btn-sm"
                                            data-kt-drawer-toggle="#drawers_shop_product_details">
                                            <i class="ki-filled ki-eye"></i>
                                            Detail
                                        </a>
                                        <button class="kt-btn kt-btn-primary kt-btn-sm shrink-0"
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

            </div>
            {{-- ===== END KONTEN PRODUK ===== --}}

        </div>
    </div>
</div>

{{-- ===== DRAWER FILTER MOBILE ===== --}}
<div class="hidden kt-drawer kt-drawer-end card flex-col max-w-[90%] w-[320px] top-5 bottom-5 end-5 rounded-xl border border-border"
    data-kt-drawer="true" data-kt-drawer-container="body" id="drawers_shop_filter">
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
                @foreach(['Sneakers','Running Shoes','Boots','Golf','Sandals','Work Shoes','Casual Wear','Outdoor Gear','Sportswear','Chelsea Boots','Loafers','Slip-On','Winter','Espadrilles','Basketball'] as $cat)
                <span class="kt-badge kt-badge-outline rounded-full cursor-pointer hover:bg-primary hover:text-primary-foreground transition-colors">{{ $cat }}</span>
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
        <button class="kt-btn kt-btn-outline">Reset</button>
        <button class="kt-btn kt-btn-primary">Terapkan</button>
    </div>
</div>
{{-- ===== END DRAWER FILTER MOBILE ===== --}}

@endsection
