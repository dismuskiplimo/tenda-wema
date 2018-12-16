@extends('layouts.user-plain')

@section('content')
    
    <div class="container">
        <div class="row mt-50 mb-50">
            <div class="col-sm-8 col-sm-offset-2">
                <h3>Don't have an Account? Register Now.</h3>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, vel odio non dicta provident sint ex autem mollitia dolorem illum repellat ipsum aliquid illo similique sapiente fugiat minus ratione.</p>

                <form id="register-form" name="register-form" class="nobottommargin" action="{{ route('register') }}" method="post">

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
                        <input type="text" id="register-form-phone" name="dob" readonly="" value="{{ old('dob') }}" class="form-control" required="">
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
                        <label for="accepted" class="checkbox-inline"> <input type="checkbox" name="accepted" id="accepted"> I accept the <a href="">terms and conditions</a> set by {{ config('app.name') }} </label>
                    </div>

                    <div class="clear"></div>

                    <div class="col_full nobottommargin">
                        <button class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register">Register Now</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
