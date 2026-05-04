<div class="card shadow-none border">
    <div class="card-body">
        <h4 class="mb-3">Riwayat Transaksi</h4>
        <div class="table-responsive">
            <table class="table table-bordered display text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penjualan</th>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ \App\Helpers\PaginateHelper::generateItemNumber($loop, $transactions->perPage(), $transactions->currentPage()) }}</td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                        <h6 class="mb-1 fw-bolder">{{ $transaction->transaction_code }}
                                        </h6>
                                        <p class="mb-1 text-muted fs-2">{{ $transaction->user->full_name }}
                                        </p>
                                        <span
                                            class="mb-1 badge fs-2 bg-info-subtle text-info">{{ $transaction->created_at->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($transaction->details->isNotEmpty())
                                    @foreach ($transaction->details as $detail)
                                        <div class="d-flex align-items-center mb-2">
                                            @php
                                                $cover = null;
                                                if ($detail->book && $detail->book->cover) {
                                                    $cover = asset('storage/' . $detail->book->cover);
                                                } elseif ($detail->module && $detail->module->book && $detail->module->book->cover) {
                                                    $cover = asset('storage/' . $detail->module->book->cover);
                                                } else {
                                                    $cover = asset('assets/dashboard/images/products/product-1.jpg');
                                                }
                                            @endphp
                                            <img src="{{ $cover }}" width="50" height="50" class="rounded-1 me-2 flex-shrink-0" alt="item-img" style="object-fit: cover;" />
                                            <div>
                                                <h6 class="mb-0 fs-2 fw-bolder">
                                                    @if($detail->book)
                                                        {{ $detail->book->title }}
                                                    @elseif($detail->module)
                                                        {{ $detail->module->book->title }}
                                                    @else
                                                        Item Tidak Diketahui
                                                    @endif
                                                </h6>
                                                <p class="mb-0 text-muted fs-2">
                                                    @if($detail->module)
                                                        BAB {{ $detail->module->chapter }} | {{ $detail->module->title }}
                                                    @endif
                                                    x {{ $detail->quantity }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif($transaction->individualBookPackage)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('assets/dashboard/images/products/product-1.jpg') }}" width="50" height="50" class="rounded-1 me-2 flex-shrink-0" alt="item-img" style="object-fit: cover;" />
                                        <div>
                                            <h6 class="mb-0 fs-2 fw-bolder">{{ $transaction->individualBookPackage->name }}</h6>
                                            <p class="mb-0 text-muted fs-2">Paket Buku Individu</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <h6 class="fw-bolder">Rp.
                                    {{ number_format($transaction->total_price, 0, ',', '.') }}</h6>
                            </td>
                            <td>
                                {{-- <span class="mb-1 badge bg-success-subtle text-success">{{ ucfirst($transaction->status) }}</span> --}}
                                @if($transaction->status == 'pending' && !$transaction->payment_proof)
                                    <br><span class="badge bg-warning-subtle text-warning mt-1">Menunggu Pembayaran</span>
                                @elseif($transaction->status == 'pending')
                                    <br><span class="badge bg-warning-subtle text-warning mt-1">Menunggu Approval</span>
                                @elseif($transaction->status == 'paid')
                                    <br><span class="badge bg-success-subtle text-success mt-1">Pembayaran Diterima</span>
                                @elseif($transaction->status == 'completed')
                                    <br><span class="badge bg-success-subtle text-success mt-1">Pembelian Selesai</span>
                                @elseif($transaction->status == 'canceled')
                                    <br><span class="badge bg-danger-subtle text-danger mt-1">Pembelian Dibatalkan</span>
                                @elseif($transaction->status == 'expired')
                                    <br><span class="badge bg-warning-subtle text-warning mt-1">Pembayaran Kadaluarsa</span>
                                @elseif($transaction->status == 'rejected')
                                    <br><span class="badge bg-danger-subtle text-danger mt-1">Pembayaran Ditolak</span>
                                @else
                                    <br><span class="badge bg-secondary-subtle text-secondary mt-1">Status Tidak Diketahui</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ route('checkout.success', $transaction->transaction_code) }}" type="button" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                    @if($transaction->status == 'paid' || $transaction->status == 'completed')
                                        @foreach($transaction->details as $detail)
                                            @if($detail->book && $detail->type === 'digital')
                                                <a href="{{ route('book.read', $detail->book->slug) }}" class="btn btn-sm btn-success">
                                                    <i class="ti ti-book me-1"></i>Baca Buku
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                    {{-- @if($transaction->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#uploadPaymentModal{{ $transaction->id }}">
                                            Upload Bukti Bayar
                                        </button>
                                    @endif --}}
                                    @if($transaction->payment_proof)
                                        <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="btn btn-sm btn-info">
                                            Lihat Bukti Bayar
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $transactions->links() }}</div>
        </div>
    </div>
