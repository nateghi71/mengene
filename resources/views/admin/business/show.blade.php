@extends('layouts.admin' , ['sectionName' => 'نمایش اطلاعات'])

@section('title' , 'نمایش اطلاعات')

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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $business->name }}</h3></div>
                        <div><a href="{{route('admin.business.index')}}" class="btn btn-primary p-2">نمایش املاکی ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                            <tr class="text-white">
                                <td>وضعیت</td>
                                <td>{{$business->status}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>نام</td>
                                <td>{{$business->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>نام انگلیسی</td>
                                <td>{{$business->en_name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شهر</td>
                                <td>{{$business->city->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>مالک</td>
                                <td>{{$business->owner->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شماره تلفن</td>
                                <td>{{$business->owner->number}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>مناطق شهرداری</td>
                                <td>{{$business->area}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>ادرس</td>
                                <td>{{$business->address}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
