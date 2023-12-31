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
                          <a href="{{route('landowner.index',['status' => 'active'])}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش مالکان</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">نمایش اطلاعات : {{ $landowner->name }}</h4>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>نوع</td>
                                <td>{{$landowner->type_sale}}</td>
                            </tr>
                            <tr>
                                <td>نام</td>
                                <td>{{$landowner->name}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{$landowner->number}}</td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{$landowner->city}}</td>
                            </tr>
                            <tr>
                                <td>نوع کار</td>
                                <td>{{$landowner->type_work}}</td>
                            </tr>
                            <tr>
                                <td>نوع ساختمان</td>
                                <td>{{$landowner->type_build}}</td>
                            </tr>
                            @if($landowner->type_sale == 'buy')
                                <tr>
                                    <td>قیمت</td>
                                    <td>{{$landowner->selling_price}}</td>
                                </tr>
                            @elseif($landowner->type_sale == 'rahn')
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
                                <td>تاریخ اعتبار</td>
                                <td>{{$landowner->expire_date}}</td>
                            </tr>
                            <tr>
                                <td>اسانسور</td>
                                <td>{{$landowner->elevator == 1 ? 'دارد' : 'ندارد'}}</td>
                            </tr>
                            <tr>
                                <td>پارکینگ</td>
                                <td>{{$landowner->parking == 1 ? 'دارد' : 'ندارد'}}</td>
                            </tr>
                            <tr>
                                <td>انبار</td>
                                <td>{{$landowner->store == 1 ? 'دارد' : 'ندارد'}}</td>
                            </tr>
                            <tr>
                                <td>ستاره</td>
                                <td>{{$landowner->is_star == 1 ? 'دارد' : 'ندارد'}}</td>
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
    </div>

@endsection
