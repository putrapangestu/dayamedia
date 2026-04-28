@extends('auth.layout')

@section('content')
<div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
  <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
    <h2 class="mb-1 fs-7 fw-bolder">Reset Password</h2>
    <p class="mb-7">Masukkan nomor WhatsApp, kode OTP, dan password baru.</p>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('password.reset.post') }}">
      @csrf
      <div class="mb-3">
        <label for="identifier" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="identifier" name="identifier" value="{{ old('identifier', session('identifier')) }}" placeholder="budi@gmail.com atau 081234567890" readonly>
        @error('identifier')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="input_code" class="form-label">Kode OTP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="input_code" name="code" value="{{ old('code') }}" placeholder="123456">
        @error('code')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="password" class="form-control" id="new_password" name="password" placeholder="password">
          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password">
            <i class="ti ti-eye"></i>
          </button>
        </div>
        @error('password')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="password" class="form-control" id="new_password_confirmation" name="password_confirmation" placeholder="password">
          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#new_password_confirmation">
            <i class="ti ti-eye"></i>
          </button>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Reset Password</button>
      <button type="submit" formaction="{{ route('password.reset.resend') }}" formnovalidate class="btn btn-outline-secondary w-100 py-8 mb-4 rounded-2">Kirim Ulang OTP</button>
      <div class="d-flex align-items-center justify-content-center">
        Sudah punya akun? <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Masuk</a>
      </div>
    </form>
  </div>
  </div>
@endsection
