<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\LinkMovie;
use Illuminate\Support\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_episode = Episode::with('movie')->orderBy('movie_id','DESC')->get();
        return view('admincp.episode.index',compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_episode = Movie::orderBy('id','DESC')->pluck('title','id');
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $link_server = LinkMovie::orderBy('id','DESC')->get();
        // echo '<pre>';
        // print_r($list_episode);
        // echo '<pre>';
        // die();
        // $episode = Episode::find('movie_id',$list_episode->id)->get();
        return view('admincp.episode.form',compact('list_episode','linkmovie','link_server'));
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
        $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        if ($episode_check > 0) {
            return redirect()->back();
        } else {
            $episode = new Episode();
            $episode->movie_id = $data['movie_id'];
            $link = str_replace('/api/embed.html?link=', '', $data['link']);
            $episode->linkphim = $link;
            $episode->episode = $data['episode'];
            $episode->server = $data['linkserver'];
            $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            // $episode->save();
            if($episode->save()) {
                toastr()->success('Thêm mới tập phim thành công');
            } else {
                toastr()->error('Thêm mới tập phim không thành công');
            }
        }
        return redirect()->back();
    }
    public function add_episode($id) {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $link_server = LinkMovie::orderBy('id','DESC')->get();
        $movie = Movie::find($id);
        $list_episode = Episode::with('movie')->where('movie_id',$id)->orderBy('episode','DESC')->get();
        return view('admincp.episode.addEpisode',compact('list_episode','movie','linkmovie','link_server'));
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
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        // $link_server = LinkMovie::orderBy('id','DESC')->get();
        $list_episode = Movie::orderBy('id','DESC')->pluck('title','id');
        $episode = Episode::find($id);
        return view('admincp.episode.form',compact('episode','list_episode','linkmovie'));
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
        $episode = Episode::find($id);
        $episode->movie_id = $data['movie_id'];
        $link = str_replace('/api/embed.html?link=', '', $data['link']);
        $episode->linkphim = $link;
        $episode->episode = $data['episode'];
        $episode->server = $data['linkserver'];
        $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        // $episode->save();
        if($episode->save()) {
            toastr()->success('Chỉnh sửa tập phim thành công');
        } else {
            toastr()->error('Chỉnh sửa tập phim không thành công');
        }
        return redirect()->to('episode');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $episode = Episode::find($id)->delete();
        if(Episode::find($id)->delete()) {
            toastr()->success('Xoá tập phim thành công');
        } else {
            toastr()->error('Xoá tập phim không thành công');
        }
        return redirect()->to('episode');
    }

    public function select_movie() {
        // $id = $_GET['id'];
        // $movie = Movie::find($id);
        $movie_by_id = Movie::find($_GET['id']);
        $out_put ='<option value="">---Chọn tập phim---</option>';
        if ($movie_by_id->type == 'phimbo') {
            for ($i=1; $i <= $movie_by_id->epis; $i++) { 
                $out_put.= '<option value="'.$i.'">'.$i.'</option>';
            }
        } else {
            $out_put.= '
            <option value="hd">HD</option>
            <option value="sd">Full HD</option>
            <option value="cam">Cam</option>
            <option value="hdcam">HD Cam</option>
            <option value="fullhd">Full HD</option>
            ';
        }
        echo $out_put;
    }
}
