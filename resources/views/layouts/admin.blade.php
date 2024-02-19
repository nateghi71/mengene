<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    {{--            @vite(['resources/css/app.css', 'resources/js/dashboard.js'])--}}


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title' , 'mengene')</title>
    @vite(['resources/js/dashboard.js', 'resources/scss/dashboard.scss'])
    <!-- plugins:css -->
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">--}}
    <!-- endinject -->
    <!-- Plugin css for this page -->
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/owl-carousel-2/owl.carousel.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css')}}">--}}

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('Admin/assets/css/datePicker/persian-datepicker.css')}}"/>--}}
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Home/assets/img/icon_m.png')}}"/>
    <style>
        input, select, textarea {
            color: white !important;
        }

        textarea:focus, input:focus {
            color: white !important;
        }

        /*--------------------------------------------------------------
# Preloader
--------------------------------------------------------------*/
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 999;
            overflow: hidden;
            background: #000000;
        }

        #preloader:before {
            content: "";
            position: fixed;
            top: calc(50% - 30px);
            left: calc(50% - 30px);
            border: 6px solid #37517e;
            border-top-color: #fff;
            border-bottom-color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: animate-preloader 1s linear infinite;
        }

        @keyframes animate-preloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    @yield('head')
</head>
<body class="rtl">
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('sections.admin.sidebar' , ['sectionName' => $sectionName])
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('sections.admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if (session()->has('message'))
                    <div class="alert alert-success d-flex justify-content-between" id="message">
                        {{session()->get('message')}}
                        <button type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            @include('sections.admin.footer')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<div id="preloader"></div>
<!-- container-scroller -->
<!-- plugins:js -->
{{--<script src="{{asset('Admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>--}}
<!-- endinject -->

<!-- Plugin js for this page -->
{{--<script src="{{asset('Admin/assets/vendors/chart.js/Chart.min.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>--}}
<!-- End plugin js for this page -->
<!-- inject:js -->
{{--<script src="{{asset('Admin/assets/js/off-canvas.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/hoverable-collapse.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/misc.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/settings.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/todolist.js')}}"></script>--}}
<!-- endinject -->
<!-- Custom js for this page -->
{{--<script src="{{asset('Admin/assets/js/dashboard.js')}}"></script>--}}

{{--<script src="{{asset('Admin/assets/js/datePicker/persian-date.js')}}"></script>--}}
{{--<script src="{{asset('Admin/assets/js/datePicker/persian-datepicker.js')}}"></script>--}}

<script type="module">
    let preloader = $('#preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.remove()
        });
    }
    $('.btn-close').on('click' , function (){
        $('#message').remove()
    })
    setTimeout(function() {
        $('#message').remove();
    }, 10000);

</script>
<!-- End custom js for this page -->
@yield('scripts')
</body>
</html>
