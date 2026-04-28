@extends('admin.layouts.app')

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
                    <div class="card-body">
                        <h4 class="card-title">List Transaksi</h4>
                        <div class="table-responsive">
                            <table id="default_order" class="table table-bordered display text-nowrap align-middle">
                                <thead>
                                    <tr>
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
                                                @php
                                                    $statusData = [
                                                        'pending' => ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Pembayaran'],
                                                        'confirmed' => ['color' => 'bg-success-subtle text-success', 'text' => 'Pembayaran Berhasil'],
                                                        'rejected' => ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembayaran Ditolak'],
                                                        'paid' => ['color' => 'bg-info-subtle text-info', 'text' => 'Sudah Dibayar'],
                                                    ][$trx->individual_book_status] ?? ['color' => 'bg-secondary-subtle text-secondary', 'text' => 'Status Tidak Diketahui'];

                                                    if($trx->individual_book_status == "pending" && $trx->payment_proof) {
                                                        $statusData = ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Konfirmasi'];
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusData['color'] }} fw-semibold fs-2">
                                                    {{ $statusData['text'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('admin.individual-books.show', $trx) }}" class="btn btn-sm btn-info px-3 shadow-none">
                                                        Detail
                                                    </a>
                                                    @if($trx->individual_book_status === 'pending')
                                                        {{-- <form action="{{ route('admin.individual-books.confirm', $trx) }}" method="POST" id="confirmForm-{{ $trx->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn btn-sm btn-success px-3 shadow-none" onclick="confirmTransaction('{{ $trx->id }}')">
                                                                Konfirmasi
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-danger px-3 shadow-none"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal{{ $trx->id }}">
                                                            Tolak
                                                        </button> --}}

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
                                            <td colspan="6" class="text-center py-4">
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

@push('js')
<script>
    function confirmTransaction(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran?',
            text: "Apakah Anda yakin ingin memverifikasi transaksi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#13deb9',
            cancelButtonColor: '#fa896b',
            confirmButtonText: 'Ya, Konfirmasi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('confirmForm-' + id).submit();
            }
        });
    }
</script>
@endpush

