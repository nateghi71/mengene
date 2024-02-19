@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'متقاضیان'])

@section('title' , 'متقاضیان')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .deletePanel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: rgba(0,0,0,0.5);
        }

        .deleteBox {
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
    <script type="module">
        $('[id^=open_delete_panel_]').on('click' , deleteBox)

        function deleteBox(e)
        {
            e.preventDefault()
            let wrapper = $('<div>' , {class:'deletePanel'})
            let box = $('<div>', {class:'deleteBox'})
            let message = $('<p>' , {
                class:"text-end pb-3",
                text:'ایا می خواهید فایل موردنظر را حذف کنید؟'
            })

            let btnContainer = $('<div>' , {class:"d-flex justify-content-between"})
            let deleteForm = $('<form>' , {
                method:"post",
                action : $(this).attr('href')
            })
            let methodInput = $('<input>' , {
                type:"hidden",
                name:"_method",
                value : "DELETE"
            })
            let csrfInput = $('<input>' , {
                type:"hidden",
                name:"_token",
                value : "{{ csrf_token() }}"
            })


            let closeBtn = $('<button>' , {
                class:"btn btn-success",
                type:"button",
                click: ()=> wrapper.remove(),
                text:'خیر'
            })

            let actionBtn = $('<button>' , {
                class:"btn btn-danger",
                type:"submit",
                text:'بله',
            })

            wrapper.append(box)
            box.append(message)
            box.append(btnContainer)
            btnContainer.append(closeBtn)
            btnContainer.append(deleteForm)
            deleteForm.append(methodInput)
            deleteForm.append(csrfInput)
            deleteForm.append(actionBtn)

            $('#selectBox').append(wrapper)
        }

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
                    calendarSwitch:{
                        enabled:false,
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

        $('#search-input').on('change' , filter)
        $('#sort-by').on('change' , filter)
        $('#type_sale').on('change' , filter)
        $('#access_level').on('change' , filter)
        $('#type_work').on('change' , filter)
        $('#type_build').on('change' , filter)
        $('#status').on('change' , filter)

        function filter() {
            console.log('heyyyyyyyyy')
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
    <div id="selectBox">

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
                            <h4 class="mb-3 mb-sm-0">به بخش متقاضیان خوش آمدید.</h4>
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
                            <input type="text" class="form-control" value="{{ request()->has('search') ? request()->search : '' }}" id="search-input" placeholder="جستوجو بر اساس نام">
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" id="sort-by">
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
                            <select class="form-control" id="type_sale">
                                <option value="default">نوع</option>
                                <option value="buy" @selected(request()->has('type_sale') && request()->type_sale == 'buy')>خرید</option>
                                <option value="rahn" @selected(request()->has('type_sale') && request()->type_sale == 'rahn')>رهن و اجاره</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="access_level">
                                <option value="default">سطح دسترسی</option>
                                <option value="private" @selected(request()->has('access_level') && request()->access_level == 'private')>نمایش خصوصی</option>
                                <option value="public" @selected(request()->has('access_level') && request()->access_level == 'public')>نمایش عمومی</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="type_work">
                                <option value="default">نوع کاربری</option>
                                <option value="home" @selected(request()->has('type_work') && request()->type_work == 'home')>خانه</option>
                                <option value="office" @selected(request()->has('type_work') && request()->type_work == 'office')>دفتر</option>
                                <option value="commercial" @selected(request()->has('type_work') && request()->type_work == 'commercial')>تجاری</option>
                                <option value="training" @selected(request()->has('type_work') && request()->type_work == 'training')>اموزشی</option>
                                <option value="industrial" @selected(request()->has('type_work') && request()->type_work == 'industrial')>صنعتی</option>
                                <option value="other" @selected(request()->has('type_work') && request()->type_work == 'other')>سایر</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="type_build">
                                <option value="default">نوع ملک</option>
                                <option value="house" @selected(request()->has('type_build') && request()->type_build == 'house')>ویلایی</option>
                                <option value="apartment" @selected(request()->has('type_build') && request()->type_build == 'apartment')>ساختمان</option>
                                <option value="shop" @selected(request()->has('type_build') && request()->type_build == 'shop')>مغازه</option>
                                <option value="land" @selected(request()->has('type_build') && request()->type_build == 'land')>زمین</option>
                                <option value="workshop" @selected(request()->has('type_build') && request()->type_build == 'workshop')>کارگاه</option>
                                <option value="parking" @selected(request()->has('type_build') && request()->type_build == 'parking')>پارکینگ</option>
                                <option value="store" @selected(request()->has('type_build') && request()->type_build == 'store')>انباری</option>
                                <option value="hall" @selected(request()->has('type_build') && request()->type_build == 'hall')>سالن</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="status">
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
                                <tr class="text-white">
                                    <th class="text-white"> # </th>
                                    <th class="text-white"> نام </th>
                                    <th class="text-white"> شماره تماس </th>
                                    <th class="text-white"> ثبت کننده </th>
                                    <th class="text-white"> نوع </th>
                                    <th class="text-white">
                                        @if($customers->pluck('status')->contains('غیرفعال') ||
                                            $customers->pluck('type_sale')->contains('خرید') && $customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif
                                    </th>
                                    <th class="text-white">زمان باقیمانده </th>
                                    <th class="text-white"> پیشنهادات </th>
                                    <th class="text-white">تنظیم هشدار</th>
                                    <th class="text-white"> نمایش </th>
                                    <th class="text-white"> ویرایش </th>
                                    <th class="text-white">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $key => $customer)
                                    <tr @class(['self_file' => auth()->user()->id === $customer->user->id])>
                                        <td class="text-white">
                                            <a class="text-decoration-none" href="{{route('customer.star',$customer->id)}}">{!!$customer->getRawOriginal('is_star') ?
                                                '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                        </td>
                                        <td class="text-white">
                                            {{$customer->name}}
                                            @if($customer->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($customer->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td class="text-white">{{$customer->number}}</td>
                                        <td class="text-white">{{$customer->user->name}}</td>
                                        <td class="text-white">{{$customer->type_sale}}</td>
                                        <td class="text-white">{{$customer->getRawOriginal('selling_price') !== 0 ? $customer->selling_price : $customer->rahn_amount}}</td>
                                        <td class="text-white">{{$customer->daysLeft ? $customer->daysLeft . ' روز' : 'منقضی'}} </td>
                                        <td class="text-white"><a class="text-white text-decoration-none" href="{{route('customer.suggestions',$customer->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                        <td class="text-white">
                                            <form action="{{route('customer.remainder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="remainder" id="remainder_input_{{$key}}">
                                                <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                                <button id="remainder_{{$key}}" class="btn btn-link text-white text-decoration-none" type="button"><i class="mdi mdi-bell"></i></button>
                                            </form>
                                        </td>
                                        <td class="text-white"><a class="text-white text-decoration-none" href="{{route('customer.show',$customer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td class="text-white"><a class="text-white text-decoration-none" href="{{route('customer.edit',$customer->id)}}"><i class="mdi mdi-lead-pencil"></i></a></td>
                                        <td class="text-white">
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
