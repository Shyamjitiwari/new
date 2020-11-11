@section('title') 
CodeWithUs - Dashboard
@endsection 
@extends('layouts.main')
@section('style')
<!-- Chartist Chart CSS -->
<link href="{{ asset('assets/plugins/chartist-js/chartist.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Datepicker CSS -->
<link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 
@section('leftbar')
    @include('layouts.parent_menu') 
@endsection 
@section('rightbar-content')
<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">{!! __('billing_and_payment.payment_confirmation_title') !!}</h4>
        </div>
        <div class="col-md-6 col-lg-6">
        </div>
    </div>          
</div>
<!-- End XP Breadcrumbbar -->
<!-- Start XP Contentbar -->    

<div class="xp-contentbar">
    <div class="row">              
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h3 style="color:green">{!! __('billing_and_payment.thankyou_message_heading') !!}</h3>
                    <h6>{!! __('billing_and_payment.thankyou_message') !!}</h6>
                </div> 
            </div> 
        </div>   
    </div>
    <div class="row">
        <div class="col-12" style="background:white">
        <br/><br/>
        <h5 style="color:black"><b>{!! __('billing_and_payment.title_for_schedule_request_by_parents') !!}</b></h5>
        <br/><br/>
        <div id="app_vue">
            <student-schedule-request></student-schedule-request>
        </div>
        </div>
    </div>
</div>        

<!-- End XP Contentbar -->
<script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script>
@endsection 
@section('script')
<!-- Chartist Chart JS -->
<script src="{{ asset('assets/plugins/chartist-js/chartist.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartist-js/chartist-plugin-tooltip.min.js') }}"></script>
<!-- To Do List JS -->
<script src="{{ asset('assets/js/init/to-do-list-init.js') }}"></script>
<!-- Datepicker JS -->
<script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
<!-- Dashboard JS -->
<script src="{{ asset('assets/js/init/dashborad.js') }}"></script>
@endsection 