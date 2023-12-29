@extends('layouts.dashboard' , ['showBanner' => true , 'sectionName' => 'متقاضیان'])

@section('title' , 'متقاضیان')

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
                                    <h3 class="mb-0">ایجاد متقاضی ملک</h3>
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
                                    <h3 class="mb-0">تمام متقاضیان</h3>
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
                                    <h3 class="mb-0">متقاضی رهن</h3>
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
                                    <h3 class="mb-0">متقاضی خرید</h3>
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
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{$customer->id}}</td>
                                        <td><a class="text-decoration-none" href="{{route('customer.show',$customer->id)}}">{{$customer->name}} </a></td>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('customer.star',$customer->id)}}">{{$customer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$customer->number}}</td>
                                        <td>{{$customer->city}}</td>
                                        <td>
                                            @if($customer->type_sale == 'rahn')
                                                رهن و اجاره
                                            @else
                                                فروشی
                                            @endif
                                        </td>
                                        <td>{{$customer->selling_price ?? $customer->rahn_amount}}</td>
                                        <td>{{$customer->rent_amount}}</td>
                                        <td>{{$customer->scale}}</td>
                                        <td>{{$customer->number_of_rooms}}</td>
                                        <td>{{$customer->description}}</td>
                                        <td>{{$customer->daysLeft ?? 'منقضی'}} روز</td>
                                        <td><a class="badge badge-outline-success text-decoration-none" href="{{route('customer.suggestions',$customer->id)}}">پیشنهادات</a></td>
                                        <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('customer.edit',$customer->id)}}">ویرایش</a></td>
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
                                @foreach($icustomers as $icustomer)
                                    <tr>
                                        <td>{{$icustomer->id}}</td>
                                        <td><a class="text-decoration-none" href="{{route('customer.show',$icustomer->id)}}">{{$icustomer->name}} </a></td>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('customer.star',$icustomer->id)}}">{{$icustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$icustomer->number}}</td>
                                        <td>{{$icustomer->city}}</td>
                                        <td>
                                            @if($customer->type_sale == 'rahn')
                                                رهن و اجاره
                                            @else
                                                فروشی
                                            @endif
                                        </td>
                                        <td>{{$icustomer->selling_price ?? $icustomer->rahn_amount}}</td>
                                        <td>{{$icustomer->rent_amount}}</td>
                                        <td>{{$icustomer->scale}}</td>
                                        <td>{{$icustomer->number_of_rooms}}</td>
                                        <td>{{$icustomer->description}}</td>
                                        <td>{{$icustomer->daysLeft ?? 'منقضی'}}</td>

                                        <td>
                                            <form action="{{route('customer.destroy',$icustomer->id)}}" method="post">
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
                                @if($rentCustomers != null)
                                    @foreach($rentCustomers as $rentCustomer)
                                        <tr>
                                            <td>{{$rentCustomer->id}}</td>
                                            <td><a class="text-decoration-none" href="{{route('customer.show',$rentCustomer->id)}}">{{$rentCustomer->name}} </a></td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('customer.star',$rentCustomer->id)}}">{{$rentCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$rentCustomer->number}}</td>
                                            <td>{{$rentCustomer->city}}</td>
                                            <td>
                                                @if($rentCustomer->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$rentCustomer->selling_price ?? $rentCustomer->rahn_amount}}</td>
                                            <td>{{$rentCustomer->rent_amount}}</td>
                                            <td>{{$rentCustomer->scale}}</td>
                                            <td>{{$rentCustomer->number_of_rooms}}</td>
                                            <td>{{$rentCustomer->description}}</td>
                                            <td>{{$rentCustomer->daysLeft ?? 'منقضی'}} روز</td>
                                            <td><a class="badge badge-outline-success text-decoration-none" href="{{route('customer.suggestions',$rentCustomer->id)}}">پیشنهادات</a></td>
                                            <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('customer.edit',$rentCustomer->id)}}">ویرایش</a></td>
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
                                @if($rentiCustomers != null)
                                    @foreach($rentiCustomers as $rentiCustomer)
                                        <tr>
                                            <td>{{$rentiCustomer->id}}</td>
                                            <td><a class="text-decoration-none" href="{{route('customer.show',$rentiCustomer->id)}}">{{$rentiCustomer->name}} </a></td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('customer.star',$rentiCustomer->id)}}">{{$rentiCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$rentiCustomer->number}}</td>
                                            <td>{{$rentiCustomer->city}}</td>
                                            <td>
                                                @if($rentiCustomer->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$rentiCustomer->selling_price ?? $rentiCustomer->rahn_amount}}</td>
                                            <td>{{$rentiCustomer->rent_amount}}</td>
                                            <td>{{$rentiCustomer->scale}}</td>
                                            <td>{{$rentiCustomer->number_of_rooms}}</td>
                                            <td>{{$rentiCustomer->description}}</td>
                                            <td>{{$rentiCustomer->daysLeft ?? 'منقضی'}}</td>

                                            <td>
                                                <form action="{{route('customer.destroy',$rentiCustomer->id)}}" method="post">
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
                                @if($buyCustomers != null)
                                    @foreach($buyCustomers as $buyCustomer)
                                        <tr>
                                            <td>{{$buyCustomer->id}}</td>
                                            <td><a class="text-decoration-none" href="{{route('customer.show',$buyCustomer->id)}}">{{$buyCustomer->name}} </a></td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('customer.star',$buyCustomer->id)}}">{{$buyCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$buyCustomer->number}}</td>
                                            <td>{{$buyCustomer->city}}</td>
                                            <td>
                                                @if($buyCustomer->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$buyCustomer->selling_price ?? $buyCustomer->rahn_amount}}</td>
                                            <td>{{$buyCustomer->rent_amount}}</td>
                                            <td>{{$buyCustomer->scale}}</td>
                                            <td>{{$buyCustomer->number_of_rooms}}</td>
                                            <td>{{$buyCustomer->description}}</td>
                                            <td>{{$buyCustomer->daysLeft ?? 'منقضی'}} روز</td>
                                            <td><a class="badge badge-outline-success text-decoration-none" href="{{route('customer.suggestions',$buyCustomer->id)}}">پیشنهادات</a></td>
                                            <td><a class="badge badge-outline-danger text-decoration-none" href="{{route('customer.edit',$buyCustomer->id)}}">ویرایش</a></td>
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
                                    <th>کرایه</th>
                                    <th>متراژ</th>
                                    <th>تعداد اتاق</th>
                                    <th>توضیحات و آدرس</th>
                                    <th>تاریخ اعتبار</th>
                                    <th>حذف کامل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($buyiCustomers != null)
                                    @foreach($buyiCustomers as $buyiCustomer)
                                        <tr>
                                            <td>{{$buyiCustomer->id}}</td>
                                            <td><a class="text-decoration-none" href="{{route('customer.show',$buyiCustomer->id)}}">{{$buyiCustomer->name}} </a></td>
                                            <td>
                                                <a class="text-decoration-none" href="{{route('customer.star',$buyiCustomer->id)}}">{{$buyiCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                            </td>
                                            <td>{{$buyiCustomer->number}}</td>
                                            <td>{{$buyiCustomer->city}}</td>
                                            <td>
                                                @if($buyiCustomer->type_sale == 'rahn')
                                                    رهن و اجاره
                                                @else
                                                    فروشی
                                                @endif
                                            </td>
                                            <td>{{$buyiCustomer->selling_price ?? $buyiCustomer->rahn_amount}}</td>
                                            <td>{{$buyiCustomer->rent_amount}}</td>
                                            <td>{{$buyiCustomer->scale}}</td>
                                            <td>{{$buyiCustomer->number_of_rooms}}</td>
                                            <td>{{$buyiCustomer->description}}</td>
                                            <td>{{$buyiCustomer->daysLeft ?? 'منقضی'}}</td>

                                            <td>
                                                <form action="{{route('customer.destroy',$buyiCustomer->id)}}" method="post">
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
