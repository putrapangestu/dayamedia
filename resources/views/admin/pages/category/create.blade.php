@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Tambah Kategori"
            description="Halaman untuk menambahkan kategori buku baru"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Tambah Kategori Buku</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.member.index') }}" class="btn bg-primary-subtle text-primary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">Kategori <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Novel" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
