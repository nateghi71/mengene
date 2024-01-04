@extends('layouts.dashboard' , ['sectionName' => 'ویرایش مالک'])

@section('title' , 'ویرایش مالک')

@section('scripts')
    <script>
        if("{{ $landowner->type_sale === "buy" }}")
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
        function separateNum(input , show) {
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

    </script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mb-3">ویرایش مالک</h3></div>
                <div><a href="{{route('landowner.index',['status' => 'active'])}}" class="btn btn-primary p-2">نمایش مالکان</a></div>
            </div>
            <hr>

            <form action="{{route('landowner.update' , $landowner->id)}}" method="post" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-3 ps-3">نوع:</label>
                        <div class="col-sm-3">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale1">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale1" onclick="buyFunction()" value="buy" {{$landowner->type_sale === "buy" ? 'checked' : '' }}> فروش </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale2">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale2" onclick="rahnFunction()" value="rahn" {{$landowner->type_sale === "rahn" ? 'checked' : '' }}> رهن و اجاره </label>
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
                        <input type="text" name="name" class="form-control" id="name" value="{{$landowner->name}}" placeholder="نام">
                        @error('name')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="number">شماره تماس:</label>
                        <input type="text" name="number" class="form-control" value="{{$landowner->number}}" id="number" placeholder="شماره تماس">
                        @error('number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="city">شهر:</label>
                        <input type="text" name="city" class="form-control" value="{{$landowner->city}}" id="city" placeholder="شهر">
                        @error('city')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="scale">متراژ:</label>
                        <input type="text" name="scale" class="form-control" value="{{$landowner->scale}}" id="scale" placeholder="متراژ">
                        @error('scale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="myDIV" class="form-group col-md-3" style="display: block">
                        <div class="d-flex justify-content-between">
                            <label for="selling_price">قیمت:</label>
                            <p id="show_selling_price"></p>
                        </div>
                        <input maxlength="9" type="text" name="selling_price" class="form-control" value="{{$landowner->selling_price}}" id="selling_price" placeholder="قیمت">
                        @error('selling_price')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV1" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rahn_amount">رهن:</label>
                            <p id="show_rahn_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rahn_amount" class="form-control" value="{{$landowner->rahn_amount}}" id="rahn_amount" placeholder="رهن">
                        @error('rahn_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV2" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rent_amount">اجاره:</label>
                            <p id="show_rent_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rent_amount" class="form-control" value="{{$landowner->rent_amount}}" id="rent_amount" placeholder="اجاره">
                        @error('rent_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_work">نوع مسکن:</label>
                        <select class="form-control" name="type_work" id="type_work">
                            <option value="home" {{$landowner->type_work === "home" ? 'select' : '' }}>خانه</option>
                            <option value="office" {{$landowner->type_work === "office" ? 'select' : '' }}>دفتر</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_build">نوع ساختمان:</label>
                        <select class="form-control" name="type_build" id="type_build">
                            <option value="house" {{$landowner->type_build === "house" ? 'select' : '' }}>ویلایی</option>
                            <option value="apartment" {{$landowner->type_build === "apartment" ? 'select' : '' }}>ساختمان</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="number_of_rooms">تعداد اتاق:</label>
                        <input type="text" name="number_of_rooms" class="form-control" value="{{$landowner->number_of_rooms}}" id="number_of_rooms" placeholder="تعداد اتاق">
                        @error('number_of_rooms')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="floor_number">شماره طبقه:</label>
                        <input type="text" name="floor_number" class="form-control" value="{{$landowner->floor_number}}" id="floor_number" placeholder="شماره طبقه">
                        @error('floor_number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="expire_date">تاریخ اعتبار:</label>
                        <input type="text" name="expire_date" class="form-control" value="{{$landowner->expire_date}}" id="expire_date" placeholder="تاریخ اعتبار">
                        @error('expire_date')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">آدرس:</label>
                        <textarea name="description" class="form-control" id="description" placeholder="آدرس" rows="3">{{$landowner->description}}</textarea>
                        @error('description')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="elevator" class="form-check-label">
                                <input type="checkbox" name="elevator" id="elevator" class="form-check-input" {{$landowner->elevator === 1 ? 'checked' : '' }}>اسانسور
                            </label>
                        </div>
                        @error('elevator')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="parking" class="form-check-label">
                                <input type="checkbox" name="parking" id="parking" class="form-check-input" {{$landowner->parking === 1 ? 'checked' : '' }}>پارکینگ
                            </label>
                        </div>
                        @error('parking')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="store" class="form-check-label">
                                <input type="checkbox" name="store" id="store" class="form-check-input" {{$landowner->store === 1 ? 'checked' : '' }}>انبار
                            </label>
                        </div>
                        @error('store')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="is_star" class="form-check-label">
                                <input type="checkbox" name="is_star" id="is_star" class="form-check-input" {{$landowner->is_star === 1 ? 'checked' : '' }}>ستاره
                            </label>
                        </div>
                        @error('is_star')
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
