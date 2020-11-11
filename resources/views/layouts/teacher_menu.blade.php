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
                    <a href="{{url('/teacher/dashboard')}}">
                      <i class="icon icon-speedometer"></i><span>Dashboard</span>
                  </a>
                </li>
               
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-text-o"></i><span>Updates</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/teacher/updates')}}">Updates</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('teachers.timeSlot')}}">
                        <i class="fa fa-code"></i><span>Time Slots</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/teacher/categories')}}">
                        <i class="fa fa-code"></i><span>Lessons</span>
                    </a>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-code-o"></i><span>Classes</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/teacher/calendar')}}">Calendar</a></li>
                        <li><a href="{{url('/task_class')}}">Add Class</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="mdi mdi-account-multiple-outline"></i><span>Students</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/add_student_form_by_user')}}">Add Students</a></li>
                        <li><a href="{{url('/add_student_form')}}">Search Students</a></li>
                    </ul>
                </li> 

                <li>
                    <a href="{{url('/online_meeting_room')}}">
                        <i class="mdi mdi-desktop-mac"></i><span>Training Room</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('teachers.training.categories')}}">
                        <i class="mdi mdi-teach"></i><span>Training</span>
                    </a>
                </li>      
               
            </ul>
        </div>
        <!-- End XP Navigationbar -->
    </div>
    <!-- End XP Sidebar -->
</div>