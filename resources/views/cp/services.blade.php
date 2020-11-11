@extends('layouts.app')

@section('content')
    <x-page-title title="Services"></x-page-title>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <services-index></services-index>
                </div>
            </div>
        </div>
    </div>
@endsection
