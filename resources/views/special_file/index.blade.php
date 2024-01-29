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
        .minute-input, .second-input, .hour-input {
            color: black !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
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
            let typeFile = $('#type_file').val();
            if (typeFile == "default") {
                $('#filter-type-file').prop('disabled', true);
            } else {
                $('#filter-type-file').val(typeFile);
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
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">به بخش فایل های ویژه خوش آمدید.</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">
                                در این بخش می توانید از فایل های اختصاصی سایت منگنه
                                استفاده کنید. دو نوع فایل وجود دارد. یک نوع فایل که برای ظاهر شدن تمام اطلاعاتش
                                باید خریده شود که پس از خرید به فایل های شما اضافه می شود. یک نوع دیگر فایل های اشتراکی هستند که
                                با خریدن اشتراک قابل دیدن هستند.
                            </p>
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
    @if($files->isEmpty())
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-success bg-gradient bg-opacity-50">
                    <a href="{{route('landowner.index')}}" class="text-decoration-none text-white">
                        <div class="card-body">
                            <div class="icon">
                                <span class="mdi mdi-account-search icon-item text-white"></span>
                                <div class="pe-3 d-flex align-items-center align-self-start text-white">
                                    <h3 class="mb-0">فایل های من</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endif

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
                            <select class="form-control" onchange="filter()" id="type_file">
                                <option value="default">نوع فایل</option>
                                <option value="subscription" @selected(request()->has('type_file') && request()->type_file == 'subscription')>اشتراکی</option>
                                <option value="buy" @selected(request()->has('type_file') && request()->type_file == 'buy')>پولی</option>
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
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">فایل های ویژه</h4>
                            <div>
                                <a href="{{route('landowner.index')}}" class="btn btn-success">فایل های من</a>
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
                                        @if($files->pluck('type_sale')->contains('فروش') && $files->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($files->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th>زمان باقیمانده </th>
                                    <th>پیشنهادات </th>
                                    <th>تنظیم هشدار</th>
                                    <th> نمایش </th>
                                    <th> انتقال به فایل های من </th>
                                    <th>خرید</th>
                                </tr>
                                </thead>
                                <tbody class="text-white">
                                @foreach($files as $key => $file)
                                    <tr>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('landowner.star',$file->id)}}">{!!$file->getRawOriginal('is_star') ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                                {{$file->name}}
                                                @if($file->getRawOriginal('status') == 'active')
                                                    <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                                @elseif($file->getRawOriginal('status') == 'unknown')
                                                    <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                                @else
                                                    <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                                @endif
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                                {{$file->number}}
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif

                                        </td>
                                        <td>{{$file->type_sale}}</td>
                                        <td>{{$file->getRawOriginal('selling_price') !== 0 ? $file->selling_price : $file->rahn_amount}}</td>
                                        <td>{{$file->daysLeft ? $file->daysLeft . ' روز' : 'منقضی'}}</td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                            <a class="text-white text-decoration-none" href="{{route('landowner.suggestions',$file->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a>
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                            <form action="{{route('landowner.remainder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="remainder" id="remainder_input_{{$key}}">
                                                <input type="hidden" name="file_id" value="{{$file->id}}">
                                                <button id="remainder_{{$key}}" class="btn btn-link text-white text-decoration-none" type="button"><i class="mdi mdi-bell"></i></button>
                                            </form>
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                            <a class="text-white text-decoration-none" href="{{route('landowner.show',$file->id)}}"><i class="mdi mdi-eye"></i></a>
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                                <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="file_id" value="{{$file->id}}">
                                                    <button type="submit" class="btn btn-link"><i class="mdi mdi-format-vertical-align-top"></i></button>
                                                </form>
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link"><i class="mdi mdi-eye-off text-danger"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->getRawOriginal('type_file') == 'subscription' && !auth()->user()->isFreeUser())
                                                <a class="text-success text-decoration-none" href="{{route('packages.index')}}"><i class="mdi mdi-eye-off text-danger"></i></a>
                                            @else
                                                @if($file->getRawOriginal('type_file') == 'subscription')
                                                    <a class="text-success text-decoration-none" href="{{route('packages.index')}}">خرید اشتراک</a>
                                                @elseif($file->getRawOriginal('type_file') == 'buy')
                                                    <form action="{{route('landowner.subscription.checkout')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                                        <button type="submit" class="btn btn-link text-decoration-none text-success">خرید فایل</button>
                                                    </form>
                                                @endif
                                            @endif
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
    {{$files->links()}}
    <form id="filter-form">
        <input id="filter-type-sale" type="hidden" name="type_sale">
        <input id="filter-type-file" type="hidden" name="type_file">
        <input id="filter-type-work" type="hidden" name="type_work">
        <input id="filter-type-build" type="hidden" name="type_build">
        <input id="filter-status" type="hidden" name="status">
        <input id="filter-sort-by" type="hidden" name="sortBy">
    </form>
@endsection
