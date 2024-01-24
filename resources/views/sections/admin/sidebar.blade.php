<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top pe-5">
        <img width="40" height="40" src="{{asset('Home/assets/img/icon_m.png')}}">
        <a class="sidebar-brand brand-logo text-decoration-none text-white" href="{{route('dashboard')}}">مِنگِنه</a>
        <a class="sidebar-brand brand-logo-mini text-decoration-none text-white"
           href="{{route('dashboard')}}">مِنگِنه</a>
    </div>
    <ul class="nav">
        <li class="nav-item nav-category">
            <span class="nav-link">{{$sectionName}}</span>
        </li>
        @can('viewIndex' , \App\Models\Business::class)
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{route('admin.business.index')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                    <span class="menu-title pe-2">املاکی ها</span>
                </a>
            </li>
        @endcan
        @can('adminViewIndex' , \App\Models\Landowner::class)
            <li class="nav-item menu-items">
                <a class="nav-link" data-bs-toggle="collapse" href="#files" aria-expanded="false" aria-controls="files">
              <span class="menu-icon">
                <i class="mdi mdi-account-search"></i>
              </span>
                    <span class="menu-title pe-2">فایل گذار</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="files">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.landowners.index')}}">نمایش فایل ها</a>
                        </li>
                        @can('adminCreate' , \App\Models\Landowner::class)
                            <li class="nav-item"><a class="nav-link" href="{{route('admin.landowners.create')}}">ایجاد
                                    فایل</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @can('viewIndex' , \App\Models\User::class)
            <li class="nav-item menu-items">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
              <span class="menu-icon">
                <i class="mdi mdi-account-search"></i>
              </span>
                    <span class="menu-title pe-2">کاربران</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">نمایش کاربران</a>
                        </li>
                        @can('viewIndex' , \App\Models\User::class)
                            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.create')}}">ایجاد
                                    کاربر</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @can('viewIndex' , \App\Models\Role::class)
            <li class="nav-item menu-items">
                <a class="nav-link" data-bs-toggle="collapse" href="#roles" aria-expanded="false" aria-controls="roles">
              <span class="menu-icon">
                <i class="mdi mdi-bullhorn"></i>
              </span>
                    <span class="menu-title pe-2">نقش ها</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="roles">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.roles.index')}}"> نمایش نقش
                                ها </a></li>
                        @can('viewIndex' , \App\Models\Role::class)
                            <li class="nav-item"><a class="nav-link" href="{{route('admin.roles.create')}}">ایجاد
                                    نقش</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
    </ul>
</nav>
