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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $role->name }}</h3></div>
                        <div><a href="{{route('admin.roles.index')}}" class="btn btn-primary p-2">نمایش نقش ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                            <tr class="text-white">
                                <td>نام</td>
                                <td>{{$role->name}}</td>
                            </tr>
                            @foreach($role->permissions->pluck('name') as $key => $permission)
                                <tr>
                                    <td>مجوز {{ $key + 1 }}</td>
                                    <td>{{$permission}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
