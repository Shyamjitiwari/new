@extends('frontend.partials.app')

@section('title', $blog->meta_title ? $blog->meta_title : $blog->name)
@section('meta_keywords',$blog->meta_keywords)
@section('meta_description', $blog->meta_description ? $blog->meta_description : $blog->description)

@section('content')
    <!--Page Header-->
    <section id="main-banner-page" class="position-relative page-header blog-header parallax section-nav-smooth">
        <div class="overlay overlay-dark opacity-7"></div>
        <div class="container">
            <div class="row">
                <div>
                    <div class="page-titles whitecolor text-center  padding_bottom"
                         style="padding-left:100px; padding-top:100px;">
                        <h2 class="font-bold" style="text-align:center;">Building a Better Financial Life</h2>

                        <h2 class="font-light" style="line-height:1.5">Insights on Personal Financial Planning </h2>
                        <br>
                        <h2 class="font-light" style="line-height:1.5; color: rgb(0, 204, 255);"> #SmartMoves</h2>
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
                        <h3 class="float-left">Information & Opinion</h3>
                        <ul class="breadcrumb top10 bottom10 float-right">
                            <li class="breadcrumb-item hover-light"><a href="{{route('fe.index')}}">Home</a></li>
                            <li class="breadcrumb-item hover-light"><a href="{{route('fe.blogs.index')}}">#SmartMoves</a></li>
                            <li class="breadcrumb-item hover-light">{{$blog->name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header ends -->

    <!-- Our Blogs -->
    <section id="our-blog" class="bglight padding">
        <div class="container">
            <div class="row">
                <div>
                    <div class="news_item shadow" style="max-width:60%; margin-left:20%">
                        <div class="image">
                            @if($blog->image)
                            <img src="{{asset('images2')}}/{{$blog->image->image->folder}}/{{$blog->image->image->name}}" alt="Latest News" class="img-responsive">
                            @else
                                <img src="{{asset('images2/default_blog.png')}}" alt="Latest News" class="img-responsive">
                            @endif
                        </div>
                        <div class="news_desc text-center text-md-left">
                            <h3 class="text-capitalize font-normal darkcolor"><a href="javascript:void(0)">{{$blog->name}}</a></h3>
                            <ul class="meta-tags top20 bottom20">
                                <li><a href="#"><i class="fas fa-calendar-alt"></i>{{$blog->created_at}}</a></li>
                                <li><a href="#"> <i class="far fa-user"></i> {{($blog->created_id ? $blog->created_by->name : '-')}} </a></li>
                                <li><a href="#"><i class="fas fa-clock"></i>3 min read</a></li>
                                <li><a href="#comments" ><i class="fas fa-comment"></i>{{optional($blog->activeComments)->count()}}</a></li>

                            </ul>
                            <p class="bottom35 text-justify">{!! $blog->description !!}</p>


                            <div class="post-comment">
                                <div class="text-center text-md-left">
                                    <h4 class=" darkcolor">Would like to share an opinion, go ahead and post it!</h4>
                                    <p class="bottom20 top20">

                                </div>
                                <form class="getin_form" id="post-a-comment" @submit.prevent="postComment({{$blog->id}})">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group bottom35">
                                                <label for="first_name1" class="d-none"></label>
                                                <input class="form-control" type="text" placeholder="Name:" required id="name1" v-model="comment.name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group bottom35">
                                                <label for="email1" class="d-none"></label>
                                                <input class="form-control" type="email" placeholder="Email:" required id="email1" v-model="comment.email">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group bottom35">
                                                <label for="message" class="d-none"></label>
                                                <textarea class="form-control" placeholder="What do you have on mind ?" id="message" v-model="comment.message" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 bottom5 text-sm-left text-center">
                                            <button type="submit" v-if="!loader" class="button gradient-btn">Post</button>
                                            <button v-else type="submit" class="button gradient-btn w-100" id="submit_btn">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="comment-section" id="comments">
                                @foreach($blog->activeComments as $comment)
                                        <div>
                                            <div class="row">
                                                <div class="col">
                                                    <i class="fas fa-user"></i>
                                                    @if($comment->name == NULL)
                                                        {{'Unknown'}}
                                                    @else
                                                        {{$comment->name}}
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <i class="fas fa-comment"></i>
                                                    {{optional($comment->replies)->count()}}
                                                </div>
                                                <!-- <div class="col">
                                                    <i class="fas fa-thumbs-up"></i>
                                                    {{optional($comment->likes)->count()}}
                                                </div> -->
                                                <!-- <div class="col">
                                                    <i class="fas fa-thumbs-down"></i>
                                                    {{optional($comment->dislikes)->count()}}
                                                </div> -->
                                                <div class="col">
                                                    <i class="fas fa-clock"></i>
                                                    {{$comment->created_at}}
                                                </div>
                                            </div>
                                            <p>{{$comment->description}}</p>
                                        </div>
                                        <button class="badge badge-secondary" data-toggle="modal" data-target="#exampleModalCenter" @click="showReplyForm({{$comment->id}})" >Reply   <i class="fas fa-reply"></i></button>
                                        <button  class="badge badge-info"> Like    <i class="fas fa-thumbs-up"></i></button>
                                        <button class="badge badge-dark"> Dislike <i class="fas fa-thumbs-down"></i></button>
                                        @foreach($comment->replies as $reply)
                                        <div class="row">
                                            <div class="col-3"></div>
                                            <div class="col-9">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h5><i class="fas fa-user"></i>
                                                    @if($reply->name == NULL)
                                                        {{'Unknown'}}
                                                    @else
                                                        {{$reply->name}}
                                                    @endif</h5>
                                                    <p class="card-text">{{$reply->description}}</p>
                                                    <h6>{{$reply->created_at}}</h6>
                                                </div>
                                                
                                            </div>
                                            
                                                    
                                            <span></span>

                                            </div>
                                            <hr>
                                        </div>
                                        <br>
                                        @endforeach
                                        <hr>
                                    @endforeach
                                </div>
                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-body">
                                            <comment-reply></comment-reply>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Modal Ends -->
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </section>
    <!--Our Blog Ends-->

@endsection
