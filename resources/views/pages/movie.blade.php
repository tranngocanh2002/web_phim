@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
<div class="halim-panel-filter">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-6">
                <div class="yoast_breadcrumb hidden-xs">
                    <span>
                        <span><a href="{{ route('category',$movie->category->slug) }}">{{$movie->category->title}}</a> » 
                            <span><a href="{{ route('country',$movie->country->slug) }}">{{$movie->country->title}}</a> » 
                            </span>
                            @foreach ($movie->movie_genre as $item)
                                <a href="{{ route('genre',[$item->slug]) }}">{{$item->title}}</a> » 
                            @endforeach
                                <span class="breadcrumb_last" aria-current="page">{{$movie->title}}</span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
        <div class="ajax"></div>
    </div>
</div>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
    <section id="content" class="test">
        <div class="clearfix wrap-content">

            <div class="halim-movie-wrapper">
                <div class="title-block">
                    <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                        <div class="halim-pulse-ring"></div>
                    </div>
                    <div class="title-wrapper" style="font-weight: bold;">
                        {{-- Bookmark --}}
                    </div>
                </div>
                <div class="movie_info col-xs-12">
                    <div class="movie-poster col-md-3">
                        @php
                            $image_check = substr($movie->image,0,4);
                        @endphp
                        @if ($image_check == 'http')
                            <img class="movie-thumb" src="{{$movie->image}}" alt="{{$movie->title}}">
                        @else
                            <img class="movie-thumb" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->title}}">
                        @endif
                        @foreach ($episode as $key => $show_epis_first)
                        @endforeach
                        @if ($movie->resolution !=5)
                            @if (isset($show_epis_first->movie))
                                <div class="bwa-content">
                                    <div class="loader"></div>
                                    <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$episode_firts->episode.'/server-'.$episode_firts->server)}}" class="bwac-btn">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div>
                            {{-- @else  --}}
                                {{-- <div class="bwa-content">
                                    <div class="loader"></div>
                                    <a href="" class="bwac-btn">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div> --}}
                            @endif
                        @else
                            <div class="bwa-content">
                                <div class="loader"></div>
                                <a href="#watch_trailer" class="bwac-btn watch_trailer">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="film-poster col-md-9">
                        <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$movie->title}}</h1>
                        <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}}</h2>
                        <ul class="list-info-group">
                            <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                                @if ($movie->resolution == 1)
                                SD
                                @elseif ($movie->resolution == 0)
                                HD
                                @elseif ($movie->resolution == 2)
                                HD CAM
                                @elseif ($movie->resolution == 3)
                                CAM
                                @elseif ($movie->resolution == 4)
                                Full HD
                                @elseif ($movie->resolution == 5)
                                Trailer
                                @endif       
                            </span>
                            @if ($movie->resolution != 5)
                                <span class="episode">
                                    @if ($movie->sub == 0)
                                    Phụ đề
                                    @elseif ($movie->sub == 1)
                                    Thuyết minh
                                    @endif     
                                </span>
                            @endif
                            </li>
                            {{-- <li class="list-info-group-item"><span>Điểm IMDb</span> : <span class="imdb">7.2</span></li> --}}
                            <li class="list-info-group-item"><span>Số tập</span> : 
                                @if ($movie->type == 'phimbo')
                                {{-- @if (isset($episode->movie)) --}}
                                    {{$episode_count}}/{{$movie->epis}} - 
                                    @if ($episode_count == $movie->epis)
                                        Hoàn thành
                                    @else
                                        Đang cập nhật
                                    @endif
                                {{-- @endif --}}
                                @elseif ($movie->type == 'phimle')
                                    HD - Full HD
                                @endif
                            </li>
                            <li class="list-info-group-item"><span>Thời lượng</span> : {{$movie->time}}</li>
                            <li class="list-info-group-item"><span>Thể loại</span> : 
                                @foreach ($movie->movie_genre as $gen)
                                    <a href="{{ route('genre',$gen->slug) }}" rel="category tag">{{$gen->title}}</a>
                                @endforeach
                            </li>
                            <li class="list-info-group-item"><span>Danh mục</span> : 
                                <a href="{{ route('category',$movie->category->slug) }}" rel="category tag">{{$movie->category->title}}</a>
                            </li>
                            <li class="list-info-group-item"><span>Quốc gia</span> : 
                                <a href="{{ route('country',$movie->country->slug) }}" rel="tag">
                                    @php
                                        echo ucwords($movie->country->title);
                                    @endphp
                                    {{-- {{$movie->country->title}} --}}
                                </a>
                            </li>
                            <li class="list-info-group-item"><span>Tập mới nhất</span> : 
                                
                                @if ($movie->type == 'phimbo')
                                    @if (isset($show_epis_first->movie))
                                        @foreach ($episode as $key => $epis)
                                        <span class="quality">
                                            <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$epis->episode.'/server-'.$episode_firts->server)}}" rel="tag">{{$epis->episode}}</a>
                                        </span>                                    
                                        @endforeach
                                    @endif
                                @elseif ($movie->type == 'phimle')
                                    @if (isset($show_epis_first->movie))
                                        @foreach ($episode as $key => $epis)
                                            <span class="quality">
                                                {{-- <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$epis->episode)}}" rel="tag"> --}}
                                                    <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$epis->episode)}}" rel="tag">
                                                        @if ($epis->episode == 'hd')
                                                        HD
                                                        @elseif ($epis->episode == 'sd')
                                                        SD
                                                        @elseif ($epis->episode == 'cam')
                                                        CAM
                                                        @elseif ($epis->episode == 'hdcam')
                                                        HD CAM
                                                        @elseif ($epis->episode == 'fullhd')
                                                        FULL HD
                                                        @endif
                                                    </a>    
                                                {{-- </a> --}}
                                            </span> 
                                        @endforeach
                                    @endif
                                @else Đang cập nhật
                                @endif
                            </li>
                            <ul class="list-inline rating"  title="Average Rating">

                                @for($count=1; $count<=5; $count++)
    
                                  @php
    
                                    if($count<=$rating){ 
                                      $color = 'color:#ffcc00;'; //mau vang
                                    }
                                    else {
                                      $color = 'color:#ccc;'; //mau xam
                                    }
                                  
                                  @endphp
                                
                                  <li title="star_rating" 
    
                                  id="{{$movie->id}}-{{$count}}" 
                                  
                                  data-index="{{$count}}"  
                                  data-movie_id="{{$movie->id}}" 
    
                                  data-rating="{{$rating}}" 
                                  class="rating" 
                                  style="cursor:pointer; {{$color}} 
    
                                  font-size:30px;">&#9733;</li>
    
                                @endfor
                            </ul>
                            <span class="list-info-group-item">
                                Đánh giá: {{$rating}}
                                <li title="star_rating" 
                                  style="cursor:pointer; color:#ffcc00; font-size:20px; display: inline;">&#9733;</li>/{{$count_total}} lượt đánh giá
                            </span>
                            {{-- <li class="list-info-group-item"><span>Đạo diễn</span> : <a class="director" rel="nofollow" href="https://phimhay.co/dao-dien/cate-shortland" title="Cate Shortland">Cate Shortland</a></li>
                            <li class="list-info-group-item last-item" style="-overflow: hidden;-display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-flex: 1;-webkit-box-orient: vertical;"><span>Diễn viên</span> : <a href="" rel="nofollow" title="C.C. Smiff">C.C. Smiff</a>, <a href="" rel="nofollow" title="David Harbour">David Harbour</a>, <a href="" rel="nofollow" title="Erin Jameson">Erin Jameson</a>, <a href="" rel="nofollow" title="Ever Anderson">Ever Anderson</a>, <a href="" rel="nofollow" title="Florence Pugh">Florence Pugh</a>, <a href="" rel="nofollow" title="Lewis Young">Lewis Young</a>, <a href="" rel="nofollow" title="Liani Samuel">Liani Samuel</a>, <a href="" rel="nofollow" title="Michelle Lee">Michelle Lee</a>, <a href="" rel="nofollow" title="Nanna Blondell">Nanna Blondell</a>, <a href="" rel="nofollow" title="O-T Fagbenle">O-T Fagbenle</a></li> --}}
                        </ul>
                        {{-- <div class="movie-trailer">
                            @php
                                $current_url = Request::url();
                            @endphp
                            <div class="fb-like" data-href="{{$current_url}}" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="halim_trailer"></div>
            <div class="clearfix"></div>
            <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                    <article id="post-38424" class="item-content">
                        {{$movie->description}}
                    </article>
                </div>
            </div>
            <div class="section-bar clearfix" id="watch_trailer">
                <h2 class="section-title"><span style="color:#ffed4d">Trailer</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                    <article id="post-38424" class="item-content">
                        @php
                            // $image_check = substr($movie->trailer,0,4);
                            $viTri = strpos($movie->trailer, "?v=");
                        @endphp
                        @if ($viTri !== false)
                            @php
                                $chuoiSauCat = substr($movie->trailer, $viTri+3);
                            @endphp
                            <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$chuoiSauCat}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$movie->trailer}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @endif
                    </article>
                </div>
            </div>
            <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Từ khoá phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                    <article id="post-38424" class="item-content">
                        @if($movie->tags==!null)
                        @php
                        $tags = array();
                        $tags = explode(',',$movie->tags);
                        @endphp
                        @foreach ($tags as $tag)
                        <a href="{{url('tag/'.$tag)}}">{{$tag}}</a>
                        @endforeach
                        @else
                        {{$movie->title}}
                        @endif
                        {{-- {{$movie->tags}} --}}
                    </article>
                </div>
            </div>
            <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Bình luận</span></h2>
            </div>
            {{-- <div class="entry-content htmlwrap clearfix cmt" style="background: white">
                <div class="video-item halim-entry-box">
                    @php
                        $current_url = Request::url();
                    @endphp
                    <article id="post-38424" class="item-content">
                        <div class="fb-comments" data-href="{{$current_url}}" data-width="100%" data-numposts="10"></div>
                    </article>
                </div>
            </div> --}}
        </div>
    </section>
    <section class="related-movies">
        <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-bar clearfix">
                <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
            </div>
            <div id="www" class="owl-carousel owl-theme related-film">
                @foreach ($related as $key => $mov)
                    <article class="thumb grid-item post-38498">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{route('movie',$mov->slug)}}">
                                @php
                                    $image_check = substr($mov->image,0,4);
                                @endphp
                                @if ($image_check == 'http')
                                <figure><img class="lazy img-responsive"
                                    src="{{$mov->image}}"
                                    alt="{{$mov->title}}" title="{{$mov->title}}">
                                </figure>
                                @else
                                <figure><img class="lazy img-responsive"
                                    src="{{asset('uploads/movie/'.$mov->image)}}"
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
                                </span><span class="episode"><i class="fa fa-play"
                                        aria-hidden="true"></i>
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
            <script>
                jQuery(document).ready(function($) {
                    var owl = $('#www');
                    owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
            </script>
        </div>
    </section>
</main>
{{-- sidebar --}}
@include('pages.include.sidebarmovie')
</div>
@endsection
