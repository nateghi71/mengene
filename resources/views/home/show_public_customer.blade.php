@extends('layouts.home')

@section('title' , 'نمایش اطلاعات')

@section('head')
@endsection

@section('scripts')
@endsection

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div
                    class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <h1>نمایش اطلاعات :
                        @if($customer->business_id !== null)
                            {{$customer->business->name}}
                        @else
                            {{$customer->name}}
                        @endif
                    </h1>
                </div>
                <div
                    class="col-lg-6 order-1 order-lg-2 hero-img"
                    data-aos="zoom-in"
                    data-aos-delay="100"
                >
                    <img
                        src="{{asset('Home/assets/img/4310987.png')}}"
                        class="img-fluid animated"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <div class="w-100 row border-bottom">
        <div class="col-md-6 mx-auto">
            <div class="px-5 py-5">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <tbody>
                        <tr>
                            <td>وضعیت</td>
                            <td>{{$customer->status}}</td>
                        </tr>
                        <tr>
                            <td>نوع</td>
                            <td>{{$customer->type_sale}}</td>
                        </tr>
                        <tr>
                            <td>نام املاکی</td>
                            <td>
                                @if($customer->business_id !== null)
                                    {{$customer->business->name}}
                                @else
                                    {{$customer->name}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>شماره املاکی</td>
                            <td>
                                @if($customer->business_id !== null)
                                    {{$customer->business->owner->number}}
                                @else
                                    {{$customer->number}}
                                @endif
                            </td>
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
                            <td>حضور کاربر</td>
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
                        @if($customer->getRawOriginal('type_work') !== 'home' && $customer->getRawOriginal('type_work') !== 'land')
                            <tr>
                                <td>تعداد طبقات کل ساختمان</td>
                                <td>{{$customer->floor_number}}</td>
                            </tr>
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
                            <td>توضیحات</td>
                            <td>{{$customer->description ?? '-'}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
