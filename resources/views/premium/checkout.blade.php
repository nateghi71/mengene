@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'مالکان'])

@section('title' , 'مالکان')

@section('head')
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body m-0 p-0">
                    <h4 class="card-title me-5 my-4">
                        @if($order['order_type'] === 'buy_credit')
                            خرید شارژ حساب کاربری
                        @elseif($order['order_type'] === 'buy_package')
                            خرید پلن
                        @elseif($order['order_type'] === 'buy_file')
                            خرید فایل
                        @endif
                    </h4>
                    <div class="table-responsive d-flex justify-content-center pt-4">
                        <table class="table table-bordered w-50">
                            <thead>
                            <tr class="text-white">
                                <th> شرح خدمات</th>
                                <th> قیمت</th>
                            </tr>
                            </thead>
                            <tbody class="text-white">
                            @if($order['order_type'] === 'buy_credit')
                                <tr>
                                    <td>خرید شارژ حساب کاربری</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
                                </tr>
                                <tr class="">
                                    <td>مالیات</td>
                                    <td>{{number_format($order['tax'])}} تومان  </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($order['amount']+$order['tax'])}} تومان  </td>
                                </tr>
                            @elseif($order['order_type'] === 'buy_package')
                                <tr>
                                    <td>{{$order['level'] == 'midLevel' ? 'خرید پلن نقره ای' : 'خرید پلن طلایی'}}</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
                                </tr>
                                <tr class="">
                                    <td>مالیات</td>
                                    <td>{{number_format($order['tax'])}} تومان  </td>
                                </tr>
                                <tr>
                                    <td>کد تخفیف</td>
                                    <td>
                                        <form action="#" method="post">
                                            @csrf
                                                <div class="input-group">
                                                    <input type="text" name="code" id="code" class="form-control"
                                                           value="{{session()->has('coupon') ? session('coupon')['code'] : ''}}"/>
                                                    <button id="couponBtn" type="button" class="input-group-btn rounded-end-0 rounded-start btn btn-primary p-2">اعمال</button>
                                                </div>
                                                @error('code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </form>
                                    </td>
                                </tr>
                                <tr class="">
                                    <td>مقدار کوپن</td>
                                    <td>0 تومان </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($order['amount']+$order['tax'])}} تومان  </td>
                                </tr>
                            @elseif($order['order_type'] === 'buy_file')
                                <tr>
                                    <td>خرید فایل</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
                                </tr>
                                <tr class="">
                                    <td>مالیات</td>
                                    <td>{{number_format($order['tax'])}} تومان  </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($order['amount']+$order['tax'])}} تومان  </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <img width="200" referrerpolicy='origin' src='{{asset('upload/files/images/zarinpal.jpg')}}' alt='' style='cursor:pointer' Code='LHv5s5WTtkYcTeuJaMNnCGJP93eVMJvf'>
                        <p class="mt-4">پرداخت توسط کلیه کارت های عضو شبکه شتاب قابل انجام است</p>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3">
                        @if($order['order_type'] === 'buy_credit')
                            <form action="{{route('business.buy_credit')}}" method="post">
                                @csrf
                                <input type="hidden" name="amount" value="{{$order['amount']}}">
                                <button type="submit" class="btn btn-success fs-5 p-2">پرداخت انلاین<i class="mdi mdi-cart "></i> </button>
                                <a href="{{route('business.Increase_credit')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                            </form>
                        @elseif($order['order_type'] === 'buy_package')
                            <form action="{{route('packages.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="level" value="{{$order['level']}}">
                                <button type="submit" class="btn btn-success fs-5 p-2">پرداخت انلاین<i class="mdi mdi-cart "></i> </button>
                                <a href="{{route('packages.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                            </form>
                        @elseif($order['order_type'] === 'buy_file')
                            <form action="{{route('landowner.buyFile')}}" method="post">
                                @csrf
                                <input type="hidden" name="file_id" value="{{$order['file_id']}}">
                                <button type="submit" class="btn btn-success fs-5 p-2">پرداخت انلاین<i class="mdi mdi-cart "></i> </button>
                                <a href="{{route('landowner.subscription.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
