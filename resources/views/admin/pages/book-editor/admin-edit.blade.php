@extends('admin.layouts.app')

@section('title', 'Kelola Pengajuan Klaim Editor')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Kelola Pengajuan Klaim Editor"
            description="Kelola persetujuan pengajuan klaim editor buku"
            :breadcrumbs="[
                ['title' => 'Persetujuan Klaim', 'url' => route('admin.book-editor.claims')],
                ['title' => 'Kelola', 'url' => '#']
            ]"
            >
        </x-header-page>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.book-editor.claims.update', $bookEditor->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Editor</label>
                                    <input type="text" class="form-control" value="{{ $bookEditor->user->full_name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Editor</label>
                                    <input type="text" class="form-control" value="{{ $bookEditor->user->email }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <input type="text" class="form-control" value="{{ $bookEditor->book->title }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" class="form-control" value="{{ $bookEditor->book->category?->name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pengajuan</label>
                                    <input type="text" class="form-control" value="{{ $bookEditor->created_at->format('d M Y H:i') }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Saat Ini</label>
                                    <div>
                                        <span class="badge {{ \App\Helpers\StatusHelper::getBookEditorStatusBadge($bookEditor->status) }}">
                                            {{ \App\Helpers\StatusHelper::getStatusText($bookEditor->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="status">Ubah Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', $bookEditor->status) === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="approved" {{ old('status', $bookEditor->status) === 'approved' ? 'selected' : '' }}>Setujui</option>
                                        <option value="rejected" {{ old('status', $bookEditor->status) === 'rejected' ? 'selected' : '' }}>Tolak</option>
                                        <option value="completed" {{ old('status', $bookEditor->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="notes">Catatan</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Tambahkan catatan untuk editor...">{{ old('notes', $bookEditor->notes) }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.book-editor.claims') }}" class="btn bg-secondary-subtle text-secondary waves-effect">
                                    Batal
                                </a>
                                <button type="submit" class="btn bg-primary waves-effect text-white">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Tambahan</h5>
                        <div class="mb-3">
                            <strong>Jumlah Bab:</strong>
                            <span class="float-end">{{ $bookEditor->book->modules->count() }} Bab</span>
                        </div>
                        <div class="mb-3">
                            <strong>Harga E-Book:</strong>
                            <span class="float-end">Rp. {{ number_format($bookEditor->book->price_digital, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Harga Cetak:</strong>
                            <span class="float-end">Rp. {{ number_format($bookEditor->book->price_physical, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <strong>Deskripsi:</strong>
                            <p class="mt-2">{!! Str::limit($bookEditor->book->description, 200) !!}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Aksi Cepat</h5>

                        <!-- Remove Editor Button -->
                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#removeEditorModal">
                            <i class="ti ti-trash"></i> Hapus Editor
                        </button>

                        <!-- Transfer Editor Button -->
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#transferEditorModal">
                            <i class="ti ti-exchange"></i> Pindahkan Editor
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remove Editor Modal -->
<div class="modal fade" id="removeEditorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Editor dari Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.book-editor.claims.remove', $bookEditor->id) }}">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus editor <strong>{{ $bookEditor->user->full_name }}</strong> dari buku <strong>{{ $bookEditor->book->title }}</strong>?</p>
                    <div class="mb-3">
                        <label for="remove_reason" class="form-label">Alasan (Opsional)</label>
                        <textarea class="form-control" id="remove_reason" name="reason" rows="3" placeholder="Berikan alasan penghapusan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Editor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Transfer Editor Modal -->
<div class="modal fade" id="transferEditorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pindahkan Editor ke Buku Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.book-editor.claims.transfer', $bookEditor->id) }}">
                @csrf
                <div class="modal-body">
                    <p>Pindahkan editor <strong>{{ $bookEditor->user->full_name }}</strong> dari buku <strong>{{ $bookEditor->book->title }}</strong> ke buku lain.</p>
                    <div class="mb-3">
                        <label for="new_book_id" class="form-label">Pilih Buku Tujuan <span class="text-danger">*</span></label>
                        <select class="form-control @error('new_book_id') is-invalid @enderror" id="new_book_id" name="new_book_id" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($transferBooks as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->modules_count }} bab)</option>
                            @endforeach
                        </select>
                        @error('new_book_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="transfer_reason" class="form-label">Alasan (Opsional)</label>
                        <textarea class="form-control" id="transfer_reason" name="reason" rows="3" placeholder="Berikan alasan pemindahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Pindahkan Editor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