</div>

<!-- Modals for Transaction Details -->
@foreach($transactions as $transaction)
    <div class="modal fade" id="transactionDetailModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="transactionDetailModalLabel{{ $transaction->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionDetailModalLabel{{ $transaction->id }}">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Informasi Transaksi</h6>
                            <table class="table table-sm">
                                <tr><td>Kode Transaksi</td><td>:</td><td><strong>{{ $transaction->transaction_code }}</strong></td></tr>
                                <tr><td>Tanggal</td><td>:</td><td>{{ $transaction->created_at->format('d F Y H:i') }}</td></tr>
                                <tr><td>Status</td><td>:</td><td><span class="badge bg-{{ $transaction->status == 'paid' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($transaction->status) }}</span></td></tr>
                                <tr><td>Total</td><td>:</td><td><strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></td></tr>
                                @if($transaction->promo_code)
                                    <tr><td>Kode Promo</td><td>:</td><td><span class="badge bg-info">{{ $transaction->promo_code }}</span></td></tr>
                                    <tr><td>Diskon</td><td>:</td><td>Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td></tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Metode Pembayaran</h6>
                            <table class="table table-sm">
                                <tr><td>Metode</td><td>:</td><td>{{ ucfirst($transaction->payment_method ?? '-') }}</td></tr>
                                @if($transaction->payment_proof)
                                    <tr><td>Bukti Bayar</td><td>:</td><td><a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a></td></tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <h6>Detail Item</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->details as $detail)
                                    <tr>
                                        <td>
                                            @if($detail->book)
                                                {{ $detail->book->title }}
                                            @elseif($detail->module)
                                                {{ $detail->module->book->title }} - BAB {{ $detail->module->chapter }}: {{ $detail->module->title }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($detail->type) }}</span>
                                        </td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp {{ number_format($detail->price_book, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->price_book * $detail->quantity, 0, ',', '.') }}</td>
                                        <td>
                                            @if($detail->book && $detail->type === 'digital' && ($transaction->status == 'paid' || $transaction->status == 'completed'))
                                                <a href="{{ route('book.read', $detail->book->slug) }}" class="btn btn-sm btn-success">
                                                    <i class="ti ti-book"></i> Baca
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modals for Upload Payment Proof -->
@foreach($transactions as $transaction)
    @if($transaction->status == 'pending')
        <div class="modal fade" id="uploadPaymentModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="uploadPaymentModalLabel{{ $transaction->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadPaymentModalLabel{{ $transaction->id }}">Upload Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('account.transaction.upload-payment', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="payment_proof{{ $transaction->id }}" class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control" id="payment_proof{{ $transaction->id }}" name="payment_proof" accept="image/*,.pdf" required>
                                <div class="form-text">Format: JPG, PNG, PDF. Maksimal 2MB</div>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method{{ $transaction->id }}" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="payment_method{{ $transaction->id }}" name="payment_method" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                    {{-- <option value="e_wallet">E-Wallet</option>
                                    <option value="qris">QRIS</option> --}}
                                </select>
                            </div>
                            <div class="alert alert-info">
                                <strong>Info:</strong> Upload bukti pembayaran untuk transaksi <strong>{{ $transaction->transaction_code }}</strong> sebesar <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Upload Bukti Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
