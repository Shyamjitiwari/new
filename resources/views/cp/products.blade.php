@extends('layouts.app')

@section('content')
    <x-page-title title="Products"></x-page-title>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <products-index></products-index>
                </div>
            </div>
        </div>
    </div>
@endsection
