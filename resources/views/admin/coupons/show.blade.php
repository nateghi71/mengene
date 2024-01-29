@extends('layouts.admin' , ['sectionName' => 'نمایش کوپن'])

@section('title' , 'نمایش کوپن')

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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $coupon->name }}</h3></div>
                        <div><a href="{{route('admin.coupons.index')}}" class="btn btn-primary p-2">نمایش کوپن ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                            <tr class="text-white">
                                <td>نام</td>
                                <td>{{$coupon->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>کد</td>
                                <td>{{$coupon->code}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>درصد</td>
                                <td>{{$coupon->percentage}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>تاریخ انقضا</td>
                                <td>{{$coupon->expire_date}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>توضیحات</td>
                                <td>{{$coupon->description}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>زمان ایجاد</td>
                                <td>{{verta($coupon->created_at)->format('Y-m-d')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
