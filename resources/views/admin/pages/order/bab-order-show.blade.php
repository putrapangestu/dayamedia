@php
    use Carbon\Carbon;
@endphp

@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Transaksi Bab Kolaborasi</h5>
                        <a href="{{ route('admin.bab-order.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bolder">Informasi Transaksi</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="30%">Kode Transaksi</td>
                                        <td width="5%">:</td>
                                        <td><strong>{{ $transaction->transaction_code }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pemesanan</td>
                                        <td>:</td>
                                        <td>{{ $transaction->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                           <span class="info-value">
                                                @if($transaction->status == 'pending' && !$transaction->payment_proof)
                                                    <span class="badge bg-warning-subtle text-warning mt-1">Menunggu Pembayaran</span>
                                                @elseif($transaction->status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning mt-1">Menunggu Approval</span>
                                                @elseif($transaction->status == 'paid')
                                                    <span class="badge bg-success-subtle text-success mt-1">Pembayaran Diterima</span>
                                                @elseif($transaction->status == 'completed')
                                                    <span class="badge bg-success-subtle text-success mt-1">Pembelian Selesai</span>
                                                @elseif($transaction->status == 'canceled')
                                                    <span class="badge bg-danger-subtle text-danger mt-1">Pembelian Dibatalkan</span>
                                                @elseif($transaction->status == 'rejected')
                                                    <span class="badge bg-danger-subtle text-danger mt-1">Pembelian Ditolak</span>
                                                @elseif($transaction->status == 'expired')
                                                    <span class="badge bg-warning-subtle text-warning mt-1">Pembayaran Kadaluarsa</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary mt-1">Status Tidak Diketahui</span>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Harga</td>
                                        <td>:</td>
                                        <td><strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bolder">Informasi Pembeli</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="30%">Nama</td>
                                        <td width="5%">:</td>
                                        <td><strong>{{ $transaction->user->full_name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. HP</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Referral Code</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->referral_code ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Limit Pembayaran</td>
                                        <td>:</td>
                                        <td>{{ $transaction->expired_at ? Carbon::parse($transaction->expired_at)->format('d F Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bolder">Detail Item</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Buku</th>
                                        <th>Bab</th>
                                        <th>Judul Bab</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->details as $index => $detail)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $detail->module?->book?->title ?? '-' }}</td>
                                            <td>BAB {{ $detail->module?->chapter ?? '-' }}</td>
                                            <td>{{ $detail->module?->title ?? '-' }}</td>
                                            <td>Rp {{ number_format($detail->price_book, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Total</th>
                                        <th>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($transaction)
                            <hr class="my-4">
                            <h6 class="fw-bolder">Informasi Pembayaran</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%">Metode Pembayaran</td>
                                            <td width="5%">:</td>
                                            <td>{{ ucfirst($transaction->payment_method) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status Pembayaran</td>
                                            <td>:</td>
                                            <td>
                                                <span class="info-value">
                                                    @if($transaction->status == 'pending' && !$transaction->payment_proof)
                                                        <span class="badge bg-warning-subtle text-warning mt-1">Menunggu Pembayaran</span>
                                                    @elseif($transaction->status == 'pending')
                                                        <span class="badge bg-warning-subtle text-warning mt-1">Menunggu Approval</span>
                                                    @elseif($transaction->status == 'paid')
                                                        <span class="badge bg-success-subtle text-success mt-1">Pembayaran Diterima</span>
                                                    @elseif($transaction->status == 'completed')
                                                        <span class="badge bg-success-subtle text-success mt-1">Pembelian Selesai</span>
                                                    @elseif($transaction->status == 'canceled')
                                                        <span class="badge bg-danger-subtle text-danger mt-1">Pembelian Dibatalkan</span>
                                                    @elseif($transaction->status == 'rejected')
                                                        <span class="badge bg-danger-subtle text-danger mt-1">Pembelian Ditolak</span>
                                                    @elseif($transaction->status == 'expired')
                                                        <span class="badge bg-warning-subtle text-warning mt-1">Pembayaran Kadaluarsa</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary mt-1">Status Tidak Diketahui</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pemesanan</td>
                                            <td>:</td>
                                            <td>{{ $transaction->created_at ? Carbon::parse($transaction->created_at)->format('d F Y H:i') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Limit Pembayaran</td>
                                            <td>:</td>
                                            <td>{{ $transaction->expired_at ? Carbon::parse($transaction->expired_at)->format('d F Y H:i') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    @if($transaction->payment_proof)
                                        <h6>Bukti Pembayaran</h6>
                                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                                             alt="Bukti Pembayaran"
                                             class="img-fluid rounded"
                                             style="max-height: 200px; cursor: pointer;"
                                             data-bs-toggle="modal"
                                             data-bs-target="#paymentProofModal">

                                        <!-- Modal Bukti Pembayaran -->
                                        <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Bukti Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}" class="img-fluid" alt="Bukti Pembayaran Full">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.bab-order.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i>Kembali
                            </a>
                            @if($transaction->status == 'pending' && $transaction->payment_proof)
                                <form action="{{ route('admin.bab-order.update', $transaction->id) }}" method="POST" class="d-inline" id="confirmForm-{{ $transaction->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="button" class="btn btn-success" onclick="confirmTransaction('{{ $transaction->id }}')">
                                        <i class="ti ti-check me-1"></i>Verifikasi Pembayaran
                                    </button>
                                </form>
                            @endif
                            @if($transaction->status == 'pending')
                                <form action="{{ route('admin.bab-order.update', $transaction->id) }}" method="POST" class="d-inline" id="rejectForm-{{ $transaction->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="button" class="btn btn-danger" onclick="rejectTransaction('{{ $transaction->id }}')">
                                        <i class="ti ti-x me-1"></i>Tolak Pembayaran
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
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
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        document.getElementById('confirmForm-' + id).submit();
                    }
                });
            }
        });
    }

    function rejectTransaction(id) {
        Swal.fire({
            title: 'Tolak Pembayaran?',
            text: "Apakah Anda yakin ingin menolak pembayaran ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa896b',
            cancelButtonColor: '#5a6a85',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        document.getElementById('rejectForm-' + id).submit();
                    }
                });
            }
        });
    }
</script>
@endpush
