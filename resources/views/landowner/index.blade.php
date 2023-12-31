@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'مالکان'])

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
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="{{asset('Admin/assets/images/dashboard/Group126@2x.png')}}" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش مالکان هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('landowner.create')}}" class="btn btn-outline-light btn-rounded get-started-btn">ایجاد مالک</a>
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
                <a href="{{route('landowner.index',['status' => 'active'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">مالکان فعال</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('landowner.index',['status' => 'unknown'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">مالکان نامعلوم</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('landowner.index',['status' => 'deActive'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">مالکان غیرفعال</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row" id="buy">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">لیست درخواست های فروش</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> ستاره </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> نوع </th>
                                <th> متراژ </th>
                                <th>اعتبار </th>
                                <th> پیشنهادات </th>
                                <th> نمایش </th>
                                <th> ویرایش </th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyLandowners as $key => $buyLandowner)
                                <tr>
                                    <td>{{$buyLandowners->firstItem() + $key}}</td>
                                    <td>
                                        <a class="text-decoration-none" href="{{route('landowner.star',$buyLandowner->id)}}">{!!$buyLandowner->is_star ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                    </td>
                                    <td>{{$buyLandowner->name}}</td>
                                    <td>{{$buyLandowner->number}}</td>
                                    <td>
                                        @if($buyLandowner->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            فروشی
                                        @endif
                                    </td>
                                    <td>{{$buyLandowner->scale}}</td>
                                    <td>{{$buyLandowner->daysLeft ? $buyLandowner->daysLeft . ' روز' : 'منقضی'}}</td>
                                    <td><a class="btn btn-outline-success text-decoration-none" href="{{route('landowner.suggestions',$buyLandowner->id)}}">پیشنهادات</a></td>
                                    <td><a class="btn btn-outline-info text-decoration-none" href="{{route('landowner.show',$buyLandowner->id)}}">نمایش</a></td>
                                    <td><a class="btn btn-outline-warning text-decoration-none" href="{{route('landowner.edit',$buyLandowner->id)}}">ویرایش</a></td>
                                    <td>
                                        <form action="{{route('landowner.destroy',$buyLandowner->id)}}" method="post">
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
    {{$buyLandowners->links()}}
    <div class="row" id="rahn">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">لیست درخواست های رهن</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> ستاره </th>
                                <th> نام </th>
                                <th> شماره تماس </th>
                                <th> نوع </th>
                                <th> متراژ </th>
                                <th>اعتبار </th>
                                <th> پیشنهادات </th>
                                <th> نمایش </th>
                                <th> ویرایش </th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rahnLandowners as $key => $rahnLandowner)
                                <tr>
                                    <td>{{$rahnLandowners->firstItem() + $key}}</td>
                                    <td>
                                        <a class="text-decoration-none" href="{{route('landowner.star',$rahnLandowner->id)}}">{!!$rahnLandowner->is_star ? '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                    </td>
                                    <td>{{$rahnLandowner->name}}</td>
                                    <td>{{$rahnLandowner->number}}</td>
                                    <td>
                                        @if($rahnLandowner->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            فروشی
                                        @endif
                                    </td>
                                    <td>{{$rahnLandowner->scale}}</td>
                                    <td>{{$rahnLandowner->daysLeft ? $rahnLandowner->daysLeft . ' روز' : 'منقضی'}} </td>
                                    <td><a class="btn btn-outline-success text-decoration-none" href="{{route('landowner.suggestions',$rahnLandowner->id)}}">پیشنهادات</a></td>
                                    <td><a class="btn btn-outline-info text-decoration-none" href="{{route('landowner.show',$rahnLandowner->id)}}">نمایش</a></td>
                                    <td><a class="btn btn-outline-warning text-decoration-none" href="{{route('landowner.edit',$rahnLandowner->id)}}">ویرایش</a></td>
                                    <td>
                                        <form action="{{route('landowner.destroy',$rahnLandowner->id)}}" method="post">
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
    {{$rahnLandowners->links()}}
@endsection
