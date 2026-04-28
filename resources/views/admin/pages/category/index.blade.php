@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Kategori Buku"
            description="List kategori buku yang terdaftar di Azzia"
            >
            <x-slot:actions>
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Kategori Buku
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nama Kategori</label>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="cari nama kategori..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-12 d-flex gap-2 mt-2">
                                <button class="btn btn-primary">
                                    <i class="ti ti-search"></i> Filter
                                </button>
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-refresh"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">List Kategori</h4>
                        <div class="table-responsive">
                        <table id="default_order" class="table table-striped table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $categories->perPage(), $categories->currentPage()) }}</td>
                                    <td>{{ $category?->name }}</td>
                                    <td>{{ $category->status }}</td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $category->id }}">
                                        <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @if ($categories->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $categories->appends(request()->only(''))->links() }}
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
            $('#form-delete').attr('action', '{{ route("admin.category.destroy", ":id") }}'.replace(':id', id));

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
