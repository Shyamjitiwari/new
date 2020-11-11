@section('title') 
CodeWithUs - Dashboard
@endsection 
@extends('layouts.main')
@section('style')
<!-- Chartist Chart CSS -->
<link href="{{ asset('assets/plugins/chartist-js/chartist.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Datepicker CSS -->
<link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 
@section('leftbar')
    @include('layouts.admin_menu') 
@endsection 
@section('rightbar-content')
                   
<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">FAQ</h4>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="xp-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </div>
        </div>
    </div>          
</div>
<!-- End XP Breadcrumbbar -->

<!-- Start XP Contentbar -->   
<div class="xp-contentbar">
    <div class="row">
        <!-- Start XP Col -->
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="text-center mt-3 mb-5">
                <h4 class="text-black">Frequently Asked Questions</h4>
            </div>
        </div> 
        <!-- End XP Col -->
         <!-- Start XP Col -->
         <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingOne">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="icon-question text-primary mr-1"></i>
                              {!! __('FAQs.about_cwu_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                          <div class="card-body">
                            {!! __('FAQs.about_cwu_answer') !!}
                          </div>
                        </div>
                      </div>
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingTwo">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="icon-question text-primary mr-1"></i>
                            {!! __('FAQs.location_of_classes_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                          <div class="card-body">
                            {!! __('FAQs.location_of_classes_answer') !!}
                          </div>
                        </div>
                      </div>
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingThree">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.classes_offered_by_cwu_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                          <div class="card-body">
                                {!! __('FAQs.classes_offered_by_cwu_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingThree">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.deciding_the_level_and_topic_for_students_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                          <div class="card-body">
                                {!! __('FAQs.deciding_the_level_and_topic_for_students_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.student_work_can_be_reviewed_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                               {!! __('FAQs.student_work_can_be_reviewed_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.online_class_looklike_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.online_class_looklike_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.technical_requirement_for_online_class_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.technical_requirement_for_online_class_answer') !!}
                          </div>
                        </div>
                      </div>
                      
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.long_term_commitment_with_cwu_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.long_term_commitment_with_cwu_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.refund_policy_on_camps_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.refund_policy_on_camps_answer') !!}
                          </div>
                        </div>
                      </div>

                    </div> 
                </div>
            </div>
        </div>
        <!-- End XP Col -->

        <!-- Start XP Col -->
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="accordion" id="accordionExample2">
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingFour">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseOne"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.teaching_methods_at_cwu_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseFour" class="collapse show" data-parent="#accordionExample2">
                          <div class="card-body">
                                {!! __('FAQs.teaching_methods_at_cwu_answer') !!}
                          </div>
                        </div>
                      </div>
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingFive">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseTwo"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.who_are_teachers_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseFive" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                            {!! __('FAQs.who_are_teachers_answer') !!}
                          </div>
                        </div>
                      </div>
                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.trying_a_class_before_signup_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.trying_a_class_before_signup_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.staying_upto_date_with_students_progress_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.staying_upto_date_with_students_progress_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.in_person_class_look_like_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.in_person_class_look_like_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.cwu_addresses_security_concern_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.cwu_addresses_security_concern_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.read_on_security_label') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.read_on_security_link') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.class_reschedule_policy_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.class_reschedule_policy_answer') !!}
                          </div>
                        </div>
                      </div>

                      <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.siblings_discount_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.siblings_discount_answer') !!}
                          </div>
                        </div>
                      </div>

                    </div> 
                </div>
            </div>
        </div>
        <!-- End XP Col -->

         <!-- Start XP Col -->
         <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                    <div class="card mb-2">
                        <div class="card-header p-1" id="headingSix">
                          <h5 class="mb-0 text-black">
                            <button class="btn btn-link text-black collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree"><i class="icon-question text-primary mr-1"></i>
                                {!! __('FAQs.siblings_discount_question') !!}
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" data-parent="#accordionExample2">
                          <div class="card-body">
                             {!! __('FAQs.siblings_discount_answer') !!}
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
         </div>

    </div>
</div>
 
<!-- End XP Contentbar -->
@endsection 
@section('script')
<!-- Chartist Chart JS -->
<script src="{{ asset('assets/plugins/chartist-js/chartist.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartist-js/chartist-plugin-tooltip.min.js') }}"></script>
<!-- To Do List JS -->
<script src="{{ asset('assets/js/init/to-do-list-init.js') }}"></script>
<!-- Datepicker JS -->
<script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
<!-- Dashboard JS -->
<script src="{{ asset('assets/js/init/dashborad.js') }}"></script>
@endsection 