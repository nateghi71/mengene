@extends('layouts.admin' , ['sectionName' => 'ایجاد نقش'])

@section('title' , 'ایجاد نقش')

@section('head')
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="row ">
        <div class="col-md-6 grid-margin mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $user->name }}</h3></div>
                        <div><a href="{{route('admin.users.index')}}" class="btn btn-primary p-2">نمایش کاربران</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                            <tr class="text-white">
                                <td>نام</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شماره</td>
                                <td>{{$user->number}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>نقش</td>
                                <td>{{$user->role->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>ایمیل</td>
                                <td>{{$user->email ?? '-'}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شهر</td>
                                <td>{{$user->city->name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
