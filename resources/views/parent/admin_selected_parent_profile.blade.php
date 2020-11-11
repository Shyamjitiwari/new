@section('title') 
CodeWithUs - Update
@endsection 
@extends('layouts.main')
@section('style')
<!-- Chartist Chart CSS -->
<link href="{{ asset('assets/plugins/chartist-js/chartist.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Datepicker CSS -->
<link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 
@section('leftbar')
    @include('layouts.admin_menu') 
@endsection 
@section('rightbar-content')
<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">Parent's Profile</h4>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="xp-breadcrumb">
                
            </div>
        </div>
    </div>          
</div>
<!-- End XP Breadcrumbbar -->
<!-- Start XP Contentbar -->    
<div class="xp-contentbar">
    <div class="row">      
        <div class="col-lg-12">
            <div class="card m-b-30">
                <!--Here, we need to show the Parents' Credits Information-->
                <div class="container">
                    <br/><br/><br/>
                    <h3>Total Credits </h3>   
                    <div class="row">
                        <div class="form-group col">
                            <label><h6 style="color:black">Total Credits Used</h6></label>
                            <input type="text" class="form-control" value="{{ $creditsused }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label><h6 style="color:black">Remaining Credits</h6></label>
                            <input type="text" class="form-control" value="{{ $creditsremaining }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label><h6 style="color:black">Edit</h6></label><br/>
                            <a class="btn btn-primary" href="{{ route('edit_parents_credits', ['userId' => $parent] ) }}">Edit</a>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="card-body">
                    <div id="app_vue">
                        <get-parent-profile :parent="'{{ $parent }}'" ></get-parent-profile>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script> 
<!-- End XP Contentbar -->
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