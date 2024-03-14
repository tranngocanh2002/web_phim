<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\MovieGenre;
use App\Models\Episode;
use App\Models\LinkMovie;
use Illuminate\Support\Carbon;
require_once '../vendor/autoload.php';
\Tinify\setKey("8PKqHw7n6kPvxZdNvtgwJR4jX2PlNT3S");

use Illuminate\Console\Command;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mergedItems = [];
        $numApis = 1;
        for ($i = 1; $i <= $numApis; $i++) {
            $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=$i")->json();
            $items = $resp['items'];
            $mergedItems = array_merge($mergedItems, $items);
        }
        
        $resp = [
            "status" => true,
            "items" => $mergedItems,
            "pathImage" => "https://img.ophim12.cc/uploads/movies/",
            "pagination" => [
                "totalItems" => count($mergedItems),
                "totalItemsPerPage" => 24,
                "currentPage" => 1,       
                "totalPages" => ceil(count($mergedItems) / 24),
            ],
        ];
        foreach ($resp['items'] as $max => $res) {
        // $slug = 'bi-duoi-khoi-to-doi-anh-hung-toi-nham-den-mot-cuoc-song-nhan-nha-o-vung-bien-cuong-phan-2';
        // if ($max == 1) {
        //     return 0;
        // }
        $slug = $res['slug'];
        // $slug = $_POST['movie_slug'];
        $check_movie = Movie::where('slug',$slug)->count();
        if ($check_movie > 1) {
            $movie = Movie::where('slug',$slug)->get();
            foreach ($movie as $mov) {
                if (file_exists('uploads/movie/'.$mov->image)) {
                    unlink('uploads/movie/'.$mov->image);
                }
                // Xoá thể loại
                $movie_genre = MovieGenre::whereIn('movie_id',[$mov->id]);
                $movie_genre->delete();
                $episode = Episode::whereIn('movie_id',[$mov->id]);
                $episode->delete();
                // Xoá phim
                $mov->delete();
                // if ($mov) {
                //     $mov->delete();
                // }
            }
            $check_movie = 0;
        }
        if ($check_movie == 0) {

        
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie'];
        $movie = new Movie();
        foreach ($resp_movie as $key => $res) {
            $movie->title = $res['name'];
            $movie->phim_hot = 0;
            // $movie->resolution = $res['resolution'];
            $movie->resolution = 0;
            // $movie->sub = $res['sub'];
            $movie->sub = 0;
            $movie->name_eng = $res['origin_name'];
            $movie->slug = $res['slug'];
            $movie->trailer = $res['trailer_url'];
            $movie->description = $res['content'];
            $movie->status = 1;
            $movie->time = $res['time'];
            $movie->year = $res['year'];
            // $movie->tags = $res['name'].','.$res['origin_name'].','.$res['year'];
            $movie->tags = $res['name'].','.$res['year'];
            $movie->epis = $res['episode_total'];
            if ($res['type'] == 'single') {
                $movie->type = 'phimle';
                $movie->category_id = 2;
            } else {
                $movie->type = 'phimbo';
                $movie->category_id = 1;
            }
            $movie->count_views = rand(100,999999);

            $country_list = Country::get();
            // $res_json = json_decode($res['country'], true);
            if (isset($res['country']) && is_array($res['country'])) {
                foreach ($res['country'] as $country) {
                    if (isset($country['slug'])) {
                        // $country_aip = substr($country['slug'],4);
                        // echo $country_aip . PHP_EOL;
                        // $country_aip = $country['slug'];
                        foreach ($country_list as $key => $coun) {
                            $country_substr = substr($coun->slug,5);
                            if ($country_substr == $country['slug']) {
                                $movie->country_id = $coun->id;
                            }
                        }
                    }
                }
                if ($movie->country_id == null) {
                    $movie->country_id = 1;
                }
            } else {
                $movie->country_id = 1;
            }
            // $country_aip = $res['country']['slug'];
            // foreach ($country as $key => $coun) {
            //     if ($coun->slug == ) {
            //         # code...
            //     }
            // }
            // $movie->country_id = $country->id;
            $list_genre_id = [];
            $genre_list = Genre::get();
            if (isset($res['category']) && is_array($res['category'])) {
                foreach ($res['category'] as $genre) {
                    if (isset($genre['slug'])) {
                        // $country_aip = substr($country['slug'],4);
                        // echo $country_aip . PHP_EOL;
                        // $country_aip = $country['slug'];
                        foreach ($genre_list as $key => $gen) {
                            $genre_substr = substr($gen->slug,5);
                            if ($genre_substr == $genre['slug']) {
                                $list_genre_id[] = $gen->id;
                            }
                        }
                    }
                }
                $movie->genre_id = $gen->id;
            } else {
                $movie->genre_id = 1;
            }

            // $movie->genre_id = $genre->id;
            $movie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            // $movie->image = $res['thumb_url'];

            $url = $res['thumb_url'];
            $imgpath = 'uploads/movie/';
            $fileName = basename($url);

            $image_data = file_get_contents($url);
            $optimized_image_data = \Tinify\fromBuffer($image_data)->toBuffer();
            $uploads_dir = "uploads/movie/";
            if (!file_exists($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }
            $fullname = $uploads_dir . $fileName;
            file_put_contents($fullname, $optimized_image_data);
            $movie->image = $fileName;

            // Thêm nhiều thể loại phim
        // foreach ($res['genre'] as $gen) {
        //     $movie->genre_id = $gen[0];
        // }
            
            if ($movie->save()) {
                $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
                foreach ($resp['episodes'] as $res) {
                    foreach($res['server_data'] as $res_data){
                        $episode = new Episode();
                        $episode->movie_id = $movie->id;
                        
                        $link = '<iframe class="metaframe rptss" src="'.$res_data['link_embed'].'" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>';
                        $episode->linkphim = $link;
                        $episode->episode = $res_data['name'];
                        $linkmovie = LinkMovie::orderBy('id','DESC')->first();
                        $episode->server = $linkmovie->id;
                        $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                        $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                        if($episode->save()) {
                            // toastr()->success('Thêm mới phim theo slug thành công');
                        } else {
                            // toastr()->error('Thêm mới phim theo slug không thành công');
                        }
                    }
                }
            } else {
                // toastr()->error('Thêm mới phim theo slug không thành công');
            }
            $movie->movie_genre()->attach($list_genre_id);

        }
        }
        else {
            $movie = Movie::where('slug',$slug)->first();
            $id = \App\Models\Movie::where('slug',$slug)->first();
            $episode = Episode::where('movie_id',$id->id)->get();
            foreach ($episode as $key => $epi) {
                if ($epi) {
                    $epi->delete();
                }
            }
            // $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
            // $url = $resp['movie']['thumb_url'];
            // // $url = $res['thumb_url'];
            // $imgpath = 'uploads/movie/';
            // $fileName = basename($url);

            // $image_data = file_get_contents($url);
            // $optimized_image_data = \Tinify\fromBuffer($image_data)->toBuffer();
            // $uploads_dir = "uploads/movie/";
            // if (!file_exists($uploads_dir)) {
            //     mkdir($uploads_dir, 0777, true);
            // }
            // $fullname = $uploads_dir . $fileName;
            // file_put_contents($fullname, $optimized_image_data);
            // $movie->image = $fileName;
            $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->save();

            $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
            foreach ($resp['episodes'] as $key => $res) {
                foreach($res['server_data'] as $key_data => $res_data){
                    $episode = new Episode();
                    $episode->movie_id = $movie->id;
                    
                    $link = '<iframe class="metaframe rptss" src="'.$res_data['link_embed'].'" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>';
                    $episode->linkphim = $link;
                    $episode->episode = $res_data['name'];
                    $linkmovie = LinkMovie::orderBy('id','DESC')->first();
                    $episode->server = $linkmovie->id;
                    // $episode->server = $data['linkserver'];
                    $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                    if($episode->save()) {
                        // toastr()->success('Phim tồn tại, Cập nhật tập phim thành công');
                    } else {
                        // toastr()->error('Cập nhật tập phim không thành công');
                    }
                }
            // }
            }
        }
        }
    }
}
