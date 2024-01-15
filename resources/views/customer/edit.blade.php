@extends('layouts.dashboard' , ['sectionName' => 'ویرایش متقاضی'])

@section('title' , 'ویرایش متقاضی')

@section('scripts')

    <script>
        function getCities(){
            var provinceID = $('#province').val();
            if (provinceID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                    success: function(res) {
                        if (res) {
                            $("#city").empty();

                            $.each(res, function(key, city) {
                                let selected = false;
                                if(city.id == "{{$customer->city_id}}")
                                {
                                    selected = true;
                                }
                                let option = $('<option>' , {
                                    value:city.id,
                                    text:city.name,
                                    selected:selected,
                                })
                                $("#city").append(option);
                            });
                        } else {
                            $("#city").empty();
                        }
                    }
                });
            } else {
                $("#city").empty();
            }
        }
        getCities()
        $('#province').on('change' , getCities)

        if("{{ $customer->getRawOriginal('type_sale') === "buy" }}")
        {
            buyFunction()
        }
        else
        {
            rahnFunction()
        }

        function buyFunction() {
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

        function rahnFunction() {
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
        $(document).ready(function() {
            $("#expire_date").persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValueType: 'persian',
                autoClose: true
            });
        });

        function separateNum(input , show = null) {
            var nStr = input.value + '';
            nStr = nStr.replace(/\,/g, "");
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            input.value = x1 + x2;
            if(show)
            {
                if (input.value)
                {
                    let amount = input.value.replaceAll(',', '')
                    amount = parseFloat(amount);
                    if (amount < 1000) {
                        show.textContent = amount + ' میلیون تومان';
                    }
                    else {
                        amount = (amount / 1000).toFixed(3)
                        show.textContent = amount.toString().replaceAll('.', '/') + ' میلیارد تومان';
                    }
                }
                else
                {
                    show.textContent = '';
                }
            }
        }

        let scaleElement = $('#scale');
        separateNum(scaleElement.get(0));
        scaleElement.on('keyup' , function (e){
            separateNum(this);
        });

        let priceElement = $('#selling_price');
        separateNum(priceElement.get(0) , $('#show_selling_price').get(0));
        priceElement.on('keyup' , function (e){
            separateNum(this , $('#show_selling_price').get(0));
        });

        let rahnElement = $('#rahn_amount');
        separateNum(rahnElement.get(0) , $('#show_rahn_amount').get(0));
        rahnElement.on('keyup' , function (e){
            separateNum(this , $('#show_rahn_amount').get(0));
        });

        let rentElement = $('#rent_amount');
        separateNum(rentElement.get(0) , $('#show_rent_amount').get(0));
        rentElement.on('keyup' , function (e){
            separateNum(this , $('#show_rent_amount').get(0));
        });

        let label = $('#is_star_label')
        let star = $('#is_star')

        label.on('click' , function (){
            if(!label.is('.checked'))
            {
                label.addClass('checked')
                label.html('<span class="mdi mdi-star fs-4 text-warning"></span>')
                star.prop('checked' , true)
            }
            else
            {
                label.removeClass('checked')
                label.html('<span class="mdi mdi-star-outline fs-4 text-warning"></span>')
                star.prop('checked' , false)
            }
        });

        if(star.prop('checked') == true)
        {
            label.addClass('checked')
            label.html('<span class="mdi mdi-star fs-4 text-warning"></span>')
        }
        else
        {
            label.removeClass('checked')
            label.html('<span class="mdi mdi-star-outline fs-4 text-warning"></span>')
        }

    </script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mb-3">ویرایش متقاضی</h3></div>
                <div><a href="{{route('customer.index')}}" class="btn btn-primary p-2">نمایش متقاضیان</a></div>
            </div>
            <hr>
            <form action="{{route('customer.update' , $customer->id)}}" method="post" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-3 ps-3">نوع:</label>
                        <div class="col-sm-3">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale1">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale1" onclick="buyFunction()" value="buy" {{$customer->getRawOriginal('type_sale') === "buy" ? 'checked' : '' }}> خرید </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale2">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale2" onclick="rahnFunction()" value="rahn" {{$customer->getRawOriginal('type_sale') === "rahn" ? 'checked' : '' }}> رهن و اجاره </label>
                            </div>
                        </div>
                        @error('type_sale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="name"> نام و نام خانوادگی:</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{$customer->name}}" placeholder="نام">
                        @error('name')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="number">شماره تماس:</label>
                        <input type="text" name="number" class="form-control" value="{{$customer->number}}" id="number" placeholder="شماره تماس"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="province">استان:</label>
                        <select class="form-control" id="province">
                            @foreach($provinces as $province)
                                <option value="{{$province->id}}" @selected($customer->city->province_id === $province->id)>{{$province->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="city">شهر:</label>
                        <select name="city_id" class="form-control" id="city">
                        </select>
                        @error('city_id')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="access_level">سطح دسترسی:</label>
                        <select class="form-control" name="access_level" id="access_level">
                            <option value="private" @selected($customer->getRawOriginal('access_level') === "private")>خصوصی</option>
                            <option value="public" @selected($customer->getRawOriginal('access_level') === "public")>عمومی</option>
                        </select>
                        @error('access_level')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="scale">متراژ:</label>
                        <input type="text" name="scale" class="form-control" value="{{$customer->getRawOriginal('scale')}}" id="scale" placeholder="متراژ"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('scale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="myDIV" class="form-group col-md-3" style="display: block">
                        <div class="d-flex justify-content-between">
                            <label for="selling_price">قیمت:</label>
                            <p id="show_selling_price"></p>
                        </div>
                        <input maxlength="9" type="text" name="selling_price" class="form-control" value="{{$customer->getRawOriginal('selling_price')}}" id="selling_price" placeholder="قیمت"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('selling_price')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV1" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rahn_amount">رهن:</label>
                            <p id="show_rahn_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rahn_amount" class="form-control" value="{{$customer->getRawOriginal('rahn_amount')}}" id="rahn_amount" placeholder="رهن"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('rahn_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV2" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rent_amount">اجاره:</label>
                            <p id="show_rent_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rent_amount" class="form-control" value="{{$customer->getRawOriginal('rent_amount')}}" id="rent_amount" placeholder="اجاره"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('rent_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_work">نوع مسکن:</label>
                        <select class="form-control" name="type_work" id="type_work">
                            <option value="home" @selected($customer->getRawOriginal('type_work') === "home")>خانه</option>
                            <option value="office" @selected($customer->getRawOriginal('type_work') === "office")>دفتر</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_build">نوع خانه:</label>
                        <select class="form-control" name="type_build" id="type_build">
                            <option value="house" @selected($customer->getRawOriginal('type_build') === "house")>ویلایی</option>
                            <option value="apartment" @selected($customer->getRawOriginal('type_build') === "apartment")>ساختمان</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="number_of_rooms">تعداد اتاق:</label>
                        <input type="text" name="number_of_rooms" class="form-control" value="{{$customer->number_of_rooms}}" id="number_of_rooms" placeholder="تعداد اتاق"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('number_of_rooms')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="floor_number">تعداد طبقات کل ساختمان:</label>
                        <input type="text" name="floor_number" class="form-control" value="{{$customer->floor_number}}" id="floor_number" placeholder="تعداد طبقات کل ساختمان"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('floor_number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="floor">شماره طبقه:</label>
                        <input type="text" name="floor" class="form-control" value="{{$customer->floor}}" id="floor" placeholder="شماره طبقه"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('floor')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="expire_date">زمان باقیمانده:</label>
                        <input type="text" name="expire_date" class="form-control" value="{{$customer->expire_date}}" id="expire_date" placeholder="زمان باقیمانده"
                               onkeypress="return false">
                        @error('expire_date')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">آدرس:</label>
                        <textarea name="description" class="form-control" id="description" placeholder="آدرس" rows="3">{{$customer->description}}</textarea>
                        @error('description')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label id="is_star_label" class="form-check-label"><span class="mdi mdi-star-outline fs-4 text-warning"></span></label>
                            <input type="checkbox" name="is_star" id="is_star" class="d-none" @checked($customer->getRawOriginal('is_star') === 1)>
                        </div>
                        @error('is_star')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="elevator" class="form-check-label">
                                <input type="checkbox" name="elevator" id="elevator" class="form-check-input" @checked($customer->getRawOriginal('elevator') === 1)>اسانسور
                            </label>
                        </div>
                        @error('elevator')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="parking" class="form-check-label">
                                <input type="checkbox" name="parking" id="parking" class="form-check-input" @checked($customer->getRawOriginal('parking') === 1)>پارکینگ
                            </label>
                        </div>
                        @error('parking')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="store" class="form-check-label">
                                <input type="checkbox" name="store" id="store" class="form-check-input" @checked($customer->getRawOriginal('store') === 1)>انبار
                            </label>
                        </div>
                        @error('store')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ویرایش</button>
                </div>

            </form>
        </div>
    </div>
@endsection
