@extends('auth.layout')

@section('content')

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
  <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
    <h2 class="mb-1 fs-7 fw-bolder">Selamat Datang di Azzia</h2>
    <p class="mb-7">Masuk untuk menuju halaman beranda</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{ old('email') }}" placeholder="budi@gmail.com">
        @error('email')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="password">
          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#exampleInputPassword1">
            <i class="ti ti-eye"></i>
          </button>
        </div>
        @error('password')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
          <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
          <label class="form-check-label text-dark fs-3" for="flexCheckChecked">
            Ingat Saya
          </label>
        </div>
        <a class="text-primary fw-medium fs-3" href="{{ route('password.forgot') }}">Lupa Password?</a>
      </div>
      <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Masuk</button>
      <div class="d-flex align-items-center justify-content-center">
        Belum punya akun? <a class="text-primary fw-medium ms-2" href="{{ route('register') }}">Daftar Sekarang</a>
      </div>
    </form>
  </div>
</div>
@endsection

{{-- @push('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.toggle-password', function() {
                const target = $(this).data('target');
                const input = $(target);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });
        });
    </script>
@endpush --}}
