<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('مشتری') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">

                    <p> نام: {{$customer->name}}  </p>
                    <p>
                        <a href="{{route('customer.status', $customer->id)}}">وضعیت: </a>
                        @php if($customer->status == 'active'){
                                 echo 'فعال';
                                 }
                                 else{
                                     echo 'غیرفعال';
                                 }
                        @endphp
                    </p>
                    <p> @php if($customer->is_star){
                                        echo '*';
                                            } @endphp
                        <a href="{{route('customer.star', $customer->id)}}"> :ستاره</a>

                    </p>
                    <p> {{$customer->number}} :شماره تماس </p>
                    <p> شهر: {{$customer->city}}  </p>
                    <p> نوع:
                        @php if($customer->type_sale == 'rahn'){
                                 echo 'رهن و اجاره';
                                 }
                                 else{
                                     echo 'فروشی';
                                 }
                        @endphp
                    </p>
                    <p> {{$customer->selling_price ?? $customer->rahn_amount}} :قیمت/رهن </p>
                    <p>
                        @php if($customer->type_sale == 'rahn'){
                                 echo 'اجاره: ' . $customer->rent_amount;
                                 }
                        @endphp
                    </p>
                    <p> {{$customer->scale}} :متراژ </p>
                    <p> {{$customer->number_of_rooms}} :تعداد اتاق</p>
                    <p> آدرس: {{$customer->description}}  </p>
                    <p> {{$customer->expire_date}} :تاریخ اعتبار </p>

                </div>
            </div>
            <p style="text-align: right"><a href="{{route('customer.index')}}">بازگشت</a></p>
        </div>
    </div>
</x-app-layout>
