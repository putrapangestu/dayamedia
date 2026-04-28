@extends('admin.layouts.app')

@section('title', 'Detail Royalty')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Detail Royalty"
            description="Detail informasi royalty"
            :breadcrumbs="[
                ['title' => 'Royalty', 'url' => route('admin.royalty.index')],
                ['title' => 'Detail', 'url' => '#']
            ]"
            >
        </x-header-page>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama User</label>
                                <input type="text" class="form-control" value="{{ $royalty->user->full_name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ $royalty->user->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" value="{{ $royalty->book->title }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" class="form-control" value="{{ $royalty->book->category?->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe</label>
                                <input type="text" class="form-control" value="{{ ucfirst($royalty->type) }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control" value="Rp. {{ number_format($royalty->amount, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Persentase</label>
                                <input type="text" class="form-control" value="{{ $royalty->percentage }}%" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <span class="badge 
                                        @if($royalty->status === 'pending') bg-warning text-dark
                                        @elseif($royalty->status === 'paid') bg-success
                                        @elseif($royalty->status === 'cancelled') bg-danger
                                        @endif">
                                        {{ ucfirst($royalty->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" rows="3" readonly>{{ $royalty->description }}</textarea>
                            </div>
                            @if($royalty->notes)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control" rows="2" readonly>{{ $royalty->notes }}</textarea>
                            </div>
                            @endif
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pembuatan</label>
                                <input type="text" class="form-control" value="{{ $royalty->created_at->format('d M Y H:i') }}" readonly>
                            </div>
                            @if($royalty->paid_at)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pembayaran</label>
                                <input type="text" class="form-control" value="{{ $royalty->paid_at->format('d M Y H:i') }}" readonly>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Transaksi</h5>
                        <div class="mb-3">
                            <strong>Kode Transaksi:</strong>
                            <span class="float-end">{{ $royalty->transaction->code }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Pembeli:</strong>
                            <span class="float-end">{{ $royalty->transaction->user->full_name }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Harga Jual:</strong>
                            <span class="float-end">Rp. {{ number_format($royalty->transactionDetail->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Komisi:</strong>
                            <span class="float-end text-success">Rp. {{ number_format($royalty->amount, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <strong>Total Transaksi:</strong>
                            <span class="float-end">Rp. {{ number_format($royalty->transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($royalty->status === 'pending')
                <div class="card mt-3" id="payment">
                    <div class="card-body">
                        <h5 class="card-title">Proses Pembayaran</h5>
                        <form method="POST" action="{{ route('admin.royalty.process-payment', $royalty->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="payment_proof" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" required accept="image/*,.pdf">
                                @error('payment_proof')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG, PDF (Max: 2MB)</small>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Tambahkan catatan pembayaran..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ti ti-credit-card"></i> Proses Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($royalty->status === 'paid' && $royalty->payment_proof)
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Bukti Pembayaran</h5>
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $royalty->payment_proof) }}" class="img-fluid rounded" alt="Bukti Pembayaran" style="max-height: 200px;">
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $royalty->payment_proof) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-eye"></i> Lihat Full
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection