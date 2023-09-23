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
                        @php if($landowner->status){
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
                        @php if($landowner->type == 'rahn'){
                                 echo 'رهن و اجاره';
                                 }
                                 else{
                                     echo 'فروشی';
                                 }
                        @endphp
                    </p>
                    <p> {{$landowner->price}} :قیمت/رهن </p>
                    <p>
                        @php if($landowner->type == 'rahn'){
                                 echo 'اجاره: ' . $landowner->rent;
                                 }
                        @endphp
                    </p>
                    <p> {{$landowner->size}} :متراژ </p>
                    <p> {{$landowner->rooms}} :تعداد اتاق</p>
                    <p> آدرس: {{$landowner->address}}  </p>
                    <p> {{$landowner->expiry_date}} :تاریخ اعتبار </p>

                </div>
            </div>
            <p style="text-align: right"><a href="{{route('landowners')}}">بازگشت</a></p>
        </div>
    </div>
</x-app-layout>
