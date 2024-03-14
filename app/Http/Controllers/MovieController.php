<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\MovieGenre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category','movie_genre','country','genre')->withCount('episode')->orderBy('id','DESC')->get();
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        $path = public_path()."/json/";
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json',json_encode($list));
        return view('admincp.movie.index',compact('list','category','country'));
    }

    public function update_year(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }
    public function update_season(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }
    public function update_topview(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }
    public function filter_topview(Request $request) {
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('updated_at','DESC')->take(15)->get();
        $out_put='';
        foreach($movie as $mov) {
            if ($mov->resolution==0){
                $text = 'HD';
            } elseif ($mov->resolution==1) {
                $text = 'SD';
            } elseif ($mov->resolution==2) {
                $text = 'HD CAM';
            } elseif ($mov->resolution==3) {
                $text = 'CAM';
            } elseif ($mov->resolution==4) {
                $text = 'Full HD';
            }
            // @php
            //     $image_check = substr($mov->image,0,4);
            // @endphp
            // @if ($image_check == 'http')
            //     <img src="{{$phim_hot_side_bar->image}}"
            //     class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
            //     title="{{$phim_hot_side_bar->title}}" />
            // @else
            //     <img src="{{asset('uploads/movie/'.$phim_hot_side_bar->image)}}"
            //     class="lazy post-thumb" alt="{{$phim_hot_side_bar->title}}"
            //     title="{{$phim_hot_side_bar->title}}" />
            // @endif
            // $out_put.='
            // <div class="item post-37176">
            //     <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
            //         <div class="item-link">
            //             '.$image_check = substr($mov->image,0,4);
            //             if ($image_check == 'http'){.'
            //                 <img src="'.url($mov->image).'"
            //                     class="lazy post-thumb" alt="'.$mov->title.'"
            //                     title="'.$mov->title.'" />
            //             '.else{.'
            //             <img src="'.url('uploads/movie/'.$mov->image).'"
            //                 class="lazy post-thumb" alt="'.$mov->title.'"
            //                 title="'.$mov->title.'" />
            //             '.}}.'
            //             <span class="is_trailer">'.$text.'</span>
            //         </div>
            //         <p class="title">'.$mov->title.'</p>
            //     </a>
            //     <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            //     <div style="float: left;">
            //         <span class="user-rate-image post-large-rate stars-large-vang"
            //             style="display: block;/* width: 100%; */">
            //             <span style="width: 0%"></span>
            //         </span>
            //     </div>
            // </div>
            // ';

            $out_put .= '
                <div class="item post-37176">
                    <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                        <div class="item-link">';

            $image_check = substr($mov->image, 0, 4);

            if ($image_check == 'http') {
                $out_put .= '
                            <img src="' . url($mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />';
            } else {
                $out_put .= '
                            <img src="' . url('uploads/movie/' . $mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />';
            }

            $out_put .= '
                            <span class="is_trailer">' . $text . '</span>
                        </div>
                        <p class="title">' . $mov->title . '</p>
                    </a>
                    <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                    <div style="float: left;">
                        <span class="user-rate-image post-large-rate stars-large-vang"
                            style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                        </span>
                    </div>
                </div>';
        }
        echo $out_put;
    }
    public function filter_default(Request $request) {
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('updated_at','DESC')->take(15)->get();
        $out_put='';
        foreach($movie as $mov) {
            if ($mov->resolution==0){
                $text = 'HD';
            } elseif ($mov->resolution==1) {
                $text = 'SD';
            } elseif ($mov->resolution==2) {
                $text = 'HD CAM';
            } elseif ($mov->resolution==3) {
                $text = 'CAM';
            } elseif ($mov->resolution==4) {
                $text = 'Full HD';
            } elseif ($mov->resolution==5) {
                $text = 'Trailer';
            } 
            // $out_put.='
            // <div class="item post-37176">
            //     <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
            //         <div class="item-link">
            //             <img src="'.url('uploads/movie/'.$mov->image).'"
            //                 class="lazy post-thumb" alt="'.$mov->title.'"
            //                 title="'.$mov->title.'" />
            //             <span class="is_trailer">'.$text.'</span>
            //         </div>
            //         <p class="title">'.$mov->title.'</p>
            //     </a>
            //     <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            //     <div class="viewsCount" style="color: #9d9d9d;">Năm: '.$mov->year.'</div>
            //     <div style="float: left;">
            //         <ul class="list-inline rating"  title="Average Rating">
            //             <li title="star_rating" class="padding_none"
            //             style="cursor:pointer;color:#ffcc00;

            //             font-size:20px;">&#9733;</li>
            //             <li title="star_rating" class="padding_none"
            //             style="cursor:pointer;color:#ffcc00;

            //             font-size:20px;">&#9733;</li>
            //             <li title="star_rating" class="padding_none"
            //             style="cursor:pointer;color:#ffcc00;

            //             font-size:20px;">&#9733;</li>
            //             <li title="star_rating" class="padding_none"
            //             style="cursor:pointer;color:#ffcc00;

            //             font-size:20px;">&#9733;</li>
            //             <li title="star_rating" class="padding_none"
            //             style="cursor:pointer;color:#ffcc00;

            //             font-size:20px;">&#9733;</li>
            //         </ul>
            //     </div>
            // </div>
            // ';
            $out_put .= '
                <div class="item post-37176">
                    <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                        <div class="item-link">';

            $image_check = substr($mov->image, 0, 4);

            if ($image_check == 'http') {
                $out_put .= '
                            <img src="' . url($mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />';
            } else {
                $out_put .= '
                            <img src="' . url('uploads/movie/' . $mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />';
            }

            $out_put .= '
                            <span class="is_trailer">' . $text . '</span>
                        </div>
                        <p class="title">' . $mov->title . '</p>
                    </a>
                    <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                    <div style="float: left;">
                        <span class="user-rate-image post-large-rate stars-large-vang"
                            style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                        </span>
                    </div>
                </div>';
        }
        echo $out_put;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $list_genre = Genre::all();
        $country = Country::pluck('title','id');
        $movie_genre = '';
        // $list = Movie::with('category','genre','country')->orderBy('id','DESC')->get();
        // return view('admincp.movie.form',compact('category','genre','country','list_genre','movie_genre'));
        return view('admincp.movie.form', ['category' => $category, 'genre' => $genre, 'country' => $country, 'list_genre' => $list_genre, 'movie_genre' => $movie_genre]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $get_movie = Movie::where('title',$data['title'])->count();
        $movie = new Movie();
        if ($get_movie == 1) {
            toastr()->error('Phim đã tồn tại');
            return redirect()->back()->withInput();
        }
        $movie->title = $data['title'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->sub = $data['sub'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->trailer = $data['trailer'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->time = $data['time'];
        $movie->tags = $data['tags'];
        $movie->epis = $data['epis'];
        $movie->type = $data['type'];
        $movie->count_views = rand(100,999999);
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        // $movie->genre_id = $data['genre_id'];
        $movie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        // Thêm nhiều thể loại phim
        foreach ($data['genre'] as $gen) {
            $movie->genre_id = $gen[0];
        }
        

        $get_image = $request->file('image');
        // $path = 'public/uploads/movie';
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie',$new_image);
            $movie->image = $new_image;
        }

        $movie->save();
        // thêm nhiều thể loại cho phim
        $movie->movie_genre()->attach($data['genre']);

        return redirect()->route('movie.index');
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
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $list_genre = Genre::all();
        // $list = Movie::with('category','genre','country')->orderBy('id','DESC')->get();
        $movie = Movie::find($id);
        $list_movie_genre = MovieGenre::where('movie_id', $id)->get();
        foreach ($list_movie_genre as $item) {
            $movie_genre[] = $item->genre_id;
        }
        return view('admincp.movie.form', ['category' => $category, 'genre' => $genre, 'country' => $country, 'movie' => $movie, 'list_genre' => $list_genre, 'movie_genre' => isset($movie_genre) ? $movie_genre : null]);
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
        $data = $request->all();
        
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->resolution = $data['resolution'];
        $movie->sub = $data['sub'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->trailer = $data['trailer'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->time = $data['time'];
        $movie->tags = $data['tags'];
        $movie->epis = $data['epis'];
        $movie->type = $data['type'];
        $movie->count_views = rand(1000,99999);
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        // $movie->genre_id = $data['genre_id'];
        $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($data['genre'] as $gen) {
            $movie->genre_id = $gen[0];
        }
        

        $get_image = $request->file('image');
        $path = 'public/uploads/movie';
        if ($get_image) {
            if (file_exists('uploads/movie/'.$movie->image)) {
                unlink('uploads/movie/'.$movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
        }

        $movie->save();
        $movie->movie_genre()->sync($data['genre']);
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        // Xoá ảnh
        if (file_exists('uploads/movie/'.$movie->image)) {
            unlink('uploads/movie/'.$movie->image);
        }
        // Xoá thể loại
        $movie_genre = MovieGenre::whereIn('movie_id',[$movie->id]);
        $movie_genre->delete();
        $episode = Episode::whereIn('movie_id',[$movie->id]);
        $episode->delete();
        // Xoá phim
        $movie->delete();
        return redirect()->back();
    }


    public function category_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();
    }
    public function country_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();
    }
    public function status_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['status_id'];
        $movie->save();
    }
    public function type_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->type = $data['type_id'];
        $movie->save();
    }
    public function phim_hot_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phim_hot = $data['phim_hot_id'];
        $movie->save();
    }
    public function resolution_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->resolution = $data['resolution_id'];
        $movie->save();
    }
    public function sub_select(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->sub = $data['sub_id'];
        $movie->save();
    }

    public function update_image_movie_ajax(Request $request) {
        $get_image = $request->file('file');
        $movie_id = $request->movie_id;

        if ($get_image) {
            $movie = Movie::find($movie_id);
            unlink('uploads/movie/'.$movie->image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
            $movie->save();
        }
    }
    
}
