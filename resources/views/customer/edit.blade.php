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
                        <div>
                            <label for="name">نام:</label>
                            <input type="text" name="name"
                                   value="{{$customer->name}}">
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
                                <option value="0" <?php if ($customer->status == 0) echo 'selected';?>>غیر فعال</option>
                            </select>
                        </div>
                        <div>
                            <label for="is_star">ستاره: </label>
                            <select name="is_star">
                                <option value="0">بدون ستاره</option>
                                <option value="1" <?php if ($customer->is_star == 1) echo 'selected';?>>ستاره دار
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="number">شماره تماس: </label>
                            <input type="text" name="number" value="{{$customer->number}}">
                            @error('number')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="city">شهر:</label>
                            <input type="text" name="city" value="{{$customer->city}}">
                            @error('city')
                            <div>{{$message}}</div> @enderror
                        </div>

                        <div>
                            :نوع
                            <br>
                            <input type="radio" id="html" name="type" value='buy' onclick="myFunction()"
                                   checked="checked">
                            <label for="type">فروشی</label><br>
                            <input type="radio" id="css" name="type" value='rahn'
                                   onclick="meFunction()" <?php if ($customer->type == 'rahn') echo "checked=checked";?>>
                            <label for="type">رهن و اجاره</label><br>
                            @error('type')
                            <div>{{$message}}</div> @enderror
                            {{--                            <label for="type">نوع: </label>--}}
                            {{--                            <select name="type">--}}
                            {{--                                <option value="1">رهن و اجاره</option>--}}
                            {{--                                <option value="0" <?php if ($customer->type == 0) echo 'selected';?>>فروشی</option>--}}
                            {{--                            </select>--}}
                            {{--                            @error('type')--}}
                            {{--                            <div>{{$message}}</div> @enderror--}}
                            {{--                        </div>--}}
                            <div>
                                <label for="price">قیمت/رهن: </label>
                                <input type="number" name="price" value="{{$customer->price}}">
                                @error('price')
                                <div>{{$message}}</div> @enderror
                            </div>
                            <div id="meDIV" style=<?php if ($customer->type == 'rahn') {
                                echo "display:block";
                            } else {
                                echo "display:none";
                            }?>>
                                <label for="rent">اجاره: </label>
                                <input type="number" name="rent" value="{{$customer->rent}}">
                                @error('rent')
                                <div>{{$message}}</div> @enderror
                            </div>
                            <div>
                                <label for="size">متراژ: </label>
                                <input type="number" name="size" value="{{$customer->size}}">
                                @error('size')

                                <div>{{$message}}</div> @enderror
                            </div>
                            <div>
                                <label for="rooms">تعداد اتاق: </label>
                                <input type="number" name="rooms" value="{{$customer->rooms}}">
                                @error('rooms')
                                <div>{{$message}}</div> @enderror
                            </div>
                            <div>
                                <label for="address">توضیحات و آدرس:</label>
                                <textarea name="address" style="width: 500px; height: 150px">
                               {{$customer->address}}
                            </textarea>
                                @error('address')
                                <div>{{$message}}</div> @enderror
                            </div>
                            <div>
                                <label for="expiry_date">تاریخ اعتبار: </label>
                                <input type="date" name="expiry_date" value="{{$customer->expiry_date}}">
                                @error('expiry_date')
                                <div>{{$message}}</div> @enderror
                            </div>
                            <br>

                            <div>
                                <button type="submit">ذخیره</button>
                            </div>
                    </form>

                </div>
                <a href="{{route('customers')}}">بازگشت</a>

            </div>
        </div>
    </div>
    <script>
        function myFunction() {

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
        }
    </script>
</x-app-layout>
