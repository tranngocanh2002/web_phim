@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <table class="table" id="tablePhim">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Tên chính thức</th>
                <th scope="col">Hình ảnh</th>
                {{-- <th scope="col">Poster</th> --}}
                <th scope="col">slug</th>
                <th scope="col">Year</th>
                {{-- <th scope="col">_ID</th> --}}
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resp['items'] as $key => $res)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$res['name']}}</td>
                <td>{{$res['origin_name']}}</td>
                <td><img style="width: 15%;" src="{{$resp['pathImage'].$res['thumb_url']}}" alt="{{$resp['pathImage'].$res['thumb_url']}}"></td>
                {{-- <td><img style="width: 40%;" src="{{$resp['pathImage'].$res['poster_url']}}" alt="{{$resp['pathImage'].$res['poster_url']}}"></td> --}}
                {{-- <td>{{$res['slug']}}</td> --}}

                <td>
                    {{-- @if (isset($res['slug']) && is_string($res['slug'])) --}}
                        <input type="text" value="{{ $res['slug'] }}" class="myInput">
                        <button onclick="myFunction(this)">Copy</button>
                    {{-- @endif --}}
                </td>
                <td>{{$res['year']}}</td>

                {{-- <td>{{$res['_id']}}</td> --}}
                <td>
                    <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary btn-sm">Chi tiết phim</a>
                    <a href="{{route('leech-episode',$res['slug'])}}" class="btn btn-danger btn-sm">Tập phim</a>
                    @php
                        $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                    @endphp
                    @if (!$movie)
                        <form action="{{route('leech-store',$res['slug'])}}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-success btn-sm" value="Thêm phim">
                        </form>
                    @else
                        @php
                            $ep = \App\Models\Episode::where('movie_id',$movie->id)->count();
                            $ep1 = Http::get("https://ophim1.com/phim/".$res['slug'])->json();
                            $ep2 = $ep1['movie']['episode_current'];
                            $ep3 = substr($ep2, 6);
                        @endphp
                        {{-- {{$ep;}}
                        {{$ep3;}} --}}
                        @if ($ep < (int)$ep3)
                            @php
                                $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                            @endphp
                            <form action="{{route('leech-episode-update',$res['slug'])}}" method="post">
                                @csrf
                                <input type="submit" value="Cập nhật tập phim" class="btn btn-success btn-sm">
                            </form>
                        @endif
                        <form action="{{route('movie.destroy',$movie->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger btn-sm" value="Xoá phim">
                        </form>
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection