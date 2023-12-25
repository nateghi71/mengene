<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('پیشنهادات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">

                    <table style="border: 2px black solid; width: 100%; text-align: center">
                        <tr style="border:1px black solid">
                            <th>ID</th>
                            <th>نام</th>
                            <th>ستاره</th>
                            <th>شماره تماس</th>
                            <th>شهر</th>
                            <th>نوع</th>
                            <th>قیمت/رهن</th>
                            <th>کرایه</th>
                            <th>متراژ</th>
                            <th>تعداد اتاق</th>
                            <th>توضیحات و آدرس</th>
                            <th>مدت اعتبار</th>
                            <th>وضعیت</th>
                        </tr>

                        @foreach($suggestions as $suggestion)
                            <tr>
                                <td>{{$suggestion->id}}</td>
                                <td><a href="{{route('landowner.show',$suggestion->id)}}">{{$suggestion->name}} </a></td>
                                <td>@php if($suggestion->is_star){
                                        echo '*';
                                            } @endphp
                                </td>
                                <td>{{$suggestion->number}}</td>
                                <td>{{$suggestion->city}}</td>
                                <td>@php if($suggestion->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                </td>
                                <td>{{$suggestion->selling_price ?? $suggestion->rahn_amount}}</td>
                                <td>{{$suggestion->rent_amount}}</td>
                                <td>{{$suggestion->scale}}</td>
                                <td>{{$suggestion->number_of_rooms}}</td>
                                <td>{{$suggestion->description}}</td>
                                <td>{{$suggestion->expire_date}} روز</td>
                                <td>
                                    <form action="{{route('landowner.send_block_message')}}" method="post">
                                        @csrf landowner_id
                                        <input type="hidden" name="landowner_id" value="{{$landowner->id}}">
                                        <input type="hidden" name="customer_id" value="{{$suggestion->id}}">
                                        <button type="submit">حذف</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            <p style="text-align: right"><a href="{{route('customer.index')}}">بازگشت</a></p>
        </div>
    </div>
</x-app-layout>
