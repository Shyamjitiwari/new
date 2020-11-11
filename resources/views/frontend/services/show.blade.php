@extends('frontend.partials.app')

@section('title', 'Our Services | Gravity Wealth Management')

@section('content')
    <!--Page Header-->
    <section id="main-banner-page"
             class="position-relative page-header service-detail-header section-nav-smooth parallax">
        <div class="overlay overlay-dark opacity-7 z-index-1"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="page-titles whitecolor text-center padding_top padding_bottom">
                        <h2 class="font-xlight">We Love </h2>
                        <h2 class="font-bold">Walking line In Usable</h2>
                        <h2 class="font-xlight">Products</h2>
                        <h3 class="font-light pt-2">The Best Multipurpose Template in Market</h3>
                    </div>
                </div>
            </div>
            <div class="gradient-bg title-wrap">
                <div class="row">
                    <div class="col-lg-12 col-md-12 whitecolor">
                        <h3 class="float-left">Funding Regular & Higher Education For Children</h3>
                        <ul class="breadcrumb top10 bottom10 float-right">
                            <li class="breadcrumb-item hover-light"><a href="{{route('fe.index')}}">Home</a></li>
                            <li class="breadcrumb-item hover-light">How We Can Help</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header ends -->
    <!-- Services us -->
    <section id="our-services" class="padding bglight">
        <div class="container">
            <div class="row whitebox top15">

                <div class="bglight position-relative" style="max-width: 100%;">
                    <div class="widget heading_space text-center text-md-left">
                        <h3 class="darkcolor font-normal bottom30">{{$service->name}}</h3>
                        <p class="bottom30">{!! $service->description !!} </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Services us ends -->
@endsection
