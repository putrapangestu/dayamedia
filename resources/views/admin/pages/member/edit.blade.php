@extends('admin.layouts.app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Edit Member"
            description="Halaman untuk mengubah member terdaftar"
            >
        </x-header-page>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('admin.member.update', $member->id) }}" method="POST">
                        @method('PUT')
                    @csrf
                        <div class="form-sticky-header">
                            <div class="d-flex border-bottom p-4">
                                <div>
                                    <h5 class="m-0 p-0">Formulir Edit Member</h5>
                                    <p class="text-muted m-0 p-0">Isi formulir dibawah ini dengan benar</p>
                                </div>
                                <div class="d-flex ms-auto gap-2">
                                    <a href="{{ route('admin.member.index') }}" class="btn bg-primary-subtle text-primary"> Kembali</a>
                                    <button class="btn btn-primary"> Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="full_name" placeholder="Budi Hartono" value="{{ old('full_name', $member->full_name) }}">
                                        @error('full_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="degree">Gelar</label>
                                        <input type="text" class="form-control" id="degree" name="degree" placeholder="S.Tr.Kom" value="{{ old('degree', $member->degree) }}">
                                        @error('degree')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="budi@gmail.com" value="{{ old('email', $member->email) }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone_number">No Whatsapp </label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number', $member->phone_number) }}">
                                        @error('phone_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="job">Pekerjaan</label>
                                        <input type="text" class="form-control" id="job" name="job" placeholder="Dosen" value="{{ old('job', $member->job) }}">
                                        @error('job')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="active" {{ $member->email_verified_at ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ !$member->email_verified_at ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="password">Password Baru <span class="text-muted fs-2">(isi hanya jika ingin mengganti)</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" autocomplete="new-password">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)" tabindex="-1">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password" autocomplete="new-password">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @push('js')
                                <script>
                                function togglePassword(inputId, btn) {
                                    const input = document.getElementById(inputId);
                                    const icon = btn.querySelector('i');
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        icon.classList.remove('ti-eye');
                                        icon.classList.add('ti-eye-off');
                                    } else {
                                        input.type = 'password';
                                        icon.classList.remove('ti-eye-off');
                                        icon.classList.add('ti-eye');
                                    }
                                }
                                </script>
                                @endpush
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
