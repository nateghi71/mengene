<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('مالک') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">

                    <p> نام: {{$landowner->name}}  </p>
                    <p>
                        <a href="{{route('landowner.status', $landowner->id)}}">وضعیت: </a>
                        @php if($landowner->status == 'active'){
                                 echo 'فعال';
                                 }
                                 else{
                                     echo 'غیرفعال';
                                 }
                        @endphp
                    </p>
                    <p> @php if($landowner->is_star){
                                        echo '*';
                                            } @endphp
                        <a href="{{route('landowner.star', $landowner->id)}}"> :ستاره</a>

                    </p>
                    <p> {{$landowner->number}} :شماره تماس </p>
                    <p> شهر: {{$landowner->city}}  </p>
                    <p> نوع:
                        @php if($landowner->type_sale == 'rahn'){
                                 echo 'رهن و اجاره';
                                 }
                                 else{
                                     echo 'فروشی';
                                 }
                        @endphp
                    </p>
                    <p> {{$landowner->selling_price ?? $landowner->rahn_amount}} :قیمت/رهن </p>
                    <p>
                        @php if($landowner->type_sale == 'rahn'){
                                 echo 'اجاره: ' . $landowner->rent_amount;
                                 }
                        @endphp
                    </p>
                    <p> {{$landowner->scale}} :متراژ </p>
                    <p> {{$landowner->number_of_rooms}} :تعداد اتاق</p>
                    <p> آدرس: {{$landowner->description}}  </p>
                    <p> {{$landowner->expire_date}} :تاریخ اعتبار </p>

                </div>
            </div>
            <p style="text-align: right"><a href="{{route('landowner.index')}}">بازگشت</a></p>
        </div>
    </div>
</x-app-layout>
