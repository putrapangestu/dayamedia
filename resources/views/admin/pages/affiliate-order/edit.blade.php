@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Tingkatan"
            description="Halaman untuk mengubah tingkatan affiliasi"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.affiliate-order.update', $affiliateOrder->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Edit Tingkatan Affiliasi</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.affiliate-order.index') }}" class="btn bg-primary-subtle text-primary">
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
                                        <label for="name">Tingkatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Premium" value="{{ old('name', $affiliateOrder->name) }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="percentage">Persentase <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="percentage" name="percentage" placeholder="Premium" value="{{ old('percentage', $affiliateOrder->percentage) }}">
                                        @error('percentage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="min_earning">Target Bulanan <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="min_earning" name="min_earning" placeholder="Premium" value="{{ old('min_earning', $affiliateOrder->min_earning) }}">
                                        @error('min_earning')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-dropzone
                                        name="icon"
                                        label="Icon Tingkatan"
                                        accept="image/*"
                                        :maxSize="5"
                                        :required="false"
                                        helperText="Upload icon tingkatan dengan jelas"
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
