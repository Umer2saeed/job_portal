@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <p class="pb-0 mb-0 text-center">{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            <p class="pb-0 mb-0 text-center">{{ Session::get('error') }}</p>
                        </div>
                    @endif
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Reset Password</h1>
                        <form action="{{ route('account.processResetPassword') }}" method="post">
                            @csrf
                            <input type="hidden" name="token" value="{{ $tokenString }}">
                            <div class="mb-3">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password">
                                @error('new_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password">
                                @error('confirm_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do you have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection
