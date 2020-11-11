<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('admin/css/app.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Fonts -->
</head>
<body>
    <div>
        <div v-if="!isLoggedIn">
            <router-view></router-view>
        </div>
        <div v-else class="d-flex" id="wrapper" :class="{'toggled' : sideMenuToggle}">
            <!-- Sidebar -->
            <div class="bg-light" id="sidebar-wrapper">
                <div style="cursor:pointer" class="sidebar-heading">Dashhboard</div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                    <a href="#" class="list-group-item list-group-item-action bg-light">Lead Source</a>
                    <a href="#" @click="signOut" class="list-group-item list-group-item-action bg-light">Log Out</a>
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
                                <a href="#" class="nav-link">Home <span class="sr-only">(current)</span></a>
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
                    Content will come here
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        </div>
    <script src="{{asset('admin/js/app.js')}}"></script>
</body>
</html>
