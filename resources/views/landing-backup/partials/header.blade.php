

<header class="header_wrap fixed-top header_with_topbar">
    <div class="bottom_header dark_skin main_menu_uppercase">
    	<div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index-2.html">
                    <img class="logo_light" src="{{ asset('assets/azzia-logo.png') }}" alt="logo" />
                    <img class="logo_dark" src="{{ asset('assets/azzia-logo.png') }}" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li>
                            <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Tulis Buku</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="about.html">Buku Individu</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="{{ route('collaboration') }}">Buku Kolaborasi</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('catalog') }}" >Katalog</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Jasa</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="about.html">Konversi Karya Ilmiah</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="contact.html">Pengurusan HAKI</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="contact.html">Jasa Parafrase</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Tentang Kami</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="about.html">Tentang Kami</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="contact.html">Kebijakan Privasi</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="contact.html">Syarat & Ketentuan</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:;" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form>
                                <input type="text" placeholder="Search" class="form-control" id="search_input">
                                <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div><div class="search_overlay"></div><div class="search_overlay"></div>
                    </li>
                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-bs-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count">2</span></a>
                        <div class="cart_box dropdown-menu dropdown-menu-right">
                            <ul class="cart_list">
                                <li>
                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                    <a href="#"><img src="assets/images/cart_thamb1.jpg" alt="cart_thumb1">Variable product 001</a>
                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>78.00</span>
                                </li>
                                <li>
                                    <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                    <a href="#"><img src="assets/images/cart_thamb2.jpg" alt="cart_thumb2">Ornare sed consequat</a>
                                    <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>81.00</span>
                                </li>
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>159.00</p>
                                <p class="cart_buttons"><a href="#" class="btn btn-fill-line btn-radius view-cart">View Cart</a><a href="#" class="btn btn-fill-out btn-radius checkout">Checkout</a></p>
                            </div>
                        </div>
                    </li>
                    @if (Auth::user())
                        <li><a href="{{ route('member') }}" class="nav-link"><i class="linearicons-user"></i> Akun Saya</a>
                    @else
                        <li><a href="{{ route('login') }}" class="nav-link"><i class="linearicons-user"></i> Login</a>
                    @endif
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
