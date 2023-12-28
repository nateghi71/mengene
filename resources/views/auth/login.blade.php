<!DOCTYPE html>
<html lang="fa" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ورود</title>
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
    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.png')}}" />
  </head>
  <body class="rtl">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">ورود</h3>
                <form action="{{route('login.handle')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="number">تلفن همراه</label>
                        <input type="text" name="number" class="form-control" id="number">
                    </div>
                    <div class="form-group">
                        <label for="password">رمز ورود</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                      <div class="form-check">
                          <label class="form-check-label">
                              <input type="checkbox" name="remember_me" class="form-check-input">مرا بخاطر بسپار
                          </label>
                      </div>
                      <a href="{{ route('password.request') }}" class="forgot-pass text-decoration-none">فراموشی پسورد</a>

                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ورود</button>
                  </div>
                  <p class="sign-up">ایا ثبت نام نکرده اید؟<a class="text-decoration-none" href="{{route('2fa.enter_number')}}"> ثبت نام</a></p>
                </form>
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
  </body>
</html>
