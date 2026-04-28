@php
    use Carbon\Carbon;

    function checkIndividualStatus ($transaction) {
        $data = [];

        switch ($transaction->individual_book_status) {
            case 'pending':
                $data = ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Pembayaran'];
                break;
            case 'confirmed':
                $data = ['color' => 'bg-success-subtle text-success', 'text' => 'Pembayaran Berhasil'];
                break;
            case 'rejected':
                $data = ['color' => 'bg-danger-subtle text-danger', 'text' => 'Pembayaran Ditolak'];
                break;
            case 'paid':
                $data = ['color' => 'bg-info-subtle text-info', 'text' => 'Sudah Dibayar'];
                break;
            default:
                $data = ['color' => 'bg-secondary-subtle text-secondary', 'text' => 'Status Tidak Diketahui'];
                break;
        }

        if($transaction->individual_book_status == "pending" && $transaction->payment_proof) {
            $data = ['color' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Konfirmasi'];
        }

        return $data;
    }
@endphp

@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Detail Transaksi</h4>
                            <p class="mb-0 text-muted">Kode: {{ $transaction->transaction_code }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.individual-books.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Informasi Transaksi</h6>
                                <table class="table table-sm">
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
                                                @php
                                                    $statusData = checkIndividualStatus($transaction);
                                                @endphp
                                                <span class="badge {{ $statusData['color'] }} mt-1">{{ $statusData['text'] }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>:</td>
                                        <td>{{ ucfirst($transaction->payment_method ?? '-') }}</td>
                                    </tr>
                                    @if($transaction->promo_code)
                                    <tr>
                                        <td>Kode Promo</td>
                                        <td>:</td>
                                        <td><span class="badge bg-info">{{ $transaction->promo_code }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Diskon</td>
                                        <td>:</td>
                                        <td>Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Informasi Pembeli</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="30%">Nama</td>
                                        <td width="5%">:</td>
                                        <td>{{ $transaction->user->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Referral Code</td>
                                        <td>:</td>
                                        <td>{{ $transaction->user->use_referral_code ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Limit Pembayaran</td>
                                        <td>:</td>
                                        <td>{{ $transaction->expired_at ? Carbon::parse($transaction->expired_at)->format('d F Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Detail Paket</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Tipe</th>
                                        <th>Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{ $transaction->individualBookPackage->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                Paket Penerbitan
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($transaction->individualBookPackage->price, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($transaction->additional_authors_count > 0)
                                    <tr>
                                        <td>
                                            <strong>Penulis Tambahan ({{ $transaction->additional_authors_count }} orang)</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                Add-ons
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format(($transaction->total_price + $transaction->discount_amount - $transaction->admin_fee - $transaction->individualBookPackage->price), 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-end">Subtotal:</th>
                                        <th>Rp {{ number_format($transaction->total_price + ($transaction->discount_amount ?? 0) - $transaction->admin_fee, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">Biaya Admin:</th>
                                        <th>Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }}</th>
                                    </tr>
                                    @if($transaction->discount_amount > 0)
                                    <tr>
                                        <th colspan="2" class="text-end">Diskon:</th>
                                        <th class="text-success">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th colspan="2" class="text-end">Total Akhir:</th>
                                        <th>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($transaction->payment_proof)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Bukti Pembayaran</h6>
                            <div class="border rounded p-3">
                                <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                                     alt="Bukti Pembayaran"
                                     class="img-fluid rounded"
                                     style="max-height: 200px; cursor: pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#paymentProofModal">
                            </div>
                        </div>

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

                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Aksi</h6>
                            <div class="d-flex gap-2">
                                @if($transaction->individual_book_status == 'pending')
                                    <form action="{{ route('admin.individual-books.confirm', $transaction->id) }}" method="POST" class="d-inline" id="confirmForm-{{ $transaction->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-success" onclick="confirmTransaction('{{ $transaction->id }}')">
                                            <i class="ti ti-check me-1"></i>Verifikasi Pembayaran
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $transaction->id }}">
                                        <i class="ti ti-x me-1"></i>Tolak Transaksi
                                    </button>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.individual-books.reject', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Transaksi {{ $transaction->transaction_code }}</h5>
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
                                <a href="{{ route('admin.individual-books.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i>Kembali ke List
                                </a>
                            </div>
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
                document.getElementById('confirmForm-' + id).submit();
            }
        });
    }
</script>
@endpush
