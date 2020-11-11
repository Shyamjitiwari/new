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
                    <a href="{{url('/admin/dashboard')}}">
                    <i class="icon icon-speedometer"></i><span>Dashboard</span>
                  </a>
                </li>
               
                <li>
                    <a href="{{route('locations.index')}}">
                        <i class="mdi mdi-city-variant-outline"></i><span>Locations</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('leads.leads')}}">
                        <i class="mdi mdi-city-variant-outline"></i><span>Leads</span>
                    </a>
                </li>
               
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-text-o"></i><span>Updates</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/admin/updates')}}">Updates</a></li>
                    </ul>
                </li>
       
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-envelope-o"></i><span>Bulk Messages</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">
                        <li><a href="{{route('admins.bulk.message.teachers')}}">Teachers</a></li>
                        <li><a href="{{route('admins.bulk.message.students')}}">Students</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-code"></i><span>Lessons</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/category')}}">Categories</a></li>
                        <li><a href="{{url('/subcategory')}}">Sub Categories</a></li>
                        <li><a href="{{url('/lecture')}}">Lessons</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-file-code-o"></i><span>Classes</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/admin/calendar')}}">Calendar</a></li>
                        <li><a href="{{route('admin.daily-task-classes')}}">Daily Classes</a></li>
                        <li><a href="{{url('/task_class')}}">Add Class</a></li>
                        <li><a href="{{route('camps')}}">Camps</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <i class="mdi mdi-teach"></i><span>Training</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">
                        <li><a href="{{route('lessons.categories')}}">Categories</a></li>
                        <li><a href="{{route('lessons.subcategories')}}">Sub Categories</a></li>
                        <li><a href="{{route('lessons.index')}}">Training</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="javaScript:void();">
                        <i class="mdi mdi-text-subject"></i><span>Topics</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/topics')}}">Topics</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="icon-people"></i><span>Teachers</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/teacher_profile')}}">Search Teacher</a></li>
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
                    <a href="javaScript:void();">
                        <i class="icon-people"></i><span>Parents</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/search_parent_profile_form')}}">Search Parent</a></li>
                    </ul>
                </li>  

                <li>
                    <a href="{{url('/online_meeting_room')}}">
                        <i class="mdi mdi-desktop-mac"></i><span>Training Room</span>
                    </a>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <i class="fa fa-free-code-camp"></i><span>Free Session</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/free_session_time_slots')}}"> Time Slots</a></li>
                    </ul>
                </li> 
               
                <li>
                    <a href="{{url('/localization')}}">
                        <i class="mdi mdi-poll"></i><span>Localization</span>
                    </a>
                </li>
               
                <li>
                    <a href="javaScript:void();">
                        <i class="mdi mdi-credit-card-multiple"></i><span>Billing</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">                                
                        <li><a href="{{url('/credits_calculation')}}">Users Credits</a></li>
                        <li><a href="{{url('/add_billing_product_form')}}">Add Stripe Product</a></li>
                        <li><a href="{{url('/stripe_products_direct_links')}}">Stripe Products</a></li>
                    </ul>
                </li>  

                <li>
                    <a href="javaScript:void();">
                        <i class="mdi mdi-credit-card-multiple"></i><span>Reports</span><i class="icon-arrow-right pull-right"></i>
                    </a>
                    <ul class="xp-vertical-submenu">
                        <li><a href="{{url('/teachers_pay_report')}}">Pay Report</a></li>
                        <li><a href="{{url('/ROI-report')}}">ROI Report</a></li> 
                    </ul>
                </li>
                <li>
                    <a href="{{url('/surveys')}}">
                        <i class="ion ion-md-document"></i><span>Surveys</span>
                    </a>
                </li>   
                <li>
                    <a href="{{url('/settings')}}">
                        <i class="mdi mdi-settings"></i><span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End XP Navigationbar -->
    </div>
    <!-- End XP Sidebar -->
</div>