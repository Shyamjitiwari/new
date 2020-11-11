<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('admin/css/app.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a409d70044.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    @yield('headerscripts')
    @yield('styles')
   
</head>
<body>
<div id="admin">
    <div class="d-flex" id="wrapper" style="min-height: 100vh">
        <!-- Sidebar -->
        <div class="bg-light" id="sidebar-wrapper">
            <div style="cursor:pointer" class="sidebar-heading">Dashhboard</div>
            <div class="list-group list-group-flush">
                <a href="{{route('home')}}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <div class="accordion" id="accordionExample">
                    <a class="list-group-item list-group-item-action bg-light font-weight-bolder cursor-pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        CMS
                    </a>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        @can('viewAny', App\Blog::class)
                            <a href="{{route('admin.blogs')}}" class="list-group-item list-group-item-action bg-light">Blogs</a>
                        @endcan                
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.products')}}" class="list-group-item list-group-item-action bg-light">Products</a>
                        @endcan    
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.services')}}" class="list-group-item list-group-item-action bg-light">Services</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.testimonials')}}" class="list-group-item list-group-item-action bg-light">Testimonials</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.galleries')}}" class="list-group-item list-group-item-action bg-light">Galleries</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.pages')}}" class="list-group-item list-group-item-action bg-light">Pages</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.menus')}}" class="list-group-item list-group-item-action bg-light">Menus</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.sliders')}}" class="list-group-item list-group-item-action bg-light">Sliders</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.brands')}}" class="list-group-item list-group-item-action bg-light">Brands</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.attributeGroups')}}" class="list-group-item list-group-item-action bg-light">Attribute Groups</a>
                        @endcan
                        @can('viewAny', App\Tag::class)
                            <a href="{{route('admin.attributes')}}" class="list-group-item list-group-item-action bg-light">Attributes</a>
                        @endcan
                    </div>
                </div>

                @can('viewAny', App\Category::class)
                <a href="{{route('admin.categories')}}" class="list-group-item list-group-item-action bg-light">Categories</a>
                @endcan
                @can('viewAny', App\Tag::class)
                <a href="{{route('admin.tags')}}" class="list-group-item list-group-item-action bg-light">Tags</a>
                @endcan
                @can('view', App\Setting::class)
                <a href="{{route('admin.settings')}}" class="list-group-item list-group-item-action bg-light">Settings</a>
                @endcan
                <a href="{{route('admin.activities')}}" class="list-group-item list-group-item-action bg-light">Activities</a>

                <div class="accordion" id="users">
                    <a class="list-group-item list-group-item-action bg-light font-weight-bolder cursor-pointer" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Roles & Users
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#users">
                        @can('viewAny', App\Role::class)
                            <a href="{{route('admin.roles')}}" class="list-group-item list-group-item-action bg-light">Roles</a>
                        @endcan
                        @can('viewAny', App\User::class)
                            <a href="{{route('admin.users')}}" class="list-group-item list-group-item-action bg-light">Users</a>
                        @endcan
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-light"
                   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                >Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <i id="menu-toggle" class="material-icons text-white">menu</i>
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a href="{{route('fe.index')}}" target="new" class="nav-link">Preview</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                            <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">Something else here</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <notifications group="notification" />
        <apiloader :apiloader="$store.state.apiLoading"></apiloader>
        <!-- /#page-content-wrapper -->
    </div>
</div>
<script src="{{asset('admin/js/app.js')}}"></script>
@yield('footerscripts')
</body>
</html>
