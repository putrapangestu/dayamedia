@php
    use Carbon\Carbon;
@endphp

@extends('admin.layouts.app')

@section('title', 'Detail Review File')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.book-editor.file-reviews') }}">Review File</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Review</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Header --}}
        <x-header-page
            title="Detail Review File"
            description="Review dan kelola file yang diupload oleh editor"
        >
            <x-slot:actions>
                <a href="{{ route('admin.book-editor.file-reviews') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </x-slot:actions>
        </x-header-page>

        <div class="row">
            {{-- Informasi Editor & Buku --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> Informasi Editor</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/dashboard/images/profile/user-1.jpg') }}" width="60" height="60" class="rounded-circle me-3" alt="profile">
                            <div>
                                <h6 class="mb-1">{{ $fileSubmission->user->full_name }}</h6>
                                <small class="text-muted">{{ $fileSubmission->user->email }}</small>
                            </div>
                        </div>

                        <div class="mb-2">
                            <strong>No. Telepon:</strong><br>
                            <span>{{ $fileSubmission->user->phone_number ?? '-' }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>Alamat:</strong><br>
                            <span>{{ $fileSubmission->user->address ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-book"></i> Informasi Buku</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $fileSubmission->book->cover) }}" class="img-fluid rounded" style="max-height: 200px;" alt="book cover">
                        </div>

                        <div class="mb-2">
                            <strong>Judul:</strong><br>
                            <span>{{ $fileSubmission->book->title }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>Kategori:</strong><br>
                            <span>{{ $fileSubmission->book->category?->name ?? '-' }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>ISBN:</strong><br>
                            <span>{{ $fileSubmission->book->isbn ?? '-' }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>Penulis:</strong><br>
                            <span>{{ $fileSubmission->book->author ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Review --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="ti ti-file-check"></i> Form Review File</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.book-editor.file-reviews.update', $fileSubmission->id) }}" method="POST" enctype="multipart/form-data">
                        {{-- <form action="" method="POST" enctype="multipart/form-data"> --}}
                            @csrf
                            @method('PUT')

                            {{-- Status File Saat Ini --}}
                            <div class="mb-4">
                                <h6>Status File Saat Ini:</h6>
                                <span class="badge {{ \App\Helpers\StatusHelper::getFileStatusBadge($fileSubmission->file_status) }} fs-6">
                                    {{ \App\Helpers\StatusHelper::getStatusText($fileSubmission->file_status) }}
                                </span>
                            </div>

                            {{-- Tanggal Submit --}}
                            <div class="mb-3">
                                <label class="form-label"><strong>Tanggal Submit:</strong></label>
                                <p class="form-control-plaintext">
                                    {{ $fileSubmission->file_submitted_at ? Carbon::parse($fileSubmission->file_submitted_at)->format('d M Y H:i') : '-' }}
                                </p>
                            </div>

                            {{-- File yang Diupload --}}
                            <div class="mb-4">
                                <label class="form-label"><strong>File yang Diupload:</strong></label>
                                <div class="border rounded p-3 bg-light">
                                    @if($fileSubmission->file_path)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="ti ti-file-text"></i> {{ basename($fileSubmission->file_path) }}
                                            </span>
                                            <a href="{{ route('admin.book-editor.download-file', $fileSubmission->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted">Tidak ada file yang diupload</span>
                                    @endif
                                </div>
                            </div>

                            {{-- File Turnitin (jika ada) --}}
                            @if($fileSubmission->file_turnitin_path)
                                <div class="mb-4">
                                    <label class="form-label"><strong>File Turnitin:</strong></label>
                                    <div class="border rounded p-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="ti ti-file-analytics"></i> {{ basename($fileSubmission->file_turnitin_path) }}
                                            </span>
                                            <a href="{{ route('admin.book-editor.download-file-turnitin', $fileSubmission->id) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="ti ti-download"></i> Download Turnitin
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Update Status --}}
                            <div class="mb-3">
                                <label for="file_status" class="form-label">Update Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('file_status') is-invalid @enderror" id="file_status" name="file_status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="pending" {{ $fileSubmission->file_status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="approved" {{ $fileSubmission->file_status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ $fileSubmission->file_status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="revision" {{ $fileSubmission->file_status == 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                                </select>
                                @error('file_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Catatan Revisi --}}
                            <div class="mb-3" id="revision_notes_container" style="display: none;">
                                <label for="revision_notes" class="form-label">Catatan Revisi</label>
                                <textarea class="form-control @error('revision_notes') is-invalid @enderror"
                                          id="revision_notes"
                                          name="revision_notes"
                                          rows="4"
                                          placeholder="Masukkan catatan revisi untuk editor...">{{ old('revision_notes', $fileSubmission->revision_notes) }}</textarea>
                                @error('revision_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Upload File Revisi (jika perlu) --}}
                            <div class="mb-3" id="file_revisi_container" style="display: none;">
                                <label for="file_revisi" class="form-label">Upload File Revisi (Optional)</label>
                                <input type="file" class="form-control @error('file_revisi') is-invalid @enderror" id="file_revisi" name="file_revisi" accept=".pdf,.doc,.docx">
                                <small class="text-muted">Format: PDF, DOC, DOCX. Max: 10MB</small>
                                @error('file_revisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check"></i> Simpan Review
                                </button>
                                <a href="{{ route('admin.book-editor.file-reviews') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-x"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- History Revisi (jika ada) --}}
        @if($fileSubmission->revision_notes || $fileSubmission->file_revisi_path)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="ti ti-history"></i> History Revisi</h5>
                    </div>
                    <div class="card-body">
                        @if($fileSubmission->revision_notes)
                            <div class="mb-3">
                                <strong>Catatan Revisi Sebelumnya:</strong>
                                <div class="border rounded p-3 bg-light mt-2">
                                    {{ $fileSubmission->revision_notes }}
                                </div>
                            </div>
                        @endif

                        @if($fileSubmission->file_revisi_path)
                            <div class="mb-3">
                                <strong>File Revisi Sebelumnya:</strong>
                                <div class="border rounded p-3 bg-light mt-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="ti ti-file"></i> {{ basename($fileSubmission->file_revisi_path) }}
                                        </span>
                                        <a href="{{ route('admin.book-editor.download-file-revisi', $fileSubmission->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                            <i class="ti ti-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-muted small">
                            <strong>Diupdate terakhir:</strong> {{ $fileSubmission->updated_at ? $fileSubmission->updated_at->format('d M Y H:i') : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    // Show/hide revision notes and file upload based on status
    document.getElementById('file_status').addEventListener('change', function() {
        const revisionContainer = document.getElementById('revision_notes_container');
        const fileRevisiContainer = document.getElementById('file_revisi_container');
        const status = this.value;

        if (status === 'revision' || status === 'rejected') {
            revisionContainer.style.display = 'block';
            if (status === 'revision') {
                fileRevisiContainer.style.display = 'block';
            } else {
                fileRevisiContainer.style.display = 'none';
            }
        } else {
            revisionContainer.style.display = 'none';
            fileRevisiContainer.style.display = 'none';
        }
    });

    // Trigger change event on page load
    document.getElementById('file_status').dispatchEvent(new Event('change'));
</script>
@endpush
