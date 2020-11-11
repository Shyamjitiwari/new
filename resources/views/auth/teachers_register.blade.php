@section('title') 
CodeWithUs - Register
@endsection
@extends('layouts.registration_main')
@section('style')
@endsection
<div class="xp-authenticate-bg"></div>
<!-- Start XP Container -->
<div id="xp-container" class="xp-container">
    <!-- Start Container -->
    <div class="container">
        <!-- Start XP Row -->
        <div class="row vh-100 align-items-center">
            <!-- Start XP Col -->
            <div class="col-lg-12 ">
                <!-- Start XP Auth Box -->
                <div class="xp-auth-box">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center mt-0 m-b-15">
                            <a href="{{url('/')}}" class="xp-web-logo"><img src="{{asset('assets/images/logo.png')}}" height="40" alt="logo"></a>
                            </h3>
                            <div class="p-3">
                            @if ($message = Session::get('incorrect_security_code'))
                                <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="time_zone" id="timeZone"/>
                                <input type="hidden" id="role_type"  name="role_type" value="teacher">
                                    <div class="text-center mb-3">
                                        <h4 class="text-black">Create New Account</h4>
                                        <p class="text-muted">Already have an account? <a href="{{ route('login') }}">Sign in</a> Here</p>
                                    </div>   
                    
                                    <div class="form-group">
                                        <input placeholder="Full Name" id="full_name" type="text" class="form-control" name="full_name"  required>
                                    </div>

                                    <div class="form-group">
                                        <input placeholder="Email" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block" style="color:red" >
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3"> 
                                            <select class="form-control m-bot15" name="country_id"> 
                                                @foreach($countries as $country) 
                                                    <option value="{{ $country->id }}" {{ $selectedCountry == $country->id ? 'selected="selected"' : '' }}>{{ $country->calling_code }}</option>  
                                                @endForeach
                                            </select> 
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input placeholder="Phone Number" id="phone_number" type="number" maxlength = "100" class="form-control" name="phone_number" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input placeholder="Password" id="password" type="password" class="form-control" name="password" minlength=8 required>
                                        @if ($errors->has('password'))
                                            <span class="help-block" style="color:red" >
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>

                                    <div class="form-group">
                                        <input placeholder="Secret Code" id="secret_code" type="text" class="form-control" name="secret_code" required >
                                    </div>
                                                        
                                  <button type="submit" class="btn btn-primary btn-rounded btn-lg btn-block">Create an Account</button>
                                </form>
                            </div>
                        </div>
                    </div>
    
                </div>
                <!-- End XP Auth Box -->
            </div>
            <!-- End XP Col -->
        </div>
        <!-- End XP Row -->
    </div>
    <!-- End Container -->
</div>
<!-- End XP Container -->
@section('script')

<script type="text/javascript">
const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
document.getElementById("timeZone").value = tz;
console.log(tz);
</script>

@endsection 