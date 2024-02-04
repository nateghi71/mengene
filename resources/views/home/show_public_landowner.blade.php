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
                        @if($landowner->business_id !== null)
                            {{$landowner->business->name}}
                        @else
                            {{$landowner->name}}
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
                            <td>{{$landowner->status}}</td>
                        </tr>
                        <tr>
                            <td>نوع</td>
                            <td>{{$landowner->type_sale}}</td>
                        </tr>
                        <tr>
                            <td>نام</td>
                            <td>
                                @if($landowner->business_id !== null)
                                    {{$landowner->business->name}}
                                @else
                                    {{$landowner->name}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>شماره تلفن</td>
                            <td>
                                @if($landowner->business_id !== null)
                                    {{$landowner->business->owner->number}}
                                @else
                                    {{$landowner->number}}
                                @endif
                            </td>
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
                            <td>حضور کاربر</td>
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
                            <td>توضیحات</td>
                            <td>{{$landowner->description ?? '-'}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
