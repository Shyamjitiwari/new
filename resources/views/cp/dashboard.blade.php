@extends('layouts.app')

@section('content')
<x-page-title title="Dashboard"></x-page-title>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <enquiry-table></enquiry-table>
                <comment-section></comment-section>
                <activity-report></activity-report>
            </div>
        </div>
    </div>
</div>
@endsection
