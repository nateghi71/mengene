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

        function filter() {
            let typeSale = $('#type_sale').val();
            if (typeSale == "default") {
                $('#filter-type-sale').prop('disabled', true);
            } else {
                $('#filter-type-sale').val(typeSale);
            }
            let accessLevel = $('#access_level').val();
            if (accessLevel == "default") {
                $('#filter-access-level').prop('disabled', true);
            } else {
                $('#filter-access-level').val(accessLevel);
            }
            let typeWork = $('#type_work').val();
            if (typeWork == "default") {
                $('#filter-type-work').prop('disabled', true);
            } else {
                $('#filter-type-work').val(typeWork);
            }
            let typeBuild = $('#type_build').val();
            if (typeBuild == "default") {
                $('#filter-type-build').prop('disabled', true);
            } else {
                $('#filter-type-build').val(typeBuild);
            }
            let status = $('#status').val();
            if (status == "default") {
                $('#filter-status').prop('disabled', true);
            } else {
                $('#filter-status').val(status);
            }

            let sortBy = $('#sort-by').val();
            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }

            let search = $('#search-input').val();
            if (search == "") {
                $('#filter-search').prop('disabled', true);
            } else {
                $('#filter-search').val(search);
            }

            $('#filter-form').submit();
        }

        $('#filter-form').on('submit', function(event) {
            event.preventDefault();
            let currentUrl = '{{ url()->current() }}';
            let url = currentUrl + '?' + decodeURIComponent($(this).serialize())
            $(location).attr('href', url);
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
{{--    <div class="row">--}}
{{--        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">--}}
{{--            <div class="card bg-primary bg-gradient bg-opacity-50">--}}
{{--                <a href="{{route('customer.index')}}" class="text-decoration-none text-white">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="icon">--}}
{{--                            <span class="mdi mdi-account-search icon-item text-white"></span>--}}
{{--                            <div class="pe-3 d-flex align-items-center align-self-start text-white">--}}
{{--                                <h3 class="mb-0">همه متقاضیان</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">--}}
{{--            <div class="card bg-primary bg-gradient bg-opacity-50">--}}
{{--                <a href="{{route('customer.index',['type' => 'deActive'])}}" class="text-decoration-none text-white">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="icon">--}}
{{--                            <span class="mdi mdi-account-search icon-item text-white"></span>--}}
{{--                            <div class="pe-3 d-flex align-items-center align-self-start text-white">--}}
{{--                                <h3 class="mb-0">متقاضیان غیرفعال</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <div class="card-body py-2 row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" onchange="filter()" value="{{ request()->has('search') ? request()->search : '' }}" id="search-input" placeholder="جستوجو بر اساس نام">
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" onchange="filter()" id="sort-by">
                                <option value="default">مرتب سازی</option>
                                <option value="max_days" @selected(request()->has('sortBy') && request()->sortBy == 'max_days')>بیشترین روزهای باقی مانده</option>
                                <option value="min_days" @selected(request()->has('sortBy') && request()->sortBy == 'min_days')>کمترین روزهای باقی مانده</option>
                                <option value="max_price" @selected(request()->has('sortBy') && request()->sortBy == 'max_price')>بیشترین قیمت / رهن</option>
                                <option value="min_price" @selected(request()->has('sortBy') && request()->sortBy == 'min_price')>کمترین قیمت / رهن</option>
                                <option value="max_scale" @selected(request()->has('sortBy') && request()->sortBy == 'max_scale')>بیشترین متراژ</option>
                                <option value="min_scale" @selected(request()->has('sortBy') && request()->sortBy == 'min_scale')>کمترین متراژ</option>
                                <option value="max_rooms" @selected(request()->has('sortBy') && request()->sortBy == 'max_rooms')>بیشترین تعداد اتاق</option>
                                <option value="min_rooms" @selected(request()->has('sortBy') && request()->sortBy == 'min_rooms')>کمترین تعداد اتاق</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <select class="form-control" onchange="filter()" id="type_sale">
                                <option value="default">نوع</option>
                                <option value="buy" @selected(request()->has('type_sale') && request()->type_sale == 'buy')>خرید</option>
                                <option value="rahn" @selected(request()->has('type_sale') && request()->type_sale == 'rahn')>رهن و اجاره</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" onchange="filter()" id="access_level">
                                <option value="default">سطح دسترسی</option>
                                <option value="private" @selected(request()->has('access_level') && request()->access_level == 'private')>خصوصی</option>
                                <option value="public" @selected(request()->has('access_level') && request()->access_level == 'public')>عمومی</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" onchange="filter()" id="type_work">
                                <option value="default">نوع مسکن</option>
                                <option value="home" @selected(request()->has('type_work') && request()->type_work == 'home')>خانه</option>
                                <option value="office" @selected(request()->has('type_work') && request()->type_work == 'office')>دفتر</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" onchange="filter()" id="type_build">
                                <option value="default">نوع خانه</option>
                                <option value="house" @selected(request()->has('type_build') && request()->type_build == 'house')>ویلایی</option>
                                <option value="apartment" @selected(request()->has('type_build') && request()->type_build == 'apartment')>ساختمان</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" onchange="filter()" id="status">
                                <option value="default">وضعیت</option>
                                <option value="active" @selected(request()->has('status') && request()->status == 'active')>فعال</option>
                                <option value="unknown" @selected(request()->has('status') && request()->status == 'unknown')>نامعلوم</option>
                                <option value="deActive" @selected(request()->has('status') && request()->status == 'deActive')>عیرفعال</option>
                            </select>
                        </div>
                    </div>
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
    <form id="filter-form">
        <input id="filter-type-sale" type="hidden" name="type_sale">
        <input id="filter-access-level" type="hidden" name="access_level">
        <input id="filter-type-work" type="hidden" name="type_work">
        <input id="filter-type-build" type="hidden" name="type_build">
        <input id="filter-status" type="hidden" name="status">
        <input id="filter-sort-by" type="hidden" name="sortBy">
        <input id="filter-search" type="hidden" name="search">
    </form>
@endsection
