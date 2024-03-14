@extends('layouts.app')

@section('content')
<div class="container-fuild">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('movie.index')}}" class="btn btn-primary">Liệt kê phim</a>
                @if (!isset($movie))
                    <div class="card-header">Thêm phim theo Slug</div>
                    {!! Form::open(['method' => 'POST', 'route' => 'leech_add_movie']) !!}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('movie_slug') ? ' has-error' : '' }}">
                            {!! Form::label('movie_slug', 'Tên phim theo slug') !!}
                            {!! Form::text('movie_slug', isset($movie) ? $movie->movie_slug : '' , ['class' => 'form-control',
                            'required' => 'required']) !!}
                        </div>
                        <div class="btn-group pull-right">
                            {!! Form::submit(isset($movie) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <hr>
                    <hr>
                    <hr>
                @endif
                {{-- <div class="card-header">Thêm phim theo Slug</div>
                {!! Form::open(['method' => 'POST', 'route' => 'leech_add_movie']) !!}
                <div class="form-group">
                    <div class="form-group{{ $errors->has('movie_slug') ? ' has-error' : '' }}">
                        {!! Form::label('movie_slug', 'Tên phim theo slug') !!}
                        {!! Form::text('movie_slug', isset($movie) ? $movie->movie_slug : '' , ['class' => 'form-control',
                        'required' => 'required']) !!}
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::submit(isset($movie) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
                {!! Form::close() !!} --}}


                <div class="card-header">Thêm/Chỉnh sửa phim thủ công</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($movie))
                    {!! Form::open(['method' => 'POST', 'route' => 'movie.store','enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! Form::open(['method' => 'PUT', 'route' => ['movie.update',
                    $movie->id],'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {!! Form::open(['method' => 'POST', 'route' => 'movie.store']) !!}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Tên phim') !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '' , ['class' => 'form-control',
                            'required' => 'required','id' => 'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('name_eng') ? ' has-error' : '' }}">
                            {!! Form::label('name_eng', 'Tên tiếng anh') !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '' , ['class' =>
                            'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                            {!! Form::label('time', 'Thời gian') !!}
                            {!! Form::text('time', isset($movie) ? $movie->time : '' , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            {!! Form::label('slug', 'Slug') !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '' , ['class' => 'form-control',
                            'required' => 'required','id' => 'convert_slug']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                            {!! Form::label('tags', 'Từ khoá') !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags : '' , ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Mô tả') !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description : '' , ['class' =>
                            'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('trailer') ? ' has-error' : '' }}">
                            {!! Form::label('trailer', 'Trailer') !!}
                            {!! Form::text('trailer', isset($movie) ? $movie->trailer : '' , ['class' =>
                            'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            {!! Form::label('status', 'Trạng thái') !!}
                            {!! Form::select('status', ['1'=>'Hiển thị', '0'=>'Không hiển thị'], isset($movie) ?
                            $movie->status : '' , ['id' => 'status', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            {!! Form::label('category', 'Danh mục') !!}
                            {!! Form::select('category_id', $category, isset($movie) ? $movie->category : '' , ['id' =>
                            'category', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            {!! Form::label('type', 'Thuộc thể loại phim') !!}
                            {!! Form::select('type', ['phimle'=>'Phim lẻ', 'phimbo'=>'Phim bộ'], isset($movie) ?
                            $movie->type : '' , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            {!! Form::label('type', 'Thuộc thể loại phim') !!}
                            {!! Form::text('type', isset($movie) ? $movie->type : '' , ['class' => 'form-control']) !!}
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            {!! Form::label('country', 'Quốc gia') !!}
                            {!! Form::select('country_id', $country, isset($movie) ? $movie->country : '' , ['id' =>
                            'country', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
                            {!! Form::label('genre', 'Thể loại') !!}
                            @foreach ($list_genre as $key => $gen)
                            <div class="checkbox{{ $errors->has('checkbox_id') ? ' has-error' : '' }}">
                                @if (!empty($movie_genre))
                                {{-- {!! Form::checkbox('genre[]', $gen->id, $item->genre_id==$gen->id ? 'checked' : '')
                                !!} --}}
                                {!! Form::checkbox('genre[]', $gen->id, in_array($gen->id, $movie_genre) ? 'checked' :
                                '') !!}
                                @else
                                {!! Form::checkbox('genre[]', $gen->id,'') !!}
                                @endif
                                {!! Form::label('genre', $gen->title) !!}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('epis') ? ' has-error' : '' }}">
                            {!! Form::label('epis', 'Số tập') !!}
                            {!! Form::number('epis', isset($movie) ? $movie->epis : '' , ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('phim_hot') ? ' has-error' : '' }}">
                            {!! Form::label('phim_hot', 'Phim hot') !!}
                            {!! Form::select('phim_hot', ['1'=>'Có', '0'=>'Không'], isset($movie) ? $movie->phim_hot :
                            '' , ['id' => 'genre', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('resolution') ? ' has-error' : '' }}">
                            {!! Form::label('resolution', 'Định dạng') !!}
                            {!! Form::select('resolution', ['0'=>'HD', '1'=>'SD','2' =>'HD CAM','3'=>'CAM','4'=>'Full
                            HD','5'=>'Trailer'], isset($movie) ? $movie->resolution : '' , ['id' => 'resolution',
                            'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('sub') ? ' has-error' : '' }}">
                            {!! Form::label('sub', 'Phụ đề') !!}
                            {!! Form::select('sub', ['0'=>'Phụ đề', '1'=>'Thuyết minh'], isset($movie) ? $movie->sub :
                            '' , ['id' => 'sub', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            {!! Form::label('image', 'Hình ảnh') !!}
                            <br>
                            {!! Form::file('image') !!}
                            @if(isset($movie))
                            <img width="30%" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->image}}">
                            @endif
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($movie) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection