@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'مالکان'])

@section('title' , 'مالکان')

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
        .self_file {
            background: #000;
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
            $('#deleteBox').children().children().eq(0).attr('action' , $(this).attr('href'))
        })
        $('#not_delete_btn').on('click' , function (){
            $('#deletePanel').hide()
        })
    </script>
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success d-flex justify-content-between" id="message">
            {{session()->get('message')}}
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
    @endif

    <div id="deletePanel">
        <div id="deleteBox">
            <p class="text-end pb-3">ایا می خواهید فایل موردنظر را حذف کنید؟</p>
            <div class="d-flex justify-content-between">
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <button id="delete_btn" class="btn btn-danger" type="submit">بله</button>
                </form>
                <button id="not_delete_btn" class="btn btn-success" type="button">خیر</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش مالکان هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('landowner.create')}}" class="btn btn-outline-light btn-rounded get-started-btn">ایجاد مالک</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.index')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">همه مالکان</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.index',['type' => 'buy'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">مالکان فروشنده</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.index',['type' => 'rahn'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">مالکان رهن دهنده</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.index',['type' => 'deActive'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">مالکان غیرفعال</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        @if($landowners->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            @if($landowners->pluck('status')->contains('غیرفعال'))
                                مالکان غیرفعال
                            @elseif($landowners->pluck('type_sale')->contains('فروش') && $landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                همه مالکان
                            @elseif($landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                مالکان رهن دهنده
                            @else
                                مالکان فروشنده
                            @endif
                        </h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr class="text-white">
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> شماره تماس </th>
                                    <th> ثبت کننده </th>
                                    <th> نوع </th>
                                    <th>
                                        @if($landowners->pluck('status')->contains('غیرفعال') ||
                                            $landowners->pluck('type_sale')->contains('فروش') && $landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($landowners->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th> متراژ </th>
                                    <th>زمان باقیمانده </th>
                                    <th> پیشنهادات </th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody class="text-white">
                                @foreach($landowners as $key => $landowner)
                                    <tr @class(['self_file' => auth()->user()->id === $landowner->user->id])>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('landowner.star',$landowner->id)}}">{!!$landowner->getRawOriginal('is_star') ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                        </td>
                                        <td>
                                            {{$landowner->name}}
                                            @if($landowner->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($landowner->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td>{{$landowner->number}}</td>
                                        <td>{{$landowner->user->name}}</td>
                                        <td>{{$landowner->type_sale}}</td>
                                        <td>{{$landowner->getRawOriginal('selling_price') !== 0 ? $landowner->selling_price : $landowner->rahn_amount}}</td>
                                        <td>{{$landowner->scale}}</td>
                                        <td>{{$landowner->daysLeft ? $landowner->daysLeft . ' روز' : 'منقضی'}}</td>
                                        <td><a class="text-white text-decoration-none" href="{{route('landowner.suggestions',$landowner->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                        <td><a class="text-white text-decoration-none" href="{{route('landowner.show',$landowner->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="text-white text-decoration-none" href="{{route('landowner.edit',$landowner->id)}}"><i class="mdi mdi-message-draw"></i></a></td>
                                        <td>
                                            <a href="{{route('landowner.destroy',$landowner->id)}}" id="open_delete_panel_{{$key}}" class="text-decoration-none text-danger" type="button"><i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <p>مالکی وجود ندارد.</p>
            </div>
        @endif

    </div>
    {{$landowners->links()}}
@endsection
