@extends('layouts.dashboard' , ['sectionName' => 'مشاوران'])

@section('title' , 'مشاوران')

@section('head')
    <style>
        #deletePanel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: rgba(0,0,0,0.5);
        }

        #deleteBox {
            position: fixed;
            padding: 20px;
            top: 50%;
            left: 50%;
            background: rgba(0,0,0,1);
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('scripts')
    <script>
        $('.btn-close').on('click' , function (){
            $('#message').remove()
        })

        $('#deletePanel').hide()

        $('[id^=open_delete_panel_]').on('click' , function (e){
            e.preventDefault()
            $('#deletePanel').show()
            $('#deleteBox').children().children().eq(0).attr('href' , $(this).attr('href'))
        })
        $('#not_delete_btn').on('click' , function (){
            $('#deletePanel').hide()
        })
    </script>
@endsection

@section('content')
    <div id="deletePanel">
        <div id="deleteBox">
            <p class="text-end pb-3">ایا می خواهید فایل موردنظر را حذف کنید؟</p>
            <div class="d-flex justify-content-between">
                <a class="btn btn-danger">
                    بله
                </a>
                <button id="not_delete_btn" class="btn btn-success" type="button">خیر</button>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success d-flex justify-content-between" id="message">
            {{session()->get('message')}}
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="lh-lg col-5 col-sm-7 col-xl-8 py-2">
                            <h4 class="mb-3 mb-sm-0">توجه!</h4>
                            <p class="mb-0 d-none d-sm-block">
                                از مشاوران خود بخواهید ثبت نام کنند و در قسمت بعدی یافتن املاک را انتخاب کنند و در کادر مربوطه شماره شما را وارد کنند و
                                بعد پیوستن را انتخاب کنند
                                بعد از ثبت درخواست مشاور
                                شما میتوانید در قسمت مشاوران آنها را مدیریت کنید(فعال یا غیر فعال سازی)
                            </p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('dashboard')}}" class="btn btn-outline-light btn-rounded get-started-btn">داشبورد</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-12 grid-margin stretch-card">--}}
{{--            <div class="card bg-success bg-gradient bg-opacity-50">--}}
{{--                <div class="card-body py-3 px-0 px-sm-3">--}}
{{--                    <div class="row align-items-center">--}}
{{--                        <p class="fs-6 lh-lg">--}}
{{--                            از مشاوران خود بخواهید ثبت نام کنند و در قسمت بعدی یافتن املاک را انتخاب کنند و در کادر مربوطه شماره شما را وارد کنند و--}}
{{--                            بعد پیوستن را انتخاب کنند--}}
{{--                            بعد از ثبت درخواست مشاور--}}
{{--                            شما میتوانید در قسمت مشاوران آنها را مدیریت کنید(فعال یا غیر فعال سازی)--}}
{{--                        </p>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row">
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('business.consultants')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-multiple-plus icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">مشاوران تایید شده</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('business.consultants',['type' => 'notAccepted'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-multiple-minus icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">مشاوران تایید نشده</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body py-2 row">
                    <div class="col-md-6">
                        <input type="text" name="number" class="form-control col-md-9" value="{{old('number')}}" id="number" placeholder="جستوجو">
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" name="type_work" id="type_work">
                            <option value="home">مرتب سازی</option>
                            <option value="office">دفتر</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row " id="accepted">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        @if($is_accepted)
                            مشاورهای تایید شده
                        @else
                            مشاورهای تایید نشده
                        @endif
                    </h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> ایمیل </th>
                                <th> شهر </th>
                                @if($is_accepted)
                                <th> زمان عضویت </th>
                                <th> تعداد آگهی های ثبت کرده </th>
                                <th> امتیاز </th>
                                <th> انتخاب مالک </th>
                                <th> غیرفعال کردن </th>
                                @else
                                    <th> قبول کردن </th>
                                    <th>حذف </th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="text-white">
                            @foreach($members as $key => $member)
                                <tr>
                                    <td>{{$members->firstItem() + $key}}</td>
                                    <td>{{$member->name}}</td>
                                    <td> {{$member->number}} </td>
                                    <td> {{$member->email ?? '-'}}</td>
                                    <td> {{$member->city->name}} </td>
                                    @if($is_accepted)
                                    <td> {{$member->daysGone}}</td>
                                    <td> {{$member->customers_count + $member->landowners_count}} </td>
                                    <td> {{($member->customers_count + $member->landowners_count) / $member->daysGone}} </td>
                                    <td>
                                        <a class="text-success text-decoration-none" href="{{ route('business.chooseOwner', ['user' => $member->id]) }}"><i class="mdi mdi-crown"></i></a>

                                    </td>
                                    <td>
                                        <a class="text-danger text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}" ><i class="mdi mdi-account-off"></i></a>
                                    </td>
                                    @else
                                        <td>
                                            <a class="text-success text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}"><i class="mdi mdi-account-check"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('business.remove.member',['user'=>$member->id])}}" id="open_delete_panel_{{$key}}" class="text-danger text-decoration-none" type="button"><i class="mdi mdi-account-remove"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{$members->links()}}
@endsection
