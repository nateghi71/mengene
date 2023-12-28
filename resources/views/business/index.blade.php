<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/owl-carousel-2/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.png')}}" />
  </head>
  <body class="rtl">
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top pe-5">
          <a class="sidebar-brand brand-logo text-decoration-none text-info" href="{{route('dashboard')}}">منگنه</a>
          <a class="sidebar-brand brand-logo-mini text-decoration-none text-info" href="{{route('dashboard')}}">منگنه</a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle" src="{{asset('Admin/assets/images/faces/face15.jpg')}}" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">{{auth()->user()->name}}</h5>
                  <span>کاربر</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">داشبورد</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{route('dashboard')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title pe-2">داشبورد</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-account-search"></i>
              </span>
              <span class="menu-title pe-2">متقاضیان ملک</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('customer.index')}}">نمایش متقاضیان</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('customer.create')}}">ایجاد متقاضی</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-bullhorn"></i>
              </span>
              <span class="menu-title pe-2">صاحبان ملک</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('landowner.index')}}"> نمایش مالکان </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('landowner.create')}}"> ایجاد مالک</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center pe-4">
            <a class="navbar-brand brand-logo-mini text-decoration-none text-info" href="{{route('dashboard')}}">منگنه</a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
{{--            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">--}}
{{--              <span class="mdi mdi-menu"></span>--}}
{{--            </button>--}}
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input type="text" class="form-control" placeholder="جست و جو">
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">ایجاد فایل جدید +</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
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
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">ایجاد مالک</p>
                    </div>
                  </a>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{asset('Admin/assets/images/faces/face4.jpg')}}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{asset('Admin/assets/images/faces/face2.jpg')}}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="{{asset('Admin/assets/images/faces/face3.jpg')}}" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Event today</p>
                      <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                      <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-link-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Launch Admin</p>
                      <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all notifications</p>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="{{asset('Admin/assets/images/faces/face15.jpg')}}" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name pe-2">{{auth()->user()->name}}</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <form action="{{route('logout')}}" method="post" class="dropdown-item preview-item">
                      @csrf
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <button type="submit" class="btn btn-link text-decoration-none text-white preview-subject mb-1">خروج</button>
                    </div>
                  </form>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">شما هم اکنون در داشبورد هستید!</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                      </div>
                      <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <span class="btn btn-outline-light btn-rounded get-started-btn">خوش امدید</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="row">
                  <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-9">
                                      <a href="{{route('customer.index')}}" class="text-decoration-none text-white">
                                          <div class="d-flex align-items-center align-self-start">
                                              <h3 class="mb-0">نمایش متقاضیان</h3>
                                              <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                          </div>
                                      </a>
                                  </div>
                                  <div class="col-3">
                                      <div class="icon icon-box-info ">
                                          <span class="mdi mdi-account-search icon-item"></span>
                                      </div>
                                  </div>
                              </div>
                              <h6 class="text-muted font-weight-normal">دیدن</h6>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-9">
                                      <a href="{{route('landowner.index')}}" class="text-decoration-none text-white">
                                          <div class="d-flex align-items-center align-self-start">
                                              <h3 class="mb-0">نمایش مالکان</h3>
                                              <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                          </div>
                                      </a>
                                  </div>
                                  <div class="col-3">
                                      <div class="icon icon-box-info ">
                                          <span class="mdi mdi-account-search icon-item"></span>
                                      </div>
                                  </div>
                              </div>
                              <h6 class="text-muted font-weight-normal">دیدن</h6>
                          </div>
                      </div>
                  </div>
              </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">تعداد فایل ها</h4>
                    <canvas id="transaction-history" class="transaction-chart"></canvas>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1">تعداد متقاضیان</h6>
                        <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                      </div>
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0">30</h6>
                      </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1">تعداد مالکان</h6>
                        <p class="text-muted mb-0">{{\Carbon\Carbon::now()}}</p>
                      </div>
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0">20</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">مشخصات املاکی</h4>
                      <p class="text-muted mb-1">اطلاعات</p>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-primary">
                                <i class="mdi mdi-file-document"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">نام املاکی :</h6>
                                <p class="text-muted mb-0">مالک</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                <p class="text-white">{{$business->name}}</p>
                                <p class="text-muted mb-0">{{$business->owner->name}}</p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-success">
                                <i class="mdi mdi-cloud-download"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">شهر :</h6>
                                <p class="text-muted mb-0">منطقه</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                <p class="text-white">{{$business->city}}</p>
                                <p class="text-muted mb-0">{{$business->area}}</p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-info">
                                <i class="mdi mdi-clock"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">ادرس :</h6>
                                <p class="text-muted mb-0">تلفن</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                <p class="text-">{{$business->address}}</p>
                                <p class="text-muted mb-0">{{$user->number}}</p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-danger">
                                <i class="mdi mdi-email-open"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">ویرایش</h6>
                                <p class="text-muted mb-0">اخرین بروزرسانی</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                <p class="text-white">
                                    <a href="{{route('business.edit',['business'=>$business->id])}}" class="btn btn-outline-success" href="">
                                        ویرایش
                                    </a>
                                </p>
                                <p class="text-muted mb-0">{{$business->updated_at}} </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                <i class="mdi mdi-chart-pie"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject"> حذف املاکی</h6>
                                <p class="text-muted mb-0">توضیحات</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0 text-start">
                                <p class="text-white">
                                  <form action="{{route('business.destroy',['business'=>$business->id])}}" method="post">
                                      @csrf
                                      @method('DELETE')
                                      <button class="btn btn-outline-danger" type="submit">حذف</button>
                                  </form>
                                  </p>
                                <p class="text-muted mb-0">حذف املاکی</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="row">
                  <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-9">
                                      <a href="{{route('customer.create')}}" class="text-decoration-none text-white">
                                          <div class="d-flex align-items-center align-self-start">
                                              <h3 class="mb-0">متقاضی ملک</h3>
                                              <p class="text-success ms-2 mb-0 font-weight-medium pe-3">+</p>
                                          </div>
                                      </a>
                                  </div>
                                  <div class="col-3">
                                      <div class="icon icon-box-success ">
                                          <span class="mdi mdi-account-search icon-item"></span>
                                      </div>
                                  </div>
                              </div>
                              <h6 class="text-muted font-weight-normal">اضافه کردن</h6>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-9">
                                      <a href="{{route('landowner.create')}}" class="text-decoration-none text-white">
                                          <div class="d-flex align-items-center align-self-start">
                                              <h3 class="mb-0">فروشنده ملک</h3>
                                              <p class="text-success ms-2 mb-0 font-weight-medium pe-3">+</p>
                                          </div>
                                      </a>
                                  </div>
                                  <div class="col-3">
                                      <div class="icon icon-box-success">
                                          <span class="mdi mdi-bullhorn icon-item"></span>
                                      </div>
                                  </div>
                              </div>
                              <h6 class="text-muted font-weight-normal">اضافه کردن</h6>
                          </div>
                      </div>
                  </div>
              </div>
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">اعضای قبول شده</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> نام </th>
                            <th> شماره تماس </th>
                            <th> ایمیل </th>
                            <th> شهر </th>
                            <th> تعداد آگهی های ثبت کرده </th>
                            <th> غیرفعال کردن </th>
                            <th> انتخاب مالک </th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($acceptedMember as $member)
                              <tr>
                                <td>
                                  <span class="ps-2">{{$member->name}}</span>
                                </td>
                                <td> {{$member->number}} </td>
                                <td> {{$member->email}}</td>
                                <td> {{$member->city}} </td>
                                <td> {{$member->added}} </td>
                                <td>
                                    <a class="badge badge-outline-success text-decoration-none" href="{{ route('business.chooseOwner', ['user' => $member->id]) }}">انتخاب مالک</a>

                                </td>
                                <td>
                                  <a class="badge badge-outline-danger text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}" >غیرفعال</a>
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
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">اعضای قبول نشده</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> نام </th>
                            <th> شماره تماس </th>
                            <th> ایمیل </th>
                            <th> شهر </th>
                            <th> غیرفعال کردن </th>
                            <th> انتخاب مالک </th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($notAcceptedMember as $member)
                              <tr>
                                <td>
                                  <span class="ps-2">{{$member->name}}</span>
                                </td>
                                <td> {{$member->number}} </td>
                                <td> {{$member->email}}</td>
                                <td> {{$member->city}} </td>
                                <td>
                                    <a class="badge badge-outline-success text-decoration-none" href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}">قبول</a>
                                </td>
                                <td>
                                  <a class="badge badge-outline-danger text-decoration-none" href="href="{{route('business.remove.member',['user'=>$member->id])}}" >حذف</a>
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
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © nateghi 2024</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> hoosein nateghi from mashhad </span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('Admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('Admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('Admin/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('Admin/assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
    <script src="{{asset('Admin/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('Admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('Admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('Admin/assets/js/misc.js')}}"></script>
    <script src="{{asset('Admin/assets/js/settings.js')}}"></script>
    <script src="{{asset('Admin/assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('Admin/assets/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
  </body>
</html>
