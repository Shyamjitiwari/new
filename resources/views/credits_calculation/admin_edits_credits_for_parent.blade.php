@section('title') 
CodeWithUs - Dashboard
@endsection 
@extends('layouts.main')
@section('leftbar')
    @include('layouts.admin_menu') 
@endsection 
@section('rightbar-content')

<!-- Start XP Breadcrumbbar -->                    
<div class="xp-breadcrumbbar">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4 class="xp-page-title">Parents Credits</h4>
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
            @if(session('success'))
                <h6 style="color:green"><b>{{session('success')}}</b></h1>
            @endif
                <form class="form-horizontal" method="POST" action="{{ route('update_parents_credits') }}">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="user_id" value="{{ $userid }}" required/>
                    <div class="row">
                        <div class="form-group col">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" value="{{ $phone }}" readonly/>
                        </div>
                        <div class="form-group col">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $email }}" readonly/>
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
                    <div class="row">
                        <div class="form-group col">
                            <label>Give Credits</label>
                            <input type="text"  placeholder="0.0" class="form-control" name="give_credits" />
                        </div>
                        <div class="form-group col">
                            <label>Deduct Credits</label>
                            <input type="text" placeholder="0.0" class="form-control" name="deduct_credits" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <textarea placeholder="Please provide a description for Adding or deducting credits" class="form-control" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Update Parents' Credits" />
                </form> 
            </div>  
            </div>
                   
        </div>
    </div>
</div>
<!-- End XP Contentbar -->
@endsection 
@section('script')

@endsection 