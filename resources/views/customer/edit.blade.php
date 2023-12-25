<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('ویرایش مشتری') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">

                    <form action="{{route('customer.update',$customer->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name">نام:</label>
                            <input type="text" name="name" value="{{$customer->name}}">
                            @error('name')
                            <div>{{$message}}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="number">شماره تماس: </label>
                            <input type="text" name="number" value="{{$customer->number}}">
                            @error('number')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="city">شهر: </label>
                            <input type="text" name="city" value="{{$customer->city}}">
                            @error('city')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            :نوع کار
                            <br>
                            <input type="radio" id="type_work1" name="type_work" value='home' {{$customer->type_work === "home" ? 'checked' : '' }}>
                            <label for="type_work1">خانه</label><br>
                            <input type="radio" id="type_work2" name="type_work" value='office' {{$customer->type_work === "office" ? 'checked' : '' }}>
                            <label for="type_work2">دفتر</label><br>
                            @error('type_work')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            :نوع ساختمان
                            <br>
                            <input type="radio" id="type_build1" name="type_build" value='house' {{$customer->type_build === "house" ? 'checked' : '' }}>
                            <label for="type_build1">ویلایی</label><br>
                            <input type="radio" id="type_build2" name="type_build" value='apartment' {{$customer->type_build === "apartment" ? 'checked' : '' }}>
                            <label for="type_build2">ساختمان</label><br>
                            @error('type_build')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            :نوع
                            <br>
                            <input type="radio" id="type1" name="type_sale" value='buy' onclick="myFunction()" {{$customer->type_sale === "buy" ? 'checked' : '' }}>
                            <label for="type1">فروشی</label><br>
                            <input type="radio" id="type2" name="type_sale" value='rahn' onclick="meFunction()" {{$customer->type_sale === "rahn" ? 'checked' : '' }}>
                            <label for="type2">رهن و اجاره</label><br>
                            @error('type_sale')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div id="myDIV" style="display: none">
                            <label for="selling_price">قیمت: </label>
                            <input type="text" name="selling_price" value="{{$customer->selling_price}}">
                            @error('selling_price')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div id="meDIV1" style="display: none">
                            <label for="rahn_amount">رهن: </label>
                            <input type="text" name="rahn_amount" value="{{$customer->rahn_amount}}">
                            @error('rahn_amount')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div id="meDIV2" style="display: none">
                            <label for="rent_amount	">اجاره: </label>
                            <input type="text" name="rent_amount" value="{{$customer->rent_amount}}">
                            @error('rent_amount')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="text">متراژ: </label>
                            <input type="text" name="scale" value="{{$customer->scale}}">
                            @error('scale')
                            <div>{{$message}}</div> @enderror
                        </div>

                        <div>
                            <label for="rooms">تعداد اتاق: </label>
                            <input type="text" name="number_of_rooms" value="{{$customer->number_of_rooms}}">
                            @error('number_of_rooms')
                            <div>{{$message}}</div> @enderror
                        </div>

                        <div>
                            <label for="description">توضیحات و آدرس:</label>
                            <textarea name="description" style="width: 500px; height: 150px">
                                {{$customer->description}}
                            </textarea>
                            @error('description')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            :اسانسور
                            <br>
                            <input type="radio" id="elevator1" name="elevator" value='0' {{$customer->elevator === 0 ? 'checked' : '' }}>
                            <label for="elevator1">ندارد</label><br>
                            <input type="radio" id="elevator2" name="elevator" value='1' {{$customer->elevator === 1 ? 'checked' : '' }}>
                            <label for="elevator2">دارد</label><br>
                            @error('elevator')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            :پارکینگ
                            <br>
                            <input type="radio" id="parking1" name="parking" value='0' {{$customer->parking === 0 ? 'checked' : '' }}>
                            <label for="parking1">ندارد</label><br>
                            <input type="radio" id="parking2" name="parking" value='1' {{$customer->parking === 1 ? 'checked' : '' }}>
                            <label for="parking2">دارد</label><br>
                            @error('parking')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            :انبار
                            <br>
                            <input type="radio" id="store1" name="store" value='0' {{$customer->store === 0 ? 'checked' : '' }}>
                            <label for="store1">ندارد</label><br>
                            <input type="radio" id="store2" name="store" value='1' {{$customer->store === 1 ? 'checked' : '' }}>
                            <label for="store2">دارد</label><br>
                            @error('store')
                            <div>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="rooms">شماره طبقه: </label>
                            <input type="text" name="floor_number" value="{{$customer->floor_number}}">
                            @error('floor_number')
                            <div>{{$message}}</div> @enderror
                        </div>

                        <div>
                            <label for="expire_date">تاریخ اعتبار: </label>
                            <input type="date" name="expire_date" value="{{$customer->expire_date}}">
                            @error('expire_date')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="is_star">ستاره: </label>
                            <select name="is_star">
                                <option value="0" {{$customer->is_star === 0 ? 'selected' : '' }}>بدون ستاره</option>
                                <option value="1" {{$customer->is_star === 1 ? 'selected' : '' }}>ستاره دار</option>
                            </select>
                        </div>
                        <br>

                        <div>
                            <button type="submit">ذخیره</button>
                        </div>
                    </form>

                </div>
                <a href="{{route('customer.index')}}">بازگشت</a>

            </div>
        </div>
    </div>
    <script>
        if("{{ $customer->type_sale === "buy" }}")
        {
            myFunction()
        }
        else
        {
            meFunction()
        }
        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("meDIV1");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
            var z = document.getElementById("meDIV2");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }

        function meFunction() {
            var x = document.getElementById("meDIV1");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("meDIV2");
            if (y.style.display === "none") {
                y.style.display = "block";
            }
            var z = document.getElementById("myDIV");
            if (z.style.display === "block") {
                z.style.display = "none";
            }
        }
    </script>
</x-app-layout>
