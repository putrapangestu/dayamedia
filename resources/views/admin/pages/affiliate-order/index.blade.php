@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Tingkatan Affiliasi"
            description="List tingkatan affiliasi yang terdaftar di Azzia"
            >
            <x-slot:actions>
                <a href="{{ route('admin.affiliate-order.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Tingkatan
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nama Tingkatan</label>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="cari nama tingkatan..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            {{-- <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div> --}}
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
                        <h4 class="card-title">List Tingkatan Affiliasi</h4>
                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Tingkatan</th>
                                <th>Persentase</th>
                                <th>Target Bulanan</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse($affiliateOrders as $affiliateOrder)

                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $affiliateOrders->perPage(), $affiliateOrders->currentPage()) }}</td>
                                        <td>
                                            <div class="d-flex align-middle justify-center align-items-center">
                                                <img src="{{ $affiliateOrder->icon ? 'storage/' . $affiliateOrder->icon : 'https://png.pngtree.com/png-vector/20220729/ourmid/pngtree-champion-award-medal-icon-png-image_6091841.png' }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                                <div class="d-flex flex-column justify-center align-middle">
                                                    <h6 class="">{{ $affiliateOrder->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="mb-1 badge bg-success-subtle text-success">{{ $affiliateOrder->percentage }} %</span>
                                        </td>
                                        <td class="fw-bold">Rp.{{ number_format($affiliateOrder->min_earning, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport" data-bs-reference="viewport"aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-4"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.affiliate-order.edit', $affiliateOrder->id) }}">
                                                                <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btn-delete" data-id="{{ $affiliateOrder->id }}" href="javascript:void(0)">
                                                            <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Tingkatan</th>
                                <th>Persentase</th>
                                <th>Target Bulanan</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-bottom">
                        {{ $affiliateOrders->appends(request()->only(''))->links() }}
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
            $('#form-delete').attr('action', '{{ route("admin.affiliate-order.destroy", ":id") }}'.replace(':id', id));

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
