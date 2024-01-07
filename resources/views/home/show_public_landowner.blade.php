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
                    <h1>نمایش اطلاعات : {{ $landowner->name }}</h1>
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
                            <td>{{$landowner->status}}</td>
                        </tr>
                        <tr>
                            <td>نوع</td>
                            <td>{{$landowner->type_sale}}</td>
                        </tr>
                        <tr>
                            <td>نام املاکی</td>
                            <td>{{$landowner->business->name}}</td>
                        </tr>

                        <tr>
                            <td>شهر</td>
                            <td>{{$landowner->city}}</td>
                        </tr>
                        <tr>
                            <td>سطح دسترسی</td>
                            <td>{{$landowner->access_level}}</td>
                        </tr>
                        <tr>
                            <td>نوع مسکن</td>
                            <td>{{$landowner->type_work}}</td>
                        </tr>
                        <tr>
                            <td>نوع ساختمان</td>
                            <td>{{$landowner->type_build}}</td>
                        </tr>
                        @if($landowner->getRawOriginal('type_sale') == 'buy')
                            <tr>
                                <td>قیمت</td>
                                <td>{{$landowner->selling_price}}</td>
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
                            <td>متراژ</td>
                            <td>{{$landowner->scale}}</td>
                        </tr>
                        <tr>
                            <td>تعداد اتاق</td>
                            <td>{{$landowner->number_of_rooms}}</td>
                        </tr>
                        <tr>
                            <td>شماره طبقه</td>
                            <td>{{$landowner->floor_number}}</td>
                        </tr>
                        <tr>
                            <td>زمان باقیمانده</td>
                            <td>{{$landowner->expire_date}}</td>
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
                        <tr>
                            <td>ستاره</td>
                            <td>{{$landowner->is_star}}</td>
                        </tr>
                        <tr>
                            <td>توضیحات و آدرس</td>
                            <td>{{$landowner->description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
