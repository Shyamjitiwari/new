<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('admin/css/app.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Fonts -->
</head>
<body>
<div>
    <div id="page-content-wrapper">
        @yield('content')
    </div>
</div>
<script src="{{asset('admin/js/app.js')}}"></script>
</body>
</html>
