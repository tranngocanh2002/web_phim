@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table" id="tablePhim">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Trình duyệt</th>
                                <th scope="col">Loại trình duyệt</th>
                                <th scope="col">Loại thiết bị</th>
                                <th scope="col">Hệ điều hành/Version</th>
                                <th scope="col">IP addres</th>
                                <th scope="col">Bằng điện thoại</th>
                                <th scope="col">Preference</th>
                                <th scope="col">Log</th>
                                <th scope="col">Truy cập</th>
                                <th scope="col">Tổng truy cập trang</th>
                            </tr>
                        </thead>
                        <tbody class="order_position">
                            @foreach ($sessions as $key => $session)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$session->agent->browser}}</td>
                                <td>{{$session->agent->name}}</td>
                                <td>{{$session->device->kind}}</td>
                                <td>{{$session->device->platfrom}}/{{$session->device->platfrom_version}}</td>
                                <td>{{$session->client_ip}}</td>
                                <td>{{$session->device->is_mobile}}</td>
                                <td>{{$session->language->preference}}</td>
                                <td></td>
                                <td>{{$session->created_at->diffForHumans()}}</td>
                                <td>{{$session->pageViews}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection