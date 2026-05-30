@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
        title="Profile Pengguna"
        description="Pengaturan profile pengguna di Daya Media"
        >
        </x-header-page>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Pengaturan Profile</h6>
                            <p>Pengaturan profile pengguna di Daya Media.</p>
                        </div>
                        <div>
                            <a href="" class="btn btn-primary">Simpan</a>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="form-group mt-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                            </div>
                            <div class="form-group mt-2">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <x-dropzone
                                id="profile_picture"
                                title="Foto Profile"
                                name="profile_picture"
                                accept="image/*"
                                max-file-size="2MB"
                                max-files="1"
                                preview-template="#profile-picture-preview"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Reset Password</h6>
                            <p>Reset password pengguna di Daya Media.</p>
                        </div>
                        <div>
                            <a href="" class="btn btn-primary">Simpan</a>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Masukkan password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#old_password">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Masukkan password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password_confirmation">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
