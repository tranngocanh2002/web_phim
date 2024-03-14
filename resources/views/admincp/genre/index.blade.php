@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <table class="table" id="tablePhim">
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
            @foreach ($list as $key => $genre)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$genre->title}}</td>
                <td>{{$genre->slug}}</td>
                <td>{{$genre->description}}</td>
                <td>
                    @if ($genre->status == 1)
                    Hiển thị
                    @else
                    Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['genre.destroy', $genre->id], 'onsubmit' =>
                    'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                    {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{route('genre.edit',$genre->id)}}" class="btn btn-warning">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection