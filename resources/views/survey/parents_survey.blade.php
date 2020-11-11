@section('title') 
CodeWithUs - Survey
@endsection
@extends('layouts.main')
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
                                <a href="{{url('/')}}" class="xp-web-logo"><img src="/../assets/images/logo.png" height="40" alt="logo"></a>
                            </h3>
                            <div class="p-3">
                           
                                <div class="text-center mb-3">
                                    <h4 class="text-black">Survey</h4>
                                    <p class="text-muted"></p>
                                </div>      
                                <form method="POST" action="{{ route('parents_survey') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="parent_id" name="parent_id" value="{{ $parent }}" />
                                    <input type="hidden" id="parent_id" name="parent_email" value="{{ $email }}" />
                                    <input type="hidden" id="parent_id" name="teacher_name" value="{{ $teacher }}" />
                                    <input type="hidden" id="parent_id" name="latest_update" value="{{ $update }}" />
                                    <label>{!! __('survey.rate_cwu') !!}</label>                                     
                                    <br/>   
                                    <input min="1" max="5" type="number" id="rate" name="rate" class="form-control" required/>
                                    <br/><br/>
                                    <label>{!! __('survey.improvements_for_cwu') !!}</label>    
                                    <textarea class="form-control"  name="improvements_for_cwu" rows="4"></textarea>
                                    <br/><br/>
                                    <label>{!! __('survey.valuable_part_of_cwu') !!}</label>    
                                    <textarea class="form-control"  name="valuable_part_of_cwu" rows="4"></textarea>
                                    <br/>
                                    <input class="btn btn-primary" type="submit" value="Submit Survey" />
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