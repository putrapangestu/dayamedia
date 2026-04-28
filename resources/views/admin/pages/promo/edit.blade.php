@extends('admin.layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/select2/dist/css/select2.min.css">
@endpush

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Promo"
            description="Halaman untuk mengubah promo"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.promo.update', $promo->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Edit Promo</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.promo.index') }}" class="btn bg-primary-subtle text-primary">
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
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="code">Kode Promo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="Premium" value="{{ old('code', $promo->code) }}">
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="percentage">Persentase <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="percentage" name="percentage" placeholder="10" value="{{ old('percentage', $promo->percentage) }}">
                                        @error('percentage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="quantity">Kuota <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Premium" value="{{ old('quantity', $promo->quantity) }}">
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Premium" value="{{ old('start_date', $promo->start_date) }}">
                                        @error('start_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Berakhir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Premium" value="{{ old('end_date', $promo->end_date) }}">
                                        @error('end_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="book_ids">Buku Terkait (opsional)</label>
                                        <select name="book_ids[]" class="form-control select2-book" id="book_ids" multiple="multiple">
                                            @foreach($books as $book)
                                                <option value="{{ $book->id }}" {{ in_array($book->id, old('book_ids', $promo->books->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('book_ids')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description">Deskripsi Promo</label>
                                        <textarea name="description" class="form-control" id="description" rows="3" placeholder="Deskripsi Promo">{{ old('description', $promo->description) }}</textarea>
                                        @error('description')
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

@push('js')
<script src="{{ asset('') }}assets/dashboard/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('') }}assets/dashboard/libs/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        var $bookSelect = $('.select2-book').select2({
            placeholder: 'Pilih Buku',
            allowClear: true,
            width: '100%',
            sorter: function(data) {
                return data;
            }
        });

        var selectedOrder = [];
        @if(old('book_ids'))
            selectedOrder = {!! json_encode(old('book_ids')) !!};
        @else
            selectedOrder = {!! json_encode($promo->books->pluck('id')->toArray()) !!};
        @endif

        $bookSelect.on('select2:select', function(e) {
            var selectedId = e.params.data.id;
            if (!selectedOrder.includes(selectedId)) {
                selectedOrder.push(selectedId);
            }
            reorderSelectedOptions();
        });

        $bookSelect.on('select2:unselect', function(e) {
            var unselectedId = e.params.data.id;
            selectedOrder = selectedOrder.filter(id => id !== unselectedId);
        });

        function reorderSelectedOptions() {
            var $select = $('.select2-book');
            var selectedValues = $select.val() || [];
            selectedValues.sort(function(a, b) {
                return selectedOrder.indexOf(a) - selectedOrder.indexOf(b);
            });
            selectedValues.forEach(function(value) {
                var $option = $select.find('option[value="' + value + '"]');
                $select.append($option);
            });
            $select.trigger('change.select2');
        }

        if (selectedOrder.length > 0) {
            reorderSelectedOptions();
        }
    });
</script>
@endpush
