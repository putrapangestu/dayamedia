@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Buku"
            description="List buku yang terdaftar di Azzia"
            >
            <x-slot:actions>
                <a href="{{ route('admin.book.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Buku
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Buku</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="cari..."
                                    value="{{ request('name') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-control" name="category_id" id="">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="">
                                    <option value="">Semua Status</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Terbuka Kolaborasi</option>
                                    <option value="editing" {{ request('status') == 'editing' ? 'selected' : '' }}>Proses Edit</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publish</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button class="btn btn-primary">
                                    Filter
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>
                        </form>
                        </div>
                    <div class="card-body">

                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                <tr>
                                    <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $books->perPage(), $books->currentPage()) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('assets/dashboard/images/products/product-1.jpg') }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                            <div>
                                                <h6 class="mb-1">{{ $book->title }}</h6>
                                                <p class="mb-1 text-muted fs-2">ISBN: {{ $book->code_isbn }}</p>
                                                <span class="mb-1 badge fs-2 bg-primary-subtle text-primary">{{ $book->category?->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6><span class="text-muted">Harga E-Book:</span> Rp.{{ number_format($book->price_digital, 0, ',', '.') }}</h6>
                                        <h6><span class="text-muted">Harga Cetak:</span> Rp.{{ number_format($book->price_physical, 0, ',', '.') }}</h6>
                                    </td>
                                    <td><span class="mb-1 badge {{ \App\Helpers\StatusHelper::getBookStatusBadge($book->status) }}">{{ \App\Helpers\StatusHelper::getStatusText($book->status) }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport" data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.book.show', $book->id) }}">
                                                            <i class="ti ti-eye me-1 fs-4"></i>Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.book.edit', $book->id) }}">
                                                            <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete" data-id="{{ $book->id }}" href="javascript:void(0)">
                                                        <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Data tidak ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $books->appends(request()->only('name', 'category_id', 'status'))->links() }}
                    </div>
                </div>
                <!-- end Default Ordering -->
            </div>
          </div>
        </div>
      </div>
    <x-form-delete></x-form-delete>
@endsection
@push('js')
<script>
    $(document).ready(function() {
         $(".btn-delete").click(function () {
            const id = $(this).data('id');
            $('#form-delete').attr('action', '{{ route("admin.book.destroy", ":id") }}'.replace(':id', id));

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "ms-3 btn bg-primary-subtle text-primary",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus data ini?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#ffffff",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya, Hapus!",
            }).then((result) => {
                if (result.value) {
                    $('#form-delete').submit();
                }
            });
        });
    });
</script>
@endpush
