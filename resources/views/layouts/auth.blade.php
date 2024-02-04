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
        .messageBox {
            position: fixed;
            padding: 20px;
            top: 15%;
            left: 50%;
            z-index: 999;
            background: rgba(0,0,0,1);
            transform: translate(-50%, -50%);
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
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            @if (session()->has('message'))
                <div class="bg-danger w-75 mx-auto d-flex justify-content-between messageBox" id="message">
                    {{session()->get('message')}}
                    <button type="button" class=" btn-close" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->

    <div id="preloader"></div>
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

<script>
    let preloader = $('#preloader');
    if (preloader) {
        console.log(preloader.get(0))
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

<!-- endinject -->
@yield('scripts')
</body>
</html>
