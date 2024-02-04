@extends('layouts.dashboard' , ['showBanner' => true , 'sectionName' => 'نمایش اطلاعات'])

@section('title' , 'نمایش اطلاعات')

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش نمایش اطلاعات هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('landowner.index')}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش مالکان</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <h4 class="card-title">نمایش اطلاعات : {{ $landowner->name }}</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>ثبت کننده</td>
                                @if($landowner->business_id !== null)
                                <td>{{$landowner->user->name}}</td>
                                @else
                                    <td>منگنه</td>
                                @endif
                            </tr>
                            @if($landowner->type_file !== 'business')
                                <tr>
                                    <td>نوع فایل</td>
                                    <td>{{$landowner->type_file}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>نوع</td>
                                <td>{{$landowner->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>سطح دسترسی</td>
                                <td>{{$landowner->access_level}}</td>
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
