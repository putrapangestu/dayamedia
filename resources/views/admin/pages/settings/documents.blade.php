@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Dokumen"
            description="List dokumen yang terdaftar di Azzia"
            >
            <x-slot:actions>
                <a href="{{ route('settings.create-document') }}" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Dokumen
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nama Dokumen</label>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="cari nama dokumen..."
                                    value="{{ request('search') }}"
                                >
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
                        <h4 class="card-title">List Dokumen</h4>
                        <div class="table-responsive">
                        <table id="default_order" class="table table-striped table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Dokumen</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse($documents as $idx => $doc)
                                    <tr>
                                        <td>{{ ($documents->currentPage() - 1) * $documents->perPage() + $idx + 1 }}</td>
                                        <td>
                                            <h6 class="mb-1">{{ $doc->name }}</h6>
                                            <small class="text-muted">
                                                {{ $doc->users()->count() > 0 ? 'Khusus Member Tertentu' : 'Untuk Semua Member' }}
                                            </small>
                                        </td>
                                        <td class="">
                                            <a class="btn btn-primary btn-sm" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                <i class="ti ti-download"></i> Unduh
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete" data-id="{{ $doc->id }}">
                                                <i class="ti ti-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Dokumen</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $documents->links() }}
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
            $('#form-delete').attr('action', '{{ route("settings.documents.destroy", ":id") }}'.replace(':id', id));

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "ms-3 btn bg-primary-subtle text-primary",
                },
                buttonsStyling: false,
            });
            swalWithBootstrapButtons.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus dokumen ini?",
                icon: "warning",
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
