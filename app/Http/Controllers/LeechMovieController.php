<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\LinkMovie;
use App\Models\MovieGenre;
use Illuminate\Support\Carbon;
require_once '../vendor/autoload.php';
\Tinify\setKey("8PKqHw7n6kPvxZdNvtgwJR4jX2PlNT3S");
class LeechMovieController extends Controller
{
    public function leech_movie() {
        // $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1")->json();
        // return view('admincp.leech.index',compact('resp'));

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
            "pathImage" => "https://img.ophim10.cc/uploads/movies/",
            "pagination" => [
                "totalItems" => count($mergedItems),
                "totalItemsPerPage" => 24,
                "currentPage" => 1,       
                "totalPages" => ceil(count($mergedItems) / 24),
            ],
        ];
        // dd($resp);
        return view('admincp.leech.index',compact('resp'));
    }

    public function leech_detail($slug) {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie'];
        return view('admincp.leech.leech_detail',compact('resp','resp_movie'));
    }

    public function leech_store(Request $request, $slug) {
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
            $movie->tags = $res['name'].','.$res['origin_name'].','.$res['year'];
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
            $movie->image = $res['thumb_url'];

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
                            toastr()->success('Thêm mới phim và tập phim thành công');
                        } else {
                            toastr()->error('Thêm mới phim và tập phim không thành công');
                        }
                    }
                }
            } else {
                toastr()->error('Thêm mới phim và tập phim không thành công');
            }
            $movie->movie_genre()->attach($list_genre_id);

        }

        return redirect()->back();
    }

    public function leech_episode($slug) {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        return view('admincp.leech.leech_episodes',compact('resp'));
    }

    public function leech_episode_store(Request $request ,$slug) {
        $movie = Movie::where('slug',$slug)->first();

        // $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        // if ($episode_check > 0) {
        //     return redirect()->back();
        // } else {
        $episode_check = Episode::where('movie_id',$movie->id)->count();
            if ($episode_check > 0) {
                toastr()->error('Các tập phim đã tồn tại');
                return redirect()->back();
            } else {
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        foreach ($resp['episodes'] as $key => $res) {
            foreach($res['server_data'] as $key_data => $res_data){
                // $episode_check = Episode::where('episode',$res_data['name'])->where('movie_id',$movie->id)->count();
                // if ($episode_check > 0) {
                //     toastr()->error('Các tập phim đã tồn tại');
                //     return redirect()->back();
                // } else {
                $episode = new Episode();
                $episode->movie_id = $movie->id;
                
                $link = '<iframe class="metaframe rptss" src="'.$res_data['link_embed'].'" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>';
                $episode->linkphim = $link;
                $episode->episode = $res_data['name'];
                // if ($key_data == 0) {
                //     $linkmovie = LinkMovie::orderBy('id','DESC')->first();
                //     $episode->server = $linkmovie->id;
                // } else {
                //     $linkmovie = LinkMovie::orderBy('id','ASC')->first();
                //     $episode->server = $linkmovie->id;
                // }
                $linkmovie = LinkMovie::orderBy('id','DESC')->first();
                $episode->server = $linkmovie->id;
                // $episode->server = $data['linkserver'];
                $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                if($episode->save()) {
                    toastr()->success('Thêm mới phim thành công');
                } else {
                    toastr()->error('Thêm mới phim không thành công');
                }
            }
        }
        }

        return redirect()->back();
    }


    public function leech_episode_update(Request $request ,$slug) {
        $movie = Movie::where('slug',$slug)->first();
        $id = \App\Models\Movie::where('slug',$slug)->first();
        $episode = Episode::where('movie_id',$id->id)->get();
        foreach ($episode as $key => $epi) {
            if ($epi) {
                $epi->delete();
            }
        }

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
                    toastr()->success('Cập nhật tập phim thành công');
                } else {
                    toastr()->error('Cập nhật tập phim không thành công');
                }
            }
        // }
        }

        return redirect()->back();
    }

    public function leech_add_movie(Request $request) {
        $slug = $_POST['movie_slug'];
        // $check_movie = Movie::where('slug',$slug)->first();
        $check_movie = Movie::where('slug',$slug)->count();
        if ($check_movie > 0) {
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

        // if (!empty($check_movie)) {
        //     $movie = Movie::where('slug',$slug)->first();
        //     // Xoá ảnh
        //     if (file_exists('uploads/movie/'.$movie->image)) {
        //         unlink('uploads/movie/'.$movie->image);
        //     }
        //     // Xoá thể loại
        //     $movie_genre = MovieGenre::whereIn('movie_id',[$movie->id]);
        //     $movie_genre->delete();
        //     $episode = Episode::whereIn('movie_id',[$movie->id]);
        //     $episode->delete();
        //     // Xoá phim
        //     $movie->delete();
        // }

        // if (empty($check_movie)) {

        
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie'];
        $movie = new Movie();
        foreach ($resp_movie as $key => $res) {
            $movie->title = $res['name'];
            $movie->phim_hot = 0;
            // $movie->resolution = $res['resolution'];
            $format = $res['quality'];
            if ($format == 'HD'){
                $movie->resolution = 0;
            } else {
                $movie->resolution = 1;
            }
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
            } else if ($res['type'] == 'series' || $res['type'] == 'tvshows' || $res['type'] == 'hoathinh'){
                $movie->type = 'phimbo';
                $movie->category_id = 1;
            } else {
                $movie->type = 'phimle';
                $movie->category_id = 2;
                $movie->resolution = 5;
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

            $movie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

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
                            toastr()->success('Thêm mới phim theo slug thành công');
                        } else {
                            toastr()->error('Thêm mới phim theo slug không thành công');
                        }
                    }
                }
            } else {
                toastr()->error('Thêm mới phim theo slug không thành công');
            }
            $movie->movie_genre()->attach($list_genre_id);

        }
        // }
        // else {
        //     $movie = Movie::where('slug',$slug)->first();
        //     $id = \App\Models\Movie::where('slug',$slug)->first();
        //     $episode = Episode::where('movie_id',$id->id)->get();
        //     foreach ($episode as $key => $epi) {
        //         if ($epi) {
        //             $epi->delete();
        //         }
        //     }

        //     $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        //     foreach ($resp['episodes'] as $key => $res) {
        //         foreach($res['server_data'] as $key_data => $res_data){
        //             $episode = new Episode();
        //             $episode->movie_id = $movie->id;
                    
        //             $link = '<iframe class="metaframe rptss" src="'.$res_data['link_embed'].'" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>';
        //             $episode->linkphim = $link;
        //             $episode->episode = $res_data['name'];
        //             $linkmovie = LinkMovie::orderBy('id','DESC')->first();
        //             $episode->server = $linkmovie->id;
        //             // $episode->server = $data['linkserver'];
        //             $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        //             $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        //             if($episode->save()) {
        //                 toastr()->success('Phim tồn tại, Cập nhật tập phim thành công');
        //             } else {
        //                 toastr()->error('Cập nhật tập phim không thành công');
        //             }
        //         }
        //     // }
        //     }
        // }

        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::where('movie_id',$id)->get();
        foreach ($episode as $key => $epi) {
            if ($epi) {
                $deleted = $epi->delete();
            
                if ($deleted) {
                    toastr()->success('Xoá tập phim thành công');
                } else {
                    toastr()->error('Xoá tập phim không thành công');
                }
            } else {
                toastr()->error('Không có tập phim để xoá');
            }
        }
        if (empty($epi)) {
            toastr()->error('Không có tập phim để xoá');
        }
        return redirect()->back();
    }
}
