<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>یافتن املاکی</title>
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
                        <table class="table text-right">
                            <thead>
                            <tr>
                                <td>نام</td>
                                <td>{{$business->name}}</td>
                            </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>شهر</td>
                                    <td>{{$business->city}}</td>
                                </tr>
                                <tr>
                                    <td>ادرس</td>
                                    <td>{{$business->address}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <form action="{{ route('consultant.join') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" value="{{ $business->id}}">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary w-100 enter-btn">پیوستن</button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                            </tbody>
                            </table>

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
