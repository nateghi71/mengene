@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'متقاضیان'])

@section('title' , 'متقاضیان')

@section('scripts')
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
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index')}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">همه متقاضیان</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['type' => 'buy'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">متقاضیان خرید</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['type' => 'rahn'])}}" class="text-decoration-none text-white">
                    <div class="card-body">
                        <div class="icon">
                            <span class="mdi mdi-account-search icon-item text-info"></span>
                            <div class="pe-3 d-flex align-items-center align-self-start text-info">
                                <h3 class="mb-0">متقاضیان رهن</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('customer.index',['type' => 'deActive'])}}" class="text-decoration-none text-white">
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
    <div class="row">
        @if($customers->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            @if($customers->pluck('status')->contains('غیرفعال'))
                                متقاضیان غیرفعال
                            @elseif($customers->pluck('type_sale')->contains('خرید') && $customers->pluck('type_sale')->contains('رهن و اجاره'))
                                همه متقاضیان
                            @elseif($customers->pluck('type_sale')->contains('رهن و اجاره'))
                                متقاضیان رهن و اجاره
                            @else
                                متقاضیان خرید
                            @endif
                        </h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> شماره تماس </th>
                                    <th> نوع </th>
                                    <th>
                                        @if($customers->pluck('status')->contains('غیرفعال') ||
                                            $customers->pluck('type_sale')->contains('خرید') && $customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            قیمت / رهن
                                        @elseif($customers->pluck('type_sale')->contains('رهن و اجاره'))
                                            رهن
                                        @else
                                            قیمت
                                        @endif

                                    </th>
                                    <th> متراژ </th>
                                    <th>زمان باقیمانده </th>
                                    <th> پیشنهادات </th>
                                    <th> نمایش </th>
                                    <th> ویرایش </th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $key => $customer)
                                    <tr>
                                        <td>
                                            <a class="text-decoration-none" href="{{route('customer.star',$customer->id)}}">{!!$customer->getRawOriginal('is_star') ?
                                                '<span class="mdi mdi-star fs-4 text-warning"></span>' : '<span class="mdi mdi-star-outline fs-4 text-warning"></span>'!!} </a>
                                        </td>
                                        <td>
                                            {{$customer->name}}
                                            @if($customer->getRawOriginal('status') == 'active')
                                                <span class="mdi mdi-checkbox-blank-circle text-success"></span>
                                            @elseif($customer->getRawOriginal('status') == 'unknown')
                                                <span class="mdi mdi-checkbox-blank-circle" style="color:#FFA500;"></span>
                                            @else
                                                <span class="mdi mdi-checkbox-blank-circle text-danger"></span>
                                            @endif
                                        </td>
                                        <td>{{$customer->number}}</td>
                                        <td>{{$customer->type_sale}}</td>
                                        <td>{{$customer->getRawOriginal('selling_price') !== 0 ? $customer->selling_price : $customer->rahn_amount}}</td>
                                        <td>{{$customer->scale}}</td>
                                        <td>{{$customer->daysLeft ? $customer->daysLeft . ' روز' : 'منقضی'}} </td>
                                        <td><a class="btn text-decoration-none" href="{{route('customer.suggestions',$customer->id)}}"><i class="mdi mdi-format-list-bulleted"></i></a></td>
                                        <td><a class="btn text-decoration-none" href="{{route('customer.show',$customer->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td><a class="btn text-decoration-none" href="{{route('customer.edit',$customer->id)}}"><i class="mdi mdi-autorenew"></i></a></td>
                                        <td>
                                            <form action="{{route('customer.destroy',$customer->id)}}" method="post">
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
        @else
            <div class="d-flex justify-content-center">
                <p>متقاضی وجود ندارد.</p>
            </div>
        @endif

    </div>

    {{$customers->links()}}
@endsection
