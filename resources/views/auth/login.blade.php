@extends('auth.layout')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="" id="login-form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>


                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">


                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
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

        $('#login-form').on('submit', function (event) {
        event.preventDefault();
        var data = new FormData(this);
        var token = $('input[name="_token"]').attr('value');
        $.ajax({
            headers: {
                'X-CSRF-Token': token
            },
            type: "POST",
            url: '/api/login',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                console.log('success', data);
                localStorage.setItem("api_token", data.token);
                localStorage.setItem("user_id", data.user.id);
                localStorage.setItem("user_name", data.user.name);
                window.location.href = '/';

            },
            error: function (e) {
                console.log(e);
                var errors = e.responseJSON;


            }
        });
    });
        })
    </script>
@endsection
