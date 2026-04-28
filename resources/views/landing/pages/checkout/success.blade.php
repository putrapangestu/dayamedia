@php
    \Carbon\Carbon::setLocale('id');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/checkout.css') }}">
    <style>
        .countdown-container {
            background-color: #fde2e4;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }
        .countdown-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2b2d42;
            margin-bottom: 10px;
        }
        .countdown-date {
            font-size: 1rem;
            color: #2b2d42;
            margin-bottom: 20px;
        }
        .countdown-timer {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 60px;
        }
        .countdown-number {
            font-size: 2rem;
            font-weight: 800;
            color: #ef233c;
            line-height: 1;
        }
        .countdown-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: #2b2d42;
            margin-top: 5px;
        }
        .countdown-note {
            font-size: 0.9rem;
            color: #2b2d42;
            line-height: 1.4;
            margin-top: 15px;
        }
        .countdown-note span {
            color: #7209b7;
            font-weight: 600;
        }
        .countdown-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
            width: 100px;
            pointer-events: none;
        }
        @media (max-width: 576px) {
            .countdown-icon {
                display: none;
            }
            .countdown-timer {
                gap: 10px;
            }
            .countdown-item {
                min-width: 50px;
            }
            .countdown-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="success-title">Transaksi Berhasil!</h1>
                <p class="success-subtitle mb-0">Transaksi Anda telah berhasil diproses</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Informasi Transaksi -->
                <div class="section-title">
                    <i class="fas fa-receipt"></i>
                    Informasi Transaksi
                </div>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Kode Transaksi</span>
                        <span class="info-value">{{ $transaction->transaction_code }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-value">{{ $transaction->created_at->format('d F Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
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
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="section-title">
                    <i class="fas fa-credit-card"></i>
                    Metode Pembayaran
                </div>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Metode</span>
                        <span class="info-value">{{ $transaction->payment_method }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Info Pembayaran</span>
                        <span class="info-value">
                            {{ $bankInfo['bank_name'] }}: {{ $bankInfo['bank_account'] }} (AN. {{ $bankInfo['bank_info'] }})
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kode Promo</span>
                        <span class="info-value">
                            @if($transaction->promo_code)
                                <span class="badge-custom badge-info">{{ $transaction->promo_code }}</span>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Diskon</span>
                        <span class="info-value text-success">- Rp {{ number_format((int) $transaction->discount_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Detail Item -->
                <div class="section-title">
                    <i class="fas fa-box"></i>
                    Detail Item
                </div>
                <div class="item-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($transaction->details->isNotEmpty())
                                @foreach ($transaction->details as $detail)
                                    <tr>
                                        <td class="item-name">{{ $detail?->book?->title ?? $detail?->module?->book?->title ?? 'Tanpa Judul' }}</td>
                                        <td class="text-center">
                                            @if($detail->book)
                                                <span class="badge-custom badge-{{ $detail->type == 'physical' ? 'info' : 'warning' }}">
                                                    {{ $detail->type == 'physical' ? 'Physical' : 'E-Book' }}
                                                </span>
                                            @elseif($detail->module)
                                                <span class="badge-custom badge-primary">
                                                    {{ $detail->module->title }} | Bab {{ $detail->module->chapter }}
                                                </span>
                                            @else
                                                <span class="badge-custom badge-secondary">Item</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format((int) $detail->price_book, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format(((int) $detail->price_book) * ((int) $detail->quantity), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @elseif($transaction->individualBookPackage)
                                <tr>
                                    <td class="item-name">
                                        {{ $transaction->individualBookPackage->name }}
                                        @if($transaction->additional_authors_count)
                                            <div class="text-muted" style="font-size: 0.9rem;">
                                                Penulis tambahan: {{ (int) $transaction->additional_authors_count }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-custom badge-primary">Paket Buku Individu</span>
                                    </td>
                                    <td class="text-center">1</td>
                                    <td class="text-end">Rp {{ number_format($packageSubtotal, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($packageSubtotal, 0, ',', '.') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada item.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Total Section -->
                <div class="total-section">
                    <div class="info-row">
                        <span class="info-label">Subtotal</span>
                        <span class="info-value">Rp {{ number_format($subtotalValue, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Diskon</span>
                        <span class="info-value">- Rp {{ number_format((int) $transaction->discount_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Biaya Admin</span>
                        <span class="info-value">Rp {{ number_format((int) $transaction->admin_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row border-0 mt-2 pt-2" style="border-top: 2px dashed rgba(255,255,255,0.3) !important;">
                        <span class="info-label" style="font-size: 1.1rem;">Total Pembayaran</span>
                        <span class="info-value total-amount">Rp {{ number_format((int) $transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($transaction->status == 'pending' && !$transaction->payment_proof && $transaction->expired_at)
                    <div class="countdown-container">
                        <div class="countdown-title">Selesaikan pembayaran sebelum:</div>
                        <div class="countdown-date">{{ \Carbon\Carbon::parse($transaction->expired_at)->translatedFormat('l, d F Y') }} pukul {{ \Carbon\Carbon::parse($transaction->expired_at)->format('H.i') }}</div>

                        <div class="countdown-timer">
                            <div class="countdown-item">
                                <span class="countdown-number" id="days">00</span>
                                <span class="countdown-label">Hari</span>
                            </div>
                            <div class="countdown-item">
                                <span class="countdown-number" id="hours">00</span>
                                <span class="countdown-label">Jam</span>
                            </div>
                            <div class="countdown-item">
                                <span class="countdown-number" id="minutes">00</span>
                                <span class="countdown-label">Menit</span>
                            </div>
                            <div class="countdown-item">
                                <span class="countdown-number" id="seconds">00</span>
                                <span class="countdown-label">Detik</span>
                            </div>
                        </div>

                        <div class="countdown-note">
                            Pesanan akan diproses setelah membayar dan upload bukti pembayaran.
                        </div>

                        <div class="countdown-icon">
                            <i class="fas fa-wallet" style="font-size: 4rem; color: #3a86ff; position: relative;"></i>
                            <i class="fas fa-clock" style="font-size: 2.5rem; color: #80ed99; position: absolute; top: -15px; right: -15px; background: white; border-radius: 50%; padding: 2px;"></i>
                        </div>
                    </div>

                    <script>
                        const expiredAt = new Date("{{ $transaction->expired_at }}").getTime();

                        const countdown = setInterval(function() {
                            const now = new Date().getTime();
                            const distance = expiredAt - now;

                            if (distance < 0) {
                                clearInterval(countdown);
                                document.getElementById("days").innerHTML = "00";
                                document.getElementById("hours").innerHTML = "00";
                                document.getElementById("minutes").innerHTML = "00";
                                document.getElementById("seconds").innerHTML = "00";
                                return;
                            }

                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
                            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
                            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
                            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');
                        }, 1000);
                    </script>
                @endif

                @if ($transaction->status == 'pending' && !$transaction->payment_proof)
                <form action="{{ route('account.transaction.upload-payment', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <x-dropzone
                            name="payment_proof"
                            label="Bukti Pembayaran"
                            accept="image/*,application/pdf"
                            :maxSize="5"
                            :required="false"
                            helperText="Upload bukti pembayaran dengan jelas"
                        />
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
                    <button type="submit" class="btn btn-primary-custom w-100">
                        Bayar Sekarang
                    </button>
                </form>
                @endif

                <button class="btn btn-outline-custom w-100 mt-2 paylater">
                    {{ $transaction->status == 'pending' && !$transaction->payment_proof ? 'Bayar Nanti' : 'Kembali' }}
                </button>

                <!-- Footer Note -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Terima kasih telah berbelanja bersama kami.
                        <a href="#" class="text-decoration-none">Hubungi Support</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('') }}assets/dashboard/js/vendor.min.js"></script>
    <script src="{{ asset('') }}assets/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.paylater').click(function (e) {
                e.preventDefault();
                localStorage.setItem(
                    'activePill',
                    '#pills-transaction'
                );

                // Redirect to account page
                window.location.href = "{{ route('member') }}";
            });
        });
    </script>
</body>
</html>
