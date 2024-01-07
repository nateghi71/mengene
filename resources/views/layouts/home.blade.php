<!-- =======================================================
    * Template Name: mengene
    * Updated: Aug 30 2023 with Bootstrap v5.3.1
    * Template URL: https://vearad.ir
    * Author: vearad.ir
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title' , 'mengene')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('Home/assets/img/icon_m.png')}}" rel="icon">
    <link href="{{asset('Home/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/glightbox/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('Home/assets/css/style.css') }}">

    @yield('head')
</head>

<body style="direction: rtl">

@include('sections.home.header')

@yield('content')

@include('sections.home.footer')
<div id="preloader"></div>
<a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"
><i class="mdi mdi-arrow-up-bold"></i
    ></a>

<!-- Vendor JS Files -->
<script src="{{asset('Home/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('Home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('Home/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('Home/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('Home/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('Home/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
<script src="{{asset('Home/assets/vendor/php-email-form/validate.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('Home/assets/js/main.js')}}"></script>
@yield('scripts')
</body>

</html>
