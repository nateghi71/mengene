@extends('layouts.dashboard' , ['showBanner' => true , 'sectionName' => 'یشنهادات'])

@section('title' , 'یشنهادات')

@section('scripts')
@endsection

@section('content')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div><h4 class="card-title">نمایش پیشنهادات برای : {{ $customer->name }}</h4></div>
                        <div><a href="{{route('customer.index')}}" class="btn btn-primary p-2">نمایش متقاضیان</a></div>
                    </div>
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
                                    <td><a href="{{route('landowner.show',$suggestion->id)}}">{{$suggestion->name}} </a></td>
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
