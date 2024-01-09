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
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در مشاوران هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
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
    <div class="row " id="accepted">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">مشاورهای تایید شده</h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> ایمیل </th>
                                <th> شهر </th>
                                <th> تعداد آگهی های ثبت کرده </th>
                                <th> انتخاب مالک </th>
                                <th> غیرفعال کردن </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($acceptedMembers as $key => $member)
                                <tr>
                                    <td>{{$acceptedMembers->firstItem() + $key}}</td>
                                    <td>{{$member->name}}</td>
                                    <td> {{$member->number}} </td>
                                    <td> {{$member->email ?? '-'}}</td>
                                    <td> {{$member->city}} </td>
                                    <td> {{$member->customers_count + $member->landowners_count}} </td>
                                    <td>
                                        <a class="btn btn-outline-success text-decoration-none" href="{{ route('business.chooseOwner', ['user' => $member->id]) }}">انتخاب مالک</a>

                                    </td>
                                    <td>
                                        <a class="btn btn-outline-danger text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}" >غیرفعال</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{$acceptedMembers->links()}}
    <div class="row "  id="notAccepted">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">مشاورهای تایید نشده</h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> ایمیل </th>
                                <th> شهر </th>
                                <th> قبول کردن </th>
                                <th>حذف </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notAcceptedMembers as $key => $member)
                                <tr>
                                    <td>{{$notAcceptedMembers->firstItem() + $key}}</td>
                                    <td>{{$member->name}}</td>
                                    <td> {{$member->number}} </td>
                                    <td> {{$member->email ?? '-'}}</td>
                                    <td> {{$member->city}} </td>
                                    <td>
                                        <a class="btn btn-outline-success text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}">قبول</a>
                                    </td>
                                    <td>
                                        <a href="{{route('business.remove.member',['user'=>$member->id])}}" id="open_delete_panel_{{$key}}" class="btn btn-outline-danger" type="button">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{$notAcceptedMembers->links()}}
@endsection
