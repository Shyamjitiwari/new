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
            <form class="form-horizontal" method="POST" action="{{ route('get_users_credits') }}">
            {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col">
                            <label>Location</label>
                            <select class="form-control"  name="location_id" required>
                                <option disabled selected value="">Select Location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location['location_id'] }}">{{ $location['location_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="starting_date" required/>
                        </div>
                            <div class="form-group col">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="ending_date" required/>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Get Users' Credits" />
                </form>   
            </div>
            @if ($usersCreditsData != null)
            <div class="card-header bg-white">
                <h5 class="card-title text-black">Surveys Data</h5>
                <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td><b>User Id</b></td> 
                            <td><b>User Name</b></td>
                            <td><b>User Email</b></td>  
                            <td><b>Class Type</b></td>     
                            <td><b>Credits Given</b></td> 
                            <td><b>Credits Used</b></td> 
                            <td><b>Remaining Credits</b></td> 
                            <td><b>Last credits used</b></td>  
                            <td></td>          
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($usersCredits as $userCredit)
                        <tr>
                            <td>{{ $userCredit['user_id'] }}</td>
                            <td>{{ $userCredit['user_name'] }}</td>
                            <td>{{ $userCredit['user_email'] }}</td>
                            <td>{{ $userCredit['task_class_type'] }}</td>
                            <td>{{ $userCredit['credits_given'] }}</td>
                            <td>{{ $userCredit['credits_used'] }}</td>
                            <td>{{ $userCredit['remaining_credits'] }}</td>
                            <td>{{ $userCredit['last_credits_used'] }}</td>
                            <td><a class="btn btn-primary" href="{{ route('edit_users_credits', ['userId' => $userCredit['user_id'], 'taskClassTypeId' => $userCredit['task_class_type_id'], 'lastCreditsUsed' => $userCredit['last_credits_used'], 'totalCreditsUsed' =>$userCredit['credits_used'] ] ) }}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div> 
            @endif           
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