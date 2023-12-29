@extends('layouts.dashboard' , ['showBanner' => true , 'sectionName' => 'داشبورد'])

@section('title' , 'داشبورد')

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <a href="{{route('customer.index')}}" class="text-decoration-none text-white">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">نمایش متقاضیان</h3>
                                    <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-info ">
                                <span class="mdi mdi-account-search icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">دیدن</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <a href="{{route('landowner.index')}}" class="text-decoration-none text-white">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">نمایش مالکان</h3>
                                    <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-info ">
                                <span class="mdi mdi-account-search icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">دیدن</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">تعداد فایل ها</h4>
                    <canvas id="transaction-history" class="transaction-chart"></canvas>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">تعداد متقاضیان</h6>
                            <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">{{$business->customers_count}}</h6>
                        </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">تعداد مالکان</h6>
                            <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">{{$business->landowners_count}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">مشخصات املاکی</h4>
                        <p class="text-muted mb-1">اطلاعات</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="preview-list">
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-file-document"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">وضعیت :</h6>
                                            <p class="text-muted mb-0">توضیحات</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">
                                                {{$user->businessUser()->first()->is_accepted ? 'تایید شده' : 'در انتظار تایید'}}
                                            </p>
                                            <p class="text-muted mb-0">مورد تایید قرار گرفتید یا خیر</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-file-document"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">نام املاکی :</h6>
                                            <p class="text-muted mb-0">مالک</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">{{$business->name}}</p>
                                            <p class="text-muted mb-0">{{$business->owner->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-cloud-download"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">شهر :</h6>
                                            <p class="text-muted mb-0">منطقه</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">{{$business->city}}</p>
                                            <p class="text-muted mb-0">{{$business->area}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="mdi mdi-clock"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">ادرس :</h6>
                                            <p class="text-muted mb-0">تلفن</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-">{{$business->address}}</p>
                                            <p class="text-muted mb-0">{{$business->owner->number}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="mdi mdi-clock"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">عکس :</h6>
                                            <p class="text-muted mb-0"></p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-">
                                                <img src="{{asset(env('BUSINESS_IMAGES_UPLOAD_PATH')) .'/'. $business->image}}" width="50">
                                            </p>
                                            <p class="text-muted mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-warning">
                                            <i class="mdi mdi-chart-pie"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">لغو همکاری</h6>
                                            <p class="text-muted mb-0">توضیحات</p>
                                        </div>
                                        <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                            <p class="text-white">
                                                <a href="{{route('consultant.leave.member',['user'=>auth()->id()])}}" class="btn btn-outline-danger">
                                                    لغو همکاری
                                                </a>
                                            </p>
                                            <p class="text-muted mb-0">لغو همکاری</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <a href="{{route('customer.create')}}" class="text-decoration-none text-white">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">متقاضی ملک</h3>
                                    <p class="text-success ms-2 mb-0 font-weight-medium pe-3">+</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-account-search icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">اضافه کردن</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <a href="{{route('landowner.create')}}" class="text-decoration-none text-white">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">فروشنده ملک</h3>
                                    <p class="text-success ms-2 mb-0 font-weight-medium pe-3">+</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-bullhorn icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">اضافه کردن</h6>
                </div>
            </div>
        </div>
    </div>
@endsection
