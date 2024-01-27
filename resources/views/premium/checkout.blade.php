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
                        @if($order['type_payment'] == 'buy_credit')
                            خرید شارژ حساب کاربری
                        @elseif($order['type_payment'] == 'buy_package')
                            خرید پلن
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
                            @if($order['type_payment'] == 'buy_credit')
                                <tr>
                                    <td>خرید شارژ حساب کاربری</td>
                                    <td>{{number_format($order['credit_amount'])}} تومان </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مبلغ پرداختی</td>
                                    <td>{{number_format($order['credit_amount'])}} تومان </td>
                                </tr>
                            @elseif($order['type_payment'] == 'buy_package')
                                <tr>
                                    <td>{{$order['level'] == 'midLevel' ? 'خرید پلن نقره ای' : 'خرید پلن طلایی'}}</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
                                </tr>
                                <tr>
                                    <td>کد تخفیف</td>
                                    <td>ندارد</td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مبلغ پرداختی</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
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
                        @if($order['type_payment'] == 'buy_credit')
                            <form action="" method="post">
                                @csrf
                                <button type="button" class="btn btn-success fs-5 p-2">پرداخت انلاین<i class="mdi mdi-cart "></i> </button>
                                <a href="{{route('business.Increase_credit')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-keyboard-backspace"></i> بازگشت</a>
                            </form>
                        @elseif($order['type_payment'] == 'buy_package')
                            <form action="{{route('packages.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="level" value="{{$order['level']}}">
                                <button type="submit" class="btn btn-success fs-5 p-2">پرداخت انلاین<i class="mdi mdi-cart "></i> </button>
                                <a href="{{route('packages.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-keyboard-backspace"></i> بازگشت</a>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
