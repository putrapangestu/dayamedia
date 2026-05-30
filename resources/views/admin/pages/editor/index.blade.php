@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Editor"
            description="List editor yang terdaftar di Daya Media"
            >
            <x-slot:actions>
                <a href="{{ route('admin.editor.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Editor
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="cari nama editor.."
                                    value="{{ request('name') }}"
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
                            <div class="col-md-3">
                                <label class="form-label">Tingkat Affiliate</label>
                                <select class="form-control" name="affiliate_level_id">
                                    <option value="">Semua Tingkat</option>
                                    @foreach(\App\Models\AffiliateLevel::all() as $level)
                                        <option value="{{ $level->id }}" {{ request('affiliate_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
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
                                <th>Nama Editor</th>
                                <th>Email</th>
                                <th>Jumlah Buku Disunting</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <!-- start row -->
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $users->perPage(), $users->currentPage()) }}</td>
                                        <td>
                                            <h6>{{ $user->full_name }}</h6>
                                            <span class="text-muted">{{ $user->phone_number }}</span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ count($user->bookEditors) }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
              data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.editor.edit', $user->id) }}">
                                                            <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete" data-id="{{ $user->id }}" href="javascript:void(0)">
                                                        <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <!-- end row -->
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada member</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Nama Editor</th>
                                <th>Email</th>
                                <th>Jumlah Buku Disunting</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    </div>
                    <!-- end Default Ordering -->
                    <div class="px-4 py-3 border-bottom">
                        {{ $users->appends(request()->only('name',))->links() }}
                    </div>
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
            $('#form-delete').attr('action', '{{ route("admin.editor.destroy", ":id") }}'.replace(':id', id));

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
