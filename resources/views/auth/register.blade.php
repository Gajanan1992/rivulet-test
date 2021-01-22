@extends('auth.layout')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="" id="register-form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control"  name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                <small class="form-text text-danger" id="name-err"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control"  name="email" value=""  autocomplete="email">
                                <small class="form-text text-danger" id="email-err"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"  autocomplete="new-password">
                                <small class="form-text text-danger" id="password-err"></small>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            <small class="form-text text-danger" id="confirm-password-err"></small>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>

        $(function(){

        $('#register-form').on('submit', function (event) {
        event.preventDefault();
        var data = new FormData(this);
        var token = $('input[name="_token"]').attr('value');
        $.ajax({
            headers: {
                'X-CSRF-Token': token
            },
            type: "POST",
            url: '/api/register',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                window.location.href = '/login';
            },
            error: function (e) {
                // console.log(e.responseJSON.errors);
                var errors = e.responseJSON.errors;
                if (errors.name) {
                    $('#name-err').html(errors.name[0]);
                } else {
                    $('#name-err').html('');
                }
                if (errors.email) {
                    $('#email-err').html(errors.email[0]);
                } else {
                    $('#email-err').html('');
                }
                if (errors.password) {
                    $('#password-err').html(errors.password[0]);
                } else {
                    $('#password-err').html('');
                }
                if (errors.password_confirmation) {
                    $('#confirm-password-err').html(errors.password[0]);
                } else {
                    $('#confirm-password-err').html('');
                }

            }
        });
    });
        })
    </script>
@endsection
