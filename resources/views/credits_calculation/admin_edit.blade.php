@section('title') 
CodeWithUs - Dashboard
@endsection 
@extends('layouts.main')
@section('style')
<!-- DataTables CSS -->
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 
@section('leftbar')
    @include('layouts.admin_menu') 
@endsection 
@section('rightbar-content')

<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">Users Credits</h4>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="xp-breadcrumb">
               
            </div>
        </div>
    </div>          
</div>
<!-- End XP Breadcrumbbar -->
<!-- Start XP Contentbar -->    
<div class="xp-contentbar">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('update_users_credits') }}">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="user_id" value="{{ $userid }}" required/>
                <input type="hidden" class="form-control" name="task_class_type_id" value="{{ $taskclasstypeid }}"/>
                    <div class="row">
                        <div class="form-group col">
                            <label>User Name</label>
                            <input type="text" class="form-control" name="user_name" value="{{ $username }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label>User Email</label>
                            <input type="text" class="form-control" name="user_email" value="{{ $useremail }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label>Task Class Type Name</label>
                            <input type="text" class="form-control" name="task_class_type_name" value="{{ $taskclasstypename }}" readonly/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Credits Given</label>
                            <input type="text" class="form-control" name="credits_given" value="{{ $creditsgiven }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label>Credits Used</label>
                            <input type="text" class="form-control" name="credits_used" value="{{ $creditsused }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label>Remaining Credits</label>
                            <input type="text" class="form-control" name="remaining_credits" value="{{ $remainingcredits }}" readonly/>
                        </div> 
                    </div>
                    <div >
                        <div class="form-group">
                            <label>Last Credit Used</label>
                            <input type="text" class="form-control" name="last_credit_used" value="{{ $lastcreditsused }}" readonly/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Give Credits</label>
                            <input type="text"  placeholder="0.0" class="form-control" name="give_credits" />
                        </div>
                        <div class="form-group col">
                            <label>Deduct Credits</label>
                            <input type="text" placeholder="0.0" class="form-control" name="deduct_credits" />
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <textarea placeholder="Please provide a description for Adding or deducting credits" class="form-control" name="description" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Update Users' Credits" />
                </form> 
            </div>  
            </div>
                   
        </div>
    </div>
</div>
<!-- End XP Contentbar -->
@endsection 
@section('script')
<!-- Required Datatable JS -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/init/table-datatable-init.js') }}"></script>
@endsection 