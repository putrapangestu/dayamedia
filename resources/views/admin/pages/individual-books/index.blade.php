@extends('admin.layouts.app')

@php
function checkIndividualStatus ($transaction) {
    $data = [];
    switch ($transaction->individual_book_status) {
        case 'pending':   $data = ['color' => 'bg-primary-subtle text-primary', 'text' => 'Menunggu Pembayaran']; break;
        case 'confirmed': $data = ['color' => 'bg-success-subtle text-success', 'text' => 'Pembayaran Berhasil']; break;
        case 'paid':      $data = ['color' => 'bg-info-subtle text-info', 'text' => 'Sudah Dibayar']; break;
        case 'rejected':  $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembayaran Ditolak']; break;
        default:          $data = ['color' => 'bg-secondary-subtle text-secondary', 'text' => 'Status Tidak Diketahui']; break;
    }
    if($transaction->individual_book_status == "pending" && $transaction->payment_proof) {
        $data = ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Konfirmasi'];
    }
    return $data;
}
@endphp

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Transaksi Buku Individu"
            description="Daftar transaksi paket penerbitan buku individu"
            >
        </x-header-page>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="px-4 py-3 border-bottom">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Kode Transaksi</label>
                                <input type="text" name="transaction_code" class="form-control"
                                    placeholder="cari kode transaksi.." value="{{ request('transaction_code') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nama Member</label>
                                <input type="text" name="user_name" class="form-control"
                                    placeholder="cari nama member.." value="{{ request('user_name') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Pembayaran Berhasil</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Pembayaran Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-12 d-flex gap-2 mt-2">
                                <button class="btn btn-primary"><i class="ti ti-search"></i> Filter</button>
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary"><i class="ti ti-refresh"></i> Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default_order" class="table table-bordered display text-nowrap align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Transaksi</th>
                                        <th>User</th>
                                        <th>Paket</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $transactions->perPage(), $transactions->currentPage()) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-0">
                                                        <h6 class="fs-4 fw-semibold mb-0">{{ $trx->transaction_code }}</h6>
                                                        <span class="fw-normal text-muted fs-2">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-0">
                                                        <h6 class="fs-4 fw-semibold mb-0">{{ $trx->user?->full_name }}</h6>
                                                        <span class="fw-normal text-muted fs-2">{{ $trx->user?->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 fw-normal fs-4 text-dark">{{ $trx->individualBookPackage?->name }}</p>
                                                <span class="badge bg-primary-subtle text-primary fs-2">
                                                    {{ $trx->additional_authors_count }} Penulis Tambahan
                                                </span>
                                            </td>
                                            <td>
                                                <h6 class="fs-4 fw-semibold mb-0">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</h6>
                                            </td>
                                            <td>
                                                <span class="mb-1 badge fs-2 {{ checkIndividualStatus($trx)['color'] }}">
                                                    {{ checkIndividualStatus($trx)['text'] }}
                                                </span>
                                                @if($trx->payment_proof)
                                                    <br><span class="mb-1 badge fs-2 bg-success-subtle text-success mt-1">Bukti Bayar Tersedia</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('admin.individual-books.show', $trx) }}" class="btn btn-sm btn-info px-3 shadow-none">
                                                        Detail
                                                    </a>
                                                    @if($trx->individual_book_status === 'pending')
                                                        <!-- Reject Modal -->
                                                        <div class="modal fade" id="rejectModal{{ $trx->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form action="{{ route('admin.individual-books.reject', $trx) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Tolak Transaksi {{ $trx->transaction_code }}</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Alasan Penolakan</label>
                                                                                <textarea name="rejected_reason" class="form-control" rows="3" required placeholder="Contoh: Bukti transfer tidak valid atau data tidak lengkap"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit" class="btn btn-danger">Tolak Transaksi</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <p class="mb-0 text-muted">Tidak ada transaksi yang ditemukan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($transactions->hasPages())
                        <div class="px-4 py-3 border-top">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

