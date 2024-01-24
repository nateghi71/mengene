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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $specialLandowner->name }}</h3></div>
                        <div><a href="{{route('admin.files.index')}}" class="btn btn-primary p-2">نمایش نقش ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>ثبت کننده</td>
                                <td>{{$specialLandowner->user->name}}</td>
                            </tr>

                            <tr>
                                <td>وضعیت</td>
                                <td>{{$specialLandowner->status}}</td>
                            </tr>
                            <tr>
                                <td>نوع</td>
                                <td>{{$specialLandowner->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>نام و نام خانوادگی</td>
                                <td>{{$specialLandowner->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$specialLandowner->number}}</td>
                            </tr>
                            <tr>
                                <td>منطقه شهرداری</td>
                                <td>{{$specialLandowner->area}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$specialLandowner->city->name}}</td>
                            </tr>
                            <tr>
                                <td>نوع فایل</td>
                                <td>{{$specialLandowner->type_file}}</td>
                            </tr>
                            <tr>
                                <td>نوع مسکن</td>
                                <td>{{$specialLandowner->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع خانه</td>
                                <td>{{$specialLandowner->type_build}}</td>
                            </tr>
                            @if($specialLandowner->getRawOriginal('type_sale') == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$specialLandowner->selling_price}}</td>
                                </tr>
                            @elseif($specialLandowner->getRawOriginal('type_sale') == 'rahn')
                                <tr>
                                    <td>رهن</td>
                                    <td>{{$specialLandowner->rahn_amount}}</td>
                                </tr>
                                <tr>
                                    <td>اجاره</td>
                                    <td>{{$specialLandowner->rent_amount}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>متراژ</td>
                                <td>{{$specialLandowner->scale}}</td>
                            </tr>
                            <tr>
                                <td>تعداد اتاق</td>
                                <td>{{$specialLandowner->number_of_rooms}}</td>
                            </tr>
                            <tr>
                                <td>تعداد طبقات کل ساختمان</td>
                                <td>{{$specialLandowner->floor_number}}</td>
                            </tr>
                            <tr>
                                <td>شماره طبقه</td>
                                <td>{{$specialLandowner->floor}}</td>
                            </tr>
                            <tr>
                                <td>زمان باقیمانده</td>
                                <td>{{$specialLandowner->expire_date}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$specialLandowner->elevator}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$specialLandowner->parking}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$specialLandowner->store}}</td>
                            </tr>
                            <tr>
                                <td>ستاره</td>
                                <td>{{$specialLandowner->is_star}}</td>
                            </tr>
                            <tr>
                                <td>توضیحات و آدرس</td>
                                <td>{{$specialLandowner->description}}</td>
                            </tr>                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
