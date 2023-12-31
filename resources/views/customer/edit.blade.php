@extends('layouts.dashboard' , ['sectionName' => 'ویرایش متقاضی'])

@section('title' , 'ویرایش متقاضی')

@section('scripts')

    <script>
        if("{{ $customer->type_sale === "buy" }}")
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

    </script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title text-center mb-3">ویرایش متقاضی</h3></div>
                <div><a href="{{route('customer.index',['status' => 'active'])}}" class="btn btn-primary p-2">نمایش متقاضیان</a></div>
            </div>
            <hr>

            <form action="{{route('customer.update' , $customer->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-3">نوع:</label>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale1">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale1" onclick="buyFunction()" value="buy" {{$customer->type_sale === "buy" ? 'checked' : '' }}> خرید </label>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale2">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale2" onclick="rahnFunction()" value="rahn" {{$customer->type_sale === "rahn" ? 'checked' : '' }}> رهن و اجاره </label>
                            </div>
                        </div>
                    </div>
                    @error('type_sale')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name"> نام:</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{$customer->name}}" placeholder="نام">
                        @error('name')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="number">شماره تماس:</label>
                        <input type="text" name="number" class="form-control" value="{{$customer->number}}" id="number" placeholder="شماره تماس">
                        @error('number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city">شهر:</label>
                        <input type="text" name="city" class="form-control" value="{{$customer->city}}" id="city" placeholder="شهر">
                        @error('city')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type_work">نوع کار:</label>
                        <select class="form-control" name="type_work" id="type_work">
                            <option value="home" {{$customer->type_work === "home" ? 'checked' : '' }}>خانه</option>
                            <option value="office" {{$customer->type_work === "office" ? 'checked' : '' }}>دفتر</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type_build">نوع ساختمان:</label>
                        <select class="form-control" name="type_build" id="type_build">
                            <option value="house" {{$customer->type_build === "house" ? 'checked' : '' }}>ویلایی</option>
                            <option value="apartment" {{$customer->type_build === "apartment" ? 'checked' : '' }}>ساختمان</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="myDIV" class="form-group col-md-6" style="display: block">
                        <label for="selling_price">قیمت:</label>
                        <input type="text" name="selling_price" class="form-control" value="{{$customer->selling_price}}" id="selling_price" placeholder="قیمت">
                        @error('selling_price')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV1" class="form-group col-md-6" style="display: none">
                        <label for="rahn_amount">رهن:</label>
                        <input type="text" name="rahn_amount" class="form-control" value="{{$customer->rahn_amount}}" id="rahn_amount" placeholder="رهن">
                        @error('rahn_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="meDIV2" class="form-group col-md-6" style="display: none">
                        <label for="rent_amount">اجاره:</label>
                        <input type="text" name="rent_amount" class="form-control" value="{{$customer->rent_amount}}" id="rent_amount" placeholder="اجاره">
                        @error('rent_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city">متراژ:</label>
                        <input type="text" name="scale" class="form-control" value="{{$customer->scale}}" id="scale" placeholder="متراژ">
                        @error('scale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="number_of_rooms">تعداد اتاق:</label>
                        <input type="text" name="number_of_rooms" class="form-control" value="{{$customer->number_of_rooms}}" id="number_of_rooms" placeholder="تعداد اتاق">
                        @error('number_of_rooms')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="floor_number">شماره طبقه:</label>
                        <input type="text" name="floor_number" class="form-control" value="{{$customer->floor_number}}" id="floor_number" placeholder="شماره طبقه">
                        @error('floor_number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="expire_date">تاریخ اعتبار:</label>
                        <input type="date" name="expire_date" class="form-control" value="{{$customer->expire_date}}" id="expire_date" placeholder="تاریخ اعتبار">
                        @error('expire_date')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="elevator">اسانسور:</label>
                        <select class="form-control" name="elevator" id="elevator">
                            <option value="0" {{$customer->elevator === 0 ? 'checked' : '' }}>ندارد</option>
                            <option value="1" {{$customer->elevator === 1 ? 'checked' : '' }}>دارد</option>
                        </select>
                        @error('elevator')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="parking">پارکینگ:</label>
                        <select class="form-control" name="parking" id="parking">
                            <option value="0" {{$customer->parking === 0 ? 'checked' : '' }}>ندارد</option>
                            <option value="1" {{$customer->parking === 1 ? 'checked' : '' }}>دارد</option>
                        </select>
                        @error('parking')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="store">انبار:</label>
                        <select class="form-control" name="store" id="store">
                            <option value="0" {{$customer->store === 0 ? 'checked' : '' }}>ندارد</option>
                            <option value="1" {{$customer->store === 1 ? 'checked' : '' }}>دارد</option>
                        </select>
                        @error('store')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="is_star">ستاره:</label>
                        <select class="form-control" name="is_star" id="is_star">
                            <option value="0" {{$customer->is_star === 0 ? 'checked' : '' }}بدون ستاره</option>
                            <option value="1" {{$customer->is_star === 1 ? 'checked' : '' }}>ستاره دار</option>
                        </select>
                        @error('is_star')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">توضیحات و آدرس:</label>
                        <textarea name="description" class="form-control" id="description" placeholder="آدرس" rows="3">{{$customer->description}}</textarea>
                        @error('description')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="text-center pt-3">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">ویرایش</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
