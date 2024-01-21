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
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش مالکان هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('landowner.index')}}" class="btn btn-outline-light btn-rounded get-started-btn">فایل های من</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card bg-primary bg-gradient bg-opacity-50">
                <div class="card-body py-2 row">
                    <div class="row">
                        <div class="form-group col-md-12">
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
                                <option value="buy" @selected(request()->has('type_sale') && request()->type_sale == 'buy')>فروش</option>
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
        @if($files->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title">فایل های ویژه</h4>
                                <div><a class="btn btn-success" href="{{route('landowner.index')}}">فایل های من</a></div>
                            </div>
                        </h4>

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
    <form id="filter-form">
        <input id="filter-type-sale" type="hidden" name="type_sale">
        <input id="filter-access-level" type="hidden" name="access_level">
        <input id="filter-type-work" type="hidden" name="type_work">
        <input id="filter-type-build" type="hidden" name="type_build">
        <input id="filter-status" type="hidden" name="status">
        <input id="filter-sort-by" type="hidden" name="sortBy">
    </form>
@endsection
