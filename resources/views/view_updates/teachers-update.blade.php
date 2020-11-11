@section('title') 
CodeWithUs - Update
@endsection 
@extends('layouts.update_layout')
@section('style')
<!-- Chartist Chart CSS -->
<link href="{{ asset('assets/plugins/chartist-js/chartist.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Datepicker CSS -->
<link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection 

<div class="xp-contentbar">

    <div class="row"> 
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="xp-widget-box text-center">
                        <h4 class="xp-counter text-warning m-t-20">{{ $update->content}}</h4>
                        <p class="text-muted font-16 text-capitalize">By : {{ $update->teacher->full_name }}</p>
                        <p class="mb-0 f-w-5 text-danger"><span class="badge badge-warning">{{ $update->created_at }}</span></p>
                    </div>
                    <br/><br/><br/>
                    <form class="form-horizontal" method="POST" action="{{ route('user_feedback') }}">
                    {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $parentid }}"/>
                        <input type="hidden" name="update_id" value="{{ $update->id }}"/>
                        <label>{!! __('survey.feedback_from_updates_page') !!}</label>
                        <textarea name="feedback" rows="4" class="form-control" required></textarea><br/>
                        <input class="btn btn-primary" type="submit" value="Submit Feedback" />
                    </form>
                </div>
            </div>       
        </div>
    </div>
</div>
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