@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                   @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                   @include('front.message')
                    <div class="card border-0 shadow mb-4">
                        <form action="" method="post" name="userForm" id="userForm">
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="email" value="{{ $user->email }}" placeholder="Enter Email" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation" value="{{ $user->designation }}" placeholder="Designation" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" value="{{ $user->mobile }}" placeholder="Mobile" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>


                    <div class="card border-0 shadow mb-4">
                        <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
                            @csrf
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">Change Password</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Old Password*</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">New Password*</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Confirm Password*</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $("#userForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
               url: '{{ route('account.updateProfile', $user->id) }}',
               type: 'put',
               data: $(this).serializeArray(),
               dataType: 'json',
               success: function (response) {
                    if(response.status == true) {

                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        window.location.href = '{{ route('account.profile') }}';

                    } else {

                        let errors = response.errors;
                        if(errors.name) {
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                    }
               }
            });
        });


        // Change password form
        $("#changePasswordForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route("account.updatePassword") }}',
                type: 'post',
                data: $("#changePasswordForm").serializeArray(),
                dataType: 'json',
                success: function (response) {
                    if(response.status == true) {

                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        window.location.href = '{{ route('account.profile') }}';

                    } else {

                        let errors = response.errors;
                        if(errors.old_password) {
                            $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.old_password);
                        } else {
                            $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors.new_password) {
                            $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.new_password);
                        } else {
                            $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                        } else {
                            $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection
