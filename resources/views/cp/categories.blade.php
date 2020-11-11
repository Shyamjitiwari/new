@extends('layouts.app')

@section('content')
    <x-page-title title="Categories"></x-page-title>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <categories-index></categories-index>
                </div>
            </div>
        </div>
    </div>
@endsection
