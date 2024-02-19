@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
    <script type="module">
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
                                console.log(city);
                                $("#city").append('<option value="' + city.id + '">' +
                                    city.name + '</option>');
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
    </script>

@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">ثبت نام</h3>
                <form action="{{ route('register.handle') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name"> نام و نام خانوادگی *</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="نام">
                        @error('name')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="province">استان:</label>
                        <select class="form-control" id="province">
                            @foreach($provinces as $province)
                                <option value="{{$province->id}}">{{$province->name}}</option>
                            @endforeach
                        </select>
                        @error('province')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">شهر:</label>
                        <select name="city_id" class="form-control" id="city">
                        </select>
                        @error('city_id')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label for="email">ایمیل (اختیاری)</label>--}}
{{--                        <input type="text" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="ایمیل">--}}
{{--                        @error('email')--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            {{$message}}--}}
{{--                        </div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="password">رمز ورود *</label>
                        <input type="password" name="password" value="{{old('password')}}" class="form-control" id="password" placeholder="رمز ورود">
                        @error('password')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تکرار رمز ورود *</label>
                        <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" id="password_confirmation" placeholder="تکرار رمز ورود">
                    </div>
                    <div class="form-group">
                        <label for="role">نقش *</label>
                        <select name="role" class="form-control" id="role">
                            <option value="1">املاکی</option>
                            <option value="0">مشاور</option>
                        </select>
                        @error('role')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center pt-3">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">ثبت نام</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
