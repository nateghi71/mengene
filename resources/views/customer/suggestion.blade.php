@extends('layouts.dashboard' , ['sectionName' => 'یشنهادات'])

@section('title' , 'یشنهادات')

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
                          <a href="{{route('customer.index',['status' => 'active'])}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش متقاضیان</a>
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
                    <h4 class="card-title">نمایش پیشنهادات برای : {{ $customer->name }}</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>شماره تماس</th>
                                <th>نوع</th>
                                <th>قیمت</th>
                                <th>رهن</th>
                                <th>کرایه</th>
                                <th>متراژ</th>
                                <th>مدت اعتبار</th>
                                <th>نمایش</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suggestions as $key => $suggestion)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$suggestion->name}}</td>
                                    <td>{{$suggestion->number}}</td>
                                    <td>
                                        @if($suggestion->type_sale == 'rahn')
                                            رهن و اجاره
                                        @else
                                            فروشی
                                        @endif
                                    </td>
                                    <td>{{$suggestion->selling_price ?? '-'}}</td>
                                    <td>{{$suggestion->rahn_amount ?? '-'}}</td>
                                    <td>{{$suggestion->rent_amount ?? '-'}}</td>
                                    <td>{{$suggestion->scale}}</td>
                                    <td>{{$suggestion->daysLeft ?? 'منقضی'}}</td>
                                    <td><a class="btn btn-outline-info text-decoration-none" href="{{route('landowner.show',$suggestion->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                    <td>
                                        <form action="{{route('customer.send_block_message')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="customer_id" value="{{$customer->id}}">
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
