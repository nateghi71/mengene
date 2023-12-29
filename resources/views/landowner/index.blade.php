@extends('layouts.dashboard' , ['showBanner' => true , 'sectionName' => 'مالکان'])

@section('title' , 'مالکان')

@section('scripts')
    <script>
        function allFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }

        function rentFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "block") {
                x.style.display = "none";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "none") {
                y.style.display = "block";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }

        function buyFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "block") {
                x.style.display = "none";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "none") {
                z.style.display = "block";
            }
        }
    </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <a href="{{route('customer.create')}}" class="text-decoration-none text-white">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">ایجاد مالک جدید</h3>
                                    <p class="text-success ms-2 mb-0 font-weight-medium pe-3">+</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-account-search icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">اضافه کردن</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="#" onclick="allFunction()" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">تمام مالکان</h3>
                                    <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-info ">
                                    <span class="mdi mdi-account-search icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">دیدن</h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="#" onclick="rentFunction()" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">رهن دهندگان</h3>
                                    <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-info ">
                                    <span class="mdi mdi-bullhorn icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">دیدن</h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="#" onclick="buyFunction()" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">فروشندگان ملک</h3>
                                    <p class="text-info ms-2 mb-0 font-weight-medium pe-3">*</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-info">
                                    <span class="mdi mdi-bullhorn icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">دیدن</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div id="allDiv" style="display:block;">
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">لیست درخواست های فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>نام</th>
                                    <th>ستاره</th>
                                    <th>شماره تماس</th>
                                    <th>شهر</th>
                                    <th>نوع</th>
                                    <th>قیمت/رهن</th>
                                    <th>کرایه</th>
                                    <th>متراژ</th>
                                    <th>تعداد اتاق</th>
                                    <th>توضیحات و آدرس</th>
                                    <th>مدت اعتبار</th>
                                    <th>پیشنهادات</th>
                                    <th>ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($landowners as $landowner)
                                    <tr>
                                        <td>{{$landowner->id}}</td>
                                        <td><a class="text-decoration-none" href="{{route('landowner.show',$landowner->id)}}">{{$landowner->name}} </a></td>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('landowner.star',$landowner->id)}}">{{$landowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$landowner->number}}</td>
                                        <td>{{$landowner->city}}</td>
                                        <td>
                                            @if($landowner->type_sale == 'rahn')
                                                رهن و اجاره
                                            @else
                                                فروشی
                                            @endif
                                        </td>
                                        <td>{{$landowner->selling_price ?? $landowner->rahn_amount}}</td>
                                        <td>{{$landowner->rent_amount}}</td>
                                        <td>{{$landowner->scale}}</td>
                                        <td>{{$landowner->number_of_rooms}}</td>
                                        <td>{{$landowner->description}}</td>
                                        <td>{{$landowner->daysLeft ?? 'منقضی'}} روز</td>
                                        <td><a class="badge badge-outline-success text-decoration-none" href="{{route('landowner.suggestions',$landowner->id)}}">پیشنهادات</a></td>
                                        <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('landowner.edit',$landowner->id)}}">ویرایش</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">درخواست های غیر فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>نام</th>
                                    <th>ستاره</th>
                                    <th>شماره تماس</th>
                                    <th>شهر</th>
                                    <th>نوع</th>
                                    <th>قیمت</th>
                                    <th>کرایه</th>
                                    <th>متراژ</th>
                                    <th>تعداد اتاق</th>
                                    <th>توضیحات و آدرس</th>
                                    <th>تاریخ اعتبار</th>
                                    <th>حذف کامل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ilandowners as $ilandowner)
                                    <tr>
                                        <td>{{$ilandowner->id}}</td>
                                        <td><a class="text-decoration-none" href="{{route('landowner.show',$ilandowner->id)}}">{{$ilandowner->name}} </a></td>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('landowner.star',$ilandowner->id)}}">{{$ilandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$ilandowner->number}}</td>
                                        <td>{{$ilandowner->city}}</td>
                                        <td>
                                            @if($ilandowner->type_sale == 'rahn')
                                                رهن و اجاره
                                            @else
                                                فروشی
                                            @endif
                                        </td>
                                        <td>{{$ilandowner->selling_price ?? $ilandowner->rahn_amount}}</td>
                                        <td>{{$ilandowner->rent_amount}}</td>
                                        <td>{{$ilandowner->scale}}</td>
                                        <td>{{$ilandowner->number_of_rooms}}</td>
                                        <td>{{$ilandowner->description}}</td>
                                        <td>{{$ilandowner->daysLeft ?? 'منقضی'}}</td>

                                        <td>
                                            <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" type="submit">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="rentDiv" style="display: none">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">لیست درخواست های رهن فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> نام </th>
                                    <th> ستاره </th>
                                    <th> شماره تماس </th>
                                    <th> شهر </th>
                                    <th> نوع </th>
                                    <th> قیمت/رهن </th>
                                    <th> کرایه </th>
                                    <th> متراژ </th>
                                    <th> تعداد اتاق </th>
                                    <th> توضیحات و آدرس </th>
                                    <th> تاریخ اعتبار </th>
                                    <th> پیشنهادات </th>
                                    <th> ویرایش </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($rentLandowners != null)
                                    @foreach($rentLandowners as $rentLandowner)
                                        <tr>
                                            <td>{{$rentLandowner->id}}</td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.show',$rentLandowner->id)}}">{{$rentLandowner->name}} </a>
                                            </td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.star',$rentLandowner->id)}}">{{$rentLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$rentLandowner->number}}</td>
                                            <td>{{$rentLandowner->city}}</td>
                                            <td>
                                                @if($rentLandowner->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$rentLandowner->selling_price ?? $rentLandowner->rahn_amount}}</td>
                                            <td>{{$rentLandowner->rent_amount}}</td>
                                            <td>{{$rentLandowner->scale}}</td>
                                            <td>{{$rentLandowner->number_of_rooms}}</td>
                                            <td>{{$rentLandowner->description}}</td>
                                            <td>{{$rentLandowner->daysLeft ?? 'منقضی'}} روز</td>
                                            <td><a class="badge badge-outline-success text-decoration-none" href="{{route('landowner.suggestions',$rentLandowner->id)}}">پیشنهادات</a></td>
                                            <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('landowner.edit',$rentLandowner->id)}}">ویرایش</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">درخواست های رهن غیر فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>نام</th>
                                    <th>ستاره</th>
                                    <th>شماره تماس</th>
                                    <th>شهر</th>
                                    <th>نوع</th>
                                    <th>قیمت</th>
                                    <th>کرایه</th>
                                    <th>متراژ</th>
                                    <th>تعداد اتاق</th>
                                    <th>توضیحات و آدرس</th>
                                    <th>تاریخ اعتبار</th>
                                    <th>حذف کامل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($rentiLandowners != null)
                                    @foreach($rentiLandowners as $rentiLandowner)
                                        <tr>
                                            <td>{{$rentiLandowner->id}}</td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.show',$rentiLandowner->id)}}">{{$rentiLandowner->name}} </a>
                                            </td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.star',$rentiLandowner->id)}}">{{$rentiLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$rentiLandowner->number}}</td>
                                            <td>{{$rentiLandowner->city}}</td>
                                            <td>
                                                @if($rentiLandowner->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$rentiLandowner->selling_price ?? $rentiLandowner->rahn_amount}}</td>
                                            <td>{{$rentiLandowner->rent_amount}}</td>
                                            <td>{{$rentiLandowner->scale}}</td>
                                            <td>{{$rentiLandowner->number_of_rooms}}</td>
                                            <td>{{$rentiLandowner->description}}</td>
                                            <td>{{$rentiLandowner->daysLeft ?? 'منقضی'}}</td>

                                            <td>
                                                <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger" type="submit">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="buyDiv" style="display: none">
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">لیست درخواست های خرید فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> نام </th>
                                    <th> ستاره </th>
                                    <th> شماره تماس </th>
                                    <th> شهر </th>
                                    <th> نوع </th>
                                    <th> قیمت/رهن </th>
                                    <th> متراژ </th>
                                    <th> تعداد اتاق </th>
                                    <th> توضیحات و آدرس </th>
                                    <th> تاریخ اعتبار </th>
                                    <th> پیشنهادات </th>
                                    <th> ویرایش </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($buyLandowners != null)
                                    @foreach($buyLandowners as $buyLandowner)
                                        <tr>
                                            <td>{{$buyLandowner->id}}</td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.show',$buyLandowner->id)}}">{{$buyLandowner->name}} </a>
                                            </td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.star',$buyLandowner->id)}}">{{$buyLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$buyLandowner->number}}</td>
                                            <td>{{$buyLandowner->city}}</td>
                                            <td>
                                                @if($buyLandowner->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$buyLandowner->selling_price ?? $buyLandowner->rahn_amount}}</td>
                                            <td>{{$buyLandowner->scale}}</td>
                                            <td>{{$buyLandowner->number_of_rooms}}</td>
                                            <td>{{$buyLandowner->description}}</td>
                                            <td>{{$buyLandowner->daysLeft ?? 'منقضی'}} روز</td>
                                            <td><a class="badge badge-outline-success text-decoration-none" href="{{route('landowner.suggestions',$buyLandowner->id)}}">پیشنهادات</a></td>
                                            <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('landowner.edit',$buyLandowner->id)}}">ویرایش</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">درخواست های خرید غیر فعال</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>نام</th>
                                    <th>ستاره</th>
                                    <th>شماره تماس</th>
                                    <th>شهر</th>
                                    <th>نوع</th>
                                    <th>قیمت</th>
                                    <th>متراژ</th>
                                    <th>تعداد اتاق</th>
                                    <th>توضیحات و آدرس</th>
                                    <th>تاریخ اعتبار</th>
                                    <th>حذف کامل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($buyiLandowners != null)
                                    @foreach($buyiLandowners as $buyiLandowner)
                                        <tr>
                                            <td>{{$buyiLandowner->id}}</td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.show',$buyiLandowner->id)}}">{{$buyiLandowner->name}} </a>
                                            </td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('landowner.star',$buyiLandowner->id)}}">{{$buyiLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$buyiLandowner->number}}</td>
                                            <td>{{$buyiLandowner->city}}</td>
                                            <td>
                                                @if($buyiLandowner->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$buyiLandowner->selling_price ?? $buyiLandowner->rahn_amount}}</td>
                                            <td>{{$buyiLandowner->scale}}</td>
                                            <td>{{$buyiLandowner->number_of_rooms}}</td>
                                            <td>{{$buyiLandowner->description}}</td>
                                            <td>{{$buyiLandowner->daysLeft ?? 'منقضی'}}</td>

                                            <td>
                                                <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger" type="submit">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
