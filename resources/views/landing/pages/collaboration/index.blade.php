
@extends('landing.layouts.app')

@section('content')
<div class="main-wrapper overflow-hidden my-3">
<div class="container">
          <div class="position-relative overflow-hidden">
            <div class="shop-part d-flex w-100">
              <div class="card-body p-4 pb-0">
                <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
                  <a class="btn btn-primary d-lg-none d-flex" data-bs-toggle="offcanvas" href="#filtercategory" role="button" aria-controls="filtercategory">
                    <i class="ti ti-menu-2 fs-6"></i>
                  </a>
                  <h5 class="fs-5 mb-0 d-none d-lg-block">Buku Kolaborasi</h5>
                  <div class="d-flex align-items-center gap-2">
                    <button class="btn bg-primary-subtle text-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                      <i class="ti ti-filter"></i> Filter
                    </button>

                    <select class="form-select w-auto" id="sort-select" onchange="window.location.href='{{ request()->fullUrlWithQuery(['sort' => '']) }}' + this.value">
                      <option value="quota_high" {{ (request('sort') ?? 'quota_high') == 'quota_high' ? 'selected' : '' }}>Kuota Terbanyak</option>
                      <option value="quota_low" {{ request('sort') == 'quota_low' ? 'selected' : '' }}>Kuota Tersedikit</option>
                      <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                      <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                      <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                      <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  @forelse ($books as $book)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="card hover-img overflow-hidden rounded-4 border-0 shadow-sm">
                            <div class="position-relative">
                                <a href="{{ route('collaborationDetail', $book->slug) }}">
                                    <img src="{{ $book->cover ? asset('storage/' . $book->cover)  : 'https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
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
                                        <h4 class="mb-0 fw-bolder fs-3" style="color: #EE128C;">
                                            Rp.{{ number_format($minPrice, 0, ',', '.') }}
                                            -
                                            Rp.{{ number_format($maxPrice, 0, ',', '.') }}</h4>
                                        <p class="text-muted mb-0" style="font-size: 13px;">Harga Bab</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  @empty
                    <div class="col-12">
                        <p class="text-center">No books found.</p>
                    </div>
                  @endforelse
                </div>
                <div class="row mt-3">
                    {{ $books->appends(request()->only('search', 'category_id'))->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
<x-filter :categories="$categories" />

<script>
// Update modal ID
$(document).ready(function() {
    // Change modal ID from exampleModal to filterModal for collaboration page
    if ($('#filterModal').length === 0) {
        $('#filterModal').attr('id', 'filterModal');
    }
});
</script>
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
