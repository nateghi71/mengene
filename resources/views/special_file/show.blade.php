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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $specialFile->name }}</h3></div>
                        <div><a href="{{route('special_files.subscription.index')}}" class="btn btn-primary p-2">نمایش فایل های ویژه</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>وضعیت</td>
                                <td>{{$specialFile->status}}</td>
                            </tr>
                            <tr>
                                <td>نوع</td>
                                <td>{{$specialFile->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>نام و نام خانوادگی</td>
                                <td>{{$specialFile->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$specialFile->number}}</td>
                            </tr>
                            <tr>
                                <td>منطقه شهرداری</td>
                                <td>{{$specialFile->area}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$specialFile->city->name}}</td>
                            </tr>
                            <tr>
                                <td>نوع فایل</td>
                                <td>{{$specialFile->type_file}}</td>
                            </tr>
                            <tr>
                                <td>نوع مسکن</td>
                                <td>{{$specialFile->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع خانه</td>
                                <td>{{$specialFile->type_build}}</td>
                            </tr>
                            @if($specialFile->getRawOriginal('type_sale') == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$specialFile->selling_price}}</td>
                                </tr>
                            @elseif($specialFile->getRawOriginal('type_sale') == 'rahn')
                                <tr>
                                    <td>رهن</td>
                                    <td>{{$specialFile->rahn_amount}}</td>
                                </tr>
                                <tr>
                                    <td>اجاره</td>
                                    <td>{{$specialFile->rent_amount}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>متراژ</td>
                                <td>{{$specialFile->scale}}</td>
                            </tr>
                            <tr>
                                <td>تعداد اتاق</td>
                                <td>{{$specialFile->number_of_rooms}}</td>
                            </tr>
                            <tr>
                                <td>تعداد طبقات کل ساختمان</td>
                                <td>{{$specialFile->floor_number}}</td>
                            </tr>
                            <tr>
                                <td>شماره طبقه</td>
                                <td>{{$specialFile->floor}}</td>
                            </tr>
                            <tr>
                                <td>زمان باقیمانده</td>
                                <td>{{$specialFile->expire_date}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$specialFile->elevator}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$specialFile->parking}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$specialFile->store}}</td>
                            </tr>
                            <tr>
                                <td>ستاره</td>
                                <td>{{$specialFile->is_star}}</td>
                            </tr>
                            <tr>
                                <td>توضیحات و آدرس</td>
                                <td>{{$specialFile->description}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
