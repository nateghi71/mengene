@extends('layouts.dashboard' , ['sectionName' => 'ایجاد مالک'])

@section('title' , 'ایجاد مالک')

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
                                if(city.id == "{{(old('city_id') == null) ? auth()->user()->business()->city_id : old('city_id')}}")
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

        // setTimeout(function() {
        //     $('.alert-danger').remove();
        // }, 5000);

        if("{{ old('type_sale') == 'buy' || old('type_sale') == null }}")
        {
            buyFunction()
        }
        else
        {
            rahnFunction()
        }

        function buyFunction() {
            $('#priceDiv').show();
            $('#documentDiv').show();
            $('#rahnDiv').hide();
            $('#rentDiv').hide();
        }

        function rahnFunction() {
            $('#priceDiv').hide();
            $('#documentDiv').hide();
            $('#rahnDiv').show();
            $('#rentDiv').show();
        }

        $('#more').hide();
        $('#more_btn').on('click' , function (){
            $('#more').slideToggle();
        })

        changeTypeBuild()
        function changeTypeBuild()
        {
            let selectOptin = $('#type_build').children(':selected').val()
            if(selectOptin === 'house')
            {
                $('.floor').show();
                $('.num-floor').hide();

            }
            else if(selectOptin === 'land')
            {
                $('.floor').hide();
                $('.num-floor').hide();
            }
            else
            {
                $('.floor').show();
                $('.num-floor').show();
            }
        }

        $(document).ready(function() {
            $("#expire_date").persianDatepicker({
                initialValue: false,
                minDate: new persianDate(),
                format: 'YYYY/MM/DD',
                autoClose: true,
                toolbox:{
                    calendarSwitch:{
                        enabled:false,
                    }
                }

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

        $('#is_star_label').on('click' , function (){
            let label = $(this)
            let star = $('#is_star')
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

    </script>

@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <form action="{{route('landowner.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="card-title">ایجاد مالک</h3>
                    </div>
                    <div class="form-group">
                        <div class="form-check my-0 py-0">
                            <label id="is_star_label" class="form-check-label"><span class="mdi mdi-star-outline fs-4 text-warning"></span></label>
                            <input type="checkbox" name="is_star" id="is_star" class="d-none" @checked(old('is_star') == 'on')>
                        </div>
                        @error('is_star')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="me-auto ms-4 mb-3"><a href="{{route('landowner.index')}}" class="btn btn-primary p-2">نمایش مالکان</a></div>
                </div>
                <hr>
                <div class="row mb-4">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-3 ps-3">نوع:</label>
                        <div class="col-sm-3">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale1">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale1" onclick="buyFunction()" value="buy" @checked(old('type_sale') == 'buy' || old('type_sale') == null)> فروش </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <label class="form-check-label" for="type_sale2">
                                    <input type="radio" class="form-check-input" name="type_sale" id="type_sale2" onclick="rahnFunction()" value="rahn"  @checked(old('type_sale') == 'rahn')> رهن و اجاره </label>
                            </div>
                        </div>
                        @error('type_sale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="access_level">سطح دسترسی:</label>
                        <select class="form-control" name="access_level" id="access_level">
                            <option value="private" @selected(old('access_level') == 'private')>نمایش خصوصی</option>
                            <option value="public" @selected(old('access_level') == 'public')>نمایش عمومی</option>
                        </select>
                        @error('access_level')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name"> نام و نام خانوادگی:</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="نام">
                        @error('name')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="number">شماره تماس:</label>
                        <input type="text" name="number" class="form-control" value="{{old('number')}}" id="number" placeholder="شماره تماس"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('number')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="scale">متراژ(متر):</label>
                        <input type="text" name="scale" class="form-control" value="{{old('scale')}}" id="scale" placeholder="متراژ"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('scale')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="province">استان:</label>
                        <select class="form-control" name="province" id="province">
                            @foreach($provinces as $province)
                                <option value="{{$province->id}}" @selected((old('province') == null) ? auth()->user()->city->province_id == $province->id : old('$province') == $province->id)>{{$province->name}}</option>
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
                        <label for="area">منطقه شهرداری:</label>
                        <input type="text" name="area" class="form-control" value="{{(old('area') == null) ? auth()->user()->business()->area : old('area')}}" id="area" placeholder="منطقه شهرداری"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('area')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="expire_date">زمان باقیمانده:</label>
                        <input type="text" name="expire_date" class="form-control" value="{{old('expire_date')}}" id="expire_date" placeholder="زمان باقیمانده"
                               onkeypress="return false">
                        @error('expire_date')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="priceDiv" class="form-group col-md-3" style="display: block">
                        <div class="d-flex justify-content-between">
                            <label for="selling_price">قیمت(تومان):</label>
                            <p id="show_selling_price"></p>
                        </div>
                        <input maxlength="9" type="text" name="selling_price" class="form-control" value="{{old('selling_price')}}" id="selling_price" placeholder="قیمت"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('selling_price')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="rahnDiv" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rahn_amount">رهن(تومان):</label>
                            <p id="show_rahn_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rahn_amount" class="form-control" value="{{old('rahn_amount')}}" id="rahn_amount" placeholder="رهن"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('rahn_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="rentDiv" class="form-group col-md-3" style="display: none">
                        <div class="d-flex justify-content-between">
                            <label for="rent_amount">اجاره(تومان):</label>
                            <p id="show_rent_amount"></p>
                        </div>
                        <input maxlength="9" type="text" name="rent_amount" class="form-control" value="{{old('rent_amount')}}" id="rent_amount" placeholder="اجاره"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('rent_amount')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_work">نوع کاربری:</label>
                        <select class="form-control" name="type_work" id="type_work">
                            <option value="home" @selected(old('type_work') == 'home')>خانه</option>
                            <option value="office" @selected(old('type_work') == 'office')>دفتر</option>
                            <option value="commercial" @selected(old('type_work') == 'commercial')>تجاری</option>
                            <option value="training" @selected(old('type_work') == 'training')>اموزشی</option>
                            <option value="industrial" @selected(old('type_work') == 'industrial')>صنعتی</option>
                            <option value="other" @selected(old('type_work') == 'other')>سایر</option>
                        </select>
                        @error('type_work')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type_build">نوع ملک:</label>
                        <select class="form-control" name="type_build" id="type_build" onchange="changeTypeBuild()">
                            <option value="house" @selected(old('type_build') == 'house')>ویلایی</option>
                            <option value="apartment" @selected(old('type_build') == 'apartment')>ساختمان</option>
                            <option value="shop" @selected(old('type_build') == 'shop')>مغازه</option>
                            <option value="land" @selected(old('type_build') == 'land')>زمین</option>
                            <option value="workshop" @selected(old('type_build') == 'workshop')>کارگاه</option>
                            <option value="parking" @selected(old('type_build') == 'parking')>پارکینگ</option>
                            <option value="store" @selected(old('type_build') == 'store')>انباری</option>
                            <option value="hall" @selected(old('type_build') == 'hall')>سالن</option>
                        </select>
                        @error('type_build')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div id="documentDiv" class="form-group col-md-3">
                        <label for="type_build">نوع سند:</label>
                        <select class="form-control" name="document" id="document">
                            <option value="six_dongs" @selected(old('document') == 'six_dongs')>شش دانگ</option>
                            <option value="mangolehdar" @selected(old('document') == 'mangolehdar')>منقوله دار</option>
                            <option value="tak_bargeh" @selected(old('document') == 'tak_bargeh')>تک برگه</option>
                            <option value="varasehee" @selected(old('document') == 'varasehee')>ورثه ای</option>
                            <option value="almosana" @selected(old('document') == 'almosana')>المثنی</option>
                            <option value="vekalati" @selected(old('document') == 'vekalati')>وکالتی</option>
                            <option value="benchag" @selected(old('document') == 'benchag')>بنچاق</option>
                            <option value="sanad_rahni" @selected(old('document') == 'sanad_rahni')>سند رهنی</option>
                            <option value="gholnameh" @selected(old('document') == 'gholnameh')>قولنامه</option>
                        </select>
                        @error('document')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="images">عکسها:</label>
                        <input type="file" name="images[]" class="form-control" id="images"  multiple="multiple" placeholder="عکسها">
                        @error('images')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">آدرس:</label>
                        <textarea name="address" class="form-control" id="address" placeholder="آدرس" rows="3">{{old('address')}}</textarea>
                        @error('address')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row row-cols-md-5">
                    <div class="form-group col">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="checkbox" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>تخلیه
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <div class="form-check">
                            <label for="elevator" class="form-check-label">
                                <input type="checkbox" name="elevator" id="elevator" class="form-check-input" @checked(old('elevator') == 'on')>اسانسور
                            </label>
                        </div>
                        @error('elevator')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <div class="form-check">
                            <label for="parking" class="form-check-label">
                                <input type="checkbox" name="parking" id="parking" class="form-check-input" @checked(old('parking') == 'on')>پارکینگ
                            </label>
                        </div>
                        @error('parking')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <div class="form-check">
                            <label for="store" class="form-check-label">
                                <input type="checkbox" name="store" id="store" class="form-check-input" @checked(old('store') == 'on')>انبار
                            </label>
                        </div>
                        @error('store')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <div class="form-check">
                            <label for="exist_owner" class="form-check-label">
                                <input type="checkbox" name="exist_owner" id="exist_owner" class="form-check-input" @checked(old('exist_owner') == 'on')>حضور مالک
                            </label>
                        </div>
                        @error('exist_owner')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <button type="button" id="more_btn" class="btn btn-link text-decoration-none text-end text-white">تنضیمات بیشتر...</button>
                </div>
                <div id="more" class="row">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="year_of_construction">سال ساخت:</label>
                            <input type="text" name="year_of_construction" class="form-control" value="{{old('year_of_construction')}}" id="year_of_construction" placeholder="سال ساخت"
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                            @error('year_of_construction')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="year_of_reconstruction">سال بازسازی:</label>
                            <input type="text" name="year_of_reconstruction" class="form-control" value="{{old('year_of_reconstruction')}}" id="year_of_reconstruction" placeholder="سال بازساری"
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                            @error('year_of_reconstruction')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="number_of_rooms">تعداد اتاق:</label>
                            <input type="text" name="number_of_rooms" class="form-control" value="{{old('number_of_rooms')}}" id="number_of_rooms" placeholder="تعداد اتاق"
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                            @error('number_of_rooms')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 floor">
                            <label for="floor_number">تعداد طبقات کل:</label>
                            <input type="text" name="floor_number" class="form-control" value="{{old('floor_number')}}" id="floor_number" placeholder="تعداد طبقات کل ساختمان"
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                            @error('floor_number')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 num-floor">
                            <label for="floor">شماره طبقه:</label>
                            <input type="text" name="floor" class="form-control" value="{{old('floor')}}" id="floor" placeholder="شماره طبقه"
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                            @error('floor')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="floor_covering">پوشش کف:</label>
                            <select class="form-control" name="floor_covering" id="floor_covering">
                                <option value="null" @selected(old('floor_covering') == 'null')>انتخاب گزینه</option>
                                <option value="ceramic" @selected(old('floor_covering') == 'ceramic')>سرامیک</option>
                                <option value="mosaic" @selected(old('floor_covering') == 'mosaic')>موزاییک</option>
                                <option value="wooden" @selected(old('floor_covering') == 'wooden')>منقوله دارچوب</option>
                                <option value="pvc" @selected(old('floor_covering') == 'pvc')>پی وی سی</option>
                                <option value="others" @selected(old('floor_covering') == 'other')>سایر</option>
                            </select>
                            @error('floor_covering')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cooling">سرمایش:</label>
                            <select class="form-control" name="cooling" id="cooling">
                                <option value="null" @selected(old('cooling') == 'null')>انتخاب گزینه</option>
                                <option value="water_cooler" @selected(old('cooling') == 'water_cooler')>کولر ابی</option>
                                <option value="air_cooler" @selected(old('cooling') == 'air_cooler')>کولر گازی</option>
                                <option value="nothing" @selected(old('cooling') == 'nothing')>ندارد</option>
                            </select>
                            @error('cooling')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="heating">گرمایش:</label>
                            <select class="form-control" name="heating" id="heating">
                                <option value="null" @selected(old('heating') == 'null')>انتخاب گزینه</option>
                                <option value="heater" @selected(old('heating') == 'heater')>بخاری</option>
                                <option value="fire_place" @selected(old('heating') == 'fire_place')>شومینه</option>
                                <option value="underfloor_heating" @selected(old('heating') == 'underfloor_heating')>گرمایش از کف</option>
                                <option value="split" @selected(old('heating') == 'split')>اسپلیت</option>
                                <option value="nothing" @selected(old('heating') == 'nothing')>ندارد</option>
                            </select>
                            @error('heating')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cabinets">کابینت:</label>
                            <select class="form-control" name="cabinets" id="cabinets">
                                <option value="null" @selected(old('cabinets') == 'null')>انتخاب گزینه</option>
                                <option value="wooden" @selected(old('cabinets') == 'wooden')>چوب</option>
                                <option value="memberan" @selected(old('cabinets') == 'memberan')>ممبران</option>
                                <option value="metal" @selected(old('cabinets') == 'metal')>فلزی</option>
                                <option value="melamine" @selected(old('cabinets') == 'melamine')>ملامینه</option>
                                <option value="mdf" @selected(old('cabinets') == 'mdf')>ام دی اف</option>
                                <option value="mdf_and_metal" @selected(old('cabinets') == 'mdf_and_metal')>بدنه فلزی و در ام دی اف</option>
                                <option value="high_glass" @selected(old('cabinets') == 'high_glass')>های گلس</option>
                                <option value="noting" @selected(old('cabinets') == 'noting')>ندارد</option>
                            </select>
                            @error('heating')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="view">نما:</label>
                            <select class="form-control" name="view" id="view">
                                <option value="null" @selected(old('view') == 'null')>انتخاب گزینه</option>
                                <option value="brick" @selected(old('view') == 'brick')>اجری</option>
                                <option value="rock" @selected(old('view') == 'rock')>سنگی</option>
                                <option value="Cement" @selected(old('view') == 'Cement')>سیمانی</option>
                                <option value="composite" @selected(old('view') == 'composite')>کامپوزیت</option>
                                <option value="Glass" @selected(old('view') == 'Glass')>شیشه ای</option>
                                <option value="ceramic" @selected(old('view') == 'ceramic')>سرامیک</option>
                                <option value="hybrid" @selected(old('view') == 'hybrid')>ترکیبی</option>
                                <option value="others" @selected(old('view') == 'others')>سایر</option>
                            </select>
                            @error('view')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">توضیحات:</label>
                            <textarea name="description" class="form-control" id="description" placeholder="توضیحات" rows="3">{{old('description')}}</textarea>
                            @error('description')
                            <div class="alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
                </div>
            </form>
        </div>
    </div>
@endsection
