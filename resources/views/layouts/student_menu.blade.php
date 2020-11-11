<div class="xp-leftbar">
    <!-- Start XP Sidebar -->
    <div class="xp-sidebar">
        <!-- Start XP Logobar -->
        <div class="xp-logobar text-center">
            <a href="{{url('/')}}" class="xp-logo"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="logo"></a>
        </div>
        <!-- End XP Logobar -->
        <!-- Start XP Navigationbar -->
        <div class="xp-navigationbar">
            <ul class="xp-vertical-menu">
                <li class="xp-vertical-header">Main</li>
                <li>
                    <a href="{{url('/student/dashboard')}}">
                      <i class="icon icon-speedometer"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('students.calendar')}}">
                      <i class="icon icon-speedometer"></i><span>Calendar</span>
                    </a>
                </li>
               
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-text-o"></i><span>Updates</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/student/update')}}">Create Update</a></li>
                        <li><a href="{{url('/student/updates')}}">Updates</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{url('/categories')}}">
                        <i class="fa fa-code"></i><span>Lessons</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/online_meeting_room')}}">
                        <i class="mdi mdi-desktop-mac"></i><span>Online Classroom</span>
                    </a>
                </li>           
            </ul>
        </div>
        <!-- End XP Navigationbar -->
    </div>
    <!-- End XP Sidebar -->
</div>