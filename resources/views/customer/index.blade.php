@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'متقاضیان'])

@section('title' , 'متقاضیان')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .minute-input, .second-input, .hour-input {
            color: black !important;
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

        // $("[id^=remainder_input_]").hide()
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
                        // let input = $('[id^=remainder_input_'+ id +']').get(0)
                        // console.log($('[id^=remainder_input_'+ id +']').parents('form').get(0))
                        // let formData = new FormData(input.form)
                        // $.ajax({
                        //     method:"post",
                        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        //     url:input.form.action,
                        //     data: formData,
                        //     dataType: 'json',
                        //     processData: false,
                        //     contentType: false,
                        //     cache:false,
                        //     success:function (response){
                        //         console.log(response.myDate)
                        //     },
                        //     error:function (xhr, ajaxOptions, thrownError){
                        //         console.log("error: " + xhr.status)
                        //     },
                        // })
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
                        <div class="lh-lg col-5 col-sm-7 col-xl-8 py-2">
                            <h4 class="mb-3 mb-sm-0">توجه کنید!</h4>
                            <p class="mb-0 d-none d-sm-block">
                                 در بخش متقاضیان می توانید کسانی که درخواست رهن و اجاره یا خرید ملکی را دارند برایشان فایلی را ایجاد کنید و
                                تمام فایل هایی که برای متقاضیانتان ایجاد کردید را در این قسمت ببینید. پیشنهاداتی که برایشان وجود دارد را بیابید.
                                هشدار پیامکی برای جلساتتان تنظیم کنید فایلهایتان را و ویرایش و حذف کنید.
                            </p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('customer.create')}}" class="btn btn-outline-light btn-rounded get-started-btn">ایجاد متقاضی</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('customer.index')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">همه متقاضیان</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <a href="{{route('customer.index',['type' => 'deActive'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-white"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                <h3 class="mb-0">متقاضیان غیرفعال</h3>
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
                    <form action="{{route('landowner.store')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="search" class="form-control col-md-9" value="{{old('search')}}" id="number" placeholder="جستوجو بر اساس نام">
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control" name="access_level" id="access_level">
                                    <option value="home">مرتب سازی</option>
                                    <option value="office">بیشترین روزهای باقی مانده</option>
                                    <option value="office">کمترین روزهای باقی مانده</option>
                                    <option value="office">بیشترین قیمت / رهن</option>
                                    <option value="office">کمترین قیمت / رهن</option>
                                    <option value="office">بیشترین متراژ</option>
                                    <option value="office">کمترین متراژ</option>
                                    <option value="office">بیشترین تعداد اتاق</option>
                                    <option value="office">کمترین تعداد اتاق</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="elevator" class="form-check-label">
                                        <input type="checkbox" name="elevator" id="elevator" class="form-check-input" {{ old('elevator') == 'on' ? 'checked' : '' }}>فروش
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="elevator" class="form-check-label">
                                        <input type="checkbox" name="elevator" id="elevator" class="form-check-input" {{ old('elevator') == 'on' ? 'checked' : '' }}>رهن و اجاره
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="parking" class="form-check-label">
                                        <input type="checkbox" name="parking" id="parking" class="form-check-input" {{ old('parking') == 'on' ? 'checked' : '' }}>خصوصی
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="store" class="form-check-label">
                                        <input type="checkbox" name="store" id="store" class="form-check-input" {{ old('store') == 'on' ? 'checked' : '' }}>عمومی
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="elevator" class="form-check-label">
                                        <input type="checkbox" name="elevator" id="elevator" class="form-check-input" {{ old('elevator') == 'on' ? 'checked' : '' }}>خانه
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="elevator" class="form-check-label">
                                        <input type="checkbox" name="elevator" id="elevator" class="form-check-input" {{ old('elevator') == 'on' ? 'checked' : '' }}>دفتر
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="parking" class="form-check-label">
                                        <input type="checkbox" name="parking" id="parking" class="form-check-input" {{ old('parking') == 'on' ? 'checked' : '' }}>ویلایی
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <label for="store" class="form-check-label">
                                        <input type="checkbox" name="store" id="store" class="form-check-input" {{ old('store') == 'on' ? 'checked' : '' }}>ساختمان
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if($customers->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            @if($customers->pluck('status')->contains('غیرفعال'))
                                متقاضیان غیرفعال
                            @else
                                همه متقاضیان
                            @endif
                        </h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> شماره تماس </th>
                                    <th> ثبت کننده </th>
                                    <th> نوع </th>
                                    <th>
                                        @if($customers->pluck('status')->contains('غیرفعال') ||
                                            $customers->pluck('type_sale')->contains('خرید') && $customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th>زمان باقیمانده </th>
                                    <th> پیشنهادات </th>
                                    <th>تنظیم هشدار</th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody class="text-white">
                                @foreach($customers as $key => $customer)
                                    <tr @class(['self_file' => auth()->user()->id === $customer->user->id])>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('customer.star',$customer->id)}}">{!!$customer->getRawOriginal('is_star') ?
                                                '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                        </td>
                                        <td>
                                            {{$customer->name}}
                                            @if($customer->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($customer->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td>{{$customer->number}}</td>
                                        <td>{{$customer->user->name}}</td>
                                        <td>{{$customer->type_sale}}</td>
                                        <td>{{$customer->getRawOriginal('selling_price') !== 0 ? $customer->selling_price : $customer->rahn_amount}}</td>
                                        <td>{{$customer->daysLeft ? $customer->daysLeft . ' روز' : 'منقضی'}} </td>
                                        <td><a class="text-white text-decoration-none" href="{{route('customer.suggestions',$customer->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                        <td>
                                            <form action="{{route('customer.remainder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="remainder" id="remainder_input_{{$key}}">
                                                <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                                <button id="remainder_{{$key}}" class="btn btn-link text-white text-decoration-none" type="button"><i class="mdi mdi-bell"></i></button>
                                            </form>
                                        </td>
                                        <td><a class="text-white text-decoration-none" href="{{route('customer.show',$customer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="text-white text-decoration-none" href="{{route('customer.edit',$customer->id)}}"><i class="mdi mdi-lead-pencil"></i></a></td>
                                        <td>
                                            <a href="{{route('customer.destroy',$customer->id)}}" id="open_delete_panel_{{$key}}" class="text-decoration-none text-danger" type="button"><i class="mdi mdi-delete"></i></a>
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
                <p>متقاضی وجود ندارد.</p>
            </div>
        @endif
    </div>
    {{$customers->links()}}
@endsection
