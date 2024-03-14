@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý thể loại</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($genre))
                    {!! Form::open(['method' => 'POST', 'route' => 'genre.store']) !!}
                    @else
                    {!! Form::open(['method' => 'PUT', 'route' => ['genre.update', $genre->id]]) !!}
                    @endif

                    {!! Form::open(['method' => 'POST', 'route' => 'genre.store']) !!}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Tiêu đề') !!}
                            {!! Form::text('title', isset($genre) ? $genre->title : '' , ['class' => 'form-control',
                            'required' => 'required','id' => 'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            {!! Form::label('slug', 'Slug') !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '' , ['class' => 'form-control',
                            'required' => 'required','id' => 'convert_slug']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Mô tả') !!}
                            {!! Form::textarea('description', isset($genre) ? $genre->description : '' , ['class' =>
                            'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            {!! Form::label('status', 'Trạng thái') !!}
                            {!! Form::select('status', ['1'=>'Hiển thị', '0'=>'Không hiển thị'], isset($genre) ?
                            $genre->status : '' , ['id' => 'status', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($genre) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection