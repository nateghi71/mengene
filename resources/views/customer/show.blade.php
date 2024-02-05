@extends('layouts.dashboard' , ['sectionName' => 'نمایش اطلاعات'])

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
                          <a href="{{route('customer.index')}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش متقاضیان</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-6 grid-margin mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">نمایش اطلاعات : {{ $customer->name }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody class="text-white">
                            <tr class="text-primary">
                                <td>ثبت کننده</td>
                                @if($customer->business_id !== null)
                                    <td>{{$customer->user->name}}</td>
                                @else
                                    <td>منگنه</td>
                                @endif
                            </tr>
                            @if($customer->type_file !== 'business')
                                <tr>
                                    <td>نوع فایل</td>
                                    <td>{{$customer->type_file}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>نوع</td>
                                <td>{{$customer->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>سطح دسترسی</td>
                                <td>{{$customer->access_level}}</td>
                            </tr>
                            <tr>
                                <td>وضعیت</td>
                                <td>{{$customer->status}}</td>
                            </tr>
                            <tr>
                                <td>نام و نام خانوادگی</td>
                                <td>{{$customer->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$customer->number}}</td>
                            </tr>
                            <tr>
                                <td>متراژ</td>
                                <td>{{$customer->scale}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$customer->city->name}}</td>
                            </tr>
                            <tr>
                                <td>منطقه شهرداری</td>
                                <td>{{$customer->area}}</td>
                            </tr>
                            <tr>
                                <td>زمان باقیمانده</td>
                                <td>{{$customer->daysLeft . ' روز' ?? 'منقضی'}}</td>
                            </tr>
                            @if($customer->getRawOriginal('type_sale') == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$customer->selling_price}}</td>
                                </tr>
                                <tr>
                                    <td>نوع سند</td>
                                    <td>{{$customer->document}}</td>
                                </tr>
                            @elseif($customer->getRawOriginal('type_sale') == 'rahn')
                                <tr>
                                    <td>رهن</td>
                                    <td>{{$customer->rahn_amount}}</td>
                                </tr>
                                <tr>
                                    <td>اجاره</td>
                                    <td>{{$customer->rent_amount}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>نوع کاربری</td>
                                <td>{{$customer->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع ملک</td>
                                <td>{{$customer->type_build}}</td>
                            </tr>
                            <tr>
                                <td>ادرس</td>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <td>تخلیه</td>
                                <td>{{$customer->discharge}}</td>
                            </tr>
                            <tr>
                                <td>حضور مالک</td>
                                <td>{{$customer->exist_owner}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$customer->elevator}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$customer->parking}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$customer->store}}</td>
                            </tr>
                            @if($customer->getRawOriginal('type_build') !== 'land')
                                <tr>
                                    <td>تعداد طبقات کل ساختمان</td>
                                    <td>{{$customer->floor_number}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('type_build') !== 'land' && $customer->getRawOriginal('type_build') !== 'house')
                                <tr>
                                    <td>شماره طبقه</td>
                                    <td>{{$customer->floor}}</td>
                                </tr>
                            @endif
                            @if($customer->year_of_construction !== null)
                                <tr>
                                    <td>سال ساخت</td>
                                    <td>{{$customer->year_of_construction}}</td>
                                </tr>
                            @endif
                            @if($customer->year_of_reconstruction !== null)
                                <tr>
                                    <td>سال بازسازی</td>
                                    <td>{{$customer->year_of_reconstruction}}</td>
                                </tr>
                            @endif
                            @if($customer->number_of_rooms !== null)
                                <tr>
                                    <td>تعداد اتاق</td>
                                    <td>{{$customer->number_of_rooms}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('floor_covering') !== 'null')
                                <tr>
                                    <td>پوشش کف</td>
                                    <td>{{$customer->floor_covering}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('cooling') !== 'null')
                                <tr>
                                    <td>سرمایش</td>
                                    <td>{{$customer->cooling}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('heating') !== 'null')
                                <tr>
                                    <td>گرمایش</td>
                                    <td>{{$customer->heating}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('cabinets') !== 'null')
                                <tr>
                                    <td>کابینت</td>
                                    <td>{{$customer->cabinets}}</td>
                                </tr>
                            @endif
                            @if($customer->getRawOriginal('view') !== 'null')
                                <tr>
                                    <td>نما</td>
                                    <td>{{$customer->view}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>ستاره</td>
                                <td>{{$customer->is_star}}</td>
                            </tr>
                            <tr>
                                <td>توضیحات</td>
                                <td>{{$customer->description ?? '-'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
