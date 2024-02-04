@extends('layouts.admin' , ['sectionName' => 'ایجاد نقش'])

@section('title' , 'ایجاد نقش')

@section('head')
@endsection

@section('scripts')

@endsection

@section('content')
    @if(count($landowner->images) > 0)
        <div class="row">
            <div class="col-12 grid-margin mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">عکس ها</h4>
                        <div class="row mx-5 mt-4">
                            @foreach ($landowner->images as $image)
                                <div class="col-md-3 mx-auto">
                                    <div class="card mb-3">
                                        <img width="100" height="170" class="card-img-top" src="{{ url(env('LANDOWNER_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                             alt="{{ $landowner->name }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row ">
        <div class="col-md-6 grid-margin mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div><h3 class="card-title mb-3">نمایش اطلاعات : {{ $landowner->name }}</h3></div>
                        <div><a href="{{route('admin.landowners.index')}}" class="btn btn-primary p-2">نمایش فایل ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>ثبت کننده</td>
                                <td>{{$landowner->user->name}}</td>
                            </tr>
                            <tr>
                                <td>نوع فایل</td>
                                @if($landowner->access_level !== 'public')
                                <td>{{$landowner->type_file}}</td>
                                @else
                                    <td>نمایش عمومی</td>
                                @endif
                            </tr>
                            <tr>
                                <td>نوع</td>
                                <td>{{$landowner->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>وضعیت</td>
                                <td>{{$landowner->status}}</td>
                            </tr>
                            <tr>
                                <td>نام و نام خانوادگی</td>
                                <td>{{$landowner->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$landowner->number}}</td>
                            </tr>
                            <tr>
                                <td>متراژ</td>
                                <td>{{$landowner->scale}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$landowner->city->name}}</td>
                            </tr>
                            <tr>
                                <td>منطقه شهرداری</td>
                                <td>{{$landowner->area}}</td>
                            </tr>
                            <tr>
                                <td>زمان باقیمانده</td>
                                <td>{{$landowner->daysLeft . ' روز' ?? 'منقضی'}}</td>
                            </tr>
                            @if($landowner->getRawOriginal('type_sale') == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$landowner->selling_price}}</td>
                                </tr>
                                <tr>
                                    <td>نوع سند</td>
                                    <td>{{$landowner->document}}</td>
                                </tr>
                            @elseif($landowner->getRawOriginal('type_sale') == 'rahn')
                                <tr>
                                    <td>رهن</td>
                                    <td>{{$landowner->rahn_amount}}</td>
                                </tr>
                                <tr>
                                    <td>اجاره</td>
                                    <td>{{$landowner->rent_amount}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>نوع کاربری</td>
                                <td>{{$landowner->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع ملک</td>
                                <td>{{$landowner->type_build}}</td>
                            </tr>
                            <tr>
                                <td>ادرس</td>
                                <td>{{$landowner->address}}</td>
                            </tr>
                            <tr>
                                <td>تخلیه</td>
                                <td>{{$landowner->discharge}}</td>
                            </tr>
                            <tr>
                                <td>حضور مالک</td>
                                <td>{{$landowner->exist_owner}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$landowner->elevator}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$landowner->parking}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$landowner->store}}</td>
                            </tr>
                            @if($landowner->getRawOriginal('type_work') !== 'home' && $landowner->getRawOriginal('type_work') !== 'land')
                                <tr>
                                    <td>تعداد طبقات کل ساختمان</td>
                                    <td>{{$landowner->floor_number}}</td>
                                </tr>
                                <tr>
                                    <td>شماره طبقه</td>
                                    <td>{{$landowner->floor}}</td>
                                </tr>
                            @endif
                            @if($landowner->year_of_construction !== null)
                                <tr>
                                    <td>سال ساخت</td>
                                    <td>{{$landowner->year_of_construction}}</td>
                                </tr>
                            @endif
                            @if($landowner->year_of_reconstruction !== null)
                                <tr>
                                    <td>سال بازسازی</td>
                                    <td>{{$landowner->year_of_reconstruction}}</td>
                                </tr>
                            @endif
                            @if($landowner->number_of_rooms !== null)
                                <tr>
                                    <td>تعداد اتاق</td>
                                    <td>{{$landowner->number_of_rooms}}</td>
                                </tr>
                            @endif
                            @if($landowner->getRawOriginal('floor_covering') !== 'null')
                                <tr>
                                    <td>پوشش کف</td>
                                    <td>{{$landowner->floor_covering}}</td>
                                </tr>
                            @endif
                            @if($landowner->getRawOriginal('cooling') !== 'null')
                                <tr>
                                    <td>سرمایش</td>
                                    <td>{{$landowner->cooling}}</td>
                                </tr>
                            @endif
                            @if($landowner->getRawOriginal('heating') !== 'null')
                                <tr>
                                    <td>گرمایش</td>
                                    <td>{{$landowner->heating}}</td>
                                </tr>
                            @endif
                            @if($landowner->getRawOriginal('cabinets') !== 'null')
                                <tr>
                                    <td>کابینت</td>
                                    <td>{{$landowner->cabinets}}</td>
                                </tr>
                            @endif
                            @if($landowner->getRawOriginal('view') !== 'null')
                                <tr>
                                    <td>نما</td>
                                    <td>{{$landowner->view}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>ستاره</td>
                                <td>{{$landowner->is_star}}</td>
                            </tr>
                            <tr>
                                <td>توضیحات</td>
                                <td>{{$landowner->description ?? '-'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
