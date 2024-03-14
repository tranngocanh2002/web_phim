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
                            {!! Form::label('movie', 'Phim') !!}
                            {!! Form::select('movie_id', ['0'=>'Chọn', ''=>$list_episode], isset($episode) ?
                            $episode->movie_id : '' , ['class' => 'form-control select-movie']) !!}
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

                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('episode') ? ' has-error' : '' }}">
                            {!! Form::label('episode', 'Tập phim') !!}
                            <select name="episode" id="show_movie" class="form-control"></select>
                        </div>
                    </div>
                    @endif
                    @if (isset($episode))
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('linkserver') ? ' has-error' : '' }}">
                            {!! Form::label('linkserver', 'Link server') !!}
                            {!! Form::select('linkserver', isset($linkmovie) ? $linkmovie: '', $episode->server , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('linkserver') ? ' has-error' : '' }}">
                            {!! Form::label('linkserver', 'Link server') !!}
                            {!! Form::select('linkserver', $linkmovie, isset($linkmovie) ? $linkmovie: '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @endif
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($episode) ? 'Chỉnh sửa' : 'Thêm tập' , ['class' => 'btn btn-success'])!!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}
@endsection