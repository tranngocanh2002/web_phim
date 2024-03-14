@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('episode.create')}}" class="btn btn-primary">Thêm tập phim</a>
            <table class="table" id="tablePhim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Hình ảnh phim</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Đường dẫn phim</th>
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
                                {{$episode->linkphim}}
                            </div>
                        </td>
                        {{-- <td>
                            @if ($category->status == 1)
                            Hiển thị
                            @else
                            Không hiển thị
                            @endif
                        </td> --}}
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