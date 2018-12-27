@extends('layouts.user-plain')

@section('content')

 <div class="container-full-width">

    <div class="row">
        
            <div style="min-height: 100vh; width: 100%; background-image: url('{{ custom_asset('images/slider/swiper/4.jpg') }}'); background-size: cover; position: relative; background-position: fixed; padding-top: 50px; padding-bottom: 50px ">
            
                    <div class="panel panel-default  noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93); margin: 0 auto;">

                    <div class="panel-body" style="padding: 40px;">
                        <form id="login-form" name="login-form" class="nobottommargin" action="{{ route('password.request') }}" method="post">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            
                            <h3>{{ __('Reset Password') }}</h3>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            <div class="col_full">
                                <label for="">Email</label>
                                <input type="email" id="" name="email" value="" class="form-control not-dark" required="" />
                            </div>

                            <div class="col_full">
                                <label for="">New Password</label>
                                <input type="text" id="" name="password" value="" class="form-control not-dark" required="" />
                            </div>

                            <div class="col_full">
                                <label for="">Retype Password</label>
                                <input type="text" id="" name="password_confirmation" value="" class="form-control not-dark" required="" />
                            </div>

                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin">
                                    {{ __('Reset Password') }}
                                </button>
                                
                            </div>  

                        </form>
                    </div>
                </div>

                <div class="row center dark">
                    <small>Copyrights &copy; All Rights Reserved by {{ config('app.name') }}.</small>
                </div>

            </div>
        

    </div>

</div><!-- #content end -->

@endsection

