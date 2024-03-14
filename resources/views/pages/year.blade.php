@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <div class="yoast_breadcrumb hidden-xs">
                        <span>
                            <span>Phim thuộc năm
                                @for ($year_bread=2020;$year_bread<=2025;$year_bread++) <span class="breadcrumb_last"
                                    aria-current="page"> » <a href="{{url('nam/'.$year_bread)}}">{{$year_bread}} </a>
                                    @endfor
                            </span>
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
        <section>
            <div class="section-bar clearfix none_mobile">
                <h1 class="section-title"><span>Lọc phim</span></h1>
            </div>
            <div class="section-bar clearfix none_mobile">
                <div class="row">
                    {{-- Bộ lọc --}}
                    @include('pages.include.filter')
                </div>
            </div>
            <div class="section-bar clearfix">
                <h1 class="section-title"><span>Năm: {{$year}}</span></h1>
            </div>
            <div class="halim_box">
                @foreach ($movie as $key => $mov)
                <article class="col-md-3 col-sm-3 col-xs-4 thumb grid-item post-37606">
                    <div class="halim-item">
                        <a class="halim-thumb" href="{{route('movie',$mov->slug)}}">
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
            <div class="clearfix"></div>
            <div class="text-center">
                {{-- <ul class='page-numbers'>
                    <li><span aria-current="page" class="page-numbers current">1</span></li>
                    <li><a class="page-numbers" href="">2</a></li>
                    <li><a class="page-numbers" href="">3</a></li>
                    <li><span class="page-numbers dots">&hellip;</span></li>
                    <li><a class="page-numbers" href="">55</a></li>
                    <li><a class="next page-numbers" href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                </ul> --}}
                {!! $movie->links("pagination::bootstrap-4") !!}
            </div>
        </section>
    </main>
    {{-- sidebar --}}
    @include('pages.include.sidebar')
</div>
@endsection