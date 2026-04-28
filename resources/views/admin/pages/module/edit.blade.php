@extends('admin.layouts.app')

@section('title', 'Edit Bab')

@push('css')
<link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/select2/dist/css/select2.min.css">
@endpush

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Bab"
            description="Halaman edit bab buku"
            :breadcrumbs="[
                ['title' => 'Buku', 'url' => route('admin.book.index')],
                ['title' => $module->book->title, 'url' => route('admin.book.show', $module->book_id)],
                ['title' => 'Edit Bab', 'url' => '#']
            ]"
            >
        </x-header-page>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.module.update', $module->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="book_id" value="{{ $module->book_id }}">

                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <label for="title">Judul <span class="text-danger">*</span></label>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $module->title) }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label for="chapter">Bab <span class="text-danger">*</span></label>
                                <input id="chapter" type="number" name="chapter" class="form-control @error('chapter') is-invalid @enderror" value="{{ old('chapter', $module->chapter) }}" required>
                                @error('chapter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="price">Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $module->price) }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Deadline Type Selection -->
                        {{-- <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="deadline_type">Tipe Tenggat <span class="text-danger">*</span></label>
                                <select id="deadline_type" name="deadline_type" class="form-control @error('deadline_type') is-invalid @enderror" required>
                                    <option value="days" {{ old('deadline_type', $module->deadline_type) == 'days' ? 'selected' : '' }}>Hari</option>
                                    <option value="date" {{ old('deadline_type', $module->deadline_type) == 'date' ? 'selected' : '' }}>Tanggal</option>
                                </select>
                                @error('deadline_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <!-- Days Input (shown when deadline_type is 'days') -->
                        @if(!$module->deadline)
                            <div class="col-md-6 mb-3" id="days_container">
                                <div class="form-group">
                                    <label for="days">Jumlah Hari <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" id="days" name="days" class="form-control @error('days') is-invalid @enderror" value="{{ old('days', $module->days) }}">
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                    @error('days')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <!-- Date Input (shown when deadline_type is 'date') -->
                            <div class="col-md-6 mb-3" id="date_container">
                                <div class="form-group">
                                    <label for="deadline_date">Tanggal Tenggat <span class="text-danger">*</span></label>
                                    <input type="date" id="deadline_date" name="deadline_date" class="form-control @error('deadline_date') is-invalid @enderror" value="{{ old('deadline_date', $module->deadline_date ?? $module->deadline) }}">
                                    @error('deadline_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif


                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="user_id">Penulis </label>
                                <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror select2-author">
                                    <option value="">Pilih Penulis</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $module->user_id) == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="description">Keterangan</label>
                                <textarea name="description" rows="4" placeholder="Deskripsi bab..." id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $module->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($module->user_id)
                            <div class="col-md-6 mb-3">
                                @if($module->file_path)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <x-dropzone
                                        name="file"
                                        label="File Naskah (Opsional)"
                                        accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        :maxSize="10"
                                        :required="false"
                                        helperText="Upload file naskah (DOC, DOCX - Max: 10MB)"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                @if($module->file_path_turnitin)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $module->file_path_turnitin) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <x-dropzone
                                        name="turnitin_file"
                                        label="File Turnitin (Opsional)"
                                        accept="application/pdf"
                                        :maxSize="5"
                                        :required="false"
                                        helperText="Upload file turnitin (PDF - Max: 5MB)"
                                    />
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.book.show', $module->book_id) }}" class="btn bg-primary-subtle text-primary waves-effect">
                            Batal
                        </a>
                        <button type="submit" class="btn bg-primary waves-effect text-white">
                            Update Bab
                        </button>
                    </div>
                </form>
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
        $('.select2-author').select2({
            width: '100%',
            allowClear: true,
            placeholder: "Pilih Penulis"
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deadlineType = document.getElementById('deadline_type');
        const daysContainer = document.getElementById('days_container');
        const dateContainer = document.getElementById('date_container');
        const daysInput = document.getElementById('days');
        const dateInput = document.getElementById('deadline_date');

        deadlineType.addEventListener('change', function() {
            if (this.value === 'days') {
                daysContainer.style.display = 'block';
                dateContainer.style.display = 'none';
                daysInput.setAttribute('required', 'required');
                dateInput.removeAttribute('required');
            } else {
                daysContainer.style.display = 'none';
                dateContainer.style.display = 'block';
                dateInput.setAttribute('required', 'required');
                daysInput.removeAttribute('required');
            }
        });

        // Set required attributes based on initial value
        if (deadlineType.value === 'days') {
            daysInput.setAttribute('required', 'required');
            dateInput.removeAttribute('required');
        } else {
            dateInput.setAttribute('required', 'required');
            daysInput.removeAttribute('required');
        }


    });
</script>
@endpush
