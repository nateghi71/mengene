<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row">
            {{ __('صاحبان ملک') }}
        </h2>
        <h3 style="text-align: right; margin: 10px">
            <span style="margin: 10px; cursor: pointer" onclick="allFunction()">همه صاحبان ملک</span>
            <span style="margin: 10px; cursor: pointer" onclick="rentFunction()">رهن و اجاره</span>
            <span style="margin: 10px; cursor: pointer" onclick="buyFunction()">فروشی</span>
        </h3>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    <p><a href="{{route('landowner.create')}}">ایجاد مالک جدید</a></p>
                    <br>
                    <hr>
                    :لیست مالک های فعال
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

                            @foreach($landowners as $landowner)
                                <tr>
                                    <td>{{$landowner->id}}</td>
                                    <td><a href="{{route('landowner.show',$landowner->id)}}">{{$landowner->name}} </a></td>
                                    <td>
                                        <a href="{{route('landowner.star',$landowner->id)}}">{{$landowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                    </td>
                                    <td>{{$landowner->number}}</td>
                                    <td>{{$landowner->city}}</td>
                                    <td>@php if($landowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$landowner->selling_price ?? $landowner->rahn_amount}}</td>
                                    <td>{{$landowner->rent_amount}}</td>
                                    <td>{{$landowner->scale}}</td>
                                    <td>{{$landowner->number_of_rooms}}</td>
                                    <td>{{$landowner->description}}</td>
                                    <td>{{$landowner->daysLeft ?? 0}} روز</td>
                                    <td><a href="{{route('landowner.suggestions',$landowner->id)}}">پیشنهادات</a></td>
                                    <td><a href="{{route('landowner.edit',$landowner->id)}}">ویرایش</a></td>
{{--                                    <td><a href="{{route('landowner.status',$landowner->id)}}">حذف</a></td>--}}
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
                            :مالک های غیر فعال
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

                            @foreach($ilandowners as $ilandowner)
                                <tr>
                                    <td>{{$ilandowner->id}}</td>
                                    <td><a href="{{route('landowner.show',$ilandowner->id)}}">{{$ilandowner->name}} </a></td>
                                    <td>
                                        <a href="{{route('landowner.star',$ilandowner->id)}}">{{$ilandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                    </td>
                                    <td>{{$ilandowner->number}}</td>
                                    <td>{{$ilandowner->city}}</td>
                                    <td>@php if($ilandowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$ilandowner->selling_price ?? $ilandowner->rahn_amount}}</td>
                                    <td>{{$ilandowner->rent_amount}}</td>
                                    <td>{{$ilandowner->scale}}</td>
                                    <td>{{$ilandowner->number_of_rooms}}</td>
                                    <td>{{$ilandowner->description}}</td>
                                    <td>{{$ilandowner->daysLeft ?? 0}}</td>
                                    <td>
                                        <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">حذف</button>
                                        </form>
                                    </td>

                                </tr>
                                {{--                            {{dd($landowner)}}--}}
                            @endforeach
                        </table>
                        </p>
                    </div>

                    <div id="rentDiv" style="display: none">
                        <p>
                        {{--                    {{dd($landowners)}}--}}

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
                            @if($rentLandowners != null)
                                @foreach($rentLandowners as $rentLandowner)
                                    <tr>
                                        <td>{{$rentLandowner->id}}</td>
                                        <td>
                                            <a href="{{route('landowner.show',$rentLandowner->id)}}">{{$rentLandowner->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('landowner.star',$rentLandowner->id)}}">{{$rentLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$rentLandowner->number}}</td>
                                        <td>{{$rentLandowner->city}}</td>
                                        <td>@php if($rentLandowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentLandowner->selling_price ?? $rentLandowner->rahn_amount}}</td>
                                        <td>{{$rentLandowner->rent_amount}}</td>
                                        <td>{{$rentLandowner->scale}}</td>
                                        <td>{{$rentLandowner->number_of_rooms}}</td>
                                        <td>{{$rentLandowner->description}}</td>
                                        <td>{{$rentLandowner->daysLeft ?? 0}} روز</td>
                                        <td><a href="{{route('landowner.suggestions',$rentLandowner->id)}}">پیشنهادات</a></td>
                                        <td><a href="{{route('landowner.edit',$rentLandowner->id)}}">ویرایش</a></td>
{{--                                        <td><a href="{{route('landowner.status',$rentLandowner->id)}}">حذف</a></td>--}}
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
                            :مالک های غیر فعال
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
                            @if($rentiLandowners != null)
                                @foreach($rentiLandowners as $rentiLandowner)
                                    <tr>
                                        <td>{{$rentiLandowner->id}}</td>
                                        <td>
                                            <a href="{{route('landowner.show',$rentiLandowner->id)}}">{{$rentiLandowner->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('landowner.star',$rentiLandowner->id)}}">{{$rentiLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$rentiLandowner->number}}</td>
                                        <td>{{$rentiLandowner->city}}</td>
                                        <td>@php if($rentiLandowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentiLandowner->selling_price ?? $rentiLandowner->rahn_amount}}</td>
                                        <td>{{$rentiLandowner->rent_amount}}</td>
                                        <td>{{$rentiLandowner->scale}}</td>
                                        <td>{{$rentiLandowner->number_of_rooms}}</td>
                                        <td>{{$rentiLandowner->description}}</td>
                                        <td>{{$rentiLandowner->daysLeft ?? 0}}</td>
                                        <td>
                                            <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">حذف</button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{--                            {{dd($landowner)}}--}}
                                @endforeach
                            @endif
                        </table>
                        </p>
                    </div>

                    <div id="buyDiv" style="display: none">
                        <p>
                        {{--                    {{dd($landowners)}}--}}

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
                            @if($buyLandowners != null)
                                @foreach($buyLandowners as $buyLandowner)
                                    <tr>
                                        <td>{{$buyLandowner->id}}</td>
                                        <td>
                                            <a href="{{route('landowner.show',$buyLandowner->id)}}">{{$buyLandowner->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('landowner.star',$buyLandowner->id)}}">{{$buyLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$buyLandowner->number}}</td>
                                        <td>{{$buyLandowner->city}}</td>
                                        <td>@php if($buyLandowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyLandowner->selling_price ?? $buyLandowner->rahn_amount}}</td>
                                        <td>{{$buyLandowner->scale}}</td>
                                        <td>{{$buyLandowner->number_of_rooms}}</td>
                                        <td>{{$buyLandowner->description}}</td>
                                        <td>{{$buyLandowner->daysLeft ?? 0}} روز</td>
                                        <td><a href="{{route('landowner.suggestions',$buyLandowner->id)}}">پیشنهادات</a></td>
                                        <td><a href="{{route('landowner.edit',$buyLandowner->id)}}">ویرایش</a></td>
{{--                                        <td><a href="{{route('landowner.status',$buyLandowner->id)}}">حذف</a></td>--}}


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
                            :مالک های غیر فعال
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
                            @if($buyiLandowners != null)
                                @foreach($buyiLandowners as $buyiLandowner)
                                    <tr>
                                        <td>{{$buyiLandowner->id}}</td>
                                        <td>
                                            <a href="{{route('landowner.show',$buyiLandowner->id)}}">{{$buyiLandowner->name}} </a>
                                        </td>
                                        <td>
                                            <a href="{{route('landowner.star',$buyiLandowner->id)}}">{{$buyiLandowner->is_star ? "ستاره دار" : 'بدون ستاره'}} </a>
                                        </td>
                                        <td>{{$buyiLandowner->number}}</td>
                                        <td>{{$buyiLandowner->city}}</td>
                                        <td>@php if($buyiLandowner->type_sale == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyiLandowner->selling_price ?? $buyiLandowner->rahn_amount}}</td>
                                        <td>{{$buyiLandowner->scale}}</td>
                                        <td>{{$buyiLandowner->number_of_rooms}}</td>
                                        <td>{{$buyiLandowner->description}}</td>
                                        <td>{{$buyiLandowner->daysLeft ?? 0}}</td>
                                        <td>
                                            <form action="{{route('landowner.destroy',$ilandowner->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">حذف</button>
                                            </form>
                                        </td>

                                    </tr>
                                    {{--                            {{dd($landowner)}}--}}
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
