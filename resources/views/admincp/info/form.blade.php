@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <a href="{{route('category.index')}}" class="btn btn-prrimary">Liệt kê danh mục</a> --}}
                <div class="card-header">Quản lý Thông tin web</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{-- @if (!isset($info)) --}}
                    {!! Form::open(['method' => 'PUT', 'enctype'=>'multipart/form-data', 'route' => ['info.update',
                    $info->id]]) !!}
                    {{-- @else --}}
                    {{-- {!! Form::open(['method' => 'PUT', 'route' => ['info.update', $info->id]]) !!} --}}
                    {{-- @endif --}}

                    {{-- {!! Form::open(['method' => 'POST', 'route' => 'info.store']) !!} --}}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Tiêu đề web') !!}
                            {!! Form::text('title', isset($info) ? $info->title : '' , ['class' => 'form-control',]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Mô tả web') !!}
                            {!! Form::textarea('description', isset($info) ? $info->description : '' , ['class' =>
                            'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            {!! Form::label('image', 'Hình ảnh logo') !!}
                            <br>
                            {!! Form::file('image') !!}
                            @if(isset($info))
                            <img width="30%" src="{{asset('uploads/logo/'.$info->logo)}}" alt="{{$info->logo}}">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('copy_right') ? ' has-error' : '' }}">
                            {!! Form::label('copy_right', 'Copy right') !!}
                            {!! Form::text('copy_right', isset($info) ? $info->copy_right : '' , ['class' =>
                            'form-control',]) !!}
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($info) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            {{-- <table class="table" id="tablePhim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $info)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$info->title}}</td>
                        <td>{{$info->slug}}</td>
                        <td>{{$info->description}}</td>
                        <td>
                            @if ($info->status == 1)
                            Hiển thị
                            @else
                            Không hiển thị
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['info.destroy', $info->id], 'onsubmit' =>
                            'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                            {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('info.edit',$info->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>
    {{--
</div> --}}
@endsection