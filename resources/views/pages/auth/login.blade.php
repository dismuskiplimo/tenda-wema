@extends('layouts.user-plain')

@section('content')
    <div class="container-fluid">
        
        <div class="row">
            <div style="min-height: 90vh; width: 100%; background-image: url('{{ custom_asset('images/slider/swiper/1.jpg') }}'); background-size: cover; position: relative; background-position: fixed; padding-top: 50px; padding-bottom: 50px ">
                
                <div class="panel panel-default  noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93); margin: 0 auto;">
                        <div class="panel-body" style="padding: 40px;">
                            <form id="login-form" name="login-form" class="nobottommargin custom-auth-form" action="{{ route('auth.login') }}" method="post">
                                @csrf
                                
                                <h3>Login to your Account</h3>

                                <span class="feedback"></span>

                                <div class="col_full">
                                    <label for="login-form-username">Username:</label>
                                    <input type="text" id="login-form-username" name="username" value="" class="form-control not-dark" />
                                </div>

                                <div class="col_full">
                                    <label for="login-form-password">Password:</label>
                                    <input type="password" id="login-form-password" name="password" value="" class="form-control not-dark" />
                                </div>

                                <div class="col_full nobottommargin">
                                    <button class="button submit button-black nomargin" id="login-form-submit" name="login-form-submit" type="submit" value="login">Login</button>
                                    <a href="{{ route('password.request') }}" class="fright">Forgot Password?</a>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="line line-sm"></div>

                            <div class="center">
                                <h4 style="margin-bottom: 15px;">or Login with:</h4>
                                <a href="{{ route('auth.facebook.login') }}" class="button button-rounded si-facebook si-colored">Facebook</a>
                                <span class="hidden-xs">or</span>
                                <a href="{{ route('auth.google.login') }}" class="button button-rounded si-google si-colored">Google</a>
                            </div>
                        </div>
                    </div>

            </div>

            

        </div>
    </div>
        
    



   



@endsection
