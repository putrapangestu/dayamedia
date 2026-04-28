@extends('auth.layout')

@section('content')
<div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
  <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
    <h2 class="mb-1 fs-7 fw-bolder">Lupa Password</h2>
    <p class="mb-7">Masukkan Email untuk menerima kode OTP.</p>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('password.forgot.send') }}">
      @csrf
      <div class="mb-3">
        <label for="identifier" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="identifier" name="identifier" value="{{ old('identifier') }}" placeholder="budi@gmail.com">
        @error('identifier')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Kirim Kode OTP</button>
      <div class="d-flex align-items-center justify-content-center">
        Ingat password? <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Masuk</a>
      </div>
    </form>
  </div>
  </div>
@endsection
