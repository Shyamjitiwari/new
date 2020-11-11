<!-- header -->
<header class="site-header" id="header">
    <nav class="navbar navbar-expand-lg transparent-bg static-nav">
        <div class="container">
            <a class="navbar-brand" href="{{route('fe.index')}}">
                <img src="{{asset('images2/logo.png')}}" alt="gravity logo" class="logo-default" style="width:200px;">
                <img src="{{asset('images2/logo.png')}}" alt="gravity logo" class="logo-scrolled" style="width:200px;">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#pointer">How We Can Help</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('fe.about')}}">Who We Are</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('fe.blogs.index')}}">#SmartMoves</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://my-eoffice.com/client/" target="_blank">Investor Login</a>
                    </li>
                </ul>
            </div>
        </div>
        <!--side menu open button-->
        <a href="javascript:void(0)" class="d-inline-block sidemenu_btn" id="sidemenu_toggle">
            <span></span> <span></span> <span></span>
        </a>
    </nav>
    <!-- side menu -->
    <div class="side-menu opacity-0 gradient-bg" style="max-width:25%;">
        <div class="overlay"></div>
        <div class="inner-wrapper">
            <span class="btn-close btn-close-no-padding" id="btn_sideNavClose"><i></i><i></i></span>
            <nav class="side-nav w-100">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('fe.about')}}">Who We Are</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pointer">How We Can Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('fe.blogs.index')}}">#SmartMoves</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://my-eoffice.com/client/" target="_blank">Portfolio
                            Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#stayconnect">Contact</a>
                    </li>
                </ul>
            </nav>
            <div class="side-footer w-100">
                <ul class="social-icons-simple white top40">
                    <li><a href="https://www.facebook.com/gravityfinsol" target="_blank"><i
                                class="fab fa-facebook-f"></i> </a></li>
                    <li><a href="https://twitter.com/gravity_wealth" target="_blank"><i class="fab fa-twitter"></i>
                        </a></li>
                    <li><a href="https://www.linkedin.com/company/gravitywealth/?viewAsMember=true" target="_blank"><i
                                class="fab fa-linkedin-in"></i> </a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i> </a></li>
                </ul>
                <p class="whitecolor">&copy; <span id=""></span> Gravity Wealth Management</p>
            </div>
        </div>
    </div>
    <div id="close_side_menu" class="tooltip"></div>
    <!-- End side menu -->
</header>
