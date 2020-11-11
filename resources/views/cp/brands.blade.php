@extends('layouts.app')

@section('content')
    <x-page-title title="Brands"></x-page-title>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <brands-index></brands-index>
                </div>
            </div>
        </div>
    </div>
@endsection
