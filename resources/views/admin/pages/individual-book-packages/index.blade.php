@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Paket Buku Individu"
            description="Manajemen paket penerbitan buku individu"
            >
            <x-slot:actions>
                <a href="{{ route('admin.individual-book-packages.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Buat Paket Baru
                </a>
            </x-slot:actions>
        </x-header-page>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Cari nama paket...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="active" @selected(request('status')==='active')>Aktif</option>
                                    <option value="inactive" @selected(request('status')==='inactive')>Non-aktif</option>
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
                        <h4 class="card-title">List Paket</h4>
                        <div class="table-responsive">
                            <table id="default_order" class="table table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama Paket</th>
                                        <th>Harga</th>
                                        <th>Penulis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($packages as $package)
                                        <tr>
                                            <td>
                                                <h6 class="fs-4 fw-semibold mb-0">{{ $package->name }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="fs-4 fw-semibold mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</h6>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary fw-semibold fs-2">
                                                    Max {{ $package->max_authors_default }} Penulis
                                                </span>
                                            </td>
                                            <td>
                                                @if($package->status === 'active')
                                                    <span class="badge bg-success-subtle text-success fw-semibold fs-2">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger fw-semibold fs-2">Non-aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="text-decoration-none" href="javascript:void(0)" id="action-dd" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-4"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="action-dd">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.individual-book-packages.edit', $package) }}">
                                                                <i class="ti ti-edit me-1 fs-4"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.individual-book-packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="ti ti-trash me-1 fs-4"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada paket yang dibuat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($packages->hasPages())
                        <div class="px-4 py-3 border-top">
                            {{ $packages->appends(request()->only(['name', 'status']))->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

