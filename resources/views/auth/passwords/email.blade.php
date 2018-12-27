@extends('layouts.user-plain')

@section('content')

 <div class="container-full-width">

    <div class="row">

        <div style="min-height: 100vh; width: 100%; background-image: url('{{ custom_asset('images/slider/swiper/3.jpg') }}'); background-size: cover; position: relative; background-position: fixed; padding-top: 50px; padding-bottom: 50px ">
            
                    <div class="panel panel-default  noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93); margin: 0 auto;">

                        <div class="panel-body" style="padding: 40px;">
                            <form id="login-form" name="login-form" class="nobottommargin" action="{{ route('password.email') }}" method="post">
                                @csrf
                                
                                <h3>Reset Password</h3>

                                @include('includes.user.messages')

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                <div class="col_full">
                                    <label for="login-form-username">Email:</label>
                                    <input type="text" id="login-form-username" name="email" value="" class="form-control not-dark" />
                                </div>

                                <div class="col_full nobottommargin">
                                    <button class="button button-3d button-black nomargin" id="login-form-submit">
                                        {{ __('Send Password Reset Link') }}
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
