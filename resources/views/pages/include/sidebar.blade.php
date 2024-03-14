<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4 none_padding">
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
            <div class="section-bar clearfix">
                <div class="section-title">
                    <span>Phim Hot</span>
                    {{-- <ul class="halim-popular-tab" role="tablist">
                        <li role="presentation" class="active">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="today">Day</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="week">Week</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="month">Month</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="all">All</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
            <section class="tab-content">
                <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                    <div class="halim-ajax-popular-post-loading hidden"></div>
                    <div id="halim-ajax-popular-post" class="popular-post">
                        @foreach($phim_hot_sidebar as $phim_hot_side_bar)
                        <div class="item post-37176">
                            <a href="{{route('movie',$phim_hot_side_bar->slug)}}" title="{{$phim_hot_side_bar->title}}">
                                <div class="item-link">
                                    @php
                                        $image_check = substr($phim_hot_side_bar->image,0,4);
                                    @endphp
                                    @if ($image_check == 'http')
                                        <img src="{{$phim_hot_side_bar->image}}"
                                        class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
                                        title="{{$phim_hot_side_bar->title}}" />
                                    @else
                                        <img src="{{asset('uploads/movie/'.$phim_hot_side_bar->image)}}"
                                        class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
                                        title="{{$phim_hot_side_bar->title}}" />
                                    @endif
                                    <span class="is_trailer">
                                        @if ($phim_hot_side_bar->resolution == 1)
                                        SD
                                        @elseif ($phim_hot_side_bar->resolution == 0)
                                        HD
                                        @elseif ($phim_hot_side_bar->resolution == 2)
                                        HD CAM
                                        @elseif ($phim_hot_side_bar->resolution == 3)
                                        CAM
                                        @elseif ($phim_hot_side_bar->resolution == 4)
                                        Full HD
                                        @elseif ($phim_hot_side_bar->resolution == 5)
                                        Trailer
                                        @endif
                                    </span>
                                </div>
                                <p class="title">{{$phim_hot_side_bar->title}}</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">
                                @if ($phim_hot_side_bar->count_views > 0)
                                @php
                                echo number_format($phim_hot_side_bar->count_views, 0, ',', '.');
                                @endphp
                                @else
                                @php
                                echo number_format(rand(1000,99999), 0, ',', '.');
                                @endphp
                                @endif
                                lượt xem
                            </div>
                            <div class="viewsCount" style="color: #9d9d9d;">Năm: {{$phim_hot_side_bar->year}}</div>
                            <div style="float: left;">
                                <ul class="list-inline rating" title="Average Rating">
                                    @for($count=1; $count<=5; $count++) <li title="star_rating" class="padding_none"
                                        style="cursor:pointer;color:#ffcc00;

                                    font-size:20px;">&#9733;</li>
                                        @endfor
                                </ul>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </section>
            {{-- <div class="clearfix"></div> --}}
        </div>
    </aside>
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
            <div class="section-bar clearfix">
                <div class="section-title">
                    <span>Phim sắp chiếu</span>
                    {{-- <ul class="halim-popular-tab" role="tablist">
                        <li role="presentation" class="active">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="today">Day</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="week">Week</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10"
                                data-type="month">Month</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="all">All</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
            <section class="tab-content">
                <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                    <div class="halim-ajax-popular-post-loading hidden"></div>
                    <div id="halim-ajax-popular-post" class="popular-post">
                        @foreach($phim_trailer_sidebar as $phim_hot_side_bar)
                        <div class="item post-37176">
                            <a href="{{route('movie',$phim_hot_side_bar->slug)}}" title="{{$phim_hot_side_bar->title}}">
                                <div class="item-link">
                                    @php
                                        $image_check = substr($phim_hot_side_bar->image,0,4);
                                    @endphp
                                    @if ($image_check == 'http')
                                    <img src="{{$phim_hot_side_bar->image}}"
                                    class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
                                    title="{{$phim_hot_side_bar->title}}" />
                                    @else
                                    <img src="{{asset('uploads/movie/'.$phim_hot_side_bar->image)}}"
                                    class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
                                    title="{{$phim_hot_side_bar->title}}" />
                                    @endif
                                    <span class="is_trailer">
                                        @if ($phim_hot_side_bar->resolution == 1)
                                        SD
                                        @elseif ($phim_hot_side_bar->resolution == 0)
                                        HD
                                        @elseif ($phim_hot_side_bar->resolution == 2)
                                        HD CAM
                                        @elseif ($phim_hot_side_bar->resolution == 3)
                                        CAM
                                        @elseif ($phim_hot_side_bar->resolution == 4)
                                        Full HD
                                        @elseif ($phim_hot_side_bar->resolution == 5)
                                        Trailer
                                        @endif
                                    </span>
                                </div>
                                <p class="title">{{$phim_hot_side_bar->title}}</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">
                                @if ($phim_hot_side_bar->count_views)
                                @php
                                echo number_format($phim_hot_side_bar->count_views, 0, ',', '.');
                                @endphp
                                @else
                                @php
                                echo number_format(rand(1000,99999), 0, ',', '.');
                                @endphp

                                @endif
                                lượt xem
                            </div>
                            <div class="viewsCount" style="color: #9d9d9d;">Năm: {{$phim_hot_side_bar->year}}</div>
                            <div style="float: left;">
                                <ul class="list-inline rating" title="Average Rating">
                                    @for($count=1; $count<=5; $count++) <li title="star_rating" class="padding_none"
                                        style="cursor:pointer;color:#ffcc00;

                                    font-size:20px;">&#9733;</li>
                                        @endfor
                                </ul>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </section>
            {{-- <div class="clearfix"></div> --}}
        </div>
    </aside>
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
            <div class="section-bar clearfix">
                <div class="section-title">
                    <span>Top Views</span>
                </div>
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab">
                <li class="nav-item active">
                    <a class="nav-link filter-sidebar" id="pills-home-tab" data-toggle="pill" href="#ngay" aria-controls="pills-home" aria-selected="true">Ngày</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-sidebar" id="pills-profile-tab" data-toggle="pill" href="#tuan" aria-controls="pills-profile" aria-selected="false">Tuần</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-sidebar" id="pills-contact-tab" data-toggle="pill" href="#thang" aria-controls="pills-contact" aria-selected="false">Tháng</a>
                </li>
            </ul>
            <span id="show_default"></span>
            <div class="tab-content" id="pills-tabContent">
                <div id="halim-ajax-popular-post-default" class="popular-post">
                    <span id="show_data_default"></span>
                </div>
                <div class="tab-pane fade show" id="tuan" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                        <div class="halim-ajax-popular-post-loading hidden"></div>
                        <div id="halim-ajax-popular-post" class="popular-post">
                            <span id="show_data"></span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="tuan" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                        <div class="halim-ajax-popular-post-loading hidden"></div>
                        <div id="halim-ajax-popular-post" class="popular-post">
                            <span id="show_data"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="tuan" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                        <div class="halim-ajax-popular-post-loading hidden"></div>
                        <div id="halim-ajax-popular-post" class="popular-post">
                            <span id="show1"></span>

                        </div>
                    </div>
                </div>
                --}}
                {{-- <div class="tab-pane fade show" id="thang" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                        <div class="halim-ajax-popular-post-loading hidden"></div>
                        <div id="halim-ajax-popular-post" class="popular-post">
                            <span id="show_data"></span>


                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="clearfix"></div> --}}
        </div>
    </aside>
</aside>