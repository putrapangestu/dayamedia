@php
    use Carbon\Carbon;
@endphp

@extends('admin.layouts.app')

@push('css')
    @include('components.timeline-style')
@endpush

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Buku Editor"
            description="List buku editor"
            >
          </x-header-page>
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="shop-detail">
                <div class="card border mb-2">
                  <div class="card-body p-4">
                    <h4 class="mb-4 fw-semibold">Timeline Penulisan</h4>
                    <div class="timeline-horizontal">
                    <!-- Step 1 -->
                    <div class="timeline-item done">
                        <div class="timeline-circle">
                        <i class="ti ti-users"></i>
                        </div>
                        <div class="timeline-text">
                        <strong>Kolaborasi</strong>
                        <span> {{ $countModules }} / {{ $countModules }}</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="timeline-item
                        @if ($countActiveModules != $countAuthorUploads &&
                            $book->status == 'editing')
                            active
                        @elseif ($countActiveModules == $countAuthorUploads &&
                            $book->status == 'editing' || $book->status == 'published')
                            done
                        @else
                            disabled
                        @endif
                    ">
                        <div class="timeline-circle">
                        <i class="ti ti-upload"></i>
                        </div>
                        <div class="timeline-text">
                        <strong>Upload Naskah</strong>
                        <span>{{ $countAuthorUploads }} / {{ $countActiveModules }}</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="timeline-item
                        @if ($book->status == 'editing' && $book->bookEditors && $book->bookEditors->file_status !== 'approved' && $countActiveModules == $countAuthorUploads)
                            active
                        @elseif (($book->status == 'published' || ($book->bookEditors && $book->bookEditors->file_status === 'approved')) && $countActiveModules == $countAuthorUploads)
                            done
                        @else
                            disabled
                        @endif
                    ">
                        <div class="timeline-circle">
                        <i class="ti ti-edit"></i>
                        </div>
                        <div class="timeline-text">
                        <strong>Editing Naskah<br>Oleh Editor</strong>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="timeline-item disabled
                        @if ($book->status == 'published' && $countActiveModules == $countAuthorUploads)
                            done
                        @elseif ($book->status == 'editing' && $book->bookEditors && $book->bookEditors->file_status === 'approved' && $countActiveModules == $countAuthorUploads)
                            active
                        @else
                            disabled
                        @endif
                    ">
                        <div class="timeline-circle">
                        <i class="ti ti-file-text"></i>
                        </div>
                        <div class="timeline-text">
                        <strong>Input ISBN</strong>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="timeline-item disabled">
                        <div class="timeline-circle">
                        <i class="ti ti-book"></i>
                        </div>
                        <div class="timeline-text">
                        <strong>Buku Publish</strong>
                        <span>created</span>
                        </div>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="row">
                    @forelse ($book->modules as $module)
                        <div class="col-md-6">
                            <div class="card border mt-3">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <img src='https://images.unsplash.com/photo-1557752281-0dcc70763e98?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' class="rounded-xl img-fluid">
                                        </div>
                                        <div class="col-8 align-items-center">
                                            <h6 class="fw-semibold mb-0">{{ $module->title }}</h6>
                                            <p class="text-muted mb-0">Bab {{ $module->chapter }} - <i class="ti ti-user"></i> {{ $module->user?->full_name }}</p>
                                            @if ($module->file_path)
                                                <a href="{{ route('editor.module.download', $module->id) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-3 w-100"><i class="ti ti-download"></i> Donwnload File</a>
                                            @else
                                                <button class="btn btn-outline-danger btn-sm mt-3 w-100" disabled>File belum diupload</button>
                                            @endif
                                            @if ($module->file_path_turnitin)
                                                <a href="{{ route('editor.module.download', $module->id) . '?type=turnitin' }}" target="_blank" class="btn btn-outline-primary btn-sm mt-3 w-100"><i class="ti ti-download"></i> Donwnload File Turnitin</a>
                                            @else
                                                <button class="btn btn-outline-danger btn-sm mt-3 w-100" disabled>File Turnitin belum diupload</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Tidak ada modul untuk buku ini.
                            </div>
                        </div>
                    @endforelse
                </div>
              </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header border-bottom bg-white">
                        <h4 class="card-title mb-0">Detail Buku</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('assets/dashboard/images/products/product-1.jpg') }}"
                                alt="{{ $book->title }}"
                                class="img-fluid rounded shadow-sm mb-3"
                                style="max-height: 250px; width: 100%; object-fit: cover;">
                            <h5 class="fw-bolder mb-1">{{ $book->title }}</h5>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $book->category?->name }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted py-2" style="width: 40%;"><i class="ti ti-barcode me-2 text-primary"></i>ISBN</td>
                                        <td class="fw-bold py-2 text-dark">{{ $book->code_isbn ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><i class="ti ti-calendar me-2 text-primary"></i>Tahun</td>
                                        <td class="fw-bold py-2 text-dark">{{ $book->year_published ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><i class="ti ti-building-community me-2 text-primary"></i>Penerbit</td>
                                        <td class="fw-bold py-2 text-dark">{{ $book->publisher ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><i class="ti ti-file-text me-2 text-primary"></i>Halaman</td>
                                        <td class="fw-bold py-2 text-dark">{{ $book->pages ?? '-' }} hlm</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><i class="ti ti-weight me-2 text-primary"></i>Berat</td>
                                        <td class="fw-bold py-2 text-dark">{{ $book->weight ?? '-' }} g</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><i class="ti ti-users me-2 text-primary"></i>Penulis</td>
                                        <td class="fw-bold py-2 text-dark">
                                            @forelse ($book->authors as $author)
                                                <div class="mb-1 text-truncate" title="{{ $author->user->full_name ?? $author->name }}">
                                                    {{ $author->user->full_name ?? $author->name }}
                                                </div>
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom bg-white">
                        <h4 class="card-title">Upload File Final</h4>
                        @if($book->bookEditors)
                            <div class="mt-2">
                                <span class="badge {{ \App\Helpers\StatusHelper::getFileStatusBadge($book->bookEditors->file_status) }}">
                                    Status File: {{ \App\Helpers\StatusHelper::getStatusText($book->bookEditors->file_status) }}
                                </span>
                                @if($book->bookEditors->file_submitted_at)
                                    <small class="text-muted d-block mt-1">Dikirim: {{ $book?->bookEditors?->file_submitted_at ?  Carbon::parse($book->bookEditors->file_submitted_at)->format('d M Y H:i') : '-' }}</small>
                                @endif
                                @if($book->bookEditors->file_reviewed_at)
                                    <small class="text-muted d-block">Direview: {{ $book?->bookEditors?->file_reviewed_at ?  Carbon::parse($book->bookEditors->file_reviewed_at)->format('d M Y H:i') : '-' }}</small>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($book->bookEditors && $book->bookEditors->file_status === 'rejected')
                            <div class="alert alert-danger mb-3">
                                <strong>File Ditolak:</strong> {{ $book->bookEditors->revision_notes }}
                            </div>
                        @elseif($book->bookEditors && $book->bookEditors->file_status === 'revision')
                            <div class="alert alert-info mb-3">
                                <strong>Perlu Revisi:</strong> {{ $book->bookEditors->revision_notes }}
                            </div>
                        @endif

                        @if($book->bookEditors && $book->bookEditors->file_status === 'approved')
                            <div class="alert alert-success mb-3">
                                <strong>File telah disetujui!</strong> Anda dapat melanjutkan ke proses berikutnya.
                            </div>
                        @endif

                        @if($book->bookEditors->file_path)
                            <div class="mb-3">
                                <a href="{{ asset('storage/' . $book->bookEditors->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                </a>
                            </div>
                        @endif
                        @if(!$book->bookEditors || in_array($book->bookEditors->file_status, ['pending', 'rejected', 'revision']))
                            <form action="{{ route('editor.book-editor.upload-file-editor', $book->bookEditors->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-dropzone
                                    name="file_path"
                                    label="File Buku"
                                    accept="application/pdf"
                                    :maxSize="100"
                                    :required="true"
                                    helperText="Upload lengkap file buku"
                                />

                                {{-- <x-dropzone
                                    name="file_turnitin"
                                    label="Turnitin"
                                    accept="application/pdf"
                                    :maxSize="100"
                                    :required="true"
                                    helperText="Upload lengkap file buku"
                                /> --}}

                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        @endif

                        <!-- Admin Approval Section -->
                        @role('admin')
                            @if($book->bookEditors && $book->bookEditors->file_submitted_at && $book->bookEditors->file_status !== 'approved')
                                <hr class="my-4">
                                <h5 class="mb-3">Review File (Admin)</h5>
                                <form action="{{ route('editor.book-editor.file-approval', $book->bookEditors->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file_status" class="form-label">Status File</label>
                                        <select class="form-control" id="file_status" name="file_status" required>
                                            <option value="pending" {{ $book->bookEditors->file_status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="approved" {{ $book->bookEditors->file_status === 'approved' ? 'selected' : '' }}>Setujui</option>
                                            <option value="rejected" {{ $book->bookEditors->file_status === 'rejected' ? 'selected' : '' }}>Tolak</option>
                                            <option value="revision" {{ $book->bookEditors->file_status === 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="revision_notes" class="form-label">Catatan Review</label>
                                        <textarea class="form-control" id="revision_notes" name="revision_notes" rows="3" placeholder="Berikan catatan untuk editor...">{{ $book->bookEditors->revision_notes }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Simpan Review</button>
                                </form>
                            @endif
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
