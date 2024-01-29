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
                        خرید شارژ حساب کاربری
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
                                <tr>
                                    <td>خرید شارژ حساب کاربری</td>
                                    <td>{{number_format($order['amount'])}} تومان </td>
                                </tr>
                                <tr class="">
                                    <td>مالیات بر ارزش افزوده 9 درصد</td>
                                    <td>{{number_format($order['tax'])}} تومان  </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($order['payment'])}} تومان  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <img width="200" referrerpolicy='origin' src='{{asset('upload/files/images/zarinpal.jpg')}}' alt='' style='cursor:pointer' Code='LHv5s5WTtkYcTeuJaMNnCGJP93eVMJvf'>
                        <p class="mt-4">پرداخت توسط کلیه کارت های عضو شبکه شتاب قابل انجام است</p>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3">
                        <form action="{{route('payment.credit')}}" method="post">
                            @csrf
                            <input type="hidden" name="amount" value="{{$order['amount']}}">
                            <button type="submit" class="btn btn-success fs-5 p-2">پرداخت<i class="mdi mdi-cart "></i> </button>
                            <a href="{{route('credits.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
