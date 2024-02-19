@extends('layouts.auth')

@section('title' , 'ایجاد املاکی')

@section('head')
    <style>

    </style>
@endsection

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
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth register-half-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 pb-5 pt-2">
                <p class="sign-up mb-4">ورود به عنوان مشاور و پیوستن به املاکی:<a class="text-decoration-none" href="{{route('consultant.find')}}"> مشاورین</a></p>
                <h3 class="card-title text-center mb-3">ایجاد املاکی</h3>
                <form action="{{ route('business.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name"> نام املاکی: *</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="نام املاکی">
                        @error('name')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="area">مناطق شهرداری: *</label>
                        <input type="text" name="area" class="form-control" value="{{old('area')}}" id="area" placeholder="منطقه">
                        @error('area')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">آدرس: *</label>
                        <textarea name="address" class="form-control" id="address" placeholder="آدرس" rows="4">{{old('address')}}</textarea>
                        @error('address')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">عکس جواز کسب: *</label>
                        <input type="file" name="image" class="form-control" id="image" placeholder="عکس">
                        @error('image')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="text-center pt-3">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
