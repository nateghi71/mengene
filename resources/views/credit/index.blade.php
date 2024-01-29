@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'مالکان'])

@section('title' , 'مالکان')

@section('head')
@endsection

@section('scripts')
    <script>
        function separateNum(input) {
            var nStr = input.value + '';
            nStr = nStr.replace(/\,/g, "");
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        $('#credit_amount').on('keyup' , function (){
            if($(this).val() !== '')
            {
                $('#credit_amount_all').text(separateNum(this) + ' تومان ')
            }
            else
            {
                $('#credit_amount_all').text('')
            }
        })
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body m-0 p-0">
                    <h4 class="card-title me-5 my-4">شارژ حساب کاربری</h4>
                    <form action="{{route('credits.checkout')}}" method="post" class="pt-4">
                        @csrf
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <label for="staticEmail" class="ms-5">مبلغ:</label>
                            <div class="w-50">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="credit_amount" name="amount"
                                           onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                                    <span class="input-group-text bg-secondary rounded-start rounded-end-0 border-0" id="inputGroup-sizing-default">تومان</span>
                                </div>
                                @error('amount')
                                <div class="alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-5">
                            <label for="staticEmail" class="ms-5">مبلغ کل:</label>
                            <div class="w-50">
                                <span id="credit_amount_all" class="badge badge-success fs-6"></span>
                            </div>
                        </div>
                        <div class="bg-secondary bg-opacity-10 p-3">
                            <button type="submit" class="btn btn-success fs-5 p-2">ادامه<i class="mdi mdi-cart mث-3"></i> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
