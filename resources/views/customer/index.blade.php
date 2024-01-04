@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'متقاضیان'])

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
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش متقاضیان هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('customer.create')}}" class="btn btn-outline-light btn-rounded get-started-btn">ایجاد متقاضی</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['status' => 'active'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">متقاضیان فعال</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['status' => 'unknown'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">متقاضیان نامعلوم</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['status' => 'deActive'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">متقاضیان غیرفعال</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row " id="buy">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">لیست درخواست های خرید</h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> ستاره </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> نوع </th>
                                <th> قیمت </th>
                                <th> متراژ </th>
                                <th>زمان باقیمانده </th>
                                <th> پیشنهادات </th>
                                <th> نمایش </th>
                                <th> ویرایش </th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyCustomers as $key => $buyCustomer)
                                <tr>
                                    <td>{{$buyCustomers->firstItem() + $key}}</td>
                                    <td>
                                        <a class="text-decoration-none" href="{{route('customer.star',$buyCustomer->id)}}">{!!$buyCustomer->is_star ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                    </td>
                                    <td>{{$buyCustomer->name}}</td>
                                    <td>{{$buyCustomer->number}}</td>
                                    <td>
                                        @if($buyCustomer->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            خرید
                                        @endif
                                    </td>
                                    <td>{{$buyCustomer->selling_price}}</td>
                                    <td>{{$buyCustomer->scale}}</td>
                                    <td>{{$buyCustomer->daysLeft ? $buyCustomer->daysLeft . ' روز' : 'منقضی'}} </td>
                                    <td><a class="btn btn-outline-success text-decoration-none" href="{{route('customer.suggestions',$buyCustomer->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                    <td><a class="btn btn-outline-info  text-decoration-none" href="{{route('customer.show',$buyCustomer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                    <td><a class="btn btn-outline-warning text-decoration-none" href="{{route('customer.edit',$buyCustomer->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                    <td>
                                        <form action="{{route('customer.destroy',$buyCustomer->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit"><i class="mdi mdi-delete"></i></button>
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

    {{$buyCustomers->links()}}

    <div class="row" id="rahn">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">لیست درخواست های رهن</h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> ستاره </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> نوع </th>
                                <th> رهن </th>
                                <th> کرایه </th>
                                <th> متراژ </th>
                                <th>زمان باقیمانده </th>
                                <th> پیشنهادات </th>
                                <th> نمایش </th>
                                <th> ویرایش </th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rahnCustomers as $key => $rahnCustomer)
                                <tr>
                                    <td>{{$rahnCustomers->firstItem() + $key}}</td>
                                    <td>
                                        <a class="text-decoration-none" href="{{route('customer.star',$rahnCustomer->id)}}">{!!$rahnCustomer->is_star ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                    </td>
                                    <td>{{$rahnCustomer->name}}</td>
                                    <td>{{$rahnCustomer->number}}</td>
                                    <td>
                                        @if($rahnCustomer->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            خرید
                                        @endif
                                    </td>
                                    <td>{{$rahnCustomer->rahn_amount}}</td>
                                    <td>{{$rahnCustomer->rent_amount}}</td>
                                    <td>{{$rahnCustomer->scale}}</td>
                                    <td>{{$rahnCustomer->daysLeft  ? $rahnCustomer->daysLeft . ' روز'  : 'منقضی'}} </td>
                                    <td><a class="btn btn-outline-success text-decoration-none" href="{{route('customer.suggestions',$rahnCustomer->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                    <td><a class="btn btn-outline-info  text-decoration-none" href="{{route('customer.show',$rahnCustomer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                    <td><a class="btn btn-outline-warning text-decoration-none" href="{{route('customer.edit',$rahnCustomer->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                    <td>
                                        <form action="{{route('customer.destroy',$rahnCustomer->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit"><i class="mdi mdi-delete"></i></button>
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

    {{$rahnCustomers->links()}}
@endsection
