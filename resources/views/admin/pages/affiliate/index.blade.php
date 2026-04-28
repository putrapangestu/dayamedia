@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Riwayat Komisi Affiliator"
            description="List riwayat komisi affiliator di Azzia"
            >
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">List Riwayat Komisi Affiliator</h4>
                        </div>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.affiliate.index') }}" class="row g-3 mb-4 align-items-end">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Cari Affiliator / Penjualan</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama atau Kode Transaksi...">
                            </div>
                            <div class="col-md-3">
                                <label for="type" class="form-label">Tipe Komisi</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="">Semua Tipe</option>
                                    <option value="affiliator" {{ request('type') == 'affiliator' ? 'selected' : '' }}>Affiliator</option>
                                    <option value="royalti" {{ request('type') == 'royalti' ? 'selected' : '' }}>Royalti</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i> Filter</button>
                                <a href="{{ route('admin.affiliate.index') }}" class="btn btn-outline-secondary"><i class="ti ti-refresh"></i> Reset</a>
                            </div>
                        </form>

                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Affiliator</th>
                                <th>Komisi</th>
                                <th>Affiliator / Royalti</th>
                                <th>Tanggal</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse ( $histories as $history )
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <h6 class="mb-1 fw-bolder">{{ $history->transaction->transaction_code }}</h6>
                                                    <p class="mb-1 text-muted fs-2">{{  $history->transaction->user->full_name }}</p>
                                                    <span class="mb-1 badge fs-2 bg-info-subtle text-info">{{ $history->transaction->created_at->format('d F Y') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex"><div>
                                                    <h6 class="mb-1">{{ $history->user->full_name }}</h6>
                                                    <p class="mb-1 text-muted fs-2">Tingkat: {{ $history->user?->affiliateLevel?->name ?? "Tidak ada" }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <h6 class="fw-bolder">Rp. {{ number_format($history->amount, 0, ',', '.') }}</h6>
                                        </td>
                                        <td>
                                            @if ($history->type == 'royalti')
                                                Royalti
                                            @else
                                                Affiliator
                                            @endif
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($history->created_at)->format('d F Y H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Item</th>
                                <th>Komisi</th>
                                <th>Affiliator / Royalti</th>
                                <th>Tanggal</th>
                            </tr>
                            <!-- end row -->
                            </tfoot>
                        </table>
                        </div>
                        <div class="mt-3">
                            {{ $histories->links() }}
                        </div>
                    </div>
                </div>
                <!-- end Default Ordering -->
            </div>
          </div>
        </div>
      </div>
@endsection
