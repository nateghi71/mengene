@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'مالکان'])

@section('title' , 'مالکان')

@section('head')
@endsection

@section('scripts')
<script>
    wallet()
    function wallet()
    {
        if($('#wallet:checked'))
        {
            $('.wallet').show()
            $('.no_wallet').hide()
        }
    }
    zarinpal()
    function zarinpal()
    {
        if($('#zarinpal:checked'))
        {
            $('.wallet').hide()
            $('.no_wallet').show()
        }
    }

    $('#wallet').on('change' , wallet)
    $('#zarinpal').on('change' , zarinpal)
</script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body m-0 p-0">
                    <h4 class="card-title me-5 my-4">
                        خرید فایل
                    </h4>
                    <form action="{{route('payment.file')}}" method="post">
                    @csrf
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
                                    <td>خرید فایل</td>
                                    <td>{{number_format($landowner->filePrice->price)}} تومان </td>
                                </tr>
                                <tr>
                                    <td>مالیات بر ارزش افزوده 9 درصد</td>
                                    <td>{{number_format($landowner->tax)}} تومان  </td>
                                </tr>
                                <tr>
                                    <td>اعمال کیف پول</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                                       checked="checked" name="payment_method">
                                                <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="wallet" class="input-radio" type="radio" value="wallet"
                                                       name="payment_method">
                                                <label for="pay">کیف پول</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr  class="wallet">
                                    <td>مبلغ کیف پول بعد اعمال</td>
                                    <td>{{number_format($landowner->walletAfterUse)}} تومان  </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10 wallet">
                                    <td>مقدار پرداختی  بعد اعمال کیف پول</td>
                                    <td>{{number_format($landowner->paymentAfterWalletUse)}} تومان  </td>
                                </tr>
                                <tr class="bg-secondary bg-opacity-10 no_wallet">
                                    <td>مقدار پرداختی</td>
                                    <td>{{number_format($landowner->payment)}} تومان  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <img width="200" referrerpolicy='origin' src='{{asset('upload/files/images/zarinpal.jpg')}}' alt='' style='cursor:pointer' Code='LHv5s5WTtkYcTeuJaMNnCGJP93eVMJvf'>
                        <p class="mt-4">پرداخت توسط کلیه کارت های عضو شبکه شتاب قابل انجام است</p>
                    </div>
                        <input type="hidden" name="file_id" value="{{$landowner->id}}">
                            <div class="bg-secondary bg-opacity-10 p-3">
                            <button type="submit" class="btn btn-success fs-5 p-2">پرداخت<i class="mdi mdi-cart "></i> </button>
                            <a href="{{route('landowner.subscription.index')}}" class="btn btn-primary fs-5 p-2"><i class="mdi mdi-arrow-right"></i> بازگشت</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
