
@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden">
    <!-- ------------------------------------- -->
    <!-- banner Start -->
    <!-- ------------------------------------- -->
    <section class="hero-section position-relative overflow-hidden mb-0 mb-lg-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xl-6">
              <div class="hero-content my-5 my-xl-0">
                <h6 class="d-flex align-items-center gap-2 fs-4 fw-semibold mb-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                    <i class="ti ti-rocket text-secondary fs-6"></i> Selamat Datang di Azzia
                </h6>
                <h1 class="fw-bolder mb-7 fs-10 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                  Tempat terbaik untuk
                  <span class="text-primary"> Membaca, Menulis & Kolaborasi</span>
                  Buku
                </h1>
                <p class="fs-5 mb-5 text-dark fw-normal aos-init aos-animate" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                  Azzia adalah platform terpadu untuk membeli buku, menulis karya sendiri, dan berkolaborasi dengan penulis lain dalam satu ekosistem yang modern dan mudah digunakan.
                </p>
                <div class="d-sm-flex align-items-center gap-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
                  <a class="btn btn-primary px-5 py-6 btn-hover-shadow d-block mb-3 mb-sm-0" href="{{ route('login') }}">Gabung Bersama Kami</a>
                </div>
              </div>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
              <div class="hero-img-slide position-relative bg-primary-subtle p-4 rounded">
                <div class="d-flex flex-row">
                  <div class="">
                    <div class="banner-img-1 slideup">
                      <img src="{{ asset('') }}assets/dashboard/images/hero-img/banner1.png" alt="modernize-img" class="img-fluid">
                    </div>
                    <div class="banner-img-1 slideup">
                      <img src="{{ asset('') }}assets/dashboard/images/hero-img/banner1.png" alt="modernize-img" class="img-fluid">
                    </div>
                  </div>
                  <div class="">
                    <div class="banner-img-2 slideDown">
                      <img src="{{ asset('') }}assets/dashboard/images/hero-img/banner2.png" alt="modernize-img" class="img-fluid">
                    </div>
                    <div class="banner-img-2 slideDown">
                      <img src="{{ asset('') }}assets/dashboard/images/hero-img/banner2.png" alt="modernize-img" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <!-- ------------------------------------- -->
    <!-- banner End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- Card Start -->
    <!-- ------------------------------------- -->
    <section class="features-section py-5">
        <div class="container ">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="text-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                <small class="text-primary fw-bold mb-2 d-block fs-3">Ekosistem lengkap bagi penulis untuk tumbuh dan berkarya bersama.</small>
                <h2 class="fs-9 text-center mb-4 mb-lg-5 fw-bolder">
                  Bangun Karya, Kelola Royalti, Raih Penghasilan
                </h2>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
              <div class="text-center mb-5">
                <i class="d-block ti ti-users text-primary fs-10"></i>
                <h5 class="fs-5 fw-semibold mt-8">Kolaborasi Penulis</h5>
                <p class="mb-0 text-dark">
                  Menulis buku bersama penulis lain secara terstruktur dan transparan.
                </p>
              </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
              <div class="text-center mb-5">
                <i class="d-block ti ti-coin text-primary fs-10"></i>
                <h5 class="fs-5 fw-semibold mt-8">Royalti Otomatis</h5>
                <p class="mb-0 text-dark">
                  Pembagian royalti otomatis dan adil sesuai kontribusi penulis.
                </p>
              </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
              <div class="text-center mb-5">
                <i class="d-block ti ti-share text-primary fs-10"></i>
                <h5 class="fs-5 fw-semibold mt-8">Program Afiliasi</h5>
                <p class="mb-0 text-dark">
                  Dapatkan komisi dengan mempromosikan buku kepada pembaca.
                </p>
              </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000">
              <div class="text-center mb-5">
                <i class="d-block ti ti-chart-bar text-primary fs-10"></i>
                <h5 class="fs-5 fw-semibold mt-8">Dashboard Analytics</h5>
                <p class="mb-0 text-dark">
                  Pantau penjualan, royalti, dan performa buku secara real-time.
                </p>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- Card end -->
    <!-- ------------------------------------- -->

    <section class="bg-primary py-9">
      <div class="container-fluid">
        <div class="d-flex gap-3 justify-content-center align-items-center flex-md-nowrap flex-wrap">
          <p class="text-white fs-4 mb-0 text-md-start text-center">Kami di sini untuk mendukung perjalanan literasimu. Ada pertanyaan lain?</p>
          <a href="https://wa.me/6281166012020" target="_blank" class="text-white fs-4 fw-semibold text-underline">Hubungi Kami</a>
        </div>
      </div>
    </section>

    <section class="py-1 py-md-1 py-lg-3 mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <h4 class="fs-7 fw-bolder">Rekomendasi Buku</h4>
            <p class="fs-3 mb-0">
              Temukan buku pilihan terbaik berdasarkan minat, tren, dan kualitas konten.
            </p>
          </div>
        </div>
        <div class="row mt-3">
            @forelse ($recommendations as $book)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6">
                <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm">
                    <div class="position-relative">
                        <a href="{{ route('bookDetail', $book->slug) }}">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                class="card-img-top"
                                alt="Book Cover"
                                style="aspect-ratio: 1 / 1.41; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="fw-bolder mb-0" style="color: #2a3547;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $book->title }}</h6>
                        <p class="text-muted mb-3 fs-2" style="font-size: 14px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            @if ($book->authors->count() > 0)
                                {{ $book->count() > 1 ? $book->authors->take(1)->map(function ($author) {
                                    return $author->author ?? $author->user->full_name;
                                })->implode(', ') . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
                            @else
                                -
                            @endif
                        </p>

                        <div class="d-flex flex-column justify-content-between align-items-start">
                            <div class="flex-fill">
                                @php
                                    $collectPrice = [$book->price_physical, $book->price_digital];
                                    $minPrice = min($collectPrice);
                                    $maxPrice = max($collectPrice);
                                @endphp
                                <h4 class="mb-0 fw-bolder fs-3" style="color: #255c83;">
                                    Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                    -
                                    Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
                            </div>
                        </div>
                        {{-- <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn">
                            <i class="ti ti-plus"></i> Keranjang
                        </button> --}}
                        <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn" data-book-id="{{ $book->id }}">
                            <i class="ti ti-plus"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center fs-4">Tidak ada rekomendasi buku.</p>
        @endforelse
        </div>
      </div>
    </section>

    <section class="py-1 py-md-1 py-lg-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <h4 class="fs-7 fw-bolder">Paket Buku Individu</h4>
            <p class="fs-3 mb-0">
              Wujudkan karya impian Anda dengan paket penerbitan profesional kami.
            </p>
          </div>
        </div>
        <div class="row mt-4">
            @forelse ($individualPackages as $package)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-img">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="fw-bolder mb-0" style="color: #2a3547;">{{ $package->name }}</h5>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $package->max_authors_default }} Penulis</span>
                            </div>

                            <h3 class="fw-black mb-4" style="color: #255c83;">Rp {{ number_format($package->price, 0, ',', '.') }}</h3>

                            <ul class="list-unstyled mb-4 flex-grow-1">
                                @foreach($package->benefits->take(4) as $benefit)
                                    <li class="d-flex align-items-start mb-2 fs-2">
                                        <i class="ti ti-check text-success me-2 mt-1"></i>
                                        <span class="text-dark">{{ $benefit->benefit_name }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ route('individual-books.purchase', $package) }}" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">Pilih Paket</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada paket tersedia saat ini.</p>
                </div>
            @endforelse

            @if($individualPackages->count() > 0)
                <div class="col-12 text-center mt-3">
                    <a href="{{ route('individual-books.packages') }}" class="btn btn-outline-primary px-4 py-2 rounded-3">Lihat Semua Paket <i class="ti ti-arrow-right ms-1"></i></a>
                </div>
            @endif
        </div>
      </div>
    </section>

    <section class="py-1 py-md-1 py-lg-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <h4 class="fs-7 fw-bolder">Buku Terbaru</h4>
            <p class="fs-3 mb-0">
              Temukan buku terbaru yang kami sediakan.
            </p>
          </div>
        </div>
        <div class="row mt-3">
            @forelse ($latestBooks as $book)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6">
                <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm">
                    <div class="position-relative">
                        <a href="{{ route('bookDetail', $book->slug) }}">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                class="card-img-top"
                                alt="Book Cover"
                                style="aspect-ratio: 1 / 1.41; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="fw-bolder mb-0" style="color: #2a3547;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $book->title }}</h6>
                        <p class="text-muted mb-3 fs-2" style="font-size: 14px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            @if ($book->authors->count() > 0)
                                {{ $book->count() > 1 ? $book->authors->take(1)->map(function ($author) {
                                    return $author->author ?? $author->user->full_name;
                                })->implode(', ') . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
                            @else
                                -
                            @endif
                        </p>

                        <div class="d-flex flex-column justify-content-between align-items-start">
                            <div class="flex-fill">
                                @php
                                    $collectPrice = [$book->price_physical, $book->price_digital];
                                    $minPrice = min($collectPrice);
                                    $maxPrice = max($collectPrice);
                                @endphp
                                <h4 class="mb-0 fw-bolder fs-3" style="color: #255c83;">
                                    Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                    -
                                    Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
                            </div>
                        </div>
                        {{-- <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn">
                            <i class="ti ti-plus"></i> Keranjang
                        </button> --}}
                        <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn" data-book-id="{{ $book->id }}">
                            <i class="ti ti-plus"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center fs-3 mb-0">Tidak ada buku</p>
        @endforelse
        </div>
      </div>
    </section>

    <section class="py-1 py-md-1 py-lg-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <h4 class="fs-7 fw-bolder">Buku Terlaris</h4>
            <p class="fs-3 mb-0">
              Temukan buku terlaris yang kami sediakan.
            </p>
          </div>
        </div>
        <div class="row mt-3">
            @forelse ($bestSellingBooks as $book)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6">
                <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm">
                    <div class="position-relative">
                        <a href="{{ route('bookDetail', $book->slug) }}">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                class="card-img-top"
                                alt="Book Cover"
                                style="aspect-ratio: 1 / 1.41; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="fw-bolder mb-0" style="color: #2a3547;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $book->title }}</h6>
                        <p class="text-muted mb-3 fs-2" style="font-size: 14px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            @if ($book->authors->count() > 0)
                                {{ $book->count() > 1 ? $book->authors->take(1)->map(function ($author) {
                                    return $author->author ?? $author->user->full_name;
                                })->implode(', ') . ', dkk' : $book->authors->first()->author ?? $book->authors->first()->user->full_name }}
                            @else
                                -
                            @endif
                        </p>

                        <div class="d-flex flex-column justify-content-between align-items-start">
                            <div class="flex-fill">
                                @php
                                    $collectPrice = [$book->price_physical, $book->price_digital];
                                    $minPrice = min($collectPrice);
                                    $maxPrice = max($collectPrice);
                                @endphp
                                <h4 class="mb-0 fw-bolder fs-3" style="color: #255c83;">
                                    Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                    -
                                    Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
                            </div>
                        </div>
                        {{-- <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn">
                            <i class="ti ti-plus"></i> Keranjang
                        </button> --}}
                        <button class="btn btn-outline-primary w-100 mt-2 add-to-cart-btn" data-book-id="{{ $book->id }}">
                            <i class="ti ti-plus"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center fs-4">Tidak ada buku terlaris.</p>
        @endforelse
        </div>
      </div>
    </section>

    <section class="py-1 py-md-1 py-lg-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <h4 class="fs-7 fw-bolder">Gabung Bersama Kami</h4>
            <p class="fs-3 mb-0">
              Temukan buku pilihan terbaik berdasarkan minat, tren, dan kualitas konten.
            </p>
          </div>
        </div>
        <div class="row mt-3">
					@forelse ($books as $book)
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-6">
							<div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm">
								<div class="position-relative">
										<a href="{{ route('collaborationDetail', $book->slug) }}">
												<img src="{{ asset('storage/' . $book->cover) }}"
														class="card-img-top"
														alt="Book Cover"
														style="aspect-ratio: 1 / 1.41; object-fit: cover;">
										</a>
								</div>
								<div class="card-body p-2">
										<h6 class="fw-bolder mb-0"  style="color: #2a3547;">{{ $book->title }}</h6>
										<p class="text-muted mb-3 fs-2" style="font-size: 14px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                            penulis {{ $book->authors->count() }}/{{ $book->modules->count() }}
										</p>

										<div class="d-flex flex-column justify-content-between align-items-start">
												<div class="flex-fill">
														@php
                                                            $collectPrice = $book->modules->count() > 0 ? $book->modules->pluck('price')->toArray() : [0];
                                                            $minPrice = min($collectPrice);
                                                            $maxPrice = max($collectPrice);
                                                        @endphp
														<h4 class="mb-0 fw-bolder fs-3" style="color: #255c83;">
																Rp.{{ number_format($minPrice, 0, ',', '.') }}
																-
																Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
														<p class="text-muted mb-0" style="font-size: 13px;">Harga Buku</p>
												</div>
										</div>
								</div>
							</div>
						</div>
					@empty

					@endforelse
				</div>
      </div>
    </section>

  </div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();

        @guest
            // Jika pengguna belum login, arahkan ke halaman login
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        let button = $(this);
        let bookId = button.data('book-id');
        let originalText = button.html();

        // Menonaktifkan tombol dan menunjukkan status loading
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: '{{ route('cart.add') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                book_id: bookId
            },
            success: function(response) {
                // Ganti teks tombol untuk memberikan feedback
                button.html('<i class="ti ti-check"></i> Ditambahkan').removeClass('btn-outline-primary').addClass('btn-success');
                updateCartCount();

                // Kembalikan tombol ke keadaan semula setelah beberapa detik
                setTimeout(function() {
                    button.prop('disabled', false).html(originalText).removeClass('btn-success').addClass('btn-outline-primary');
                }, 2000);
            },
            error: function(xhr) {
                // Tangani error, misalnya jika item gagal ditambahkan
                button.html('<i class="ti ti-x"></i> Gagal').removeClass('btn-outline-primary').addClass('btn-danger');

                // Kembalikan tombol ke keadaan semula setelah beberapa detik
                setTimeout(function() {
                    button.prop('disabled', false).html(originalText).removeClass('btn-danger').addClass('btn-outline-primary');
                }, 2000);
            }
        });
    });
});
</script>
@endpush
