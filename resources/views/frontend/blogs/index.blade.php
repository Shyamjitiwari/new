@extends('frontend.partials.app')

@section('title', 'Blog List')

@section('content')
    <!--Page Header-->
    <section id="main-banner-page" class="position-relative page-header blog-header parallax section-nav-smooth">
        <div class="overlay overlay-dark opacity-7"></div>
        <div class="container">
            <div class="row">
                <div>
                    <div class="page-titles whitecolor text-center  padding_bottom" style="padding-left:100px; padding-top:100px;">
                        <h2 class="font-bold" style="text-align:center;">Building a Better Financial Life</h2>
                        <h2 class="font-light" style="line-height:1.5">Insights on Personal Financial Planning </h2>
                        <br>
                        <h2 class="font-light" style="line-height:1.5; color: rgb(0, 204, 255);"> #SmartMoves</h2>
                    </div>
                </div>
                <ul class="social-icons-simple revicon white">
                    <li class="d-table"><a href="https://www.facebook.com/gravityfinsol" target="_blank"><i class="fab fa-facebook-f"></i></a> </li>
                    <li class="d-table"><a href="https://twitter.com/gravity_wealth" target="_blank"><i class="fab fa-twitter"></i> </a> </li>
                    <li class="d-table"><a href="https://www.linkedin.com/company/gravitywealth/?viewAsMember=true" target="_blank"><i class="fab fa-linkedin-in"></i> </a> </li>
                    <li class="d-table"><a href="javascript:void(0)"><i class="fab fa-instagram"></i> </a> </li>
                </ul>
            </div>
            <div class="gradient-bg title-wrap">
                <div class="row">
                    <div class="col-lg-12 col-md-12 whitecolor">
                        <h3 class="float-left">Information & Opinion</h3>
                        <ul class="breadcrumb top10 bottom10 float-right">
                            <li class="breadcrumb-item hover-light"><a href="{{route('fe.index')}}">Home</a></li>
                            <li class="breadcrumb-item hover-light">#SmartMoves</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header ends -->
    <section id="our-blog" class="bglight padding">
        <div class="container">
            <div id="blog-filter" class="cbp-l-filters dark bottom40 wow fadeIn d-table mx-auto" data-wow-delay="350ms">
                <div data-filter="*" class="cbp-filter-item">
                    <span>All</span>
                </div>
                @foreach($tags as $tag)
                <div data-filter=".{{$tag->slug}}" class="cbp-filter-item">
                    <span>{{$tag->name}}</span>
                </div>
                @endforeach
            </div>
            <div id="blog-measonry" class="cbp">
                <!--Post29-->
                @foreach($blogs as $blog)
                <div class="cbp-item
                    @foreach($blog->tags as $tag)
                    {{$tag->slug}}
                    @endforeach
                    ">
                    <div class="news_item shadow text-center text-md-left">
                        <a class="image" href="{{route('fe.blogs.show', $blog->slug)}}">
                            @if($blog->image)
                            <img src="{{asset('images2')}}/{{$blog->image->image->folder}}/{{$blog->image->image->name}}" alt="Latest News" class="img-responsive">
                            @else
                            <img src="{{asset('images2/default_blog.png')}}" alt="Latest News" class="img-responsive">
                            @endif

                        </a>
                        <div class="news_desc investment">
                            <h3 class="font-normal darkcolor"><a href="{{route('fe.blogs.show', $blog->slug)}}">{{$blog->name}}</a></h3>
                            <ul class="meta-tags top20 bottom20" style="font-size: 5px">
                                <li><a href="#"><i class="fas fa-calendar-alt"></i>{{$blog->created_at}}</a></li>
                                <li><a href="#" class="text-capitalize"> <i class="far fa-user"></i> {{$blog->created_id ? $blog->created_by->name : 'Admin'}} </a></li>
                                <li><a href="#"><i class="fas fa-clock"></i>{{$blog->read_time ? $blog->read_time : 5}} min read</a></li>
                            </ul>
                            <div style="height: 50px; margin-bottom: 10px; white-space:normal; overflow: hidden; text-overflow:ellipsis;">
                                <p class="bottom35" >{!! Str::limit($blog->description, 100) !!}</p>
                            </div>
                            <a href="{{route('fe.blogs.show', $blog->slug)}}" class="button gradient-btn">Read more</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{$blogs->links()}}
        </div>
    </section>
    <!--Our Blogs Ends-->
@endsection
