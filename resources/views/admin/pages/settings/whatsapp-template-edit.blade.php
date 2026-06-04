@extends('admin.layouts.app')

@section('title', 'Edit Template WhatsApp')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Template WhatsApp"
            description="Perbarui isi dan status template pesan WhatsApp"
            >
        </x-header-page>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.whatsapp-templates.update', $template->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Template <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $template->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="template_key" class="form-label">Key</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="template_key"
                                    value="{{ $template->template_key }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Template <span class="text-danger">*</span></label>
                                <textarea
                                    class="form-control @error('content') is-invalid @enderror"
                                    id="content"
                                    name="content"
                                    rows="8"
                                    required>{{ old('content', $template->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" @selected(old('status', $template->status) === 'active')>Active</option>
                                    <option value="inactive" @selected(old('status', $template->status) === 'inactive')>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="description"
                                    name="description"
                                    rows="3">{{ old('description', $template->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.whatsapp-templates.index') }}" class="btn bg-secondary-subtle text-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn bg-primary text-white">
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
                        <h5 class="card-title">Variable Tersedia</h5>
                        @forelse(($template->variables ?? []) as $variable)
                            <code class="d-inline-block mb-2">{{ '{' . '{' . $variable . '}' . '}' }}</code><br>
                        @empty
                            <p class="text-muted mb-0">Belum ada variable terdeteksi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
