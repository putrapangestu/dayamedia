<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
      <a href="{{ route('home') }}">
        <img src="{{ asset('') }}assets/azzia-logo.png" alt="Logo" height="40" />
      </a>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="list-unstyled ps-0">
        <!-- Beranda -->
        <li class="mb-2">
          <a href="{{ route('home') }}" class="px-0 fs-4 d-block text-dark link-primary w-100 py-2 fw-semibold">
            <i class="ti ti-home me-2"></i> Beranda
          </a>
        </li>

        <!-- Katalog -->
        <li class="mb-2">
          <a href="{{ route('catalog') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary fw-semibold">
            <i class="ti ti-books me-2"></i> Katalog
          </a>
        </li>

        <!-- Tulis Buku (Accordion) -->
        <li class="mb-2">
          <button class="btn btn-toggle d-flex align-items-center w-100 text-start px-0 fs-4 fw-semibold text-dark border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#tulisBukuCollapse" aria-expanded="false">
            <i class="ti ti-pencil me-2"></i> Tulis Buku
            <i class="ti ti-chevron-down ms-auto fs-3"></i>
          </button>
          <div class="collapse" id="tulisBukuCollapse">
            <ul class="list-unstyled ps-4 mt-2">
              <li class="mb-2">
                <a href="{{ route('individual-books.packages') }}" class="text-dark link-primary d-block py-1 {{ request()->routeIs('individual-books.packages') ? 'text-primary fw-bold' : '' }}">
                  Buku Individu
                </a>
              </li>
              <li class="mb-2">
                <a href="{{ route('collaboration') }}" class="text-dark link-primary d-block py-1 {{ request()->routeIs('collaboration') ? 'text-primary fw-bold' : '' }}">
                  Buku Kolaborasi
                </a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Jasa (Accordion) -->
        <li class="mb-2">
          <button class="btn btn-toggle d-flex align-items-center w-100 text-start px-0 fs-4 fw-semibold text-dark border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#jasaCollapse" aria-expanded="false">
            <i class="ti ti-briefcase me-2"></i> Jasa
            <i class="ti ti-chevron-down ms-auto fs-3"></i>
          </button>
          <div class="collapse" id="jasaCollapse">
            <ul class="list-unstyled ps-4 mt-2">
              <li class="mb-2">
                <a href="https://wa.me/6282333390205" target="_blank" class="text-dark link-primary d-block py-1">
                  Konversi Karya Ilmiah
                </a>
              </li>
              <li class="mb-2">
                <a href="https://wa.me/6282333390205" target="_blank" class="text-dark link-primary d-block py-1">
                  Pengurusan HAKI
                </a>
              </li>
              <li class="mb-2">
                <a href="https://wa.me/6282333390205" target="_blank" class="text-dark link-primary d-block py-1">
                  Jasa Parafrase
                </a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Tentang Kami -->
        <li class="mb-2">
          <a href="{{ route('about') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary fw-semibold">
            <i class="ti ti-info-circle me-2"></i> Tentang Kami
          </a>
        </li>

        @if (auth()->check())
          <!-- Divider untuk user yang login -->
          <li><hr class="my-3"></li>

          <!-- User Profile Info -->
          <li class="mb-3">
            <div class="d-flex align-items-center px-0 py-2">
              <img src="{{ asset('') }}assets/dashboard/images/profile/user-1.jpg" class="rounded-circle me-2" width="40" height="40" alt="User">
              <div>
                <h6 class="mb-0 fs-4 fw-bold">{{ auth()->user()->full_name }}</h6>
                <small class="text-muted">{{ auth()->user()->email }}</small>
              </div>
            </div>
          </li>

          <!-- Keranjang -->
          <li class="mb-2">
            <a href="{{ route('cart') }}" class="px-0 fs-4 d-flex align-items-center w-100 py-2 text-dark link-primary">
              <i class="ti ti-shopping-cart me-2"></i> Keranjang
              @if($cartCount > 0)
                <span class="badge bg-danger ms-auto">{{ $cartCount }}</span>
              @endif
            </a>
          </li>

          @role('member')
            <!-- Profil -->
            <li class="mb-2">
                <a href="{{ route('member') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">
                <i class="ti ti-user-circle me-2"></i> Profil Saya
                </a>
            </li>

            <!-- Pesanan -->
            <li class="mb-2">
                <a href="{{ route('cart') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">
                <i class="ti ti-shopping-bag me-2"></i> Pesanan Saya
                </a>
            </li>
          @endrole
          @role('admin')
            <!-- Dashboard Admin -->
            <li class="mb-2">
                <a href="{{ route('admin.home') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">
                <i class="ti ti-activity me-2"></i> Dashboard Admin
                </a>
            </li>
          @endrole
          @role('editor')
            <!-- Dashboard Editor -->
            <li class="mb-2">
                <a href="{{ route('editor.home') }}" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">
                <i class="ti ti-activity me-2"></i> Dashboard Editor
                </a>
            </li>
          @endrole

          <!-- Logout -->
          <li class="mt-3">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="ti ti-logout"></i> Keluar
              </button>
            </form>
          </li>
        @else
          <!-- Login Button untuk user yang belum login -->
          <li class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
              <i class="ti ti-login"></i> Log In
            </a>
          </li>
        @endif
      </ul>
    </div>
  </div>

<style>
/* Offcanvas accordion chevron animation */
.btn-toggle[aria-expanded="true"] .ti-chevron-down {
  transform: rotate(180deg);
  transition: transform 0.3s ease;
}

.btn-toggle .ti-chevron-down {
  transition: transform 0.3s ease;
}

/* Hover effect untuk link di offcanvas */
.offcanvas-body a:hover {
  background-color: rgba(var(--bs-primary-rgb), 0.1);
  border-radius: 6px;
  padding-left: 8px;
  transition: all 0.2s ease;
}

.offcanvas-body .collapse a:hover {
  background-color: rgba(var(--bs-primary-rgb), 0.05);
}
</style>
