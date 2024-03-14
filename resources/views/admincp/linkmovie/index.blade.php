@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <table class="table" id="tablePhim">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tiêu link</th>
                <th scope="col">Mô tả link</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $linkmovie)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$linkmovie->title}}</td>
                <td>{{$linkmovie->description}}</td>
                <td>
                    @if ($linkmovie->status == 1)
                    Hiển thị
                    @else
                    Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['linkmovie.destroy', $linkmovie->id], 'onsubmit' =>
                    'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                    {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{route('linkmovie.edit',$linkmovie->id)}}" class="btn btn-warning">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection