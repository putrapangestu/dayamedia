<?php
use Carbon\Carbon;
?>

@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Promo"
            description="List promo yang terdaftar di Azzia"
            >
            <x-slot:actions>
                <a href="{{ route('admin.promo.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Promo
                </a>
            </x-slot:actions>
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Nama Promo</label>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="cari nama atau kode promo..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control"
                                    value="{{ request('start_date') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input
                                    type="date"
                                    name="end_date"
                                    class="form-control"
                                    value="{{ request('end_date') }}"
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
                        <h4 class="card-title">List Promo</h4>
                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Promo</th>
                                <th>Keterangan</th>
                                <th>Kuota</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse ($promos as $key => $promo)
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $promos->perPage(), $promos->currentPage()) }}</td>
                                        <td>
                                            <div class="d-flex align-middle justify-center align-items-center">
                                                <h1 class="fw-bolder">{{ $promo->percentage }}%</h1>
                                                <div class="d-flex flex-column justify-center align-middle ms-3">
                                                    <span class="mb-1 badge bg-primary-subtle text-primary fw-bolder">#{{ $promo->code }}</span>
                                                    <h6 class="">{{ Carbon::parse($promo->start_date)->format('d F Y') }} - {{ Carbon::parse($promo->end_date)->format('d F Y') }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $promo->description }}
                                        </td>
                                        <td>
                                            {{ $promo->quantity }} (sisa: {{ $promo->quantity - $promo->histories_count }})
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.promo.edit', $promo->id) }}">
                                                            <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete" data-id="{{ $promo->id }}" href="javascript:void(0)">
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
                                <th>Promo</th>
                                <th>Keterangan</th>
                                <th>Kuota</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $promos->appends(request()->only(''))->links() }}
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
            $('#form-delete').attr('action', '{{ route("admin.promo.destroy", ":id") }}'.replace(':id', id));

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
