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
            @foreach ($list as $key => $country)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$country->title}}</td>
                <td>{{$country->slug}}</td>
                <td>{{$country->description}}</td>
                <td>
                    @if ($country->status == 1)
                    Hiển thị
                    @else
                    Không hiển thị
                    @endif
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['country.destroy', $country->id], 'onsubmit' =>
                    'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                    {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{route('country.edit',$country->id)}}" class="btn btn-warning">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection