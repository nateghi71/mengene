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
                    <h1>نمایش اطلاعات : {{ $customer->name }}</h1>
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
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>#</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
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
                                    منگنه
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>شهر</td>
                            <td>{{$customer->city->name}}</td>
                        </tr>
                        <tr>
                            <td>نوع مسکن</td>
                            <td>{{$customer->type_work}}</td>
                        </tr>
                        <tr>
                            <td>نوع خانه</td>
                            <td>{{$customer->type_build}}</td>
                        </tr>
                        @if($customer->getRawOriginal('type_sale') == 'buy')
                            <tr>
                                <td>قیمت</td>
                                <td>{{$customer->selling_price}}</td>
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
                            <td>متراژ</td>
                            <td>{{$customer->scale}}</td>
                        </tr>
                        <tr>
                            <td>تعداد اتاق</td>
                            <td>{{$customer->number_of_rooms}}</td>
                        </tr>
                        <tr>
                            <td>شماره طبقه</td>
                            <td>{{$customer->floor_number}}</td>
                        </tr>
                        <tr>
                            <td>زمان باقیمانده</td>
                            <td>{{$customer->expire_date}}</td>
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
                        <tr>
                            <td>توضیحات و آدرس</td>
                            <td>{{$customer->description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
