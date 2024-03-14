@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <table class="table" id="tablePhim">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Slug phim</th>
                <th scope="col">Số tập</th>

                <th scope="col">Tập phim</th>
                <th scope="col">Server 1</th>
                <th scope="col">Server 2</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resp['episodes'] as $key => $res)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$resp['movie']['name']}}</td>
                <td>{{$resp['movie']['slug']}}</td>
                <td>{{$resp['movie']['episode_total']}}</td>

                <td>{{$res['server_name']}}</td>
                <td>
                    @foreach ($res['server_data'] as $server_1)
                        <ul>
                            <li>
                                Tập {{$server_1['name']}}
                                <input type="text" class="form-control" value="{{$server_1['link_embed']}}">
                            </li>
                        </ul>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['server_data'] as $server_1)
                        <ul>
                            <li>
                                Tập {{$server_1['name']}}
                                <input type="text" class="form-control" value="{{$server_1['link_m3u8']}}">
                            </li>
                        </ul>
                    @endforeach
                </td>
                <td>
                    @php
                        $movie = \App\Models\Movie::where('slug',$resp['movie']['slug'])->first();
                    @endphp
                    <form action="{{route('leech-episode-store',$resp['movie']['slug'])}}" method="post">
                        @csrf
                        <input type="submit" value="Thêm tập phim" class="btn btn-success btn-sm">
                    </form>
                    <form action="{{route('leech_movie.destroy',$movie->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Xoá tập phim" class="btn btn-danger btn-sm">
                    </form>
                </td>
                {{-- <td>
                    <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary">Chi tiết phim</a>
                    @php
                        $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                    @endphp
                    @if (!$movie)
                        <form action="{{route('leech-store',$res['slug'])}}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-success" value="Thêm phim">
                        </form>
                    @else
                        <form action="{{route('movie.destroy',$movie->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Xoá phim">
                        </form>
                    @endif

                </td> --}}
                {{-- <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['category.destroy', $category->id], 'onsubmit' =>
                    'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                    {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{route('category.edit',$category->id)}}" class="btn btn-warning">Sửa</a>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection