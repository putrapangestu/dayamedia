<div class="row">
    <div class="col-lg-4">        <div class="col-12">
            <div class="card shadow-none border">
            <div class="card-body">
                <h4 class="mb-3">Reset Password</h4>
                <form action="{{ route('account.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="existing_password">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="existing_password"
                                name="existing_password" placeholder="password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#existing_password">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                        @error('existing_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="new_password">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password"
                                name="new_password" placeholder="password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" placeholder="password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password_confirmation">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-none border">
            <form action="{{ route('account.profile.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body row">
                    <h4 class="mb-3">Informasi Pengguna</h4>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="full_name"
                                placeholder="Nama Lenkap" value="{{ old('full_name', $user->full_name) }}">
                            <label>
                                <i class="ti ti-user me-2 fs-4"></i>Nama Lenkap
                            </label>
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email"
                                placeholder="Email" value="{{ old('email', $user->email) }}">
                            <label>
                                <i class="ti ti-mail me-2 fs-4"></i>Email
                            </label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="phone_number"
                                placeholder="No Whatsapp" value="{{ old('phone_number', $user->phone_number) }}">
                            <label>
                                <i class="ti ti-phone me-2 fs-4"></i>No Whatsapp
                            </label>
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <textarea class="form-control h-140" name="address" placeholder="Alamat" id="address">{{ old('address', $user->address) }}</textarea>
                            <label for="address"><i class="ti ti-home me-2 fs-4"> </i>Alamat</label>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-dropzone name="photo" label="Foto Profil"
                            helperText="Upload foto profil baru" />
                        @error('photo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
