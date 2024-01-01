<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title' , 'mengene')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Home/assets/img/icon_m.png')}}" />
    <style>
        input, select, textarea{
            color: white !important;
        }

        textarea:focus, input:focus {
            color: white !important;
        }
    </style>

</head>
<body class="rtl">
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                    <div class="card-body px-5 py-5">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('Admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('Admin/assets/js/off-canvas.js')}}"></script>
<script src="{{asset('Admin/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('Admin/assets/js/misc.js')}}"></script>
<script src="{{asset('Admin/assets/js/settings.js')}}"></script>
<script src="{{asset('Admin/assets/js/todolist.js')}}"></script>
<!-- endinject -->
@yield('scripts')
</body>
</html>
