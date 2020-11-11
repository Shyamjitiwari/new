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
                            @if ($error != null && $error != "")
                                <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $error }}</strong>
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <input  type="hidden" id="full_name"  name="full_name" value="{{$fullname}}" />
                                <input type="hidden" id="password"  name="password" value="{{$password}}" />
                                <input type="hidden" id="role_type"  name="role_type" value="student">
                                <input type="hidden" id="time_zone"  name="time_zone" value="{{$timezone}}">
                                    <div class="text-center mb-3">
                                        <h4 class="text-black">Create New Account</h4>
                                        <p class="text-muted">Already have an account? <a href="{{url('/login')}}">Sign in</a> Here</p>
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
                                            <input placeholder="Guardian's Phone Number" id="phone_number" type="number" maxlength = "100" class="form-control" name="phone_number" required >
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <input placeholder="Date of birth" id="dob" type="text" class="form-control" name="dob" required >
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
@endsection 