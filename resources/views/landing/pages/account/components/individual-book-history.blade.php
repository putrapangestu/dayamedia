<div class="card shadow-none border">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Riwayat Buku Individu</h4>
            <a href="{{ route('individual-books.packages') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="ti ti-plus fs-4"></i>
                Beli Paket Baru
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered display text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>Transaksi</th>
                        <th>Paket</th>
                        <th>Penulis</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $individualTrx = $transactions->filter(fn($t) => $t->individual_book_package_id != null);
                    @endphp
                    @forelse ($individualTrx as $trx)
                        <tr>
                            <td>
                                <h6 class="mb-1 fw-bolder">{{ $trx->transaction_code }}</h6>
                                <span class="badge fs-2 bg-info-subtle text-info">{{ $trx->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <h6 class="mb-0 fw-bolder">{{ $trx->individualBookPackage?->name }}</h6>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $trx->additional_authors_count + ($trx->individualBookPackage?->max_authors_default ?? 0) }} Total Penulis
                                </span>
                            </td>
                            <td>
                                <h6 class="fw-bolder mb-0">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</h6>
                            </td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'pending' => ['class' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Pembayaran'],
                                        'confirmed' => ['class' => 'bg-success-subtle text-success', 'text' => 'Terkonfirmasi'],
                                        'rejected' => ['class' => 'bg-danger-subtle text-danger', 'text' => 'Ditolak'],
                                        'paid' => ['class' => 'bg-info-subtle text-info', 'text' => 'Sudah Bayar'],
                                    ];
                                    $label = $statusLabels[$trx->individual_book_status] ?? ['class' => 'bg-secondary-subtle text-secondary', 'text' => ucfirst($trx->individual_book_status)];
                                @endphp
                                <span class="badge {{ $label['class'] }}">{{ $label['text'] }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($trx->individual_book_status === 'confirmed' &&
                                        ($trx->details?->first()?->book?->status != "published" || $trx->details?->first()?->book?->status != "closed")
                                    )
                                        <a href="{{ route('individual-books.upload', $trx) }}" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                                            <i class="ti ti-upload fs-4"></i> Unggah Naskah
                                        </a>
                                    @endif
                                    <a href="{{ route('checkout.success', $trx->transaction_code) }}" class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="mb-3">
                                    <i class="ti ti-book-off fs-10 text-muted"></i>
                                </div>
                                <p class="text-muted mb-0">Belum ada riwayat pesanan buku individu.</p>
                                <a href="{{ route('individual-books.packages') }}" class="btn btn-primary mt-3">Lihat Paket Penerbitan</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
