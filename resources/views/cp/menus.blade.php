@extends('layouts.app')

@section('content')
    <x-page-title title="Menus"></x-page-title>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <menus-index></menus-index>
                </div>
            </div>
        </div>
    </div>
@endsection
