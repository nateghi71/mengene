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
                        @php if($customer->status){
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
                        @php if($customer->type == 'rahn'){
                                 echo 'رهن و اجاره';
                                 }
                                 else{
                                     echo 'فروشی';
                                 }
                        @endphp
                    </p>
                    <p> {{$customer->price}} :قیمت/رهن </p>
                    <p>
                        @php if($customer->type == 'rahn'){
                                 echo 'اجاره: ' . $customer->rent;
                                 }
                        @endphp
                    </p>
                    <p> {{$customer->size}} :متراژ </p>
                    <p> {{$customer->rooms}} :تعداد اتاق</p>
                    <p> آدرس: {{$customer->address}}  </p>
                    <p> {{$customer->expiry_date}} :تاریخ اعتبار </p>

                </div>
            </div>
            <p style="text-align: right"><a href="{{route('customers')}}">بازگشت</a></p>
        </div>
    </div>
</x-app-layout>
