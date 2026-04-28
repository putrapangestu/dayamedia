@extends('admin.layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/select2/dist/css/select2.min.css">
@endpush

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Tambah Dokumen"
            description="Halaman untuk menambahkan dokumen baru"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('settings.store-document') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Tambah Dokumen</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('settings.documents') }}" class="btn bg-primary-subtle text-primary">
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
                                        <label for="name">Nama Dokumen <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Panduan Penulisan" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author">Member </label>
                                        <select name="member[]" id="member" class="form-control select2-member" multiple="multiple">
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" {{ in_array($member->id, old('member', [])) ? 'selected' : '' }}>{{ $member->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-small">Pilih member jika dokumen ini hanya untuk member tertentu</div>
                                        @error('member.*')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-dropzone
                                        name="file"
                                        label="File Dokumen"
                                        accept="application/pdf,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        :maxSize="5"
                                        :required="true"
                                        helperText="Upload file dokumen (PDF/Gambar/Dokumen Word - Max: 5MB)"
                                    />
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

@push('js')
<script src="{{ asset('') }}assets/dashboard/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('') }}assets/dashboard/libs/select2/dist/js/select2.min.js"></script>

<script>
     $(document).ready(function() {
        var $authorSelect = $('.select2-member').select2({
            placeholder: 'Pilih Member',
            allowClear: true,
            width: '100%',
            // IMPORTANT: Disable built-in sorting
            sorter: function(data) {
                return data;
            }
        });
     })
</script>
@endpush
