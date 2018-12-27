@extends('layouts.user-plain')

@section('content')
    
    <div class="container">
        <div class="row mt-50 mb-50">
            <div class="col-sm-8 col-sm-offset-2">
                <h3>Don't have an Account? Register Now.</h3>

                <p>I don't know what your destiny will be, but one thing I do know; the only ones among you who will be really happy are those who have sought and found how to serve. - <i>Albert Schweitzer</i></p>

                <form id="register-form" name="register-form" class="nobottommargin custom-auth-form" action="{{ route('auth.signup') }}" method="post">

                    @csrf

                    <p class="text-muted"><span class="text-danger">*</span> Required fields</p>

                    <div class="col_half">
                        <label for="register-form-fname">First Name <span class="text-danger">*</span> </label>
                        <input type="text" id="register-form-fname" name="fname" value="{{ old('fname') }}" class="form-control" required="">
                    </div>

                    <div class="col_half col_last">
                        <label for="register-form-lname">Last Name <span class="text-danger">*</span> </label>
                        <input type="text" id="register-form-lname" name="lname" value="{{ old('lname') }}" class="form-control" required="">
                    </div>

                    <div class="clear"></div>

                    <div class="col_half">
                        <label for="register-form-email">Email Address <span class="text-danger">*</span> </label>
                        <input type="email" id="register-form-email" name="email" value="{{ old('email') }}" class="form-control" required="">
                    </div>

                    

                    <div class="col_half col_last">
                        <label for="register-form-username">Choose a Username <span class="text-danger">*</span> </label>
                        <input type="text" id="register-form-username" name="username" value="{{ old('username') }}" class="form-control" required="">
                    </div>

                    <div class="col_full">
                        <label for="register-form-phone">Date of Birth <span class="text-danger">*</span> </label>
                        <input type="text" id="register-form-phone" name="dob" readonly="" value="{{ old('dob') }}" class="form-control dob" required="">
                    </div>

                    <div class="clear"></div>

                    <div class="col_half">
                        <label for="register-form-password">Choose Password <span class="text-danger">*</span> </label>
                        <input type="password" id="register-form-password" name="password" value="" class="form-control" required="">
                    </div>

                    <div class="col_half col_last">
                        <label for="register-form-repassword">Re-enter Password <span class="text-danger">*</span> </label>
                        <input type="password" id="register-form-repassword" name="password_confirmation" value="" class="form-control" required="">
                    </div>

                    <div class="clear"></div>
                    
                    <div class="checkbox mb-20">
                        <label for="accepted" class="checkbox-inline"> <input type="checkbox" name="accepted" id="accepted"> I accept the <a href="{{ route('terms-and-conditions') }}">terms and conditions</a> set by {{ config('app.name') }} </label>
                    </div>

                    <div class="clear"></div>

                    <span class="feedback"></span>

                    <div class="col_full nobottommargin">
                        <button class="button button-black nomargin submit" id="register-form-submit" name="register" value="register" type="submit">Register Now</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
