@extends('layouts.dashboard' , ['sectionName' => 'پیشنهادات'])

@section('title' , 'پیشنهادات')

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
                            <h4 class="mb-1 mb-sm-0">شما هم اکنون در بخش پیشنهادات هستید!</h4>
                            <p class="mb-0 font-weight-normal d-none d-sm-block">خوش امدید</p>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                        <span>
                          <a href="{{route('landowner.index',['status' => 'active'])}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش مالکان</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">نمایش پیشنهادات برای : {{ $landowner->name }}</h4>
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
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suggestions as $suggestion)
                                <tr>
                                    <td>{{$suggestion->id}}</td>
                                    <td><a href="{{route('customer.show',$suggestion->id)}}">{{$suggestion->name}} </a></td>
                                    <td>
                                        @if($suggestion->is_star)
                                            *
                                        @endif
                                    </td>
                                    <td>{{$suggestion->number}}</td>
                                    <td>{{$suggestion->city}}</td>
                                    <td>
                                        @if($suggestion->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            فروشی
                                        @endif
                                    </td>
                                    <td>{{$suggestion->selling_price ?? $suggestion->rahn_amount}}</td>
                                    <td>{{$suggestion->rent_amount}}</td>
                                    <td>{{$suggestion->scale}}</td>
                                    <td>{{$suggestion->number_of_rooms}}</td>
                                    <td>{{$suggestion->description}}</td>
                                    <td>{{$suggestion->daysLeft ?? 'منقضی'}}</td>
                                    <td>
                                        <form action="{{route('landowner.send_block_message')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="customer_id" value="{{$landowner->id}}">
                                            <input type="hidden" name="landowner_id" value="{{$suggestion->id}}">
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
@endsection
