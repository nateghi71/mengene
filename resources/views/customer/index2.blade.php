<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row">
            {{ __('مشتریان') }}
        </h2>
        <h3 style="text-align: right; margin: 10px">
            <span style="margin: 10px; cursor: pointer" onclick="allFunction()">همه مشتریان</span>
            <span style="margin: 10px; cursor: pointer" onclick="rentFunction()">رهن و اجاره</span>
            <span style="margin: 10px; cursor: pointer" onclick="buyFunction()">فروشی</span>
        </h3>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    <p><a href="{{route('customer.create')}}">ایجاد مشتری جدید</a></p>
                    <br>
                    <hr>
                    :لیست درخواست های فعال
                    <div id="allDiv" style="display:block;">
                        <p>
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
                                <th>پیشنهادات</th>
                                <th>ویرایش</th>
{{--                                <th>حذف کردن</th>--}}

                            </tr>

                            @foreach($customers as $customer)
{{--                                {{dd($customer->expire_date)}}--}}

                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td><a href="{{route('customer.show',$customer->id)}}">{{$customer->name}} </a></td>
                                    <td>
                                        <a href="{{route('customer.star',$customer->id)}}">{{$customer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                    </td>
                                    <td>{{$customer->number}}</td>
                                    <td>{{$customer->city}}</td>
                                    <td>@php if($customer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$customer->selling_price ?? $customer->rahn_amount}}</td>
                                    <td>{{$customer->rent_amount}}</td>
                                    <td>{{$customer->scale}}</td>
                                    <td>{{$customer->number_of_rooms}}</td>
                                    <td>{{$customer->description}}</td>
                                    <td>{{$customer->daysLeft ?? 0}} روز</td>
                                    <td><a href="{{route('customer.suggestions',$customer->id)}}">پیشنهادات</a></td>
                                    <td><a href="{{route('customer.edit',$customer->id)}}">ویرایش</a></td>
                                    {{--                                    <td><a href="{{route('customer.status',$customer->id)}}">حذف</a></td>--}}
                                </tr>
                            @endforeach
                        </table>

                        </p>
                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                        <p>
                            :درخواست های غیر فعال
                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>ID</th>
                                <th>نام</th>
                                <th>ستاره</th>
                                <th>شماره تماس</th>
                                <th>شهر</th>
                                <th>نوع</th>
                                <th>قیمت</th>
                                <th>کرایه</th>
                                <th>متراژ</th>
                                <th>تعداد اتاق</th>
                                <th>توضیحات و آدرس</th>
                                <th>تاریخ اعتبار</th>
                                <th>حذف کامل</th>
                            </tr>

                            @foreach($icustomers as $icustomer)
                                <tr>
                                    <td>{{$icustomer->id}}</td>
                                    <td><a href="{{route('customer.show',$icustomer->id)}}">{{$icustomer->name}} </a></td>
                                    <td>
                                        <a href="{{route('customer.star',$icustomer->id)}}">{{$icustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                    </td>
                                    <td>{{$icustomer->number}}</td>
                                    <td>{{$icustomer->city}}</td>
                                    <td>@php if($icustomer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$icustomer->selling_price ?? $icustomer->rahn_amount}}</td>
                                    <td>{{$icustomer->rent_amount}}</td>
                                    <td>{{$icustomer->scale}}</td>
                                    <td>{{$icustomer->number_of_rooms}}</td>
                                    <td>{{$icustomer->description}}</td>
                                    <td>{{$icustomer->daysLeft ?? 0}}</td>

                                    <td>
                                        <form action="{{route('customer.destroy',$icustomer->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">حذف</button>
                                        </form>
                                    </td>

                                </tr>
                                {{--                            {{dd($customer)}}--}}
                            @endforeach
                        </table>
                        </p>
                    </div>

                    <div id="rentDiv" style="display: none">
                        <p>
                        {{--                    {{dd($customers)}}--}}

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
                                <th>پیشنهادات</th>
                                <th>ویرایش</th>
                                {{--                                <th>حذف کردن</th>--}}
                            </tr>
                            @if($rentCustomers != null)
                                @foreach($rentCustomers as $rentCustomer)
                                    <tr>
                                        <td>{{$rentCustomer->id}}</td>
                                        <td>
                                            <a href="{{route('customer.show',$rentCustomer->id)}}">{{$rentCustomer->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('customer.star',$rentCustomer->id)}}">{{$rentCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$rentCustomer->number}}</td>
                                        <td>{{$rentCustomer->city}}</td>
                                        <td>@php if($rentCustomer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentCustomer->selling_price ?? $rentCustomer->rahn_amount}}</td>
                                        <td>{{$rentCustomer->rent_amount}}</td>
                                        <td>{{$rentCustomer->scale}}</td>
                                        <td>{{$rentCustomer->number_of_rooms}}</td>
                                        <td>{{$rentCustomer->description}}</td>
                                        <td>{{$rentCustomer->daysLeft ?? 0}} روز</td>
                                        <td><a href="{{route('customer.suggestions',$rentCustomer->id)}}">پیشنهادات</a></td>
                                        <td><a href="{{route('customer.edit',$rentCustomer->id)}}">ویرایش</a></td>

{{--                                        <td><a href="{{route('customer.status',$rentCustomer->id)}}">حذف</a></td>--}}
                                    </tr>
                                @endforeach
                            @endif
                        </table>

                        </p>
                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                        <p>
                            :درخواست های غیر فعال
                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>ID</th>
                                <th>نام</th>
                                <th>ستاره</th>
                                <th>شماره تماس</th>
                                <th>شهر</th>
                                <th>نوع</th>
                                <th>قیمت</th>
                                <th>کرایه</th>
                                <th>متراژ</th>
                                <th>تعداد اتاق</th>
                                <th>توضیحات و آدرس</th>
                                <th>تاریخ اعتبار</th>
                                <th>حذف کامل</th>
                            </tr>
                            @if($rentiCustomers != null)
                                @foreach($rentiCustomers as $rentiCustomer)
                                    <tr>
                                        <td>{{$rentiCustomer->id}}</td>
                                        <td>
                                            <a href="{{route('customer.show',$rentiCustomer->id)}}">{{$rentiCustomer->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('customer.star',$rentiCustomer->id)}}">{{$rentiCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$rentiCustomer->number}}</td>
                                        <td>{{$rentiCustomer->city}}</td>
                                        <td>@php if($rentiCustomer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentiCustomer->selling_price ?? $rentiCustomer->rahn_amount}}</td>
                                        <td>{{$rentiCustomer->rent_amount}}</td>
                                        <td>{{$rentiCustomer->scale}}</td>
                                        <td>{{$rentiCustomer->number_of_rooms}}</td>
                                        <td>{{$rentiCustomer->description}}</td>
                                        <td>{{$rentiCustomer->daysLeft ?? 0}}</td>
                                        <td>
                                            <form action="{{route('customer.destroy',$icustomer->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">حذف</button>
                                            </form>
                                        </td>

                                    </tr>
                                    {{--                            {{dd($customer)}}--}}
                                @endforeach
                            @endif
                        </table>
                        </p>
                    </div>

                    <div id="buyDiv" style="display: none">
                        <p>
                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>ID</th>
                                <th>نام</th>
                                <th>ستاره</th>
                                <th>شماره تماس</th>
                                <th>شهر</th>
                                <th>نوع</th>
                                <th>قیمت/رهن</th>
                                <th>متراژ</th>
                                <th>تعداد اتاق</th>
                                <th>توضیحات و آدرس</th>
                                <th>مدت اعتبار</th>
                                <th>پیشنهادات</th>
                                <th>ویرایش</th>
                                {{--                                <th>حذف کردن</th>--}}
                            </tr>
                            @if($buyCustomers != null)
                                @foreach($buyCustomers as $buyCustomer)
                                    <tr>
                                        <td>{{$buyCustomer->id}}</td>
                                        <td><a href="{{route('customer.show',$buyCustomer->id)}}">{{$buyCustomer->name}} </a></td>
                                        <td>
                                            <a href="{{route('customer.star',$buyCustomer->id)}}">{{$buyCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$buyCustomer->number}}</td>
                                        <td>{{$buyCustomer->city}}</td>
                                        <td>@php if($buyCustomer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyCustomer->selling_price ?? $buyCustomer->rahn_amount}}</td>
                                        <td>{{$buyCustomer->scale}}</td>
                                        <td>{{$buyCustomer->number_of_rooms}}</td>
                                        <td>{{$buyCustomer->description}}</td>
                                        <td>{{$buyCustomer->daysLeft ?? 0}} روز</td>
                                        <td><a href="{{route('customer.suggestions',$buyCustomer->id)}}">پیشنهادات</a></td>
                                        <td><a href="{{route('customer.edit',$buyCustomer->id)}}">ویرایش</a></td>
{{--                                        <td><a href="{{route('customer.status',$buyCustomer->id)}}">حذف</a></td>--}}
                                    </tr>
                                @endforeach
                            @endif
                        </table>

                        </p>
                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                        <p>
                            :درخواست های غیر فعال
                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>ID</th>
                                <th>نام</th>
                                <th>ستاره</th>
                                <th>شماره تماس</th>
                                <th>شهر</th>
                                <th>نوع</th>
                                <th>قیمت</th>
                                <th>متراژ</th>
                                <th>تعداد اتاق</th>
                                <th>توضیحات و آدرس</th>
                                <th>تاریخ اعتبار</th>
                                <th>حذف کامل</th>
                            </tr>
                            @if($buyiCustomers != null)
                                @foreach($buyiCustomers as $buyiCustomer)
                                    <tr>
                                        <td>{{$buyiCustomer->id}}</td>
                                        <td>
                                            <a href="{{route('customer.show',$buyiCustomer->id)}}">{{$buyiCustomer->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('customer.star',$buyiCustomer->id)}}">{{$buyiCustomer->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$buyiCustomer->number}}</td>
                                        <td>{{$buyiCustomer->city}}</td>
                                        <td>@php if($buyiCustomer->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyiCustomer->selling_price ?? $buyiCustomer->rahn_amount}}</td>
                                        <td>{{$buyiCustomer->scale}}</td>
                                        <td>{{$buyiCustomer->number_of_rooms}}</td>
                                        <td>{{$buyiCustomer->description}}</td>
                                        <td>{{$buyiCustomer->daysLeft ?? 0}}</td>
                                        <td>
                                            <form action="{{route('customer.destroy',$icustomer->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">حذف</button>
                                            </form>
                                        </td>

                                    </tr>
                                    {{--                            {{dd($customer)}}--}}
                                @endforeach
                            @endif
                        </table>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function allFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }

        function rentFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "block") {
                x.style.display = "none";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "none") {
                y.style.display = "block";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }

        function buyFunction() {
            var x = document.getElementById("allDiv");
            if (x.style.display === "block") {
                x.style.display = "none";
            }
            var y = document.getElementById("rentDiv");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
            var z = document.getElementById("buyDiv");
            if (z.style.display === "none") {
                z.style.display = "block";
            }
        }
    </script>

</x-app-layout>
