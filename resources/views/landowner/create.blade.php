<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('ایجاد مالک جدید') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">


                    <form action="{{route('landowner.store')}}" method="POST">
                        @csrf
                        <div>
                            <label for="name">نام:</label>
                            <input type="text" name="name"
                                   value="{{old('name')}}">
                            @error('name')
                            <div>{{$message}}</div> @enderror
                        </div>
                        {{--                        <div>--}}
                        {{--                            <label for="status">وضعیت: </label>--}}
                        {{--                            <select name="status">--}}
                        {{--                                <option value="1">فعال</option>--}}
                        {{--                                <option value="0">غیر فعال</option>--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        <div>
                            <label for="status">وضعیت: </label>
                            <select name="status">
                                <option value="1">فعال</option>
                                <option value="0">غیر فعال</option>
                            </select>
                        </div>
                        <div>
                            <label for="is_star">ستاره: </label>
                            <select name="is_star">
                                <option value="0">بدون ستاره</option>
                                <option value="1">ستاره دار</option>
                            </select>
                        </div>
                        <div>
                            <label for="number">شماره تماس: </label>
                            <input type="text" name="number" value="{{old('number')}}">
                            @error('number')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <input type="hidden" name="city" value="{{old('city')}}">
                            @error('city')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="address">توضیحات و آدرس:</label>
                            <textarea name="address" style="width: 500px; height: 150px">
                                {{old('address')}}
                            </textarea>
                            @error('address')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            :نوع
                            <br>
                            <input type="radio" id="html" name="type" value='buy' onclick="myFunction()">
                            <label for="type">فروشی</label><br>
                            <input type="radio" id="css" name="type" value='rahn' onclick="meFunction()">
                            <label for="type">رهن و اجاره</label><br>
                            @error('type')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div id="myDIV" style="display: none">
                            <label for="price">قیمت/رهن: </label>
                            <input type="text" name="price" value="{{old('price')}}">
                            @error('price')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div id="meDIV" style="display: none">
                            <label for="rent">اجاره: </label>
                            <input type="text" name="rent" value="{{old('rent')}}">
                            @error('rent')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="text">متراژ: </label>
                            <input type="text" name="size" value="{{old('size')}}">
                            @error('size')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="rooms">تعداد اتاق: </label>
                            <input type="text" name="rooms" value="{{old('rooms')}}">
                            @error('rooms')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="expiry_date">تاریخ اعتبار: </label>
                            <input type="date" name="expiry_date" value="{{old('expiry_date')}}">
                            @error('expiry_date')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <br>

                        <div>
                            <button type="submit">ذخیره</button>
                        </div>
                    </form>

                </div>
                <a href="{{route('landowners')}}">بازگشت</a>

            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("meDIV");
            if (y.style.display === "block") {
                y.style.display = "none";
            }
        }

        function meFunction() {
            var x = document.getElementById("meDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
            var y = document.getElementById("myDIV");
            if (y.style.display === "none") {
                y.style.display = "block";
            }
        }
    </script>

</x-app-layout>
