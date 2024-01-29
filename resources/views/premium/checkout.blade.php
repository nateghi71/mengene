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
                        خرید پلن
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
                                    <td>
                                        @if($package->name === 'bronze')
                                            خرید پلن برنزی
                                        @elseif($package->name === 'silver')
                                            خرید پلن نقره ای
                                        @elseif($package->name === 'golden')
                                            خرید پلن طلایی
                                        @endif
                                    </td>
                                    <td>{{number_format($package->price)}} تومان </td>
                                </tr>
                                <tr class="">
                                    <td>مالیات بر ارزش افزوده 9 درصد</td>
                                    <td>{{number_format($package->tax)}} تومان  </td>
                                </tr>
                                <tr class="">
                                    <td>شارژ حساب کاربری</td>
                                    <td>{{number_format($package->walletCharge)}} تومان  </td>
                                </tr>
                                <tr>
                                    <td>کد تخفیف</td>
                                    <td>
                                        <form action="{{route('coupon.apply')}}" method="post">
                                            @csrf
                                                <div class="input-group">
                                                    <input type="hidden" name="amount" value="{{$package->price}}">
                                                    <input type="text" name="code" id="code" class="form-control"
                                                           value="{{session()->has('coupon') ? session('coupon')['code'] : ''}}"/>
                                                    <button id="couponBtn" type="submit" class="input-group-btn rounded-end-0 rounded-start btn btn-primary p-2">اعمال</button>
                                                </div>
                                                @error('code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </form>
                                    </td>
                                </tr>
                                <tr class="">
                                    <td>مبلغ کد تخفیف</td>
                                    <td>
                                        {{$package->coupon_amount}} تومان
                                    </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($package->payment)}} تومان  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <img width="200" referrerpolicy='origin' src='{{asset('upload/files/images/zarinpal.jpg')}}' alt='' style='cursor:pointer' Code='LHv5s5WTtkYcTeuJaMNnCGJP93eVMJvf'>
                        <p class="mt-4">پرداخت توسط کلیه کارت های عضو شبکه شتاب قابل انجام است</p>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3">
                        <form action="{{route('payment.package')}}" method="post">
                            @csrf
                            <input type="hidden" name="package_name" value="{{$package->name}}">
                            <button type="submit" class="btn btn-success fs-5 p-2">پرداخت<i class="mdi mdi-cart "></i> </button>
                            <a href="{{route('packages.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
