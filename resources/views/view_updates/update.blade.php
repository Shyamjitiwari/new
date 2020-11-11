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
                        <h4 class="xp-counter text-warning m-t-20">{{ $update['content'] }}</h4>
                        <p class="text-muted font-16">By : {{ $update['created_by'] }}</p>
                        <p class="mb-0 f-w-5 text-danger"><span class="badge badge-warning">{{ $update['created_at'] }}</span></p> 
                    </div>
                </div>
            </div>
            <h6 style="color:black">Feel free to call (408) 909-7717 or chat with us for more information on your student's progress, or to give us either positive or negative feedback.</h6>
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