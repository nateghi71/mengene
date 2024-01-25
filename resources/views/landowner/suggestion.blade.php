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
                          <a href="{{route('landowner.index')}}" class="btn btn-outline-light btn-rounded get-started-btn">نمایش مالکان</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        @if($suggestions->isNotEmpty())
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">نمایش پیشنهادات برای : {{ $landowner->name }}</h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>شماره تماس</th>
                                    <th>نوع</th>
                                    @if($suggestions->first()->getRawOriginal('type_sale') == 'buy')
                                        <th>قیمت</th>
                                    @elseif($suggestions->first()->getRawOriginal('type_sale') == 'rahn')
                                        <th>رهن</th>
                                        <th>کرایه</th>
                                    @endif
                                    <th>متراژ</th>
                                    <th>مدت زمان باقیمانده</th>
                                    <th>نمایش</th>
                                    <th>ارسال</th>
                                    <th>وضعیت</th>
                                </tr>
                                </thead>
                                <tbody class="text-white">
                                @foreach($suggestions as $key => $suggestion)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$suggestion->name}}</td>
                                        <td>{{$suggestion->number}}</td>
                                        <td>{{$suggestion->type_sale}}</td>
                                        @if($suggestion->getRawOriginal('type_sale') == 'buy')
                                            <td>{{$suggestion->selling_price}}</td>
                                        @elseif($suggestion->getRawOriginal('type_sale') == 'rahn')
                                            <td>{{$suggestion->rahn_amount}}</td>
                                            <td>{{$suggestion->rent_amount}}</td>
                                        @endif
                                        <td>{{$suggestion->scale}}</td>
                                        <td>{{$suggestion->daysLeft ?? 'منقضی'}}</td>
                                        <td><a class="text-white text-decoration-none" href="{{route('customer.show',$suggestion->id)}}"><i class="mdi mdi-eye"></i></a></td>
                                        <td>
                                            <form action="{{route('landowner.send_share_message')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="landowner_id" value="{{$landowner->id}}">
                                                <input type="hidden" name="customer_id" value="{{$suggestion->id}}">
                                                <button class="btn btn-link text-decoration-none text-white" type="submit"><i class="mdi mdi-email"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{route('landowner.send_block_message')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="landowner_id" value="{{$landowner->id}}">
                                                <input type="hidden" name="customer_id" value="{{$suggestion->id}}">
                                                <button class="btn btn-link text-decoration-none text-danger" type="submit"><i class="mdi mdi-delete"></i></button>
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
                <p>پیشنهادی وجود ندارد.</p>
            </div>
        @endif
    </div>
@endsection
