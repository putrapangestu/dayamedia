<aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ auth()->user()->hasRole('admin') ? route('admin.home') : route('home') }}" class="text-nowrap logo-img">
            <img src="{{ asset('') }}assets/azzia-logo.png" class="dark-logo" alt="Logo-Dark" />
            <img src="{{ asset('') }}assets/azzia-logo.png" class="light-logo" alt="Logo-light" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
            @role('admin')
            @php $menuState = getAdminMenuState(); @endphp
            <li class="sidebar-item {{ $menuState['dashboard'] }}">
              <a class="sidebar-link" href="{{ route('admin.home') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-home"></i>
                </span>
                <span class="hide-menu">Beranda</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['master_data'] }}">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Master Data</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item {{ isActiveRoute('admin.category.*') }}">
                  <a href="{{ route('admin.category.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Kategori</span>
                  </a>
                </li>
                <li class="sidebar-item {{ isActiveRoute('admin.individual-book-packages.*') }}">
                  <a href="{{ route('admin.individual-book-packages.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Paket Buku Individu</span>
                  </a>
                </li>
              </ul>
            </li>
            <!-- ---------------------------------- -->
            <!-- Home -->
            <!-- ---------------------------------- -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Affiliasi & Promo</span>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <li class="sidebar-item {{ $menuState['affiliate_level'] }}">
              <a class="sidebar-link" href="{{ route('admin.affiliate-order.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-binary-tree"></i>
                </span>
                <span class="hide-menu">Tingkatan Affiliate</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['promo'] }}">
              <a class="sidebar-link" href="{{ route('admin.promo.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-discount"></i>
                </span>
                <span class="hide-menu">Promo</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Buku, Member & Editor</span>
            </li>
            <li class="sidebar-item {{ $menuState['books'] }}">
              <a class="sidebar-link" href="{{ route('admin.book.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-books"></i>
                </span>
                <span class="hide-menu">Buku</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['members'] }}">
              <a class="sidebar-link" href="{{ route('admin.member.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Member</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['editor'] }}">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-edit"></i>
                </span>
                <span class="hide-menu">Editor</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item {{ isActiveRoute('admin.editor.*') }}">
                  <a href="{{ route('admin.editor.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Akun</span>
                  </a>
                </li>
                <li class="sidebar-item {{ isActiveRoute('admin.book-editor.claims') }}">
                  <a href="{{ route('admin.book-editor.claims') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Persetujuan Klaim</span>
                  </a>
                </li>
                <li class="sidebar-item {{ isActiveRoute('admin.book-editor.file-reviews') }}">
                  <a href="{{ route('admin.book-editor.file-reviews') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Review File Editor</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transaksi</span>
            </li>
            <li class="sidebar-item {{ $menuState['orders'] }}">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-shopping-cart"></i>
                </span>
                <span class="hide-menu">Order</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item {{ isActiveRoute('admin.book-order.*') }}">
                  <a href="{{ route('admin.book-order.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Penjualan Buku</span>
                  </a>
                </li>
                <li class="sidebar-item {{ isActiveRoute('admin.bab-order.*') }}">
                  <a href="{{ route('admin.bab-order.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Penjualan Bab</span>
                  </a>
                </li>
                <li class="sidebar-item {{ isActiveRoute('admin.individual-books.*') }}">
                  <a href="{{ route('admin.individual-books.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Buku Individu</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item {{ $menuState['affiliate'] }}">
              <a class="sidebar-link" href="{{ route('admin.affiliate.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-affiliate"></i>
                </span>
                <span class="hide-menu">Affiliate</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['withdrawal'] }}">
              <a class="sidebar-link" href="{{ route('admin.withdrawl.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-aperture"></i>
                </span>
                <span class="hide-menu">Withdrawl</span>
              </a>
            </li>
            {{-- <li class="sidebar-item">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-files"></i>
                </span>
                <span class="hide-menu">Laporan</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="../main/frontend-landingpage.html" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Homepage</span>
                  </a>
                </li>
              </ul>
            </li> --}}

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Pengaturan</span>
            </li>
            <li class="sidebar-item {{ $menuState['settings'] }}">
              <a class="sidebar-link" href="{{ route('settings.admin-fee') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-cash"></i>
                </span>
                <span class="hide-menu">Biaya Admin</span>
              </a>
            </li>
            <li class="sidebar-item {{ $menuState['settings'] }}">
              <a class="sidebar-link" href="{{ route('settings.documents') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-files"></i>
                </span>
                <span class="hide-menu">Dokumen</span>
              </a>
            </li>
            {{-- <li class="sidebar-item">
              <a class="sidebar-link" href="" aria-expanded="false">
                <span>
                  <i class="ti ti-photo"></i>
                </span>
                <span class="hide-menu">Banner Gambar</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="" aria-expanded="false">
                <span>
                  <i class="ti ti-messages"></i>
                </span>
                <span class="hide-menu">Testimoni</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-settings"></i>
                </span>
                <span class="hide-menu">Pengaturan</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="../main/frontend-landingpage.html" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                      <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Menu</span>
                  </a>
                </li>
              </ul> --}}
            </li>
            @endrole
            @role ('editor')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('editor.home') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-home"></i>
                </span>
                <span class="hide-menu">Beranda</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Editing</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('editor.book.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Buku</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Pengaturan</span>
            </li>
            @endrole

            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('settings.profile') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Profil Pengguna</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
