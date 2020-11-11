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
    @include('layouts.admin_menu')
@endsection
@section('rightbar-content')

    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <h4 class="xp-page-title">Locations</h4>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="xp-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Locations</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End XP Breadcrumbbar -->
    <!-- Start XP Contentbar -->
    <div class="xp-contentbar">
        <div id="app_vue">
            <locations> </locations>
            <loader v-if="showLoader"> </loader>
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