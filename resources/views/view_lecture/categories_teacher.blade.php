@section('title') 
CodeWithUs - Lesson
@endsection 
@extends('layouts.main')
@section('style')
<!-- Chartist Chart CSS -->
<link href="{{ asset('assets/plugins/chartist-js/chartist.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Datepicker CSS -->
<link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 
@section('leftbar')
    @include('layouts.teacher_menu') 
@endsection 
@section('rightbar-content')

<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">Lesson Categories</h4>
        </div>
        <div class="col-md-6 col-lg-6">
        </div>
    </div>          
</div>
<!-- End XP Breadcrumbbar -->
<!-- Start XP Contentbar -->    
<div class="xp-contentbar" id="app_vue">
    <div class="row"> 
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <ul class="list-group">
                    @foreach($categories as $key => $value)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a class="text-capitalize" href="{{  $value['url'] }}">{{ $value['name'] }}</a>
                                <span class="badge badge-primary badge-pill">
                                    <span v-if="!categoryPassword" @click="categoryPassword = true">Show Password</span>
                                    <span v-else @click="categoryPassword = false">({{ $value['password'] }})</span>
                                </span>
                            </li>


                        <br/>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End XP Contentbar -->
@endsection 
@section('script')
    <script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script>
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