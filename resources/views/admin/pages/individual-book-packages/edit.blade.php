@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Paket"
            description="Halaman untuk memperbarui data paket penerbitan"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.individual-book-packages.update', $package) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Edit Paket</h5>
                                    <p class="text-muted m-0 p-0">Perbarui informasi paket dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.individual-book-packages.index') }}" class="btn bg-primary-subtle text-primary">
                                        <i class="ti ti-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" placeholder="Contoh: Paket Premium" required>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                                        <input type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price', $package->price) }}" placeholder="0" required>
                                        @error('price')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Penulis Default <span class="text-danger">*</span></label>
                                        <input type="number" name="max_authors_default" min="1" class="form-control" value="{{ old('max_authors_default', $package->max_authors_default) }}" required>
                                        @error('max_authors_default')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan deskripsi paket...">{{ old('description', $package->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select" required>
                                            <option value="active" @selected(old('status', $package->status) == 'active')>Aktif</option>
                                            <option value="inactive" @selected(old('status', $package->status) == 'inactive')>Non-aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="m-0">Benefit Paket</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addBenefit()">
                                    <i class="ti ti-plus"></i> Tambah Benefit
                                </button>
                            </div>

                            <div id="benefits">
                                @forelse($package->benefits as $benefit)
                                <div class="row g-2 align-items-end mb-2 benefit-row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Benefit</label>
                                        <input type="text" name="benefit_name[]" class="form-control" value="{{ $benefit->benefit_name }}" placeholder="Contoh: ISBN">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nilai/Deskripsi</label>
                                        <input type="text" name="benefit_value[]" class="form-control" value="{{ $benefit->benefit_value }}" placeholder="Contoh: Terdaftar resmi">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Urutan</label>
                                        <input type="number" name="benefit_order[]" class="form-control" value="{{ $benefit->sort_order }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100" onclick="removeBenefit(this)">Hapus</button>
                                    </div>
                                </div>
                                @empty
                                <div class="row g-2 align-items-end mb-2 benefit-row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Benefit</label>
                                        <input type="text" name="benefit_name[]" class="form-control" placeholder="Contoh: ISBN">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nilai/Deskripsi</label>
                                        <input type="text" name="benefit_value[]" class="form-control" placeholder="Contoh: Terdaftar resmi">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Urutan</label>
                                        <input type="number" name="benefit_order[]" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100" onclick="removeBenefit(this)">Hapus</button>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addBenefit() {
    const container = document.getElementById('benefits');
    const row = document.createElement('div');
    row.className = 'row g-2 align-items-end mb-2 benefit-row';
    row.innerHTML = `
        <div class="col-md-4">
            <input type="text" name="benefit_name[]" class="form-control" placeholder="Nama Benefit">
        </div>
        <div class="col-md-4">
            <input type="text" name="benefit_value[]" class="form-control" placeholder="Nilai/Deskripsi">
        </div>
        <div class="col-md-2">
            <input type="number" name="benefit_order[]" class="form-control" value="0">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger w-100" onclick="removeBenefit(this)">Hapus</button>
        </div>`;
    container.appendChild(row);
}
function removeBenefit(btn) {
    const row = btn.closest('.benefit-row');
    if (row) row.remove();
}
</script>
@endsection
