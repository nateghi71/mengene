<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row-reverse">
            {{ __('صاحب ملکان') }}
        </h2>
        <h3 style="text-align: right; margin: 10px">
            <span style="margin: 10px; cursor: pointer" onclick="allFunction()">همه صاحب ملکان</span>
            <span style="margin: 10px; cursor: pointer" onclick="rentFunction()">رهن و اجاره</span>
            <span style="margin: 10px; cursor: pointer" onclick="buyFunction()">فروشی</span>
        </h3>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    <p><a href="{{route('landowner.create')}}">ایجاد مالک جدید</a></p>
                    :لیست مالک های فعال
                    <div id="allDiv" style="display:block;">
                        <p>
                        {{--                    {{dd($landowners)}}--}}

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

                            @foreach($landowners as $landowner)
                                <tr>

                                    <td><a href="{{route('landowner.status',$landowner->id)}}">حذف</a></td>
                                    <td><a href="{{route('landowner.edit',$landowner->id)}}">ویرایش</a></td>
                                    <td>{{$landowner->expiry_date}} روز</td>
                                    <td>{{$landowner->address}}</td>
                                    <td>{{$landowner->rooms}}</td>
                                    <td>{{$landowner->size}}</td>

                                    <td>{{$landowner->rent}}</td>
                                    <td>{{$landowner->price}}</td>
                                    <td>@php if($landowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$landowner->city}}</td>
                                    <td>{{$landowner->number}}</td>
                                    <td>@php if($landowner->is_star){
                                        echo '*';
                                            } @endphp
                                    </td>
                                    <td><a href="{{route('landowner',$landowner->id)}}">{{$landowner->name}} </a></td>
                                    <td>{{$landowner->id}}</td>

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

                            @foreach($ilandowners as $ilandowner)
                                <tr>

                                    <td><a href="{{route('landowner.delete',$ilandowner->id)}}">حذف</a></td>
                                    <td><a href="{{route('landowner.status',$ilandowner->id)}}">بازگرد</a></td>
                                    <td>{{$ilandowner->expiry_date}}</td>
                                    <td>{{$ilandowner->address}}</td>
                                    <td>{{$ilandowner->rooms}}</td>
                                    <td>{{$ilandowner->size}}</td>
                                    <td>{{$ilandowner->rent}}</td>
                                    <td>{{$ilandowner->price}}</td>
                                    <td>@php if($ilandowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                    </td>
                                    <td>{{$ilandowner->city}}</td>
                                    <td>{{$ilandowner->number}}</td>
                                    <td>@php if($ilandowner->is_star){
                                        echo '*';
                                            } @endphp
                                    </td>
                                    <td><a href="{{route('landowner',$ilandowner->id)}}">{{$ilandowner->name}} </a></td>
                                    <td>{{$ilandowner->id}}</td>

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
                            @if($rentLandowners != null)
                                @foreach($rentLandowners as $rentLandowner)
                                    <tr>

                                        <td><a href="{{route('landowner.status',$rentLandowner->id)}}">حذف</a></td>
                                        <td><a href="{{route('landowner.edit',$rentLandowner->id)}}">ویرایش</a></td>
                                        <td>{{$rentLandowner->expiry_date}} روز</td>
                                        <td>{{$rentLandowner->address}}</td>
                                        <td>{{$rentLandowner->rooms}}</td>
                                        <td>{{$rentLandowner->size}}</td>

                                        <td>{{$rentLandowner->rent}}</td>
                                        <td>{{$rentLandowner->price}}</td>
                                        <td>@php if($rentLandowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentLandowner->city}}</td>
                                        <td>{{$rentLandowner->number}}</td>
                                        <td>@php if($rentLandowner->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('landowner',$rentLandowner->id)}}">{{$rentLandowner->name}} </a>
                                        </td>
                                        <td>{{$rentLandowner->id}}</td>

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
                            @if($rentiLandowners != null)
                                @foreach($rentiLandowners as $rentiLandowner)
                                    <tr>

                                        <td><a href="{{route('landowner.delete',$rentiLandowner->id)}}">حذف</a></td>
                                        <td><a href="{{route('landowner.status',$rentiLandowner->id)}}">بازگرد</a></td>
                                        <td>{{$rentiLandowner->expiry_date}}</td>
                                        <td>{{$rentiLandowner->address}}</td>
                                        <td>{{$rentiLandowner->rooms}}</td>
                                        <td>{{$rentiLandowner->size}}</td>
                                        <td>{{$rentiLandowner->rent}}</td>
                                        <td>{{$rentiLandowner->price}}</td>
                                        <td>@php if($rentiLandowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$rentiLandowner->city}}</td>
                                        <td>{{$rentiLandowner->number}}</td>
                                        <td>@php if($rentiLandowner->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('landowner',$rentiLandowner->id)}}">{{$rentiLandowner->name}} </a>
                                        </td>
                                        <td>{{$rentiLandowner->id}}</td>

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
                            @if($buyLandowners != null)
                                @foreach($buyLandowners as $buyLandowner)
                                    <tr>

                                        <td><a href="{{route('landowner.status',$buyLandowner->id)}}">حذف</a></td>
                                        <td><a href="{{route('landowner.edit',$buyLandowner->id)}}">ویرایش</a></td>
                                        <td>{{$buyLandowner->expiry_date}} روز</td>
                                        <td>{{$buyLandowner->address}}</td>
                                        <td>{{$buyLandowner->rooms}}</td>
                                        <td>{{$buyLandowner->size}}</td>

                                        <td>{{$buyLandowner->price}}</td>
                                        <td>@php if($buyLandowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyLandowner->city}}</td>
                                        <td>{{$buyLandowner->number}}</td>
                                        <td>@php if($buyLandowner->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('landowner',$buyLandowner->id)}}">{{$buyLandowner->name}} </a>
                                        </td>
                                        <td>{{$buyLandowner->id}}</td>

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
                            @if($buyiLandowners != null)
                                @foreach($buyiLandowners as $buyiLandowner)
                                    <tr>

                                        <td><a href="{{route('landowner.delete',$buyiLandowner->id)}}">حذف</a></td>
                                        <td><a href="{{route('landowner.status',$buyiLandowner->id)}}">بازگرد</a></td>
                                        <td>{{$buyiLandowner->expiry_date}}</td>
                                        <td>{{$buyiLandowner->address}}</td>
                                        <td>{{$buyiLandowner->rooms}}</td>
                                        <td>{{$buyiLandowner->size}}</td>
                                        <td>{{$buyiLandowner->price}}</td>
                                        <td>@php if($buyiLandowner->type == 'rahn'){
                                        echo 'رهن و اجاره';
                                            }
                                            else{
                                                echo 'فروشی';
                                            } @endphp
                                        </td>
                                        <td>{{$buyiLandowner->city}}</td>
                                        <td>{{$buyiLandowner->number}}</td>
                                        <td>@php if($buyiLandowner->is_star){
                                        echo '*';
                                            } @endphp
                                        </td>
                                        <td>
                                            <a href="{{route('landowner',$buyiLandowner->id)}}">{{$buyiLandowner->name}} </a>
                                        </td>
                                        <td>{{$buyiLandowner->id}}</td>

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
