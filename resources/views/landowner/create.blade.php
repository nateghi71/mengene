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
                <div class="card row">
                    <div class="card-body px-5 py-4">
                        <div class="d-flex justify-content-between">
                            <div><h3 class="card-title mb-3">ایجاد مالک</h3></div>
                            <div><a href="{{route('landowner.index')}}" class="btn btn-primary p-2">نمایش مالکان</a></div>
                        </div>
                        <hr>

                        <form action="{{route('landowner.store')}}" method="post">
                            @csrf

                            <div class="row">
                                <div class="form-group d-flex align-items-center">
                                    <label class="col-sm-3">نوع:</label>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <label class="form-check-label" for="type_sale1">
                                                <input type="radio" class="form-check-input" name="type_sale" id="type_sale1" onclick="buyFunction()" value="buy" checked> خرید </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label" for="type_sale2">
                                                <input type="radio" class="form-check-input" name="type_sale" id="type_sale2" onclick="rahnFunction()" value="rahn"> رهن و اجاره </label>
                                        </div>
                                    </div>
                                </div>
                                @error('type_sale')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name"> نام:</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="نام">
                                    @error('name')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="number">شماره تماس:</label>
                                    <input type="text" name="number" class="form-control" value="{{old('number')}}" id="number" placeholder="شماره تماس">
                                    @error('number')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city">شهر:</label>
                                    <input type="text" name="city" class="form-control" value="{{old('city')}}" id="city" placeholder="شهر">
                                    @error('city')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type_work">نوع کار:</label>
                                    <select class="form-control" name="type_work" id="type_work">
                                        <option value="home">خانه</option>
                                        <option value="office">دفتر</option>
                                    </select>
                                    @error('type_work')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type_build">نوع ساختمان:</label>
                                    <select class="form-control" name="type_build" id="type_build">
                                        <option value="house">ویلایی</option>
                                        <option value="apartment">ساختمان</option>
                                    </select>
                                    @error('type_work')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div id="myDIV" class="form-group col-md-6" style="display: block">
                                    <label for="selling_price">قیمت:</label>
                                    <input type="text" name="selling_price" class="form-control" value="{{old('selling_price')}}" id="selling_price" placeholder="قیمت">
                                    @error('selling_price')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div id="meDIV1" class="form-group col-md-6" style="display: none">
                                    <label for="rahn_amount">رهن:</label>
                                    <input type="text" name="rahn_amount" class="form-control" value="{{old('rahn_amount')}}" id="rahn_amount" placeholder="رهن">
                                    @error('rahn_amount')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div id="meDIV2" class="form-group col-md-6" style="display: none">
                                    <label for="rent_amount">اجاره:</label>
                                    <input type="text" name="rent_amount" class="form-control" value="{{old('rent_amount')}}" id="rent_amount" placeholder="اجاره">
                                    @error('rent_amount')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city">متراژ:</label>
                                    <input type="text" name="scale" class="form-control" value="{{old('scale')}}" id="scale" placeholder="متراژ">
                                    @error('scale')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="number_of_rooms">تعداد اتاق:</label>
                                    <input type="text" name="number_of_rooms" class="form-control" value="{{old('number_of_rooms')}}" id="number_of_rooms" placeholder="تعداد اتاق">
                                    @error('number_of_rooms')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="floor_number">شماره طبقه:</label>
                                    <input type="text" name="floor_number" class="form-control" value="{{old('floor_number')}}" id="floor_number" placeholder="شماره طبقه">
                                    @error('floor_number')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="expire_date">تاریخ اعتبار:</label>
                                    <input type="date" name="expire_date" class="form-control" value="{{old('expire_date')}}" id="expire_date" placeholder="تاریخ اعتبار">
                                    @error('expire_date')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="elevator">اسانسور:</label>
                                    <select class="form-control" name="elevator" id="elevator">
                                        <option value="0">ندارد</option>
                                        <option value="1">دارد</option>
                                    </select>
                                    @error('elevator')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="parking">پارکینگ:</label>
                                    <select class="form-control" name="parking" id="parking">
                                        <option value="0">ندارد</option>
                                        <option value="1">دارد</option>
                                    </select>
                                    @error('parking')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="store">انبار:</label>
                                    <select class="form-control" name="store" id="store">
                                        <option value="0">ندارد</option>
                                        <option value="1">دارد</option>
                                    </select>
                                    @error('store')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="is_star">ستاره:</label>
                                    <select class="form-control" name="is_star" id="is_star">
                                        <option value="0">بدون ستاره</option>
                                        <option value="1">ستاره دار</option>
                                    </select>
                                    @error('is_star')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">توضیحات و آدرس:</label>
                                    <textarea name="description" class="form-control" id="description" placeholder="آدرس" rows="3">{{old('description')}}</textarea>
                                    @error('description')
                                    <div class="alert-danger">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="text-center pt-3">
                                    <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- content-wrapper ends -->
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
<script>
    myFunction();
    function buyFunction() {
        var x = document.getElementById("myDIV");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
        var y = document.getElementById("meDIV1");
        if (y.style.display === "block") {
            y.style.display = "none";
        }
        var z = document.getElementById("meDIV2");
        if (z.style.display === "block") {
            z.style.display = "none";
        }
    }

    function rahnFunction() {
        var x = document.getElementById("meDIV1");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
        var y = document.getElementById("meDIV2");
        if (y.style.display === "none") {
            y.style.display = "block";
        }
        var z = document.getElementById("myDIV");
        if (z.style.display === "block") {
            z.style.display = "none";
        }
    }

</script>

</body>
</html>
