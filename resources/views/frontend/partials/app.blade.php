<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="description" content="@yield('meta_description')">
    @include('frontend.partials.headerscripts')
</head>
<body>
<div id="app">
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="cssload-loader"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
    @include('frontend.partials.navbar')
    <!-- header -->
    @yield('content')
    @include('frontend.partials.contact')
    @include('frontend.partials.footer')
</div>
@include('frontend.partials.footerscript')
</body>
</html>
