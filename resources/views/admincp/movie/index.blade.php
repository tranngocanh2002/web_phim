@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="table-responsive">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('movie.create')}}" class="btn btn-primary">Thêm phim</a>
            <table class="table" id="tablePhim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Số tập</th>
                        {{-- <th scope="col">Tên tiếng anh</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Slug</th> --}}
                        {{-- <th scope="col">Trailer</th> --}}
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Phim hot</th>
                        <th scope="col">Định dạng</th>
                        <th scope="col">Phụ đề</th>
                        {{-- <th scope="col">Mô tả</th> --}}
                        <th scope="col">Từ khoá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Quốc gia</th>
                        <th scope="col">Thuộc phim</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Năm phim</th>
                        <th scope="col">Season</th>
                        <th scope="col">Top views</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày chỉnh sửa</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $movie)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$movie->title}}</td>
                        <td><a href="{{route('add-episode',[$movie->id])}}" class="btn btn-primary btn-sm">Thêm tập</a>
                        </td>
                        <td>{{$movie->episode_count}}/{{$movie->epis}} tập</td>
                        {{-- <td>{{$movie->name_eng}}</td>
                        <td>{{$movie->time}}</td>
                        <td>{{$movie->slug}}</td> --}}
                        {{-- <td>{{$movie->trailer}}</td> --}}
                        <td>
                            @php
                                $image_check = substr($movie->image,0,4);
                            @endphp
                            @if ($image_check == 'http')
                                <img width="40%" src="{{$movie->image}}" alt="{{$movie->image}}">
                            @else
                                <img width="40%" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->image}}">
                            @endif
                            <input type="file" name="image_select" data-movie_id="{{$movie->id}}"
                                id="file-{{$movie->id}}" class="form-control-file file_image">
                            <span id="error_image"></span>
                        </td>
                        <td>
                            {{-- @if ($movie->phim_hot == 1)
                            Có
                            @else
                            Không
                            @endif --}}
                            <select name="" id="{{$movie->id}}" class="phim_hot_select">
                                @if ($movie->phim_hot == 1)
                                <option value="0">Không</option>
                                <option value="1" selected>Có</option>
                                @elseif ($movie->phim_hot == 0)
                                <option value="0" selected>Không</option>
                                <option value="1">Có</option>
                                @endif
                            </select>
                        </td>
                        <td>
                            {{-- @if ($movie->resolution == 1)
                            SD
                            @elseif ($movie->resolution == 0)
                            HD
                            @elseif ($movie->resolution == 2)
                            HD CAM
                            @elseif ($movie->resolution == 3)
                            CAM
                            @elseif ($movie->resolution == 4)
                            Full HD
                            @elseif ($movie->resolution == 5)
                            Trailer
                            @endif --}}
                            @php
                            $options = array('0'=>'HD','1'=>'SD','2'=>'HD CAM','3'=>'CAM','4'=>'Full
                            HD','5'=>'Trailer');
                            @endphp
                            <select name="" id="{{$movie->id}}" class="resolution_select">
                                @foreach ($options as $key => $option)
                                <option {{$movie->resolution==$key ? 'selected' : ''}} value="{{$key}}">{{$option}}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {{-- @if ($movie->sub == 0)
                            Phụ đề
                            @else
                            Thuyết minh
                            @endif --}}
                            <select name="" id="{{$movie->id}}" class="sub_select">
                                @if ($movie->sub == 1)
                                <option value="0">Phụ đề</option>
                                <option value="1" selected>Thuyết minh</option>
                                @elseif ($movie->sub == 0)
                                <option value="0" selected>Phụ đề</option>
                                <option value="1">Thuyết minh</option>
                                @endif
                            </select>
                        </td>
                        {{-- <td>{{$movie->description}}</td> --}}
                        <td>
                            @if (strlen($movie->tags)>70)
                            {{ substr($movie->tags,0,70)}} [...]
                            @else
                            {{$movie->tags}}
                            @endif
                        </td>
                        <td>
                            {{-- {{$movie->category->title}} --}}

                            {!! Form::select('category_id', $category, isset($movie) ? $movie->category_id : '' , ['id'
                            => $movie->id, 'class' => 'form-control category_select']) !!}

                        </td>
                        <td>
                            @foreach ($movie->movie_genre as $gen)
                            <span class="badge badge-dark">{{$gen->title}}</span>
                            @endforeach
                        </td>
                        <td>
                            {{-- {{$movie->country->title}} --}}
                            {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : '' , ['id' =>
                            $movie->id, 'class' => 'form-control country_select']) !!}
                        </td>
                        <td>
                            {{-- @if ($movie->type == 'phimle')
                            Phim lẻ
                            @elseif ($movie->type == 'phimbo')
                            Phim bộ
                            @endif --}}
                            <select name="" id="{{$movie->id}}" class="type_select">
                                @if ($movie->type == 'phimle')
                                <option value="phimbo">Phim bộ</option>
                                <option value="phimle" selected>Phim lẻ</option>
                                @elseif ($movie->type == 'phimbo')
                                <option value="phimbo" selected>Phim bộ</option>
                                <option value="phimle">Phim lẻ</option>
                                @endif
                            </select>
                        </td>
                        <td>
                            {{-- @if ($movie->status == 1)
                            Hiển thị
                            @else
                            Không hiển thị
                            @endif --}}
                            <select name="" id="{{$movie->id}}" class="status_select">
                                @if ($movie->status == 1)
                                <option value="0">Không hiển thị</option>
                                <option value="1" selected>Hiển thị</option>
                                @elseif ($movie->status == 0)
                                <option value="0" selected>Không hiển thị</option>
                                <option value="1">Hiển thị</option>
                                @endif
                            </select>
                        </td>
                        <td>
                            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                {!! Form::selectYear('year', 2020, 2025, isset($movie->year) ? $movie->year : "",
                                ['class' => 'select-year', 'id'=>$movie->id, 'required' =>
                                'required','placeholder'=>'Trống']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group{{ $errors->has('season') ? ' has-error' : '' }}">
                                {!! Form::selectRange('season', 0, 20, isset($movie->season) ? $movie->season : "",
                                ['class' => 'select-season', 'id'=>$movie->id, 'required' =>
                                'required','placeholder'=>'Trống']) !!}
                            </div>
                        </td>
                        <td>
                            {!! Form::select('topview', [''=>'Trống', '0'=>'Ngày', '1'=>'Tuần', '2'=>'Tháng'],
                            isset($movie) ? $movie->topview : '' , ['id' => $movie->id, 'class' => 'select-topview'])
                            !!}
                        </td>
                        <td>{{$movie->created_at}}</td>
                        <td>{{$movie->updated_at}}</td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['movie.destroy', $movie->id], 'onsubmit'
                            => 'return confirm("Bạn có chắc chắn muốn xoá")', 'class' => 'form-horizontal']) !!}
                            {!! Form::submit('Xoá', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('movie.edit',$movie->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection