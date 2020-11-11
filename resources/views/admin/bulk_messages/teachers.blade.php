@section('title')
    CodeWithUs - Dashboard
@endsection
@extends('layouts.main')
@section('style')
{{--    //--}}
@endsection
@section('leftbar')
    @include('layouts.admin_menu')
@endsection
@section('rightbar-content')

    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <h4 class="xp-page-title">Send Messages To Teachers</h4>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="xp-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Teachers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End XP Breadcrumbbar -->
    <!-- Start XP Contentbar -->
    <div class="xp-contentbar">
        <div id="app_vue">
            <bulk-messages> </bulk-messages>
        </div>
    </div>
    <!-- End XP Contentbar -->
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script>
@endsection