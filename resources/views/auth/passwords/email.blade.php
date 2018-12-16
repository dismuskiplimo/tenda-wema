@extends('layouts.user-plain')

@section('content')

 <section id="content">

    <div class="content-wrap nopadding">

        <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('{{ custom_asset('images/parallax/home/1.jpg') }}') center center no-repeat; background-size: cover;">  
        </div>

        <div class="section nobg full-screen nopadding nomargin">
            <div class="container vertical-middle divcenter clearfix">

                <div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
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

    </div>

</section><!-- #content end -->

@endsection
