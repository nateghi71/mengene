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
        .buy_file {
            background: #000;
        }
        .minute-input, .second-input, .hour-input {
            color: black !important;
        }

    </style>
@endsection

@section('scripts')
    <script>
        $("[id^=remainder]").on('click' , function (){
            console.log()
        })

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

        let datePicker = $("[id^=remainder_]").persianDatepicker({
            timePicker: {
                enabled: true,
            },
            toolbox:{
                submitButton: {
                    enabled: true,
                    text: {
                        fa: 'تایید'
                    },
                    onSubmit:function (element){
                        let id = element.inputElement.id.slice(10)
                        let input = $('[id^=remainder_input_'+ id +']')
                        let myDate = new persianDate(element.api.getState().selected.unixDate).format("YYYY-MM-DD HH:mm:ss")
                        input.val(myDate)
                        input.parents('form').submit()
                    }
                },
                calendarSwitch:{
                    enabled: false,
                },
                todayButton:{
                    enabled: false,
                },
            },
            initialValue: false,
            minDate: new persianDate(),
        });

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
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.sub_files')}}" class="text-decoration-none text-white">
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
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.sub_files',['type' => 'buy'])}}" class="text-decoration-none text-white">
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
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('landowner.sub_files',['type' => 'rahn'])}}" class="text-decoration-none text-white">
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
    </div>
    <div class="row">
        @if($files->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        @if($files->pluck('status')->contains('غیرفعال'))
                            @php
                                $title = 'مالکان غیرفعال';
                            @endphp
                        @elseif($files->pluck('type_sale')->contains('فروش') && $files->pluck('type_sale')->contains('رهن و اجاره'))
                            @php
                                $title = 'همه مالکان';
                            @endphp
                        @elseif($files->pluck('type_sale')->contains('رهن و اجاره'))
                            @php
                                $title = 'مالکان رهن دهنده';
                            @endphp
                        @else
                            @php
                            $title = 'مالکان فروشنده';
                            @endphp
                        @endif
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{$title}}</h4>
                            <div class="mb-0">
                                <a href="{{route('landowner.index')}}" class="btn btn-success">فایل های من</a>
                                <a href="{{route('landowner.sub_files')}}" class="btn btn-success">فایل های ویژه</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr class="text-white">
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> شماره تماس </th>
                                    <th> نوع </th>
                                    <th>
{{--                                        {{dd($files->pluck('type_sale'))}}--}}
                                        @if($files->pluck('type_sale')->contains('فروش') && $files->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($files->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th>زمان باقیمانده </th>
                                    <th> پیشنهادات </th>
                                    <th>تنظیم هشدار</th>
                                    <th> نمایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody class="text-white">
                                @foreach($files as $key => $file)
                                    @if($file->getRawOriginal('type_file') === 'buy' || ($file->getRawOriginal('type_file') === 'subscription' && !auth()->user()->isFreeUser()))
                                        <tr @class(['buy_file' => $file->getRawOriginal('type_file') === 'buy'])>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.star',$file->id)}}">{!!$file->getRawOriginal('is_star') ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                            </td>
                                            <td>
                                                @if($file->getRawOriginal('type_file') === 'subscription')
                                                    {{$file->name}}
                                                    @if($file->getRawOriginal('status') == 'active')
                                                        <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                                    @elseif($file->getRawOriginal('status') == 'unknown')
                                                        <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                                    @else
                                                        <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($file->getRawOriginal('type_file') === 'subscription')
                                                    {{$file->number}}
                                                @else
                                                    -
                                                @endif

                                            </td>
                                            <td>{{$file->type_sale}}</td>
                                            <td>{{$file->getRawOriginal('selling_price') !== 0 ? $file->selling_price : $file->rahn_amount}}</td>
                                            <td>{{$file->daysLeft ? $file->daysLeft . ' روز' : 'منقضی'}}</td>
                                            <td>
                                                @if($file->getRawOriginal('type_file') === 'subscription')
                                                    <a class="text-white text-decoration-none" href="{{route('landowner.suggestions',$file->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a>
                                                @else
                                                    -
                                                @endif

                                            </td>
                                            <td>
                                                @if($file->getRawOriginal('type_file') === 'subscription')
                                                    <form action="{{route('landowner.remainder')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="remainder" id="remainder_input_{{$key}}">
                                                        <input type="hidden" name="landowner_id" value="{{$file->id}}">
                                                        <button id="remainder_{{$key}}" class="btn btn-link text-white text-decoration-none" type="button"><i class="mdi mdi-bell"></i></button>
                                                    </form>
                                                @else
                                                    -
                                                @endif

                                            </td>
                                            <td><a class="text-white text-decoration-none" href="{{route('landowner.show',$file->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                            <td>
                                                <a href="{{route('landowner.destroy',$file->id)}}" id="open_delete_panel_{{$key}}" class="text-decoration-none text-danger" type="button"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endif
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
    {{$files->links()}}
@endsection
