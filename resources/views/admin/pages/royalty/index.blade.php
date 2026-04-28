@extends('admin.layouts.app')

@section('title', 'Manajemen Royalty')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Manajemen Royalty"
            description="Kelola komisi royalty dan referral"
            >
            <x-slot:actions>
                <a href="{{ route('admin.royalty.settings') }}" class="btn btn-outline-primary">
                    <i class="ti ti-settings"></i> Pengaturan
                </a>
            </x-slot:actions>
        </x-header-page>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Daftar Royalty</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.royalty.index') }}" class="btn btn-outline-secondary btn-sm {{ !request('status') && !request('type') ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.royalty.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ request('status') === 'pending' ? 'active' : '' }}">Menunggu</a>
                        <a href="{{ route('admin.royalty.index', ['status' => 'paid']) }}" class="btn btn-outline-success btn-sm {{ request('status') === 'paid' ? 'active' : '' }}">Dibayar</a>
                        <a href="{{ route('admin.royalty.index', ['type' => 'referral']) }}" class="btn btn-outline-info btn-sm {{ request('type') === 'referral' ? 'active' : '' }}">Referral</a>
                        <a href="{{ route('admin.royalty.index', ['type' => 'royalty']) }}" class="btn btn-outline-primary btn-sm {{ request('type') === 'royalty' ? 'active' : '' }}">Royalty</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Buku</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($royalties as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/dashboard/images/profile/user-1.jpg') }}" width="40" height="40" class="rounded-circle me-2" alt="profile">
                                            <div>
                                                <h6 class="mb-0">{{ $item->user->full_name }}</h6>
                                                <small class="text-muted">{{ $item->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->book->cover) }}" width="40" height="40" class="rounded me-2" alt="book cover">
                                            <div>
                                                <h6 class="mb-0">{{ $item->book->title }}</h6>
                                                <small class="text-muted">{{ $item->book->category?->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->type === 'referral' ? 'bg-info' : 'bg-primary' }}">
                                            {{ ucfirst($item->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">Rp. {{ number_format($item->amount, 0, ',', '.') }}</h6>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $item->percentage }}%</span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($item->status === 'pending') bg-warning text-dark
                                            @elseif($item->status === 'paid') bg-success
                                            @elseif($item->status === 'cancelled') bg-danger
                                            @endif">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-decoration-none" href="javascript:void(0)" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-4"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.royalty.show', $item->id) }}">
                                                        <i class="ti ti-eye me-1"></i>Detail
                                                    </a>
                                                </li>
                                                @if($item->status === 'pending')
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.royalty.show', $item->id) }}#payment">
                                                        <i class="ti ti-credit-card me-1"></i>Proses Bayar
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data royalty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $royalties->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection