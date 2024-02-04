<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center pe-4">
        <a class="navbar-brand brand-logo-mini text-decoration-none text-info" href="{{route('dashboard')}}">مِنگِنه</a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        {{--        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">--}}
        {{--          <span class="mdi mdi-menu"></span>--}}
        {{--        </button>--}}
        {{--        <ul class="navbar-nav w-100">--}}
        {{--            <li class="nav-item w-100">--}}
        {{--                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">--}}
        {{--                    <input type="text" class="form-control" placeholder="جست و جو">--}}
        {{--                </form>--}}
        {{--            </li>--}}
        {{--        </ul>--}}
        <ul class="navbar-nav w-100">
            @if(auth()->user()->ownedBusiness()->exists())
                @if(!auth()->user()->isFreeUser())
                <li class="nav-item w-75">
                    <div class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text p-2 bg-secondary w-75 bg-opacity-10 border-0 text-white">
                            اعتبار حساب:
                            <span id="wallet_amount" class="pe-3">{{number_format(auth()->user()->business()->wallet)}} تومان </span>
                            </span>
                            <a href="{{route('credits.index')}}" class="p-2 rounded-start bg-primary bg-gradient bg-opacity-50 text-white text-decoration-none">افزایش اعتبار</a>
                        </div>
                    </div>
                </li>
               @endif
            @endif
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn bg-primary bg-gradient bg-opacity-50 create-new-button" id="createbuttonDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false" href="#">ایجاد فایل جدید +</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="createbuttonDropdown">
                    <h6 class="p-3 mb-0 text-end">ایجاد فایل</h6>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('customer.create')}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-file-outline text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">ایجاد متقاضی</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('landowner.create')}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-file-outline text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">ایجاد مالک</p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown border-left">
                @php
                    $notifications = auth()->user()->notifications()->where('type' , \App\Notifications\ConsultantRequestNotification::class)->take(6)->get();
                @endphp

                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email"></i>
                    @if($notifications->count() > 0)
                        <span class="count bg-success"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="messageDropdown">
                    <h6 class="p-3 mb-0">پیام ها</h6>
                    <div class="dropdown-divider"></div>

                    @foreach($notifications as $notification)
                        <div class="dropdown-item preview-item">
                            <a href="{{route('business.notificationRead' , $notification->id)}}">
                                <div class="preview-thumbnail text-danger">
                                    <i class="mdi mdi-close"></i>
                                </div>
                            </a>
                            <div class="preview-item-content">
                                <p class="preview-subject  mb-1">{{$notification->data['message']}}</p>
                                <p class="text-muted mb-0"> {{verta($notification->created_at)}} </p>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>
                    @endforeach
                    @if($notifications->count() > 0)
                        <p class="p-3 mb-0 text-center">{{$notifications->count()}} درخواست جدید</p>
                    @endif
                </div>
            </li>
            <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                   data-bs-toggle="dropdown">
                    @php
                        $notifications = auth()->user()->notifications()->where('type' , \App\Notifications\ReminderForCustomerNotification::class)
                        ->orWhere('type' , \App\Notifications\ReminderForLandowerNotification::class)->take(6)->get();
                    @endphp

                    <i class="mdi mdi-bell"></i>
                    @if($notifications->count() > 0)
                        <span class="count bg-danger"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0">اطلاع ها</h6>
                    <div class="dropdown-divider"></div>

                    @foreach($notifications as $notification)
                        <div class="dropdown-item preview-item">
                            <a href="{{route('business.notificationRead' , $notification->id)}}">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-close"></i>
                                </div>
                            </a>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">{{$notification->data['message']}}</p>
                                <p class="text-muted mb-0"> {{verta($notification->created_at)}} </p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    @if($notifications->count() > 0)
                        <p class="p-3 mb-0 text-center">{{$notifications->count()}} درخواست جدید</p>
                    @endif
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle"
                             src="{{asset('Admin/assets/images/faces-clipart/pic-4.png')}}" alt="">
                        <p class="mb-0 d-none d-sm-block navbar-profile-name pe-2">{{auth()->user()->name}}</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="profileDropdown">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <div class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-logout text-danger"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <button type="submit" class="btn btn-link text-decoration-none w-100 text-white preview-subject mb-1">
                                    خروج
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
