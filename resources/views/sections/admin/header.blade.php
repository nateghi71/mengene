<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center pe-4">
        <a class="navbar-brand brand-logo-mini text-decoration-none text-info" href="{{route('dashboard')}}">مِنگِنه</a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle" src="{{asset('Admin/assets/images/faces-clipart/pic-4.png')}}" alt="">
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
                            <button type="submit" class="btn btn-link text-decoration-none w-100 text-white preview-subject mb-1">خروج</button>
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
