    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center wow fadeIn" data-wow-delay="300ms">
                    <div class="heading-title bottom30 darkcolor wow fadeInUp" data-wow-delay="300ms">
                        <span class="defaultcolor">Here's what we can do for you</span>
                        <h2 class="font-normal darkcolor"> Wealth Creation Through Mentoring </h2>
                    </div>
                    <div class="col-md-8 offset-md-2 heading_space" style="text-align:justify;">
                        <p>We understand the diversified needs of an individual and draw up a personalized financial
                            plan, which helps you prepare for your
                            financial milestones. With a comprehensive plan, you make your life simpler and achieve your
                            goals comfortably. With us,
                            you unleash the power of financial planning and achieve more with money.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="grid-mosaic" class="cbp cbp-l-grid-mosaic-flat">
                        @foreach($services as $service)
                            <div class="cbp-item gbi">
                                @if($service->image)
                                <img src="{{asset('images2/'.$service->image->image->folder.'/'.$service->image->image->name)}}" alt="{{$service->name}}">
                                @else
                                <img src="{{asset('/images2/default_blog.png')}}" alt="{{$service->name}}">
                                @endif
                                <div class="gallery-hvr whitecolor">
                                    <div class="center-box">
                                        <a href="{{route('fe.services.show', $service->slug)}}" class="opens" title="View Details"> <i class="fas fa-door-open"></i></a>
                                        <a href="{{route('fe.services.show', $service->slug)}}"><h4 class="w-100">{{$service->name}}</h4></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
