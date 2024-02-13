<div class="row">
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">عبارتست از تملیک منافع</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-8 col-form-label">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>دانگ
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>دستگاه
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>یک باب
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label class="col-sm-3 col-form-label" for="address">به آدرس</label>
            <div class="col-sm-9">
                <textarea name="address" class="form-control" id="address" placeholder="آدرس" rows="3">{{old('address')}}</textarea>
                @error('address')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">دارای پلاک ثبتی شماره</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">فرعی از</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">اصلی</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">بخش</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">به مساحت</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-8">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">متر مربع دارای سند مالکیت به شماره سریال</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">صفحه</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">دفتر</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">بنام</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">مشتمل بر</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-6 col-form-label">
                <div class="row">
                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">اتاق خواب با حق استفاده</label>
                    <div class="form-group col-sm-2">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="checkbox" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')> برق
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="checkbox" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>آب
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="checkbox" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>گاز
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </label>
            <div class="col-sm-6">
                <div class="row">
                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">به صورت </label>
                    <div class="form-group col-sm-4">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')> اختصاصی
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <div class="form-check">
                            <label for="discharge" class="form-check-label">
                                <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>اشتراکی
                            </label>
                        </div>
                        @error('discharge')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">شوفاژ</label>

            <div class="form-group col-sm-3">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>روشن
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>غیر روشن
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="checkbox" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')> کولر
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>

        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">فرعی به متراژ</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label"> متر مربع/انباری فرعی</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label"> به متراژ</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">متر مربع تلفن </label>
            <div class="form-group col-sm-4">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')> دایر
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group col-sm-4">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>غیر دایر
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group col-md-4">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label"> به شماره</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="row">
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">و سایر لوازم و منصوبات و مشاعات مربوطه که جهت استفاده به رویت</label>
            <div class="form-group col-sm-2">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')> مستاجر
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group col-sm-2">
                <div class="form-check">
                    <label for="discharge" class="form-check-label">
                        <input type="radio" name="discharge" id="discharge" class="form-check-input" @checked(old('discharge') == 'on')>مستاجرین
                    </label>
                </div>
                @error('discharge')
                <div class="alert-danger">{{$message}}</div>
                @enderror
            </div>
            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">رسیده و مورد قبول قرار گرفته است.</label>
        </div>
    </div>
</div>
