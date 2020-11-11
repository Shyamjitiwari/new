@extends('frontend.partials.app')

@section('title', 'Gravity Wealth Management')

@section('content')
    @include('frontend.partials.slider')
    <!--Some Services-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="services-slider" class="owl-carousel">
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="far fa-chart-line"></i></span>
                            <h4 class="bottom10">Execution</h4>
                            <p style="text-align:justify;">The resolve is steel never to be broken by relentless
                                obstacles in the path. The only thing you can perhaps control is to, <b><em>Keep at
                                        it,</em></b> or not.</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-cocktail"></i></span>
                            <h4 class="bottom10">Fulfilment</h4>
                            <p style="text-align:justify;">Sit back and relax. Bask in the glory of good decisions
                                made.</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-random"></i></span>
                            <h4 class="bottom10 text-nowrap">Planning</h4>
                            <p style="text-align:justify;">When it comes to future (but certain) expenses, wouldn't you
                                like prepare well ? How about we lay it out for you. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Some Services ends-->
    <div>
        <span style="display:block;  margin-bottom: 50px;"></span>
    </div>
    <!--About Us-->
    <section id="about" class="single-feature padding_bottom padding_top_half mt-1 mt-lg-n4 mt-md-n3">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-md-7 col-sm-7 text-sm-left text-center wow fadeInLeft" data-wow-delay="300ms">
                    <div class="heading-title mb-4">
                        <h2 class="darkcolor font-normal bottom30">Making the <span class="defaultcolor">Right</span>
                            choice</h2>
                    </div>
                    <div class="bottom25"><strong> Wealth Creation through Mentoring</strong></div>
                    <p class="bottom35" style="text-align: justify;">Every pilot needs a matching wingman, right ? Well,
                        we’re that for you.
                        We help you set the course and steer performance in your journey to wealth creation. We don’t
                        just consult, but endeavour
                        to spread financial awareness through mentoring and working together to help you achieve your
                        financial freedom. </p>
                    <a href="#pointer" class="button btnsecondary gradient-btn  mb-sm-0 mb-4">Learn More</a>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-5 col-sm-5 wow fadeInRight" data-wow-delay="300ms">
                    <div class="image"><img alt="SEO" src="{{asset('images2/owl.png')}}"></div>
                </div>
            </div>
        </div>
    </section>
    <!--About Us-->
    <!-- WOrk Process-->
    <section id="our-process" class="padding bgdark">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <div class="heading-title whitecolor wow fadeInUp" data-wow-delay="300ms">
                        <span>Looking for A reason to get going ? </span>
                        <h2 class="font-normal">How about 5 ! </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <ul class="process-wrapp">
                    <li class="whitecolor wow fadeIn" data-wow-delay="300ms">
                        <span class="pro-step bottom20">01</span>
                        <p class="fontbold bottom25">Saving <br>is not Investing</p>
                        <p style="width:200px; font-size:13px; text-align:justify;">If you can (think you can) make do
                            with diminishing withdrawals from savings,
                            you don't need this. For those of us who know money loses value with time, we're just a
                            phone call away.</p>
                    </li>
                    <li class="whitecolor wow fadeIn" data-wow-delay="500ms">
                        <span class="pro-step bottom20">02</span>
                        <p class="fontbold bottom25">Contingencies<br> don't Discriminate</p>
                        <p style="width:200px; font-size:13px; text-align:justify;">Are you absolutely certain that your
                            family will have a secure & regular income that
                            will keep flowing in even if you are not around anymore or unable to provide for in the same
                            capacity?</p>
                    </li>
                    <li class="whitecolor wow fadeIn active" data-wow-delay="400ms">
                        <span class="pro-step bottom20">03</span>
                        <p class="fontbold bottom25">Everybody <br>has Lifegoals</p>
                        <p style="width:200px; font-size:13px; text-align:justify;">If you think you don't, you either
                            can't visualize them yet or you know them
                            by another name. Material ones among them, will need money to fulfill. Realistic ones among
                            us plan ahead.</p>
                    </li>

                    <li class="whitecolor wow fadeIn" data-wow-delay="600ms">
                        <span class="pro-step bottom20">04</span>
                        <p class="fontbold bottom25">You don't have<br>all the Time in the world</p>
                        <p style="width:200px; font-size:13px; text-align:justify;">Not just because the sooner you
                            start the better it is (and we haven't even begun
                            to show the math here) but also because if you don't, chances are you will always fall
                            short.</p>
                    </li>
                    <li class="whitecolor wow fadeIn" data-wow-delay="700ms">
                        <span class="pro-step bottom20">05</span>
                        <p class="fontbold bottom25">One size<br> doesn't Fit All</p>
                        <p style="width:200px; font-size:13px; text-align:justify;">All people are different, and so are
                            the dynamics for each one of us.
                            All of us need our very own, customized plan for how to make sure we can look back and say
                            we've arrived well !</p>
                    </li>
                </ul>
            </div>
        </div>

    </section>
    <!--WOrk Process ends-->
    <div id="pointer"></div>
    <div>
        <span style="display:block;  margin-bottom: 100px;"></span>
    </div>
    <!-- SERVICES -->
    <x-services-component></x-services-component>
    <!-- SERVICES-->
    <div>
        <span style="display:block;  margin-bottom: 50px;"></span>
    </div>
    <!-- Partners-->
    <section id="our-partners" class="padding">
        <div class="container">
            <div class="row">
                <h2 class="darkcolor font-normal bottom30 text-center text-md-left">Our Partners</h2>
                <div class="col-md-12 col-sm-12">
                    <div id="partners-slider" class="owl-carousel">
                        <div class="item">
                            <div class="logo-item"><img alt="Axis Mutual Fund" src="{{asset('images2/Axis.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Tata Mutual Fund" src="{{asset('images2/Tata.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="SBI Mutual Fund" src="{{asset('images2/SBI.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="HDFC Mutual Fund" src="{{asset('images2/HDFC.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="ICICI Mutual Fund" src="{{asset('images2/ICICI.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Kotak Mutual Fund" src="{{asset('images2/Kotak.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Invesco Mutual Fund"
                                                        src="{{asset('images2/Invesco.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="UTI Mutual Fund" src="{{asset('images2/UTI.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Nippon India Mutual Fund"
                                                        src="{{asset('images2/Nippon.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="ABSL Mutual Fund" src="{{asset('images2/ABSL.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Canara Robeco Mutual Fund"
                                                        src="{{asset('images2/CR.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="DSP Mutual Fund" src="{{asset('images2/DSP.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="IDFC Mutual Fund" src="{{asset('images2/IDFC.png')}}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="L&T Mutual Fund" src="{{asset('images2/L&T.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Mahindra Mutual Fund"
                                                        src="{{asset('images2/Mahindra.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Mirae Asset Mutual Fund"
                                                        src="{{asset('images2/Mirae.png')}}"></div>
                        </div>
                        <div class="item">
                            <div class="logo-item"><img alt="Sundaram Mutual Fund"
                                                        src="{{asset('images2/Sundaram.png')}}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Partners ends-->
    <!-- Testimonials -->
    <x-testimonial-component></x-testimonial-component>
    <!--testimonials end-->
@endsection
