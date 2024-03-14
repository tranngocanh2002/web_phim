@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('episode.index')}}" class="btn btn-primary">Liệt kê tập phim</a>
                <div class="card-header">Quản lý tập phim</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($episode))
                    {!! Form::open(['method' => 'POST', 'route' => 'episode.store','enctype'=>'multipart/form-data'])
                    !!}
                    @else
                    {!! Form::open(['method' => 'PUT', 'route' => ['episode.update',
                    $episode->id],'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {!! Form::open(['method' => 'POST', 'route' => 'episode.store']) !!}

                    <div class="form-group">
                        <div class="form-group{{ $errors->has('movie') ? ' has-error' : '' }}">
                            {!! Form::label('movie_title', 'Phim') !!}
                            {!! Form::text('movie_title', isset($movie) ? $movie->title : '' , ['class' => 'form-control
                            select-movie','readonly']) !!}
                            {!! Form::hidden('movie_id', isset($movie) ? $movie->id : '') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                            {!! Form::label('link', 'Link phim') !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '' , ['class' =>
                            'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>
                    @if (isset($episode))
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('episode') ? ' has-error' : '' }}">
                            {!! Form::label('episode', 'Tập phim') !!}
                            {!! Form::text('episode', isset($episode) ? $episode->episode : '' , ['class' =>
                            'form-control', isset($episode) ? 'readonly' : '']) !!}
                            {{-- {!! Form::selectRange('episode',1,$movie->epis,$movie->epis, ['class' =>
                            'form-control']) !!} --}}
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('episode') ? ' has-error' : '' }}">
                            {!! Form::label('episode', 'Tập phim') !!}
                            {{-- <select name="episode" id="show_movie" class="form-control"></select> --}}
                            {!! Form::selectRange('episode',1,$movie->epis,$movie->epis, ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('linkserver') ? ' has-error' : '' }}">
                            {!! Form::label('linkserver', 'Link server') !!}
                            {!! Form::select('linkserver',  isset($linkmovie) ? $linkmovie: '','' , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    {{-- {{$movie->epis}} --}}
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($episode) ? 'Chỉnh sửa' : 'Thêm tập' , ['class' => 'btn btn-success'])
                        !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {{-- Liệt kê phim --}}


        <div class="col-md-12">
            {{-- <a href="{{route('episode.create')}}" class="btn btn-primary">Thêm tập phim</a> --}}
            <table class="table" id="tablePhim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Hình ảnh phim</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Đường dẫn phim</th>
                        <th scope="col">Link server</th>
                        {{-- <th scope="col">Trạng thái</th> --}}
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody class="order_position">
                    @foreach ($list_episode as $key => $episode)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$episode->movie->title}}</td>
                        <td><img width="50%" src="{{asset('uploads/movie/'.$episode->movie->image)}}"
                                alt="{{$episode->movie->image}}"></td>
                        <td>{{$episode->episode}}</td>
                        <td>
                            <style type="text/css">
                                .set_iframe iframe {
                                    width: 450px;
                                    height: 200px;
                                }
                            </style>
                            <div class="set_iframe">
                                {{-- {!!$episode->linkphim!!} --}}
                                {{$episode->linkphim}}
                            </div>
                        </td>
                        <td>
                            @foreach ($link_server as $server_link)
                                @if ($episode->server == $server_link->id)
                                    {{$server_link->title}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['episode.destroy', $episode->id],
                            'onsubmit' => 'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal'])
                            !!}
                            {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('episode.edit',$episode->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{--
</div> --}}
@endsection