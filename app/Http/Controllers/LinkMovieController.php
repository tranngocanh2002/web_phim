<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkMovie;
use App\Http\Requests\IndexRequest;

class LinkMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = LinkMovie::all();
        
        return view('admincp.linkmovie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admincp.linkmovie.form');
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
        $linkmovie = new LinkMovie();
        $linkmovie->title = $data['title'];
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];
        // $linkmovie->save();
        if($linkmovie->save()) {
            toastr()->success('Thêm link phim thành công');
        } else {
            toastr()->error('Thêm link phim không thành công');
        }
        return redirect()->route('linkmovie.index');
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
        $linkmovie = LinkMovie::find($id);
        $list = LinkMovie::all();
        return view('admincp.linkmovie.form', compact('list','linkmovie'));
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
        $linkmovie = LinkMovie::find($id);
        $linkmovie->title = $data['title'];
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];
        // $linkmovie->save();
        if($linkmovie->save()) {
            toastr()->success('Chỉnh sửa link phim thành công');
        } else {
            toastr()->error('Chỉnh sửa link phim không thành công');
        }
        return redirect()->route('linkmovie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // linkmovie::find($id)->delete();
        if(LinkMovie::find($id)->delete()) {
            toastr()->success('Xoá link phim thành công');
        } else {
            toastr()->error('Xoá link phim không thành công');
        }
        return redirect()->back();
    }
}
