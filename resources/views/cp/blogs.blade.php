@extends('layouts.app')

@section('content')
    <x-page-title title="Blogs"></x-page-title>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <blogs-index></blogs-index>
                </div>
            </div>
        </div>
    </div>
@endsection
