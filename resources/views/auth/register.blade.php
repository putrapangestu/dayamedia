@extends('auth.layout')

@section('content')
<div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
  <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
    <h2 class="mb-1 fs-7 fw-bolder">Daftar member Azzia</h2>
    <p class="mb-7">Lengkapi formulir dibawah ini untuk menjadi member Azzia</p>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="mb-2">
        <label for="input_name" class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="input_name" name="full_name" value="{{ old('full_name') }}" aria-describedby="emailHelp" placeholder="Budi Hartono">
        @error('full_name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <label for="input_email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="input_email" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="budi@gmail.com">
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <label for="input_phone" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="input_phone" name="phone_number" value="{{ old('phone_number') }}" aria-describedby="emailHelp" placeholder="08123456789">
        @error('phone_number')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="password">
          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#exampleInputPassword1">
            <i class="ti ti-eye"></i>
          </button>
        </div>
        <small class="form-text text-muted">note: Password minimal 8 karakter</small>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password">
          <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password_confirmation">
            <i class="ti ti-eye"></i>
          </button>
        </div>
        @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-2">
        <label for="exampleInputEmail1" class="form-label">Kode Referal</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="referral_code" value="{{ old('referal_code', $referral_code) }}" aria-describedby="emailHelp" placeholder="123456">
        @error('referal_code')
            <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Daftar</button>
      <div class="d-flex align-items-center justify-content-center">
        <p class="fs-4 mb-0 fw-medium">Sudah memiliki akun?</p>
        <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Masuk</a>
      </div>
    </form>
  </div>
</div>
@endsection

@push('script')
<script>
//   $(document).ready(function() {
//     $('#input_phone').on('change', function() {
//         console.log($(this).val());
//         $(this).val($(this).val().replace(/\D/g, ''));
//     });
//   });
</script>
@endpush
