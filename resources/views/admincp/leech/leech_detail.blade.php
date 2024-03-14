@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="table-responsive">
    <table class="table" id="tablePhim">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">_id</th>
                <th scope="col">name</th>
                <th scope="col">slug</th>
                <th scope="col">origin_name</th>
                <th scope="col">content</th>
                <th scope="col">type</th>
                <th scope="col">status</th>
                <th scope="col">thumb_url</th>
                <th scope="col">poster_url</th>
                <th scope="col">is_copyright</th>
                <th scope="col">sub_docquyen</th>
                <th scope="col">chieurap</th>
                <th scope="col">trailer_url</th>
                <th scope="col">time</th>
                <th scope="col">episode_current</th>
                <th scope="col">episode_total</th>
                <th scope="col">quality</th>
                <th scope="col">lang</th>
                <th scope="col">notify</th>
                <th scope="col">showtimes</th>
                <th scope="col">year</th>
                <th scope="col">view</th>
                <th scope="col">actor</th>
                <th scope="col">director</th>
                <th scope="col">category</th>
                <th scope="col">country</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resp_movie as $key => $res)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$res['_id']}}</td>
                <td>{{$res['name']}}</td>
                <td>{{$res['slug']}}</td>
                <td>{{$res['origin_name']}}</td>
                <td>{{substr($res['content'],0,70).' ...'}}</td>
                <td>{{$res['type']}}</td>
                <td>{{$res['status']}}</td>
                <td><img style="width: 40%;" src="{{$res['thumb_url']}}" alt=""></td>
                <td><img style="width: 40%;" src="{{$res['poster_url']}}" alt=""></td>
                <td>
                    @if ($res['is_copyright']==true)
                        <span class="text text-success">Có</span>
                    @else 
                        <span class="text text-danger">Không</span>
                    @endif
                </td>
                <td>
                    @if ($res['sub_docquyen']==true)
                        <span class="text text-success">Có</span>
                    @else 
                        <span class="text text-danger">Không</span>
                    @endif
                </td>
                <td>
                    @if ($res['chieurap']==true)
                        <span class="text text-success">Có</span>
                    @else 
                        <span class="text text-danger">Không</span>
                    @endif
                </td>
                <td>{{$res['trailer_url']}}</td>
                <td>{{$res['time']}}</td>
                <td>{{$res['episode_current']}}</td>
                <td>{{$res['episode_total']}}</td>
                <td>{{$res['quality']}}</td>
                <td>{{$res['lang']}}</td>
                <td>{{$res['notify']}}</td>
                <td>{{$res['showtimes']}}</td>
                <td>{{$res['year']}}</td>
                <td>{{$res['view']}}</td>
                <td>
                    @foreach ($res['actor'] as $actor)
                        <span class="badge badge-info">{{$actor}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['director'] as $director)
                        <span class="badge badge-info">{{$director}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['category'] as $category)
                        <span class="badge badge-info">{{$category['name']}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['country'] as $country)
                        <span class="badge badge-info">{{$country['name']}}</span>
                    @endforeach
                </td>
                {{-- <td>{{$res['origin_name']}}</td>
                <td><img style="width: 40%;" src="{{$resp['pathImage'].$res['thumb_url']}}" alt="{{$resp['pathImage'].$res['thumb_url']}}"></td>
                <td><img style="width: 40%;" src="{{$resp['pathImage'].$res['poster_url']}}" alt="{{$resp['pathImage'].$res['poster_url']}}"></td>
                <td>{{$res['slug']}}</td>
                <td>{{$res['year']}}</td>
                <td>{{$res['_id']}}</td>
                <td><a href="{{route('leech-detail')}}" class="btn btn-primary">Chi tiết phím</a></td> --}}
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
</div>
@endsection