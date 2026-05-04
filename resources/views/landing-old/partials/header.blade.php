<header class="header-fp p-0 w-100">
    <nav class="navbar navbar-expand-lg bg-primary-subtle py-2 py-lg-10" style="padding: 18px 0!important;">
      <div class="custom-container d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="text-nowrap logo-img">
          <img src="{{ asset('') }}assets/azzia-logo.png" class="dark-logo" alt="Logo-Dark" />
          <img src="{{ asset('') }}assets/azzia-logo.png" class="light-logo" alt="Logo-light" />
        </a>
        <button class="navbar-toggler border-0 p-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
          <i class="ti ti-menu-2 fs-8"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 gap-xl-7 gap-8 mb-lg-0">
            <li class="nav-item nav-icon-hover-bg rounded w-auto">
              <a class="nav-link fs-4 fw-bold text-dark link-primary {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="nav-item nav-icon-hover-bg rounded w-auto">
              <a class="nav-link fs-4 fw-bold text-dark link-primary {{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">Katalog</a>
            </li>
            <li class="nav-item nav-icon-hover-bg rounded w-auto dropdown d-none d-sm-block mx-0">
                <div class="hover-dd" style="width: fit-content!important;">
                  <a class="nav-link fs-4 fw-bold text-dark link-primary {{ request()->routeIs('collaboration') ? 'active' : '' }}" href="javascript:void(0)">
                      Tulis Buku<span class="mt-1">
                      <i class="ti ti-chevron-down fs-3"></i>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0" style="min-width: 12rem!important;">
                    <div class="position-relative p-7 border-start">
                          <ul class="">
                            <li class="mb-3">
                              <a class="bg-hover-primary {{ request()->routeIs('individual-books.packages') ? 'text-primary fw-bold' : '' }}" href="{{ route('individual-books.packages') }}">Buku Individu</a>
                            </li>
                            <li class="mb-3">
                              <a class="bg-hover-primary {{ request()->routeIs('collaboration') ? 'text-primary fw-bold' : '' }}" href="{{ route('collaboration') }}">Buku Kolaborasi</a>
                            </li>
                          </ul>
                        </div>
                  </div>
                </div>
            </li>
            <li class="nav-item nav-icon-hover-bg rounded w-auto dropdown d-none d-sm-block mx-0">
                <div class="hover-dd" style="width: fit-content!important;">
                  <a class="nav-link" href="javascript:void(0)">
                      Jasa<span class="mt-1">
                      <i class="ti ti-chevron-down fs-3"></i>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0" style="min-width: 12rem!important;">
                    <div class="position-relative p-7 border-start">
                          <ul class="">
                            <li class="mb-3">
                              <a class="bg-hover-primary" href="https://wa.me/6282333390205" target="_blank">Konversi Karya Ilmiah</a>
                            </li>
                            <li class="mb-3">
                              <a class="bg-hover-primary" href="https://wa.me/6282333390205" target="_blank">Pengurusan HAKI</a>
                            </li>
                            <li class="mb-3">
                              <a class="bg-hover-primary" href="https://wa.me/6282333390205" target="_blank">Jasa Parafrase</a>
                            </li>
                          </ul>
                        </div>
                  </div>
                </div>
            </li>
            <li class="nav-item nav-icon-hover-bg rounded w-auto">
              <a class="nav-link fs-4 fw-bold text-dark link-primary {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
            </li>
          </ul>

          <div class="d-flex align-items-center gap-2">
            @if (auth()->check())
                <!-- Keranjang Icon -->
                <a href="{{ route('cart') }}" class="btn btn-light-primary rounded-circle d-flex align-items-center justify-content-center position-relative" style="width: 42px; height: 42px;">
                  <i class="ti ti-shopping-cart fs-6"></i>
                  @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                      {{ $cartCount }}
                    </span>
                  @endif
                </a>

                <!-- User Dropdown -->
                <div class="dropdown ms-2">
                  <div class="user-profile-img" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('') }}assets/dashboard/images/profile/user-1.jpg" class="rounded-circle" width="35" height="35" alt="modernize-img">
                  </div>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="userDropdown" style="min-width: 200px;">
                    <li class="px-3 py-2 border-bottom">
                      <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light-primary d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                          <img src="{{ asset('') }}assets/dashboard/images/profile/user-1.jpg" class="rounded-circle" width="35" height="35" alt="modernize-img">
                        </div>
                        <div>
                          <h6 class="mb-0 fs-4 fw-bolder">{{ auth()->user()->full_name }}</h6>
                          <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                      </div>
                    </li>
                    @role('member')
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('member') }}">
                                <i class="ti ti-user-circle fs-5"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('cart') }}">
                                <i class="ti ti-shopping-cart fs-5"></i>
                                <span>Pesanan Saya</span>
                            </a>
                        </li>
                    @endrole
                    @role('admin')
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.home') }}">
                                <i class="ti ti-activity fs-5"></i>
                                <span>Dashboard Admin</span>
                            </a>
                        </li>
                    @endrole
                    @role('editor')
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('editor.home') }}">
                                <i class="ti ti-activity fs-5"></i>
                                <span>Dashboard Editor</span>
                            </a>
                        </li>
                    @endrole
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                          <i class="ti ti-logout fs-5"></i>
                          <span>Keluar</span>
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary py-8 px-9">Masuk</a>
              <a href="{{ route('register') }}" class="btn bg-primary-subtle text-primary py-8 px-9">Daftar</a>
            @endif
          </div>
        </div>
      </div>
    </nav>
  </header>

