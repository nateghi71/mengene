<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top pe-5">
        <img width="40" height="40" src="{{asset('Home/assets/img/icon_m.png')}}">
        <a class="sidebar-brand brand-logo text-decoration-none text-white" href="{{route('dashboard')}}">مِنگِنه</a>
        <a class="sidebar-brand brand-logo-mini text-decoration-none text-white" href="{{route('dashboard')}}">مِنگِنه</a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="{{asset('Admin/assets/images/faces-clipart/pic-4.png')}}" alt="">
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
            <span class="nav-link">{{$sectionName}}</span>
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
                    <li class="nav-item"> <a class="nav-link" href="{{route('customer.index' , ['type' => 'buy'])}}">نمایش متقاضیان خرید</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('customer.index' , ['type' => 'rahn'])}}">نمایش متقاضیان رهن</a></li>
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
                    <li class="nav-item"> <a class="nav-link" href="{{route('landowner.index' , ['type' => 'buy'])}}">نمایش مالکان فروشنده</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('landowner.index' , ['type' => 'rahn'])}}">نمایش مالکان رهن دهنده</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('landowner.create')}}"> ایجاد مالک</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#android" aria-expanded="false" aria-controls="android">
              <span class="menu-icon">
                <i class="mdi mdi-android"></i>
              </span>
                <span class="menu-title pe-2">دانلود اپلیکیشن</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="android">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="https://98diha.ir//wp-content/themes/ringtone/api/mengene.apk"> دانلود مستقیم اپلیکیشن </a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"> دانلود اپلیکیشن از بازار </a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
