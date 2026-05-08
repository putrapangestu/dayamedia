<footer class="bg-light pt-9 pb-7 border-top">
    <div class="container-fluid px-4">
      <div class="row g-4">
        <!-- Brand Section -->
        <div class="col-lg-4 col-md-6">
          <div class="mb-4">
            <img src="{{ asset('') }}assets/azzia-logo.png" alt="Azzia Logo" class="mb-3" style="max-height: 50px;">
            <p class="text-muted pe-lg-5 fs-3">
              Azzia adalah platform penerbitan yang berfokus pada kolaborasi penulis untuk menghasilkan karya-karya berkualitas bagi pembaca Indonesia.
            </p>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-2 col-md-6">
          <h5 class="fw-bold mb-4">Tautan Cepat</h5>
          <ul class="list-unstyled">
            <li class="mb-3">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none hover-primary d-flex align-items-center gap-2">
                    <i class="ti ti-chevron-right fs-2"></i> Beranda
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('catalog') }}" class="text-muted text-decoration-none hover-primary d-flex align-items-center gap-2">
                    <i class="ti ti-chevron-right fs-2"></i> Katalog Buku
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('collaboration') }}" class="text-muted text-decoration-none hover-primary d-flex align-items-center gap-2">
                    <i class="ti ti-chevron-right fs-2"></i> Kolaborasi
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('publications') }}" class="text-muted text-decoration-none hover-primary d-flex align-items-center gap-2">
                    <i class="ti ti-chevron-right fs-2"></i> Publikasi
                </a>
            </li>
          </ul>
        </div>

        <!-- Contact Section -->
        <div class="col-lg-6 col-md-12">
          <h5 class="fw-bold mb-4">Hubungi Kami</h5>
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="d-flex gap-3">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                  <i class="ti ti-map-pin fs-6"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1">Alamat</h6>
                  <p class="text-muted fs-2 mb-0 lh-base">
                    Perumahan Griya Anak Air Permai Blok B19, Batipuh Panjang, Koto Tangah, Kota Padang, Sumatera Barat
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="d-flex gap-3 mb-4">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                  <i class="ti ti-brand-whatsapp fs-6"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1">Layanan Admin</h6>
                  <a href="https://wa.me/6282333390205" target="_blank" class="text-muted fs-2 d-block text-decoration-none hover-primary mb-1">+62 823-3339-0205</a>
                  <a href="https://wa.me/6282333390206" target="_blank" class="text-muted fs-2 d-block text-decoration-none hover-primary">+62 823-3339-0206</a>
                </div>
              </div>
              <div class="d-flex gap-3">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                  <i class="ti ti-mail fs-6"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1">Email</h6>
                  <a href="mailto:penerbit@azzia.id" class="text-muted fs-2 text-decoration-none hover-primary">penerbit@azzia.id</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-1 opacity-10">

      <div class="d-flex justify-content-between flex-md-nowrap flex-wrap gap-3 align-items-center">
        <div class="d-flex gap-2 align-items-center">
          <p class="fs-2 mb-0 text-muted">© {{ date('Y') }} All rights reserved by <span class="fw-semibold text-dark">Azzia</span>.</p>
        </div>
        <div class="d-flex flex-column justify-content-center">
          <p class="mb-0 fs-2 text-muted">Produced by <a target="_blank" href="https://azzia.id/" class="text-primary fw-semibold text-decoration-none">Azzia.id</a>.</p>
        </div>
      </div>
    </div>
  </footer>

  <style>
    .hover-primary:hover {
      color: var(--bs-primary) !important;
    }
    footer .ti {
        transition: all 0.3s ease;
    }
    footer a:hover .ti-chevron-right {
        transform: translateX(3px);
    }
  </style>
