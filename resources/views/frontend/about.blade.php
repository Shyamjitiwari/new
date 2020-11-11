@extends('frontend.partials.app')

@section('title', 'Gravity Wealth Management')

@section('content')
    <!--Page Header-->
    <section id="main-banner-page" class="position-relative page-header about-header parallax section-nav-smooth">
        <div class="overlay overlay-dark opacity-7"></div>
        <div class="container">
            <div class="row">
                <div>
                    <div class="page-titles whitecolor text-center padding_top padding_bottom">
                        <h2 class="font-bold"><em>You Inspire Us</em></h2>
                        <h2 class="font-xlight"></h2>
                        <h3 class="font-light" style="line-height:2">We help to make sure the means find the ends, that you've worked so hard to secure.</h3>
                    </div>
                </div>
                <ul class="social-icons-simple revicon white">
                    <li class="d-table"><a href="https://www.facebook.com/gravityfinsol" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="d-table"><a href="https://twitter.com/gravity_wealth" target="_blank"><i class="fab fa-twitter"></i> </a></li>
                    <li class="d-table"><a href="https://www.linkedin.com/company/gravitywealth/?viewAsMember=true" target="_blank"><i class="fab fa-linkedin-in"></i> </a></li>
                    <li class="d-table"><a href="javascript:void(0)"><i class="fab fa-instagram"></i> </a></li>
                </ul>
            </div>
            <div class="gradient-bg title-wrap">
                <div class="row">
                    <div class="col-lg-12 col-md-12 whitecolor">
                        <h3 class="float-left">Who we are..</h3>
                        <ul class="breadcrumb top10 bottom10 float-right">
                            <li class="breadcrumb-item hover-light"><a href="{{route('fe.index')}}">Home</a></li>
                            <li class="breadcrumb-item hover-light">About</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header ends -->
    <!-- About us -->
    <section id="aboutus" class="padding_top padding_bottom">
        <div class="container aboutus">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 padding_bottom_half">
                    <div class="image"><img alt="About Us" src="{{asset('images2/about4.png')}}"></div>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-6 padding_bottom_half text-center text-md-left">
                    <h2 class="darkcolor font-normal bottom30">Helping you carve out your <span class="defaultcolor"> Freedom</span>
                    </h2>
                    <p class="bottom35" style="text-align:justify;"><em><strong>Gravity</strong></em> is a premier
                        investment consultation and services firm catering
                        to investors in India and abroad for the past 5 years. It is our endeavour to spread financial
                        awareness through mentoring and working
                        together to help you achieve your financial freedom. We believe in investor empowerment by
                        sharing insights from the financial world so
                        that you make the right choice when it comes to your investment decisions. We understand the
                        diversified needs of individuals and draw up
                        personalized financial plans,to prepare for your milestones. With a comprehensive plan, you make
                        your life simpler
                        and achieve your goals comfortably. With us, your investments work harder, stronger, better !
                    </p>
                    <a href="{{route('fe.index')}}#pointer" class="button btnsecondary gradient-btn">How we can Help</a>
                </div>
            </div>
            <div class="row  align-items-center">
                <div class="col-lg-5  col-md-6 padding_top_half text-center text-md-left">
                    <h2 class="darkcolor font-normal bottom30">Talk to us about anything <span class="defaultcolor">Investments</span>
                    </h2>
                    <p class="bottom35" style="text-align:justify;">Although we offer a wide range of services relating
                        to personal investment planning, if
                        we were to scale our clients by solutions provided, it would be for Comprehensive Goal Based
                        Investing, Contingency Planning and Fixed Income
                        Solutions, in that order. Are you also looking for one of those ?
                    </p>
                </div>
                <div class="col-lg-6 offset-lg-1 col-md-6 padding_top_half">
                    <div class="progress-bars">
                        <div class="progress">
                            <p>Goal Based Investment Plans</p>
                            <div class="progress-bar gradient-bg" data-value="53">
                                <span class="gradient-bg whitecolor">53%</span>
                            </div>
                        </div>
                        <div class="progress">
                            <p>Contingency Planning</p>
                            <div class="progress-bar gradient-bg" data-value="27">
                                <span class="gradient-bg whitecolor">27%</span>
                            </div>
                        </div>
                        <div class="progress">
                            <p>Fixed Income Solutions</p>
                            <div class="progress-bar gradient-bg" data-value="20">
                                <span class="gradient-bg whitecolor">20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About us ends -->
    <!-- Our Team-->
    <section id="our-team" class="half-section-alt teams-border">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="heading-title wow fadeInUp" data-wow-delay="300ms">
                        <span class="defaultcolor text-center text-md-left">A <font size=5> <strong>Big Hello</strong> </font> there !!!</span>
                        <h2 class="darkcolor font-normal bottom30 text-center text-md-left">Meet Our Team</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="ourteam-slider" class="owl-carousel">
                        <div class="item">
                            <div class="team-box">
                                <div class="image">
                                    <img src="{{asset('images2/puneet.png')}}" alt="">
                                </div>
                                <div class="team-content">
                                    <h4 class="darkcolor">Puneet</h4>
                                    <p>Founder & Principal Advisor</p>
                                    <ul class="social-icons-simple">
                                        <li><a class="facebook" href="javascript:void(0)"><i class="fab fa-facebook-f"></i> </a></li>
                                        <li><a class="twitter" href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                        <li><a class="insta" href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="team-box">
                                <div class="image">
                                    <img src="{{asset('images2/neelima.png')}}" alt="">
                                </div>
                                <div class="team-content">
                                    <h4 class="darkcolor">Neelima </h4>
                                    <p>Wealth Manager</p>
                                    <ul class="social-icons-simple">
                                        <li><a class="facebook" href="javascript:void(0)"><i class="fab fa-facebook-f"></i> </a></li>
                                        <li><a class="twitter" href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                        <li><a class="insta" href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="team-box single">
                                <div class="image">
                                    <img src="{{asset('images2/narain.png')}}" alt="">
                                </div>
                                <div class="team-content">
                                    <h4 class="darkcolor">Narain</h4>
                                    <p>Wealth Manager</p>
                                    <ul class="social-icons-simple">
                                        <li><a class="facebook" href="javascript:void(0)"><i class="fab fa-facebook-f"></i> </a></li>
                                        <li><a class="twitter" href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                        <li><a class="insta" href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="team-box">
                                <div class="image">
                                    <img src="{{asset('images2/gaurav.png')}}" alt="Gaurav">
                                </div>
                                <div class="team-content">
                                    <h4 class="darkcolor">Gaurav </h4>
                                    <p>Lead Client Relations</p>
                                    <ul class="social-icons-simple">
                                        <li><a class="facebook" href="javascript:void(0)"><i class="fab fa-facebook-f"></i> </a></li>
                                        <li><a class="twitter" href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                        <li><a class="insta" href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Team ends-->
    <!-- Team Speak -->
    <section id="our-apps" class="padding">
        <div class="container">
            <div class="row d-flex align-items-center" id="app-feature">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="text-center text-md-right">
                        <div class="feature-item mt-3 wow fadeInLeft" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms; animation-name: fadeInLeft;">
                            <div class="icon"><i class="fas fa-bezier-curve"></i></div>
                            <div class="text">
                                <h3 class="bottom15">
                                    <span class="d-inline-block">Puneet</span>
                                </h3>
                                <p style="text-align:justify;">Puneet is professionally qualified for investment
                                    consultation and is highly passionate about it.
                                    After an MBA in Finance and a decade in the industry,
                                    he setup Gravity about 5 years ago and there's been no looking back ever since. An
                                    AMFI recognised investment specialist,
                                    Puneet has not only been helping clients as a strategic
                                    advisor and a successful investor but also has been guiding students and fellow
                                    advisors as a mentor by sharing insights
                                    gained over the years in the industry.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item mt-5 wow fadeInLeft" data-wow-delay="350ms" style="visibility: visible; animation-delay: 350ms; animation-name: fadeInLeft;">
                            <div class="icon"><i class="fas fa-cubes"></i></div>
                            <div class="text">
                                <h3 class="bottom15">
                                    <span class="d-inline-block">Narain</span>
                                </h3>
                                <p style="text-align:justify;">Number crunching is his game and he's been at it for 20
                                    years ! Narain supports the portfolio management
                                    team with simple executable outcomes of hours of complex research, to develop
                                    portfolio strategies that supplement the overall effort.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{asset('images2/team.png')}}" alt="Teamwork">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="text-center text-md-left">
                        <div class="feature-item mt-3 wow fadeInRight" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms; animation-name: fadeInRight;">
                            <div class="icon"><i class="fas fa-chart-bar"></i></div>
                            <div class="text">
                                <h3 class="bottom15">
                                    <span class="d-inline-block">Neelima</span>
                                </h3>
                                <p style="text-align:justify;"> Neelima is the perfect blend of theory and practice with
                                    a knack of identifying opportunities while
                                    managing the risks adeptly. She is the lead Wealth Manager at Gravity and along with
                                    the team handles our portfolio base with a
                                    single objective – achieving the target returns. An AMFI certified investment
                                    expert, an MBA (Finance) and with over
                                    15 years of industry experience she manages funds for over 800 clients and
                                    counting.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item mt-5 wow fadeInRight" data-wow-delay="350ms" style="visibility: visible; animation-delay: 350ms; animation-name: fadeInRight;">
                            <div class="icon"><i class="fas fa-comments"></i></div>
                            <div class="text">
                                <h3 class="bottom15">
                                    <span class="d-inline-block">Gaurav </span>
                                </h3>
                                <p style="text-align:justify; margin-bottom: 50px;"> After stints in the Indian Army &
                                    the banking industry,
                                    Gaurav now manages Client Relations for Gravity. An MBA in Finance, he is also an
                                    expert at simplifying complex financial instruments
                                    and methodologies for our clients. Still passionate about the service, he also
                                    manages a dedicated portfolio for our brothers
                                    in uniform.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Team Speak ends-->
@endsection
