@extends('layouts.dashboard' , ['sectionName' => 'مشاوران'])

@section('title' , 'مشاوران')

@section('head')
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
            let btnContainer = $('<div>' , {class:"d-flex justify-content-between"})

            let message = $('<p>' , {
                class:"text-end pb-3",
            })

            if($(this).attr('href').indexOf('chooseOwner') !== -1)
            {
                message.text('ایا می خواهید کاربر موردنظر را به عنوان مالک انتخاب کنید؟')
            }
            else if($(this).attr('href').indexOf('remove') !== -1)
            {
                message.text('ایا می خواهید کاربر موردنظر را حذف کنید؟')
            }
            else if($(this).attr('href').indexOf('accept') !== -1 && $(this).hasClass('accept'))
            {
                message.text('ایا می خواهید کاربر موردنظر را به عنوان مشاور انتخاب کنید؟')
            }
            else if($(this).attr('href').indexOf('accept') !== -1 && !$(this).hasClass('accept'))
            {
                message.text('ایا می خواهید کاربر موردنظر را از لیست مشاوران تایید شده خارج کنید؟')
            }


            let closeBtn = $('<button>' , {
                class:"btn btn-success",
                type:"button",
                click: ()=> wrapper.remove(),
                text:'خیر'
            })

            let actionBtn = $('<a>' , {
                class:"btn btn-danger",
                text:'بله',
                href: $(this).attr('href')
            })

            wrapper.append(box)
            box.append(message)
            box.append(btnContainer)
            btnContainer.append(closeBtn)
            btnContainer.append(actionBtn)

            $('#selectBox').append(wrapper)
        }
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
                            <img src="{{asset('images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="lh-lg col-5 col-sm-7 col-xl-8 py-2">
                            <h4 class="mb-3 mb-sm-0">به بخش مشاوران خوش آمدید.</h4>
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
    <div class="row">
        <div class=" col-xl-6 col-sm-6 grid-margin stretch-card">
            <div @class(['card' , 'bg-secondary bg-gradient bg-opacity-50' => url()->full() !== route('business.consultants'),
                        'bg-primary bg-gradient bg-opacity-50' => url()->full() === route('business.consultants')])>
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
            <div  @class(['card' , 'bg-secondary bg-gradient bg-opacity-50' => url()->full() !== route('business.consultants',['type' => 'notAccepted']) ,
                            'bg-primary bg-gradient bg-opacity-50' => url()->full() === route('business.consultants',['type' => 'notAccepted'])])>
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
                                        <a class="text-success text-decoration-none" id="open_delete_panel_{{$key}}" href="{{ route('business.chooseOwner', ['user' => $member->id]) }}"><i class="mdi mdi-crown"></i></a>
                                    </td>
                                    <td>
                                        <a class="text-danger text-decoration-none" id="open_delete_panel_{{$key}}" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}" ><i class="mdi mdi-account-off"></i></a>
                                    </td>
                                    @else
                                        <td>
                                            <a class="text-success text-decoration-none accept" id="open_delete_panel_{{$key}}" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}"><i class="mdi mdi-account-check"></i></a>
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
