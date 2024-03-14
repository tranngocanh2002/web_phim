@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <a href="{{route('linkmovie.index')}}" class="btn btn-prrimary">Liệt kê danh mục</a> --}}
                <div class="card-header">Quản lý link phim</div>
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
                    @if (!isset($linkmovie))
                    {!! Form::open(['method' => 'POST', 'route' => 'linkmovie.store']) !!}
                    @else
                    {!! Form::open(['method' => 'PUT', 'route' => ['linkmovie.update', $linkmovie->id]]) !!}
                    @endif

                    {!! Form::open(['method' => 'POST', 'route' => 'linkmovie.store']) !!}
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Tiêu link') !!}
                            {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '' , ['class' =>
                            'form-control','id' => 'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Mô tả link') !!}
                            {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description : '' , ['class'
                            => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            {!! Form::label('status', 'Trạng thái') !!}
                            {!! Form::select('status', [ '1'=>'Hiển thị', '0'=>'Không hiển thị'], isset($linkmovie) ?
                            $linkmovie->status : '' , ['id' => 'status', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                        {!! Form::submit(isset($linkmovie) ? 'Chỉnh sửa' : 'Thêm mới' , ['class' => 'btn btn-success'])
                        !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}
@endsection