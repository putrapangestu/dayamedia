@extends('admin.layouts.app')

@section('title', 'Edit Buku')

@push('css')
<link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/select2/dist/css/select2.min.css">
@endpush


@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Buku"
            description="Halaman untuk mengubah buku"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4 align-items-center">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Edit Buku</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.book.index') }}" class="btn bg-primary-subtle text-primary">
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
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="isbn">Status Buku <span class="text-danger">*</span></label>
                                        <div class="col-md-12 col-xl-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input primary" type="radio" name="status" id="success-radio" value="open" {{ $book->status == 'open' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="success-radio">Open Kolaborasi</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input primary" type="radio" name="status" id="success2-radio" value="editing" {{ $book->status == 'editing' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="success2-radio">Editing</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input primary" type="radio" name="status" id="success3-radio" value="published" {{ $book->status == 'published' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="success3-radio">Published</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input primary" type="radio" name="status" id="success3-radio" value="closed" {{ $book->status == 'closed' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="success3-radio">Closed</label>
                                            </div>
                                        </div>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="code_isbn">ISBN</label>
                                        <input type="text" class="form-control" id="code_isbn" name="code_isbn" placeholder="2025-12738-9837-0" value="{{ old('code_isbn', $book->code_isbn) }}">
                                        @error('code_isbn')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title">Judul Buku <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Buku 1" value="{{ old('title', $book->title) }}">
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="price_physical">Harga Buku Cetak </label>
                                        <input type="text" class="form-control" id="price_physical" name="price_physical" placeholder="100000" value="{{ old('price_physical', $book->price_physical) }}">
                                        @error('price_physical')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="price_digital">Harga E-book </label>
                                        <input type="text" class="form-control" id="price_digital" name="price_digital" placeholder="100000" value="{{ old('price_digital', $book->price_digital) }}">
                                        @error('price_digital')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="editor">Nama Editor (Opsional)</label>
                                        <input type="text" class="form-control" id="editor" name="editor" placeholder="Nama Editor" value="{{ old('editor', $book->editor) }}">
                                        @error('editor')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="category">Kategori <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category?->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if(!$book->is_individual)
                                 <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="author">Penulis</label>
                                        <select name="author[]" id="author" class="form-control select2-author" multiple="multiple">
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}" {{ in_array($author->id, old('author', $authorSelecteds->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $author->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('author')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                 <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="publisher">Penerbit </label>
                                        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Azzia" value="{{ old('publisher', $book->publisher) }}">
                                        @error('publisher')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="weight">Berat Buku</label>
                                        <div class="input-group">
                                            <input type="number" id="weight" name="weight" class="form-control" placeholder="100" aria-label="Berat Buku" aria-describedby="basic-addon1" value="{{ old('weight', $book->weight) }}">
                                            <span class="input-group-text">Gram</span>
                                        </div>
                                        @error('weight')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="pages">Halaman Buku</label>
                                        <div class="input-group">
                                            <input type="number" id="pages" name="pages" class="form-control" placeholder="314" aria-label="Berat Buku" aria-describedby="basic-addon1" value="{{ old('pages', $book->pages) }}">
                                            <span class="input-group-text">Halaman</span>
                                        </div>
                                        @error('pages')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="year_published">Tahun Terbit <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="year_published" name="year_published" placeholder="2026" value="{{ old('year_published', $book->year_published) }}">
                                        @error('year_published')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="website">Website Buku</label>
                                        <input type="text" class="form-control" id="website" name="website" placeholder="https://azzia.com" value="{{ old('website', $book->website) }}">
                                        @error('website')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="google_scholar_url">Google Scholar</label>
                                        <input type="url" class="form-control" id="google_scholar_url" name="google_scholar_url" placeholder="https://scholar.google.com/..." value="{{ old('google_scholar_url', $book->google_scholar_url) }}">
                                        @error('google_scholar_url')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea id="mymce" name="description">{!! old('description', $book->description) !!}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Foto Buku</label>
                                    @if($book->cover)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Current Cover" class="img-thumbnail" style="max-width: 200px;">
                                            {{-- <p class="text-muted small mt-1">File saat ini: {{ basename($book->cover) }}</p> --}}
                                        </div>
                                    @endif
                                    <x-dropzone
                                        name="cover"
                                        label="Ganti Foto Buku"
                                        accept="image/*"
                                        :maxSize="1"
                                        :required="false"
                                        helperText="Upload foto buku dengan jelas (Max: 1MB)"
                                    />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">File Buku Lengkap</label>
                                    @if($book->full_content)
                                        <div class="mb-2">
                                            <a href="{{ route('book.file', [$book->slug, 'full']) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="ti ti-file-text"></i> Lihat File Saat Ini
                                            </a>
                                            {{-- <p class="text-muted small mt-1">File saat ini: {{ basename($book->full_content) }}</p> --}}
                                        </div>
                                    @endif
                                    <x-dropzone
                                        name="full_content"
                                        label="Ganti File Buku"
                                        accept="application/pdf"
                                        :maxSize="10"
                                        :required="false"
                                        helperText="Upload file buku (Max: 10MB)"
                                    />

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">File Preview Buku</label>
                                    @if($book->half_content)
                                        <div class="mb-2">
                                            <a href="{{ route('book.preview-pdf', $book->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="ti ti-file-text"></i> Lihat Preview Saat Ini
                                            </a>
                                            {{-- <p class="text-muted small mt-1">File saat ini: {{ basename($book->half_content) }}</p> --}}
                                        </div>
                                    @endif
                                    <x-dropzone
                                        name="half_content"
                                        label="Ganti Preview Buku"
                                        accept="application/pdf"
                                        :maxSize="2"
                                        :required="false"
                                        helperText="Upload preview file buku (Max: 2MB)"
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
<script src="{{ asset('') }}assets/dashboard/libs/tinymce/tinymce.min.js"></script>
<script>
    let authors = @json($authors);
    // let bookAuthors = @json($book->authors);/

    $(document).ready(function() {
        tinymce.init({
            selector: "textarea#mymce",
        });

        $(".select2").select2();

        var $authorSelect = $('.select2-author').select2({
        placeholder: 'Pilih Penulis',
        allowClear: true,
        width: '100%',
        // IMPORTANT: Disable built-in sorting
        sorter: function(data) {
            return data;
        }
    });

        var selectedOrder = [];
        // Set selected authors
        // const selectedAuthors = Array.from(bookAuthors.map(bookAuthor => bookAuthor.user_id));
        const selectedAuthors = @json($authorSelecteds->pluck('id')->toArray());
        selectedOrder = selectedAuthors;
        $("#author").val(selectedAuthors).trigger("change");

    // Store old selection order if exists
    @if(old('author'))
        selectedOrder = {!! json_encode(old('author')) !!};
    @endif

    // Maintain selection order on change
    $authorSelect.on('select2:select', function(e) {
        var selectedId = e.params.data.id;

        // Add to order array if not exists
        if (!selectedOrder.includes(selectedId)) {
            selectedOrder.push(selectedId);
        }

        // Reorder selected options based on selection order
        reorderSelectedOptions();
    });

    // Handle deselection
    $authorSelect.on('select2:unselect', function(e) {
        var unselectedId = e.params.data.id;

        // Remove from order array
        selectedOrder = selectedOrder.filter(id => id !== unselectedId);
    });

    // Function to reorder selected options
    function reorderSelectedOptions() {
        var $select = $('.select2-author');

        // Get all selected values
        var selectedValues = $select.val() || [];

        // Sort selected values based on selection order
        selectedValues.sort(function(a, b) {
            return selectedOrder.indexOf(a) - selectedOrder.indexOf(b);
        });

        // Update select element order
        selectedValues.forEach(function(value) {
            var $option = $select.find('option[value="' + value + '"]');
            $select.append($option); // Move to end (maintains order)
        });

        // Trigger change to update Select2 display
        $select.trigger('change.select2');
    }

    // Initialize order on page load (for old values)
    if (selectedOrder.length > 0) {
        reorderSelectedOptions();
    }


    });
</script>
@endpush
