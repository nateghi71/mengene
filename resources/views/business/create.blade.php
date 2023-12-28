<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ایجاد املاکی</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset("Admin/assets/vendors/mdi/css/materialdesignicons.min.css")}}">
    <link rel="stylesheet" href="{{asset("Admin/assets/vendors/css/vendor.bundle.base.css")}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset("Admin/assets/css/style.css")}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset("Admin/assets/images/favicon.png")}}" />
</head>
<body class="rtl">
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                    <div class="card-body px-5 py-4">
                        <h3 class="card-title text-center mb-3">ایجاد املاکی</h3>
                        <form action="{{ route('business.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name"> نام املاکی: *</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="نام املاکی">
                                @error('name')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="en_name">نام انگلیسی: *</label>
                                <input type="text" name="en_name" class="form-control" value="{{old('en_name')}}" id="en_name" placeholder="نام انگلیسی">
                                @error('en_name')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="city">شهر:</label>
                                <input type="text" name="city" class="form-control" value="{{old('city')}}" id="city" placeholder="شهر">
                                @error('city')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="area">منطقه: *</label>
                                <input type="text" name="area" class="form-control" value="{{old('area')}}" id="area" placeholder="منطقه">
                                @error('area')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="address">آدرس: *</label>
                                <textarea name="address" class="form-control" id="address" placeholder="آدرس" rows="4">{{old('address')}}</textarea>
                                @error('address')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="image">عکس: *</label>
                                <input type="file" name="image" class="form-control" id="image" placeholder="عکس">
                                @error('image')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="text-center pt-3">
                                <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
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
<script src="{{asset("Admin/assets/vendors/js/vendor.bundle.base.js")}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset("Admin/assets/js/off-canvas.js")}}"></script>
<script src="{{asset("Admin/assets/js/hoverable-collapse.js")}}"></script>
<script src="{{asset("Admin/assets/js/misc.js")}}"></script>
<script src="{{asset("Admin/assets/js/settings.js")}}"></script>
<script src="{{asset("Admin/assets/js/todolist.js")}}"></script>
<!-- endinject -->
</body>
</html>
