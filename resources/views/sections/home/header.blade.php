<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <h1 class="logo ">
            <img src="{{asset('Home/assets/img/icon_m.png')}}">
            <span class="text-white">مِنگِنه</span></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="dashboard.blade.php" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar px-4">
            <ul>
                <li><a class="nav-link scrollto" href="{{route('welcome').'#home'}}">خانه</a></li>
{{--                <li><a class="nav-link scrollto" href="{{route('login')}}">ورود</a></li>--}}
                <a class="nav-link scrollto" href="{{route('dashboard')}}">مدیریت</a>
                <li><a class="nav-link scrollto" href="{{route('landowner.public.index')}}" target="_blank">مالکان</a></li>
                <li><a class="nav-link scrollto" href="{{route('customer.public.index')}}" target="_blank">متقاضیان</a></li>
                <li><a class="nav-link scrollto" href="{{route('welcome').'#pricing'}}">تعرفه ها</a></li>
                <li><a class="nav-link scrollto" href="{{route('welcome').'#contact'}}">ارتباط با ما</a></li>
                {{--                <li><a class="nav-link scrollto" href="#footer">درباره ما</a></li>--}}
                <!-- <li><a class="nav-link scrollto" href="#team">Team</a></li> -->
                <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                  <li><a href="#">Drop Down 1</a></li>
                  <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                      <li><a href="#">Deep Drop Down 1</a></li>
                      <li><a href="#">Deep Drop Down 2</a></li>
                      <li><a href="#">Deep Drop Down 3</a></li>
                      <li><a href="#">Deep Drop Down 4</a></li>
                      <li><a href="#">Deep Drop Down 5</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Drop Down 2</a></li>
                  <li><a href="#">Drop Down 3</a></li>
                  <li><a href="#">Drop Down 4</a></li>
                </ul>
              </li> -->
                <!-- <li><a class="nav-link scrollto" href="#contact">Contact</a></li> -->
                <!-- <li><a class="getstarted scrollto" href="#about">ورود</a></li> -->
            </ul>
            <i class="mdi mdi-format-list-bulleted mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
</header>
<!-- End Header -->
