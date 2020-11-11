<section id="testimonial" class="bglight padding_bottom">
        <div class="parallax page-header testimonial-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-6 col-md-12 text-center text-lg-right">
                        <div class="heading-title wow fadeInUp padding_testi" data-wow-delay="300ms">
                            <span class="whitecolor">Our clients are pretty happy, </span>
                            <h2 class="whitecolor font-normal">Let's us team up too!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="owl-carousel" id="testimonial-slider">
                <!--item 1-->
                @foreach($testimonials as $testimonial)
                <div class="item testi-box">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-12 text-center">
                            <div class="testimonial-round d-inline-block" style="margin-top:150px;">
                                @if($testimonial->image)
                                <img src="{{asset('images2/'.$testimonial->image->image->folder.'/'.$testimonial->image->image->name)}}" alt="">
                                @else
                                <img src="{{asset('/images2/default_blog.png')}}" alt="">
                                @endif
                            </div>
                            <h4 class="defaultcolor font-light top15"><a href="#">{{$testimonial->name}}</a></h4>
                            <p>{{$testimonial->designation}} @ {{$testimonial->company}}</p>
                        </div>
                        <div class="col-lg-6 offset-lg-2 col-md-10 offset-md-1 text-lg-left text-center"
                             style="margin-top: 25px;">

                            <p class="bottom15 top90" style="text-align: justify;">{{$testimonial->description}}</p>
                            <span class="d-inline-block test-star">
                                <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
</section>
