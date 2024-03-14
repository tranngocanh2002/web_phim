<form action="{{route('filter')}}" method="get">
    <style type="text/css">
        select#exampleFormControlSelect1 {
            background: black;
            color: #d0d0d0;
        }

        input.btn-sm.btn-default {
            background: black;
            color: #d0d0d0;
            padding-bottom: 10px;
        }
    </style>
    <div class="col-md-2">
        <div class="form-group">
            {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
            <select class="form-control style_filter" name="order" id="exampleFormControlSelect1">
                <option value="">-Sắp xếp-</option>
                <option value="date">Ngày đăng</option>
                <option value="year">Năm sản xuất</option>
                <option value="name">Tên phim</option>
                <option value="view">Lượt xem</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
            <select class="form-control" name="genre" id="exampleFormControlSelect1">
                <option value="">-Thể loại-</option>
                @foreach ($genre as $key => $gen)
                <option {{ (isset($_GET['genre'])) && $_GET['genre']==$gen->id ? 'selected' : '' }}
                    value="{{$gen->id}}">{{$gen->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
            <select class="form-control" name="country" id="exampleFormControlSelect1">
                <option value="">-Quốc gia-</option>
                @foreach ($country as $key => $count)
                <option {{ (isset($_GET['country'])) && $_GET['country']==$count->id ? 'selected' : '' }}
                    value="{{$count->id}}">{{$count->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
            <select class="form-control" name="year" id="exampleFormControlSelect1">
                <option value="">-Năm-</option>
                @for ($year=2020;$year<=2025;$year++) {{-- <li><a title="{{$year}}"
                        href="{{ url('nam/'.$year) }}">{{$year}}</a></li> --}}
                    <option {{ (isset($_GET['year'])) && $_GET['year']==$year ? 'selected' : '' }}>{{$year}}</option>
                    @endfor
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <input type="submit" class="btn-sm btn-default" value="Lọc phim">
    </div>
</form>