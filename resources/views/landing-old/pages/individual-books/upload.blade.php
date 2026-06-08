@extends('landing.layouts.app')

@push('css')
    <!-- Select2 CSS -->
    <link href="{{ asset('assets/dashboard/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 3.25rem;
            border-radius: 0.75rem;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            padding-left: 0;
            color: #212529;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 0.75rem;
        }
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
            outline: 0;
        }
        .custom-card {
            border-radius: 1rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            border: 1px solid rgba(0,0,0,.125);
            overflow: hidden;
        }
        .custom-card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1.25rem;
            min-height: 3.25rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
            border-color: var(--bs-primary);
        }
        .btn-custom {
            border-radius: 0.75rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        .section-title {
            border-left: 4px solid var(--bs-primary);
            padding-left: 0.75rem;
            font-weight: bold;
            color: #212529;
            margin-bottom: 1.5rem;
        }
        .section-title-success {
            border-left-color: var(--bs-success);
        }
    </style>
@endpush

@section('content')
<div class="bg-light py-5 min-vh-100">
    <div class="container" style="max-width: 1000px;">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold text-dark mb-2">Unggah Naskah Buku Individu</h1>
            <p class="text-muted">Lengkapi data buku Anda untuk memulai proses editorial.</p>
        </div>

        <div class="card custom-card border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center bg-primary bg-opacity-10 border-bottom-0">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:bill-list-bold" class="text-primary fs-1 me-3"></iconify-icon>
                    <div>
                        <p class="small fw-bold text-primary text-uppercase tracking-widest mb-0">Transaksi Terkonfirmasi</p>
                        <h4 class="h5 fw-bold text-dark mb-0">{{ $transaction->transaction_code }}</h4>
                    </div>
                </div>
                <div class="text-end">
                    <p class="small text-muted mb-0">Paket</p>
                    <p class="fw-bold text-dark mb-0">{{ $transaction->individualBookPackage?->name }}</p>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('individual-books.upload.store', $transaction) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-5">
                        <div class="col-md-6">
                            <h3 class="h5 section-title">Informasi Buku</h3>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title', $book?->title ?? "") }}"
                                       class="form-control"
                                       placeholder="Masukkan judul lengkap buku" required />
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" id="categorySelect" class="form-select" required>
                                    <option value=""></option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id', $book?->category_id ?? "") == $cat->id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Deskripsi / Abstrak <span class="text-danger">*</span></label>
                                <textarea name="description" rows="5"
                                          class="form-control"
                                          placeholder="Tuliskan deskripsi singkat atau abstrak buku Anda..." required>{{ old('description', $book?->description ?? "") }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="h5 section-title section-title-success">Berkas & Penulis</h3>

                            <div class="p-4 bg-light rounded-3 border mb-4">
                                @if($modules?->file_path)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $modules?->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif

                                <div class="mb-4">
                                    <x-dropzone
                                        name="full_content"
                                        label="File Naskah"
                                        accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        :maxSize="10"
                                        :required="!$modules?->file_path"
                                        helperText="Upload file naskah (DOC, DOCX - Max: 10MB)"
                                    />
                                </div>

                                @if($modules?->file_path_turnitin)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $modules?->file_path_turnitin) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="ti ti-file-text"></i> Lihat File Turnitin Saat Ini
                                        </a>
                                    </div>
                                @endif

                                <div>
                                    <x-dropzone
                                        name="turnitin_file"
                                        label="File Turnitin"
                                        accept="application/pdf"
                                        :maxSize="5"
                                        :required="!$modules?->file_path_turnitin"
                                        helperText="Upload file turnitin (PDF - Max: 5MB)"
                                    />
                                </div>
                            </div>

                            <div>
                                @php
                                    $maxDefault = $transaction->individualBookPackage->max_authors_default ?? 3;
                                    $extraAuthors = $transaction->additional_authors_count ?? 0;
                                    $totalAuthors = $maxDefault + $extraAuthors;
                                @endphp
                                <label class="form-label fw-bold text-dark d-flex justify-content-between align-items-center">
                                    <span>Penulis Buku (Total: {{ $totalAuthors }} Slot)</span>
                                </label>
                                <div id="authorsContainer" class="d-flex flex-column gap-3 mt-2">
                                    {{-- Penulis Pertama (User Login) --}}
                                    <div>
                                        <label class="form-label small text-muted fw-semibold mb-1">Penulis 1 (Utama)</label>
                                        <input type="text"
                                               class="form-control bg-light text-muted"
                                               value="{{ auth()->user()->full_name }}" readonly />
                                    </div>

                                    {{-- Penulis Tambahan --}}
                                    @for($i = 2; $i <= $totalAuthors; $i++)
                                        <div>
                                            <label class="form-label small text-muted fw-semibold mb-1">Penulis {{ $i }} (Opsional)</label>
                                            <input type="text" name="additional_authors[]"
                                                value="{{ $authors[$i-1]["author"] ?? "" }}"
                                                class="form-control"
                                                placeholder="Nama penulis ke-{{ $i }}" />
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center text-warning bg-warning bg-opacity-10 px-3 py-2 rounded-3 border border-warning border-opacity-25 w-100 w-md-auto">
                            <iconify-icon icon="solar:info-circle-bold" class="me-2 fs-4 flex-shrink-0"></iconify-icon>
                            <p class="small mb-0">Pastikan data sudah benar. Setelah diunggah, naskah akan masuk ke proses editorial.</p>
                        </div>
                        <button type="submit" class="btn btn-primary btn-custom shadow-sm d-flex align-items-center justify-content-center w-100 w-md-auto">
                            <iconify-icon icon="solar:cloud-upload-bold" class="me-2 fs-4"></iconify-icon>
                            Mulai Proses Editorial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- Select2 JS -->
<script src="{{ asset('assets/dashboard/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#categorySelect').select2({
            placeholder: "Pilih Kategori Buku",
            allowClear: true,
            width: '100%',
        });
    });
</script>
@endpush
