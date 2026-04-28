@php
    use Carbon\Carbon;
@endphp

@extends('admin.layouts.app')

@section('title', 'Review File Editor')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Review File Editor"
            description="Kelola review file yang diupload oleh editor"
            >
        </x-header-page>

        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Cari Editor/Buku</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="cari nama editor atau judul buku..."
                            value="{{ request('search') }}"
                            onchange="this.form.submit()"
                        >
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status File</label>
                        <select class="form-control" name="file_status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('file_status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('file_status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('file_status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="revision" {{ request('file_status') == 'revision' ? 'selected' : '' }}>Perlu Revisi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Submit</label>
                        <input
                            type="date"
                            name="date"
                            class="form-control"
                            value="{{ request('date') }}"
                            onchange="this.form.submit()"
                        >
                    </div>
                    <div class="col-12 d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search"></i> Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">List File yang Perlu Direview</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.book-editor.file-reviews') }}" class="btn btn-outline-secondary btn-sm {{ !request('file_status') ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.book-editor.file-reviews', ['file_status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ request('file_status') === 'pending' ? 'active' : '' }}">Menunggu</a>
                        <a href="{{ route('admin.book-editor.file-reviews', ['file_status' => 'approved']) }}" class="btn btn-outline-success btn-sm {{ request('file_status') === 'approved' ? 'active' : '' }}">Disetujui</a>
                        <a href="{{ route('admin.book-editor.file-reviews', ['file_status' => 'rejected']) }}" class="btn btn-outline-danger btn-sm {{ request('file_status') === 'rejected' ? 'active' : '' }}">Ditolak</a>
                        <a href="{{ route('admin.book-editor.file-reviews', ['file_status' => 'revision']) }}" class="btn btn-outline-info btn-sm {{ request('file_status') === 'revision' ? 'active' : '' }}">Perlu Revisi</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Editor</th>
                                <th>Buku</th>
                                <th>Tanggal Submit</th>
                                <th>Status File</th>
                                <th>Catatan Revisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fileSubmissions as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/dashboard/images/profile/user-1.jpg') }}" width="40" height="40" class="rounded-circle me-2" alt="profile">
                                            <div>
                                                <h6 class="mb-0">{{ $item->user->full_name }}</h6>
                                                <small class="text-muted">{{ $item->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->book->cover) }}" width="40" height="40" class="rounded me-2" alt="book cover">
                                            <div>
                                                <h6 class="mb-0">{{ $item->book->title }}</h6>
                                                <small class="text-muted">{{ $item->book->category?->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->file_submitted_at ? Carbon::parse($item->file_submitted_at)->format('d M Y H:i') : '-' }}</td>
                                    <td>
                                        <span class="badge {{ \App\Helpers\StatusHelper::getFileStatusBadge($item->file_status) }}">
                                            {{ \App\Helpers\StatusHelper::getStatusText($item->file_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->revision_notes)
                                            <span class="text-muted">{{ Str::limit($item->revision_notes, 50) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-decoration-none" href="javascript:void(0)" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-4"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.book-editor.file-reviews.edit', $item->id) }}">
                                                        <i class="ti ti-edit me-1"></i>Review
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.book-editor.download-file', $item->id) }}" target="_blank">
                                                        <i class="ti ti-download me-1"></i>Download File
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <a class="dropdown-item" href="{{ route('admin.book-editor.download-file-turnitin', $item->id) }}" target="_blank">
                                                        <i class="ti ti-download me-1"></i>Download Turnitin
                                                    </a>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada file yang perlu direview</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $fileSubmissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
