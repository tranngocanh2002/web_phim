<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\MovieGenre;
use App\Models\Rating;
use App\Models\Info;
use App\Models\LinkMovie;
use Illuminate\Support\Facades\DB;
class HomePageController extends Controller
{
    public function filter() {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $info = Info::find(1);

        $order_filter = $_GET['order'];
        $genre_filter = $_GET['genre'];
        $country_filter = $_GET['country'];
        $year_filter = $_GET['year'];
        $meta_title = $info->title;
        $meta_description = $info->description;
        $meta_image = '';
        if ($order_filter == '' && $genre_filter == '' && $country_filter == '' && $year_filter == '') {
            $movie = new Movie;
            $movie = $movie->orderBy('updated_at','DESC')->where('status',1)->paginate(40);
            return view('pages.filter', compact('category','genre','country','movie','phim_hot_sidebar','phim_trailer_sidebar','meta_title','meta_description','meta_image'));
        }
        else {
            $movie = new Movie;
            $movie = $movie->withCount('episode');
            if ($genre_filter) {
                $movie = $movie->where('genre_id', $genre_filter);
            }
            if ($country_filter) {
                $movie = $movie->where('country_id', $country_filter);
            }
            if ($year_filter) {
                $movie = $movie->where('year', $year_filter);
            }
            // $movie = Movie::withCount('episode')->where('country_id', $country_filter)->orWhere('genre_id', $genre_filter)->orWhere('year', $year_filter)->orderBy('updated_at','DESC')->paginate(40);
            $movie = $movie->orderBy('updated_at','DESC')->where('status',1)->paginate(40);
            return view('pages.filter', compact('category','genre','country','movie','phim_hot_sidebar','phim_trailer_sidebar','meta_title','meta_description'));
        }
    }
    public function search() {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
            $genre = Genre::orderBy('id', 'DESC')->get();
            $country = Country::orderBy('id', 'DESC')->get();
            // $cate_slug = Category::where('slug', $slug)->first();
            $movie = Movie::withCount('episode')->where('title','LIKE', '%'.$search.'%')->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
            $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
            $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
            $info = Info::find(1);
            $meta_title = $info->title;
            $meta_description = $info->description;
            $meta_image = '';
            return view('pages.search', compact('category','genre','country','search','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
        } else {
            return redirect()->to('/');
        }
        
    }
    public function home() {
        $info = Info::find(1);
        $meta_title = $info->title;
        $meta_description = $info->description;
        $meta_image = 'https://rapphim360.anhtran.id.vn/uploads/logo/meta_img.png';

        $phim_hot = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $category_home = Category::with(['movie' => function($q){ $q->withCount('episode')->where('status',1); }])->orderBy('id', 'DESC')->where('status',1)->get();
        $info = Info::find(1);
        return view('pages.home', compact('category','genre','country','category_home','phim_hot','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function category($slug) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $cate_slug = Category::where('slug', $slug)->first();
        $movie = Movie::withCount('episode')->where('category_id', $cate_slug->id)->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $info = Info::find(1);
        $meta_title = $cate_slug->title;
        $meta_description = $cate_slug->description;
        $meta_image = 'https://rapphim360.anhtran.id.vn/uploads/logo/meta_img.png';
        return view('pages.category', compact('category','genre','country','cate_slug','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function year($year) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $year = $year;
        $movie = Movie::withCount('episode')->where('year',$year)->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $info = Info::find(1);
        $meta_title = 'Năm phim: '.$year;
        $meta_description = 'Phim năm '.$year;
        $meta_image = 'https://rapphim360.anhtran.id.vn/uploads/logo/meta_img.png';
        return view('pages.year', compact('category','genre','country','year','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function tag($tag) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $tag = $tag;
        $movie = Movie::withCount('episode')->where('tags','LIKE','%'.$tag.'%')->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $info = Info::find(1);
        $meta_title = $tag;
        $meta_description = $tag;
        $meta_image = 'https://rapphim360.anhtran.id.vn/uploads/logo/meta_img.png';
        return view('pages.tag', compact('category','genre','country','tag','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function genre($slug) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $genre_slug = Genre::where('slug', $slug)->first();
        // $movie = Movie::where('genre_id', $genre_slug->id)->orderBy('updated_at','DESC')->paginate(40);
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        // nhiều thể loại
        $movie_genre = MovieGenre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $mov_gen) {
            $many_genre[] = $mov_gen->movie_id;
        }
        $movie = Movie::withCount('episode')->whereIn('id', $many_genre)->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
        $info = Info::find(1);
        $meta_title = $genre_slug->title;
        $meta_description = $genre_slug->description;
        $meta_image = 'https://rapphim360.anhtran.id.vn/uploads/logo/meta_img.png';
        return view('pages.genre', compact('category','genre','country','genre_slug','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function country($slug) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $country_slug = Country::where('slug', $slug)->first();
        $movie = Movie::withCount('episode')->where('country_id', $country_slug->id)->where('status',1)->orderBy('updated_at','DESC')->paginate(40);
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $info = Info::find(1);
        $meta_title = $country_slug->title;
        $meta_description = $country_slug->description;
        $meta_image = '';
        return view('pages.country', compact('category','genre','country','country_slug','movie','phim_hot_sidebar','phim_trailer_sidebar','info','meta_title','meta_description','meta_image'));
    }
    public function movie($slug) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $related = Movie::with('category','country','genre')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->take(12)->get();
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        // Lấy 3 tập gần nhất
        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderByRaw('CAST(episode AS UNSIGNED) DESC')->take(3)->get();
        // Lấy tập hiện có mới nhất
        $episode_new = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(1)->first();
        // Lấy tập đầu tiên - tập 1
        $episode_firts = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
        // Lấy tổng số tập
        $episode_count_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_count = $episode_count_list->count();

        // rating
        $rating = Rating::where('movie_id',$movie->id)->avg('rating');
        $rating = round($rating);
        $count_total = Rating::where('movie_id',$movie->id)->count();

        // tăng views
        $count_views = $movie->count_views;
        $count_view = $count_views + 1;
        $movie->count_views = $count_view;
        $movie->save();
        $info = Info::find(1);
        $meta_title = 'Xem phim: '.$movie->title;
        $meta_description = $movie->description;
        // $meta_image = url('uploads/movie/'.$movie->image);
        $meta_image = $movie->image;
        return view('pages.movie',compact('category','genre','country','movie','related','phim_hot_sidebar','phim_trailer_sidebar','episode','episode_firts','episode_new','episode_count','rating','count_total','info','meta_title','meta_description','meta_image'));
    }
    
    public function add_rating(Request $request) {
        $data = $request->all();
        $ip_address = $request->ip();

        $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
        if ($rating_count>0) {
            $rating = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->first();
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'exist';
        } else {
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'done';
        }
    }


    public function watch($slug,$tap,$server_active) {
        $category = Category::orderBy('id', 'DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updated_at','DESC')->take('15')->get();
        $phim_trailer_sidebar = Movie::where('resolution',5)->where('status',1)->orderBy('updated_at','DESC')->take('10')->get();
        $movie = Movie::with('category','genre','country','movie_genre','episode')->where('slug',$slug)->where('status',1)->first();
        $related = Movie::with('category','country','genre')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->take(12)->get();
        // $movie = Movie::with('category','genre','country','movie_genre','episode')->join('episodes', 'movies.id', '=', 'episodes.movie_id')->where('slug',$slug)->where('status',1)->orderBy('episodes.episode', 'DESC')->first();
    //     $movie = Movie::with('category', 'genre', 'country', 'movie_genre', 'episode')
    // ->join('episodes', 'movies.id', '=', 'episodes.movie_id')
    // ->where('movies.slug', $slug)
    // ->where('movies.status', 1)
    // ->orderBy('episodes.episode', 'DESC')
    // ->first();

        if (isset($tap)) {
            $tapphim = $tap;
            $tapphim = substr($tap,4);
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
            // dd($tapphim);
        } else {
            $tapphim = 1;
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        }
        
        $info = Info::find(1);
        $server = LinkMovie::orderBy('id','DESC')->get();
        $episode_movie = Episode::where('movie_id',$movie->id)->orderBy('episode','ASC')->get()->unique('server');
        // $episode_list = Episode::where('movie_id',$movie->id)->orderBy('episode','DESC')->get();
        $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw('CAST(episode AS UNSIGNED) DESC')->get();
        $meta_title = 'Xem phim: '.$movie->title;
        $meta_description = $movie->description;
        // $meta_image = url('uploads/movie/'.$movie->image);
        $meta_image = $movie->image;
        return view('pages.watch',compact('category','genre','country','movie','phim_hot_sidebar','phim_trailer_sidebar','episode','tapphim','related','info','server','episode_movie','episode_list','server_active','meta_title','meta_description','meta_image'));
    }
    public function episode() {
        $info = Info::find(1);
        return view('pages.episode','info');
    }
}
