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
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $file->name }}</h3></div>
                        <div><a href="{{route('admin.files.index')}}" class="btn btn-primary p-2">نمایش نقش ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>ثبت کننده</td>
                                <td>{{$file->user->name}}</td>
                            </tr>

                            <tr>
                                <td>وضعیت</td>
                                <td>{{$file->status}}</td>
                            </tr>
                            <tr>
                                <td>نوع</td>
                                <td>{{$file->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>نام و نام خانوادگی</td>
                                <td>{{$file->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$file->number}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$file->city->name}}</td>
                            </tr>
                            <tr>
                                <td>نوع فایل</td>
                                <td>{{$file->type_file}}</td>
                            </tr>
                            <tr>
                                <td>نوع مسکن</td>
                                <td>{{$file->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع خانه</td>
                                <td>{{$file->type_build}}</td>
                            </tr>
                            @if($file->getRawOriginal('type_sale') == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$file->selling_price}}</td>
                                </tr>
                            @elseif($file->getRawOriginal('type_sale') == 'rahn')
                                <tr>
                                    <td>رهن</td>
                                    <td>{{$file->rahn_amount}}</td>
                                </tr>
                                <tr>
                                    <td>اجاره</td>
                                    <td>{{$file->rent_amount}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>متراژ</td>
                                <td>{{$file->scale}}</td>
                            </tr>
                            <tr>
                                <td>تعداد اتاق</td>
                                <td>{{$file->number_of_rooms}}</td>
                            </tr>
                            <tr>
                                <td>تعداد طبقات کل ساختمان</td>
                                <td>{{$file->floor_number}}</td>
                            </tr>
                            <tr>
                                <td>شماره طبقه</td>
                                <td>{{$file->floor}}</td>
                            </tr>
                            <tr>
                                <td>زمان باقیمانده</td>
                                <td>{{$file->expire_date}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$file->elevator}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$file->parking}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$file->store}}</td>
                            </tr>
                            <tr>
                                <td>ستاره</td>
                                <td>{{$file->is_star}}</td>
                            </tr>
                            <tr>
                                <td>توضیحات و آدرس</td>
                                <td>{{$file->description}}</td>
                            </tr>                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
