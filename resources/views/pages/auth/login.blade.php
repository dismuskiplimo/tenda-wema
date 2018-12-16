@extends('layouts.user-plain')

@section('content')
    <section id="content">

        <div class="content-wrap nopadding">

            <div class="section nopadding nomargin" style="min-width: 100%; min-height: 100%; position: absolute; left: 0; top: 0; background: url('{{ custom_asset('images/parallax/home/1.jpg') }}') center center no-repeat; background-size: cover;"></div>

            <div class="section nobg full-screen nopadding nomargin">
                <div class="container vertical-middle divcenter clearfix">

                   

                    <div class="panel panel-default divcenter noradius noborder mt-20" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
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
                                <a href="#" class="button button-rounded si-facebook si-colored">Facebook</a>
                                <span class="hidden-xs">or</span>
                                <a href="#" class="button button-rounded si-twitter si-colored">Twitter</a>
                            </div>
                        </div>
                    </div>

                    

                </div>
            </div>

        </div>

    </section><!-- #content end -->



@endsection
