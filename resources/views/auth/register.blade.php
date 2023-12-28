<!DOCTYPE html>
<html lang="fa" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ثبت نام</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="Admin/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="Admin/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="Admin/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="Admin/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-4">
                <h3 class="card-title text-center mb-3">ثبت نام</h3>
                <form action="{{ route('register.handle') }}" method="post" class="text-right">
                    @csrf
                    <div class="form-group">
                        <label for="name"> نام *</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="نام">
                    </div>
                    <div class="form-group">
                        <label for="city">شهر *</label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="شهر">
                    </div>
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="ایمیل">
                    </div>
                    <div class="form-group">
                        <label for="password">رمز ورود *</label>
                        <input type="text" name="password" class="form-control" id="password" placeholder="رمز ورود">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تکرار رمز ورود *</label>
                        <input type="text" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="تکرار رمز ورود">
                    </div>
                    <div class="form-group">
                        <label for="role">نقش *</label>
                        <select name="role" class="form-control" id="role">
                            <option value="1">املاکی</option>
                            <option value="0">مشاور</option>
                        </select>
                    </div>
                    <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ثبت نام</button>
                  </div>
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
    <script src="Admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="Admin/assets/js/off-canvas.js"></script>
    <script src="Admin/assets/js/hoverable-collapse.js"></script>
    <script src="Admin/assets/js/misc.js"></script>
    <script src="Admin/assets/js/settings.js"></script>
    <script src="Admin/assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
