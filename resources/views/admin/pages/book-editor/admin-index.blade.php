@extends('admin.layouts.app')

@section('title', 'Persetujuan Klaim Editor')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Persetujuan Klaim Editor"
            description="Kelola pengajuan klaim editor buku"
            >
        </x-header-page>

        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="row g-2 align-items-end">
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
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Pengajuan</label>
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
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">List Pengajuan Klaim Editor</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.book-editor.claims') }}" class="btn btn-outline-secondary btn-sm {{ !request('status') ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.book-editor.claims', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ request('status') === 'pending' ? 'active' : '' }}">Menunggu</a>
                        <a href="{{ route('admin.book-editor.claims', ['status' => 'approved']) }}" class="btn btn-outline-success btn-sm {{ request('status') === 'approved' ? 'active' : '' }}">Disetujui</a>
                        <a href="{{ route('admin.book-editor.claims', ['status' => 'rejected']) }}" class="btn btn-outline-danger btn-sm {{ request('status') === 'rejected' ? 'active' : '' }}">Ditolak</a>
                        <a href="{{ route('admin.book-editor.claims', ['status' => 'completed']) }}" class="btn btn-outline-primary btn-sm {{ request('status') === 'completed' ? 'active' : '' }}">Selesai</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Editor</th>
                                <th>Buku</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookEditors as $item)
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
                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ \App\Helpers\StatusHelper::getBookEditorStatusBadge($item->status) }}">
                                            {{ \App\Helpers\StatusHelper::getStatusText($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->notes)
                                            <span class="text-muted">{{ Str::limit($item->notes, 50) }}</span>
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
                                                    <a class="dropdown-item" href="{{ route('admin.book-editor.claims.edit', $item->id) }}">
                                                        <i class="ti ti-edit me-1"></i>Kelola
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.book-editor.claims.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                                            <i class="ti ti-trash me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pengajuan klaim editor</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $bookEditors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
