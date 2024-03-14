<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width,initial-scale=1.0, maximum-scale=2.0" name="viewport" />
    <meta name="theme-color" content="#1A1A1A">
    <meta http-equiv="Content-Language" content="vi" />
    <meta content="VN" name="geo.region" />
    <meta name="DC.language" scheme="utf-8" content="vi" />
    <meta name="language" content="Việt Nam">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="shortcut icon"
        href="{{asset('uploads/logo/icon.png')}}"
        type="image/x-icon" />    
    <meta name="revisit-after" content="1 days" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <title>{{$meta_title}}</title>
    <meta name="description"
        content="{{$meta_description}}" />
    <link rel="canonical" href="{{Request::url()}}">
    <link rel="next" href="" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:description" content="{{$meta_description}}" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="{{$meta_title}}" />
    <meta property="og:image" content="{!!$meta_image!!}" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="55" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel='dns-prefetch' href='//s.w.org' />

    <link rel='stylesheet' id='bootstrap-css' href='{{ asset('css/bootstrap.min.css?ver=5.7.2') }}' media='all' />
    <link rel='stylesheet' id='style-css' href='{{ asset('css/style.css?ver=5.7.2') }}' media='all' />
    <link rel='stylesheet' id='wp-block-library-css' href='{{ asset('css/style.min.css?ver=5.7.2') }}' media='all' />

    <link rel="stylesheet" href="../public/css/fix.css">

    <script type='text/javascript' src='{{ asset('js/jquery.min.js?ver=5.7.2') }}' id='halim-jquery-js'></script>
    <style type="text/css" id="wp-custom-css">
        .textwidget p a img {
            width: 100%;
        }
    </style>
    <style>
        #header .site-title {
            background: url(https://www.pngkey.com/png/detail/360-3601772_your-logo-here-your-company-logo-here-png.png) no-repeat top left;
            background-size: contain;
            text-indent: -9999px;
        }
        .site-title {
            background: url(https://www.pngkey.com/png/detail/360-3601772_your-logo-here-your-company-logo-here-png.png) no-repeat top left;
            background-size: contain;
            text-indent: -9999px;
        }
    </style>
</head>

<body class="home blog halimthemes halimmovies" data-masonry="">
    <header id="header">
        <div class="container none_mobile">
            <div class="row" id="headwrap">
                <div class="col-md-3 col-sm-6 slogan">
                    {{-- <p class="site-title"> --}}
                    <p class="">
                        <a class="logo" href="{{route('homepage')}}" title="phim hay ">
                            <img src="{{asset('uploads/logo/'.$info->logo)}}" alt="{{$info->logo}}">
                        </a>
                    </p>
                </div>
                <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                    <div class="header-nav">
                        <div class="col-xs-12">
                            {{-- <form id="search-form-pc" name="halimForm" role="search" action="" method="GET"> --}}
                            <div class="form-group">
                                <form action="{{route('search')}}" method="GET">
                                    <div class="input-group col-xs-12">
                                        <input id="timkiem" type="text" name="search" class="form-control" placeholder="Tìm kiếm phim..." autocomplete="off">
                                        <button class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                            {{-- </form> --}}
                        </div>
                        <ul class="list-group" id="result" style="dispaly: none;position: absolute;z-index:9999; background:#121212;width:94%;list-style: none;        margin: 45px 15px;"></ul>
                    </div>
                </div>
                <div class="col-md-4 hidden-xs">
                    <div id="get-bookmark" class="box-shadow"><i class="hl-bookmark"></i><span> Bookmarks</span><span
                            class="count">0</span></div>
                    <div id="bookmark-list" class="hidden bookmark-list-on-pc">
                        <ul style="margin: 0;"></ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-container">
        <div class="container">
            <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
                <div class="navbar-header">
                    <div class="none_mobile">
                        <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse"
                        data-target="#halim" aria-expanded="false">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <button type="button" title="Tìm kiếm" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                            <span class="hl-search" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="row flex_nav">
                        <div class="col1">
                            <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse"
                                data-target="#halim" aria-expanded="false">
                                <span class="sr-only">Menu</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="col2">
                            {{-- <div class=""> --}}
                                <a class="logo" href="{{route('homepage')}}" title="phim hay ">
                                    <img src="{{asset('uploads/logo/'.$info->logo)}}" alt="{{$info->logo}}">
                                </a>
                                {{--
                            </div> --}}
                        </div>
                        <div class="col3">
                            <button type="button" class="navbar-toggle collapsed pull-right expand-search-form"
                                data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                                {{-- <span class="hl-search" aria-hidden="true"></span> --}}
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                      </div>
                    {{-- <button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">
                        Bookmarks<i class="hl-bookmark" aria-hidden="true"></i>
                        <span class="count">0</span>
                    </button> --}}
                    {{-- <button type="button" class="navbar-toggle collapsed pull-right get-locphim-on-mobile">
                        <a href="javascript:;" id="expand-ajax-filter" style="color: #ffed4d;">Lọc <i
                                class="fas fa-filter"></i></a>
                    </button> --}}
                </div>
                <div class="collapse navbar-collapse" id="halim">
                    <div class="menu-menu_1-container">
                        <ul id="menu-menu_1" class="nav navbar-nav navbar-left">
                            <li class="current-menu-item active"><a title="Trang Chủ"
                                    href="{{ route('homepage') }}">Trang Chủ</a></li>
                            @foreach ($category as $key => $cate)
                                <li class="mega"><a title="{{$cate->title}}" href="{{ route('category',$cate->slug) }}">{{$cate->title}}</a>
                                </li>
                            @endforeach
                            <li class="mega dropdown">
                                <a title="Thể Loại" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Thể Loại <span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @foreach ($genre as $key => $gen)
                                        <li><a title="{{$gen->title}}" href="{{ route('genre',$gen->slug) }}">{{$gen->title}}</a></li>
                                    @endforeach

                                </ul>
                            </li>
                            <li class="mega dropdown">
                                <a title="Quốc Gia" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Quốc Gia <span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @foreach ($country as $key => $count)
                                        <li><a title="{{$count->title}}" href="{{ route('country',$count->slug) }}">
                                            @php
                                                echo ucwords($count->title);
                                            @endphp    
                                            {{-- {{$count->title}} --}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mega dropdown">
                                <a title="Năm phim" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Năm phim<span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @for ($year=2020;$year<=2025;$year++)
                                        <li><a title="{{$year}}" href="{{ url('nam/'.$year) }}">{{$year}}</a></li>
                                    @endfor
                                </ul>
                            </li>
                            {{-- <li><a title="Phim Lẻ" href="danhmuc.php">Phim Lẻ</a></li> --}}
                            {{-- <li><a title="Phim Bộ" href="danhmuc.php">Phim Bộ</a></li> --}}
                            {{-- <li><a title="Phim Chiếu Rạp" href="danhmuc.php">Phim Chiếu Rạp</a></li> --}}
                        </ul>
                    </div>
                    {{-- <ul class="nav navbar-nav navbar-left" style="background:#000;">
                        <li><a href="#" onclick="locphim()" style="color: #ffed4d;">Lọc Phim</a></li>
                    </ul> --}}
                </div>
            </nav>
            <div class="collapse navbar-collapse" id="search-form">
                <div id="mobile-search-form" class="halim-search-form">
                    <div class="form-group">
                        <form action="{{route('search')}}" method="GET">
                            <div class="row class_input_search">
                                <div class="col-10 class_input_search input-group">
                                    <input type="text" name="search" class="form-control timkiem" placeholder="Tìm kiếm phim..." autocomplete="off">
                                </div>
                                <div class="col-2 class_input_search">
                                    <button class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form_result">
                        <ul class="list-group result" 
                        {{-- style="dispaly: none;position: absolute;z-index:9999; background:#1b2d3c;width:94%;list-style: none;        margin: 45px 15px;" --}}
                        ></ul>
                    </div>

                    {{-- <div class="form-group">
                        <form action="{{route('search')}}" method="GET">
                            <div class="input-group col-xs-12">
                                <input id="timkiem" type="text" name="search" class="form-control" placeholder="Tìm kiếm phim..." autocomplete="off">
                                <button class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>
            <div class="collapse navbar-collapse" id="user-info">
                <div id="mobile-user-login"></div>
            </div>
        </div>
    </div>
    </div>

    <div class="container">
        <div class="row fullwith-slider"></div>
    </div>
    <div class="container">
        @yield('content')
    </div>
    <div class="clearfix"></div>
    <footer id="footer" class="clearfix">
        <div class="container footer-columns">
            <div class="row container">
                <div class="widget about col-xs-12 col-sm-4 col-md-4">
                    <div class="">
                        <img class="img-responsive"
                        src="{{asset('uploads/logo/'.$info->logo)}}" alt="{{$info->logo}}"/>
                    </div>
                    {{-- Liên hệ QC: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                        data-cfemail="e5958d8c888d849ccb868aa58288848c89cb868a88">[email&#160;protected]</a> --}}
                </div>
            </div>
        </div>
    </footer>
    <div class="widget about col-xs-12 col-sm-4 col-md-12 text_center">
        <p>{{$info->copy_right}}</p>
    </div>
    <div id='easy-top'></div>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0" nonce="xUhkxxbF"></script>

    <script type='text/javascript' src='{{ asset('js/bootstrap.min.js?ver=5.7.2') }}' id='bootstrap-js'></script>
    <script type='text/javascript' src='{{ asset('js/owl.carousel.min.js?ver=5.7.2') }}' id='carousel-js'></script>

    <script type='text/javascript' src='{{ asset('js/halimtheme-core.min.js?ver=1626273138') }}' id='halim-init-js'>
    </script>
    {{-- <script>
        jQuery(document).ready(function($) {
            var owl = $('#halim_related_movies-2');
            owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function(){
            // lấy ra topview ngày phim
            $.ajax({
                url:"{{url('/filter-topview-default')}}",
                method:"GET",
                // data:{value:value},
                success:function(data) {
                    $('#show_data_default').html(data);
                }
            });
        
        $('.filter-sidebar').click(function() {
            var href = $(this).attr('href');
            if (href == '#ngay') {
                var value = 0;
            } else if (href == '#tuan') {
                var value = 1;
            } else if (href == '#thang') {
                var value = 2;
            }
            $.ajax({
                url:"{{url('/filter-topview-phim')}}",
                method:"POST",
                data:{value:value},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data) {
                    $('#halim-ajax-popular-post-default').css("display","none");
                    $('#show_data').html(data);
                }
            });
        })
    })

    </script>
    <script type="text/javascript">
        $(".watch_trailer").click(function(e){
            e.preventDefault();
            var aid = $(this).attr("href");
            $('html,body').animate({scrollTop: $(aid).offset().top},'slow');
        })
    </script>

    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#timkiem').keyup(function() {
                $('#result').html('');
                var search = $('#timkiem').val();
                if(search != ''){
                    var expression = new RegExp(search,"i");
                    // alert(expression);
                    $.getJSON('json/movies.json', function(data){
                        $.each(data, function(key, value){
                            if (value.title.search(expression) != -1 || value.description.search(expression) != -1){
                                // $('#result').css('display','inherit');
                                $('#result').append('<li style="cursor:pointer" class="list-group-item">da</li>');
                            }
                            
                        });
                    });
                }
            })
        })
        
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#timkiem').keyup(function() {
                $('#result').html('');
                var search = $('#timkiem').val();
                if(search != ''){
                    var expression = new RegExp(search,"i");
                    // alert(expression);
                    $.getJSON('json/movies.json', function(data){
                        $.each(data,function(key, value){
                            if (value.title.search(expression) != -1 || value.description.search(expression) != -1){
                                $('#result').css('display','inherit');
                                var image_check = value.image.substring(0, 4);
                                if (image_check.startsWith('http')) {
                                    $('#result').append('<li style="cursor:pointer" class="list-group-item"><img src="'+value.image+'"height="40" width="40" /> '+value.title+'<br/> |<span class="text-mited">'+value.description+'</span></li>');
                                } else {
                                    $('#result').append('<li style="cursor:pointer" class="list-group-item"><img src="uploads/movie/'+value.image+'"height="40" width="40" /> '+value.title+'<br/> |<span class="text-mited">'+value.description+'</span></li>');
                                }
                            }
                            
                        });
                    });
                } else {
                    $('#result').css('display','none');
                }
            })
        })
        $('#result').on('click', 'li', function(){
            var click_text = $(this).text().split('|');
            $('#timkiem').val($.trim(click_text[0]));
            $('#result').html('');
            $('#result').css('display','none');
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.timkiem').keyup(function() {
                $('.result').html('');
                var search = $('.timkiem').val();
                if(search != ''){
                    var expression = new RegExp(search,"i");
                    // alert(expression);
                    $.getJSON('json/movies.json', function(data){
                        $.each(data,function(key, value){
                            if (value.title.search(expression) != -1 || value.description.search(expression) != -1){
                                $('.result').css('display','inherit');
                                $('.result').append('<li style="cursor:pointer" class="list-group-item"><img src="uploads/movie/'+value.image+'"height="40" width="40" /> '+value.title+'<br/> |<span class="text-mited">'+value.description+'</span></li>');
                            }
                            
                        });
                    });
                } else {
                    $('.result').css('display','none');
                }
            })
        })
        $('.result').on('click', 'li', function(){
            var click_text = $(this).text().split('|');
            $('.timkiem').val($.trim(click_text[0]));
            $('.result').html('');
            $('.result').css('display','none');
        })
    </script>
    <script type="text/javascript">
        
        function remove_background(movie_id)
         {
          for(var count = 1; count <= 5; count++)
          {
           $('#'+movie_id+'-'+count).css('color', '#ccc');
          }
        }

        //hover chuột đánh giá sao
        $(document).on('mouseenter', '.rating', function(){
          var index = $(this).data("index");
          var movie_id = $(this).data('movie_id');
        // alert(index);
        // alert(movie_id);
          remove_background(movie_id);
          for(var count = 1; count<=index; count++)
          {
           $('#'+movie_id+'-'+count).css('color', '#ffcc00');
          }
        });
       //nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function(){
          var index = $(this).data("index");
          var movie_id = $(this).data('movie_id');
          var rating = $(this).data("rating");
          remove_background(movie_id);
          //alert(rating);
          for(var count = 1; count<=rating; count++)
          {
           $('#'+movie_id+'-'+count).css('color', '#ffcc00');
          }
         });

        //click đánh giá sao
        $(document).on('click', '.rating', function(){
            var index = $(this).data("index");
            var movie_id = $(this).data('movie_id');
        
            $.ajax({
            url:"{{route('add-rating')}}",
            method:"POST",
            data:{index:index, movie_id:movie_id},
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data)
            {
            if(data == 'done')
            {
                // alert("Bạn đã đánh giá "+index +" trên 5");
                location.reload();
                
            }else if(data =='exist'){
                // alert("Sửa đánh giá thành công");
                location.reload();
            }
            else
            {
                alert("Lỗi đánh giá");
            }
            
            }
            });
        });
    </script>

    <style>
        #overlay_mb {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer
        }

        #overlay_mb .overlay_mb_content {
            position: relative;
            height: 100%
        }

        .overlay_mb_block {
            display: inline-block;
            position: relative
        }

        #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center
        }

        #overlay_mb .overlay_mb_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7)
        }

        #overlay_mb img {
            position: relative;
            z-index: 999
        }

        @media only screen and (max-width: 768px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }
    </style>

    <style>
        #overlay_pc {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer;
        }

        #overlay_pc .overlay_pc_content {
            position: relative;
            height: 100%;
        }

        .overlay_pc_block {
            display: inline-block;
            position: relative;
        }

        #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        #overlay_pc .overlay_pc_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7);
        }

        #overlay_pc img {
            position: relative;
            z-index: 999;
        }

        @media only screen and (max-width: 768px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }
    </style>

    <style>
        .float-ck {
            position: fixed;
            bottom: 0px;
            z-index: 9
        }

        * html .float-ck

        /* IE6 position fixed Bottom */
            {
            position: absolute;
            bottom: auto;
            top: expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop, 10)||0)-(parseInt(this.currentStyle.marginBottom, 10)||0)));
        }

        #hide_float_left a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
            float: left;
        }

        #hide_float_left_m a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
        }

        span.bannermobi2 img {
            height: 70px;
            width: 300px;
        }

        #hide_float_right a {
            background: #01AEF0;
            padding: 5px 5px 1px 5px;
            color: #FFF;
            float: left;
        }
    </style>
    {{-- Chặn f12 --}}
    {{-- <script>//<![CDATA[
        const disabledKeys = ["J", "u", "I"];
        const showAlert = e => {
          e.preventDefault();
        //   return alert("Sorry, you can't view or copy source codes this way!");
        }
        document.addEventListener("contextmenu", e => {
          showAlert(e);
        });
        document.addEventListener("keydown", e => {
          // calling showAlert() function, if the pressed key matched to disabled keys
          if((e.ctrlKey && disabledKeys.includes(e.key)) || e.key === "F12") {
            showAlert(e);
          }
        });
        window.addEventListener("load",function(){
          try {
            !function t(n) {
              1 === ("" + n / n).length && 0 !== n || function() {}.constructor("debugger")(), t(++n)
            }(0)
          } catch (n) {
            setTimeout(t, 100)
          }
        });
  //]]></script> --}}
</body>

</html>
