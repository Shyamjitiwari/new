<div class="xp-rightbar">  
    <!-- Start XP Topbar -->
    <div class="xp-topbar">
        <!-- Start XP Row -->
        <div class="row">
            <!-- Start XP Col -->
            <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                <div class="xp-menubar">
                    <a class="xp-menu-hamburger" href="javascript:void();">
                       <i class="icon-menu font-20 text-white"></i>
                     </a>
                 </div>
            </div> 
            <!-- End XP Col -->
            <!-- Start XP Col -->
            <div class="col-10 col-md-11 col-lg-11 order-1 order-md-2">
                <div class="xp-profilebar text-right">
                    <ul class="list-inline mb-0">
                       
                        <li class="list-inline-item mr-0">
                            <div class="dropdown xp-userprofile">
                                <a class="dropdown-toggle" href="#" role="button" id="xp-userprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('assets/images/topbar/user.jpg') }}" alt="user-profile" class="rounded-circle img-fluid"><span class="xp-user-live"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-userprofile">
                                    <a class="dropdown-item py-3 text-white text-center font-16" href="#">Welcome</a>
                                  
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="icon-power text-danger mr-2"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                
                                </div>
                            </div>                                   
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End XP Col -->
        </div> 
        <!-- End XP Row -->
    </div>
    <!-- End XP Topbar -->
    @yield('rightbar-content')
    <!-- Start XP Footerbar -->
    <div class="xp-footerbar">
        <footer class="footer">
            <p class="mb-0">© 2020 CodeWithUs - All Rights Reserved.</p>
        </footer>
    </div>
    <!-- End XP Footerbar -->
</div>