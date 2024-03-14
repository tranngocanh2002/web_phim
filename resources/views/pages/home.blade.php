@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
            <div class="ajax"></div>
        </div>
    </div>
    <div id="halim_related_movies-2xx" class="wrap-slider">
        <div class="section-bar clearfix">
            <h3 class="section-title"><span>Phim hot</span></h3>
        </div>
        <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
            @foreach($phim_hot as $hot)
            <article class="thumb grid-item post-38498">
                <div class="halim-item">
                    <a class="halim-thumb" href="{{route('movie',$hot->slug)}}" title="{{$hot->title}}">
                        @php
                            $image_check = substr($hot->image,0,4);
                        @endphp
                        @if ($image_check == 'http')
                        <figure><img class="lazy img-responsive" src="{{$hot->image}}" alt="{{$hot->title}}" title="{{$hot->title}}"></figure>
                        @else
                        <figure><img class="lazy img-responsive" src="{{asset('uploads/movie/'.$hot->image)}}" alt="{{$hot->title}}" title="{{$hot->title}}"></figure>
                        @endif
                        <span class="status">
                            @if ($hot->resolution == 1)
                            SD
                            @elseif ($hot->resolution == 0)
                            HD
                            @elseif ($hot->resolution == 2)
                            HD CAM
                            @elseif ($hot->resolution == 3)
                            CAM
                            @elseif ($hot->resolution == 4)
                            Full HD
                            @elseif ($hot->resolution == 5)
                            Trailer
                            @endif
                        </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                            @if ($hot->type == 'phimbo')
                                {{$hot->episode_count}}/{{$hot->epis}} |
                            @endif

                            @if ($hot->sub == 0)
                            Phụ đề
                            @elseif ($hot->sub == 1)
                            Thuyết minh
                            @endif
                        </span>
                        <div class="icon_overlay"></div>
                        <div class="halim-post-title-box">
                            <div class="halim-post-title ">
                                <p class="entry-title">{{$hot->title}}</p>
                                <p class="original_title">{{$hot->name_eng}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        <script>
            $(document).ready(function($) {
                    var owl = $('#halim_related_movies-2');
                    owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 5000,autoplayHoverPause: true,nav: true,navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],responsiveClass: true,responsive: {0: {items:3},480: {items:3}, 600: {items:5},1000: {items: 6}}})});
        </script>
    </div>
    <div id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        @foreach ($category_home as $key => $cate_home)
        <section id="halim-advanced-widget-2">
            <div class="section-heading">
                <a href="{{ route('category',$cate_home->slug) }}" title="{{ $cate_home->title }}">
                    <span class="h-text">{{ $cate_home->title }}</span>
                </a>
                <div class="text_right">
                    <a href="{{route('category',$cate_home->slug)}}" title="{{route('category',$cate_home->slug)}}">
                        <span class="h-text">Xem thêm >> </span>
                    </a>
                </div>
            </div>
            <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                @foreach ($cate_home->movie->sortByDesc('updated_at')->take(12) as $key => $mov)
                <article class="col-md-3 col-sm-3 col-xs-4 thumb grid-item post-37606">
                    <div class="halim-item">
                        <a class="halim-thumb" href="{{route('movie',$mov->slug)}}" title="{{$mov->title}}">
                            @php
                                $image_check = substr($mov->image,0,4);
                            @endphp
                            @if ($image_check == 'http')
                                <figure><img class="lazy img-responsive" src="{{$mov->image}}"
                                    alt="{{$mov->title}}" title="{{$mov->title}}">
                                </figure>
                            @else
                                <figure><img class="lazy img-responsive" src="{{asset('uploads/movie/'.$mov->image)}}"
                                    alt="{{$mov->title}}" title="{{$mov->title}}">
                                </figure>
                            @endif
                            <span class="status">
                                @if ($mov->resolution == 1)
                                SD
                                @elseif ($mov->resolution == 0)
                                HD
                                @elseif ($mov->resolution == 2)
                                HD CAM
                                @elseif ($mov->resolution == 3)
                                CAM
                                @elseif ($mov->resolution == 4)
                                Full HD
                                @elseif ($mov->resolution == 5)
                                Trailer
                                @endif
                            </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                @if ($mov->type == 'phimbo')
                                    {{$mov->episode_count}}/{{$mov->epis}} |
                                @endif
                                @if ($mov->sub == 0)
                                Phụ đề
                                @elseif ($mov->sub == 1)
                                Thuyết minh
                                @endif
                            </span>
                            <div class="icon_overlay"></div>
                            <div class="halim-post-title-box">
                                <div class="halim-post-title ">
                                    <p class="entry-title">{{$mov->title}}</p>
                                    <p class="original_title">{{$mov->name_eng}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        <div class="clearfix"></div>
        @endforeach
        <section id="halim-advanced-widget-2">
            <div class="section-heading">
                <a href="" title="Phim sắp chiéu">
                    <span class="h-text">Phim sắp chiéu</span>
                </a>
                <div class="text_right">
                    <a href="" title="">
                        <span class="h-text">Xem thêm >> </span>
                    </a>
                </div>
            </div>
            <div id="halim-advanced-widget-2-ajax-box" class="halim_box">

                @foreach($phim_trailer_sidebar->take(12) as $keys => $mov)
                    <article class="col-md-3 col-sm-3 col-xs-4 thumb grid-item post-37606">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{route('movie',$mov->slug)}}" title="{{$mov->title}}">
                                @php
                                    $image_check = substr($mov->image,0,4);
                                @endphp
                                @if ($image_check == 'http')
                                    <figure><img class="lazy img-responsive" src="{{$mov->image}}"
                                        alt="{{$mov->title}}" title="{{$mov->title}}">
                                    </figure>
                                @else
                                    <figure><img class="lazy img-responsive" src="{{asset('uploads/movie/'.$mov->image)}}"
                                        alt="{{$mov->title}}" title="{{$mov->title}}">
                                    </figure>
                                @endif
                                <span class="status">
                                    @if ($mov->resolution == 1)
                                    SD
                                    @elseif ($mov->resolution == 0)
                                    HD
                                    @elseif ($mov->resolution == 2)
                                    HD CAM
                                    @elseif ($mov->resolution == 3)
                                    CAM
                                    @elseif ($mov->resolution == 4)
                                    Full HD
                                    @elseif ($mov->resolution == 5)
                                    Trailer
                                    @endif
                                </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                    @if ($mov->type == 'phimbo')
                                        {{$mov->episode_count}}/{{$mov->epis}} |
                                    @endif
                                    @if ($mov->sub == 0)
                                    Phụ đề
                                    @elseif ($mov->sub == 1)
                                    Thuyết minh
                                    @endif
                                </span>
                                <div class="icon_overlay"></div>
                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <p class="entry-title">{{$mov->title}}</p>
                                        <p class="original_title">{{$mov->name_eng}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
    {{-- sidebar --}}
    @include('pages.include.sidebar')
</div>
@endsection