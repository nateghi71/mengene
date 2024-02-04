@extends('layouts.admin' , ['sectionName' => 'نمایش سفارش'])

@section('title' , 'نمایش سفارش')

@section('head')
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="row ">
        <div class="col-md-6 grid-margin mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div><h3 class="card-title mb-3">نمایش اطلاعات</h3></div>
                        <div><a href="{{route('admin.orders.index')}}" class="btn btn-primary p-2">نمایش سفارش ها</a></div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                            <tr class="text-white">
                                <td>کاربر</td>
                                <td>{{$order->user->name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>املاکی</td>
                                <td>{{$order->business->name}}</td>
                            </tr>
                            @if($order->coupon !== null)
                                <tr class="text-white">
                                <td>کوپن</td>
                                <td>{{$order->coupon->name}}</td>
                            </tr>
                            @endif

                            <tr class="text-white">
                                <td>قیمت محصول</td>
                                <td>{{$order->amount}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>مبلغ مالیات</td>
                                <td>{{$order->tax_amount}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>مبلغ کوپن</td>
                                <td>{{$order->coupon_amount}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>مبلغ پرداختی</td>
                                <td>{{$order->paying_amount}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شیوه پرداخت</td>
                                <td>{{$order->payment_type}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>نوع سفارش</td>
                                <td>{{$order->order_type}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>وضعیت پرداخت</td>
                                <td>{{$order->payment_status}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>استفاده از کیف پول</td>
                                <td>{{$order->use_wallet}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>شماره ارجاع</td>
                                <td>{{$order->ref_id}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>توکن</td>
                                <td>{{$order->token}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>درگاه پرداخت</td>
                                <td>{{$order->gateway_name}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>توضیحات</td>
                                <td>{{$order->description}}</td>
                            </tr>
                            <tr class="text-white">
                                <td>زمان ایجاد</td>
                                <td>{{verta($order->created_at)->format('Y-m-d')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
