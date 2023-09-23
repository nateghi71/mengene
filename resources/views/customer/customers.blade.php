<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row-reverse">
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
                    <p><a href="{{route('customer.create')}}">ایجاد درخواست جدید</a></p>
                    :لیست درخواست های فعال
                    <div id="allDiv" style="display:block;">
                        <p>
                        {{--                    {{dd($customers)}}--}}

                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>حذف کردن</th>
                                <th>ویرایش</th>
                                <th>مدت اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>کرایه</th>
                                <th>قیمت/رهن</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>

                            @foreach($customers as $customer)
                                <tr>

                                    <td><a href="{{route('customer.status',$customer->id)}}">حذف</a></td>
                                    <td><a href="{{route('customer.edit',$customer->id)}}">ویرایش</a></td>
                                    <td>{{$customer->expiry_date}} روز</td>
                                    <td>{{$customer->address}}</td>
                                    <td>{{$customer->rooms}}</td>
                                    <td>{{$customer->size}}</td>

                                    <td>{{$customer->rent}}</td>
                                    <td>{{$customer->price}}</td>
                                    <td>@php if($customer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$customer->city}}</td>
                                    <td>{{$customer->number}}</td>
                                    <td>@php if($customer->is_star){
                                        echo '*';
                                            } @endphp
                                    </td>
                                    <td><a href="{{route('customer',$customer->id)}}">{{$customer->name}} </a></td>
                                    <td>{{$customer->id}}</td>

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
                                <th>حذف کامل</th>
                                <th>بازگرد</th>
                                <th>تاریخ اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>کرایه</th>
                                <th>قیمت/رهن</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>

                            @foreach($icustomers as $icustomer)
                                <tr>

                                    <td><a href="{{route('customer.delete',$icustomer->id)}}">حذف</a></td>
                                    <td><a href="{{route('customer.status',$icustomer->id)}}">بازگرد</a></td>
                                    <td>{{$icustomer->expiry_date}}</td>
                                    <td>{{$icustomer->address}}</td>
                                    <td>{{$icustomer->rooms}}</td>
                                    <td>{{$icustomer->size}}</td>
                                    <td>{{$icustomer->rent}}</td>
                                    <td>{{$icustomer->price}}</td>
                                    <td>@php if($icustomer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$icustomer->city}}</td>
                                    <td>{{$icustomer->number}}</td>
                                    <td>@php if($icustomer->is_star){
                                        echo '*';
                                            } @endphp
                                    </td>
                                    <td><a href="{{route('customer',$icustomer->id)}}">{{$icustomer->name}} </a></td>
                                    <td>{{$icustomer->id}}</td>

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
                                <th>حذف کردن</th>
                                <th>ویرایش</th>
                                <th>مدت اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>کرایه</th>
                                <th>رهن</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>
                            @if($rentCustomers != null)
                                @foreach($rentCustomers as $rentCustomer)
                                    <tr>

                                        <td><a href="{{route('customer.status',$rentCustomer->id)}}">حذف</a></td>
                                        <td><a href="{{route('customer.edit',$rentCustomer->id)}}">ویرایش</a></td>
                                        <td>{{$rentCustomer->expiry_date}} روز</td>
                                        <td>{{$rentCustomer->address}}</td>
                                        <td>{{$rentCustomer->rooms}}</td>
                                        <td>{{$rentCustomer->size}}</td>

                                        <td>{{$rentCustomer->rent}}</td>
                                        <td>{{$rentCustomer->price}}</td>
                                        <td>@php if($rentCustomer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentCustomer->city}}</td>
                                        <td>{{$rentCustomer->number}}</td>
                                        <td>@php if($rentCustomer->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('customer',$rentCustomer->id)}}">{{$rentCustomer->name}} </a>
                                        </td>
                                        <td>{{$rentCustomer->id}}</td>

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
                                <th>حذف کامل</th>
                                <th>بازگرد</th>
                                <th>تاریخ اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>کرایه</th>
                                <th>رهن</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>
                            @if($rentiCustomers != null)
                                @foreach($rentiCustomers as $rentiCustomer)
                                    <tr>

                                        <td><a href="{{route('customer.delete',$rentiCustomer->id)}}">حذف</a></td>
                                        <td><a href="{{route('customer.status',$rentiCustomer->id)}}">بازگرد</a></td>
                                        <td>{{$rentiCustomer->expiry_date}}</td>
                                        <td>{{$rentiCustomer->address}}</td>
                                        <td>{{$rentiCustomer->rooms}}</td>
                                        <td>{{$rentiCustomer->size}}</td>
                                        <td>{{$rentiCustomer->rent}}</td>
                                        <td>{{$rentiCustomer->price}}</td>
                                        <td>@php if($rentiCustomer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentiCustomer->city}}</td>
                                        <td>{{$rentiCustomer->number}}</td>
                                        <td>@php if($rentiCustomer->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('customer',$rentiCustomer->id)}}">{{$rentiCustomer->name}} </a>
                                        </td>
                                        <td>{{$rentiCustomer->id}}</td>

                                    </tr>
                                    {{--                            {{dd($customer)}}--}}
                                @endforeach
                            @endif
                        </table>
                        </p>
                    </div>

                    <div id="buyDiv" style="display: none">
                        <p>
                        {{--                    {{dd($customers)}}--}}

                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>حذف کردن</th>
                                <th>ویرایش</th>
                                <th>مدت اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>قیمت</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>
                            @if($buyCustomers != null)
                                @foreach($buyCustomers as $buyCustomer)
                                    <tr>

                                        <td><a href="{{route('customer.status',$buyCustomer->id)}}">حذف</a></td>
                                        <td><a href="{{route('customer.edit',$buyCustomer->id)}}">ویرایش</a></td>
                                        <td>{{$buyCustomer->expiry_date}} روز</td>
                                        <td>{{$buyCustomer->address}}</td>
                                        <td>{{$buyCustomer->rooms}}</td>
                                        <td>{{$buyCustomer->size}}</td>

                                        <td>{{$buyCustomer->price}}</td>
                                        <td>@php if($buyCustomer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyCustomer->city}}</td>
                                        <td>{{$buyCustomer->number}}</td>
                                        <td>@php if($buyCustomer->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td><a href="{{route('customer',$buyCustomer->id)}}">{{$buyCustomer->name}} </a>
                                        </td>
                                        <td>{{$buyCustomer->id}}</td>

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
                                <th>حذف کامل</th>
                                <th>بازگرد</th>
                                <th>تاریخ اعتبار</th>
                                <th>توضیحات و آدرس</th>
                                <th>تعداد اتاق</th>
                                <th>متراژ</th>
                                <th>قیمت</th>
                                <th>نوع</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ستاره</th>
                                <th>نام</th>
                                <th>ID</th>
                            </tr>
                            @if($buyiCustomers != null)
                                @foreach($buyiCustomers as $buyiCustomer)
                                    <tr>

                                        <td><a href="{{route('customer.delete',$buyiCustomer->id)}}">حذف</a></td>
                                        <td><a href="{{route('customer.status',$buyiCustomer->id)}}">بازگرد</a></td>
                                        <td>{{$buyiCustomer->expiry_date}}</td>
                                        <td>{{$buyiCustomer->address}}</td>
                                        <td>{{$buyiCustomer->rooms}}</td>
                                        <td>{{$buyiCustomer->size}}</td>
                                        <td>{{$buyiCustomer->price}}</td>
                                        <td>@php if($buyiCustomer->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyiCustomer->city}}</td>
                                        <td>{{$buyiCustomer->number}}</td>
                                        <td>@php if($buyiCustomer->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('customer',$buyiCustomer->id)}}">{{$buyiCustomer->name}} </a>
                                        </td>
                                        <td>{{$buyiCustomer->id}}</td>

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
