@extends('admin.layouts.app')

@php
function checkStatus ($transaction) {
    $data = [];

    switch ($transaction->status) {
        case 'pending':
            $data = ['color' => 'bg-primary-subtle text-primary', 'text' => 'Menunggu Pembayaran'];
            break;
        case 'failed':
            $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembelian Gagal'];
            break;
        case 'paid':
            $data = ['color' => 'bg-success-subtle text-success', 'text' => 'Pembayaran Berhasil'];
            break;
        case 'completed':
            $data = ['color' => 'bg-success-subtle text-success', 'text' => 'Pembelian Selesai'];
            break;
        case 'canceled':
            $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembelian Dibatalkan'];
            break;
        case 'rejected':
            $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembelian Ditolak'];
            break;
        case 'expired':
            $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembelian Kadaluarsa'];
            break;
        default:
            $data = ['color' => 'bg-secondary-subtle text-secondary', 'text' => 'Status Tidak Diketahui'];
            break;
    }

    if($transaction->status == "pending" && $transaction->payment_proof) {
        $data = ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Konfirmasi'];
    }

    return $data;
}
@endphp

@section('content')
<div class="body-wrapper">
        <div class="container-fluid">
          <x-header-page
            title="Pembelian Bab Kolaborasi"
            description="List bab kolaborasi yang terjual di Azzia"
            >
            </x-header-page>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Nama Buku</label>
                                <input
                                    type="text"
                                    name="book_name"
                                    class="form-control"
                                    placeholder="cari nama buku.."
                                    value="{{ request('book_name') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kode Transaksi</label>
                                <input
                                    type="text"
                                    name="transaction_code"
                                    class="form-control"
                                    placeholder="cari kode transaksi.."
                                    value="{{ request('transaction_code') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nama Member</label>
                                <input
                                    type="text"
                                    name="user_name"
                                    class="form-control"
                                    placeholder="cari nama member.."
                                    value="{{ request('user_name') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pembayaran Berhasil</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pembayaran Selesai</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Pembayaran Kadaluarsa</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Pembayaran Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input
                                    type="date"
                                    name="date"
                                    class="form-control"
                                    value="{{ request('date') }}"
                                >
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
                        <div class="table-responsive">
                        <table id="default_order" class="table table-bordered display text-nowrap">
                            <thead>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Item</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $transactions->perPage(), $transactions->currentPage()) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <h6 class="mb-1 fw-bolder">{{ $transaction->transaction_code }}</h6>
                                                    <p class="mb-1 text-muted fs-2">{{ $transaction->user->name }}</p>
                                                    <span class="mb-1 badge fs-2 bg-info-subtle text-info">{{ $transaction->created_at->format('d F Y') }}</span>
                                                    @if($transaction->payment_proof)
                                                        <br><span class="mb-1 badge fs-2 bg-success-subtle text-success">Bukti Bayar Tersedia</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @foreach ($transaction->details as $detail)
                                                    <img src="{{ $detail->module?->book?->cover ? asset('storage') . '/' . $detail->module?->book?->cover : asset(''). 'assets/dashboard/images/products/product-1.jpg' }}" width="50" height="50" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                                                    <div>
                                                        <h6 class="mb-1">{{ $detail->module?->book?->title }}</h6>
                                                        <p class="mb-1 text-muted fs-2">BAB {{ $detail->module?->chapter }} | {{ $detail->module?->title }}</p>
                                                        <p class="mb-1 text-muted fs-2">{{ $transaction->user->full_name }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="fw-bolder">Rp. {{ number_format(($transaction->total_price - $transaction->discount_amount ?? 0 - $transaction->admin_fee ?? 0), 0, ',', '.') }}</h6>
                                        </td>
                                        <td>
                                            <span class="mb-1 badge fs-2 {{ checkStatus($transaction)['color'] }}">
                                                {{ checkStatus($transaction)['text'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown"  data-bs-boundary="viewport"
                                                    data-bs-reference="viewport"aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="balance-dd" style="z-index: 1055;">
                                                    <li>
                                                        <a href="{{ route('admin.bab-order.show', $transaction->id) }}" class="dropdown-item">
                                                            <i class="ti ti-eye me-1 fs-4"></i>Lihat Detail
                                                        </a>
                                                    </li>
                                                    {{-- @if ($transaction->status == 'pending' && $transaction->payment_proof)
                                                        <li>
                                                            <form action="{{ route('admin.bab-order.update', $transaction->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="paid">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="ti ti-edit me-1 fs-4"></i>Verifikasi Pembayaran
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.bab-order.update', $transaction->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="ti ti-trash me-1 fs-4"></i>Tolak Pembayaran
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pembelian bab kolaborasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Penjualan</th>
                                <th>Item</th>
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
                        {{ $transactions->links() }}
                    </div>
                    </div>
                    <!-- end Default Ordering -->
            </div>
          </div>
        </div>
      </div>
@endsection
