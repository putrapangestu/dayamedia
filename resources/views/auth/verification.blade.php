@extends('auth.layout')

@section('content')
 <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
    <div class="auth-max-width mx-auto d-flex align-items-center w-100 h-100">
        <div class="card-body">
            <div class="mb-5">
                <h3 class="fw-bolder fs-7 mb-3">Two Step Verification</h3>
                <p>We sent a verification code to your mobile. Enter the code from the mobile in the field below.
                </p>
                <h6 class="fw-bolder">******1234</h6>
            </div>
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fw-semibold">Type your 6 digits security
                    code</label>
                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <input type="text" class="form-control" placeholder="">
                    <input type="text" class="form-control" placeholder="">
                    <input type="text" class="form-control" placeholder="">
                    <input type="text" class="form-control" placeholder="">
                    <input type="text" class="form-control" placeholder="">
                    <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <a href="javascript:void(0)" class="btn btn-primary w-100 py-8 mb-4">Verify My Account</a>
                <div class="d-flex align-items-center">
                    <p class="fs-4 mb-0 text-dark">Didn't get the code?</p>
                    <a class="text-primary fw-medium ms-2" href="javascript:void(0)">Resend</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection