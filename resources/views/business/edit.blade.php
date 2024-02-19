@extends('layouts.dashboard' , ['sectionName' => 'ویرایش بیزنس'])

@section('title' , 'ویرایش بیزنس')

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
                                let selected = false;
                                if(city.id == "{{$business->city_id}}")
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
    </script>
@endsection

@section('content')
    <div class="card col-md-6 mx-auto">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title text-center mb-3">ویرایش املاکی</h3></div>
                <div><a href="{{route('dashboard')}}" class="btn btn-primary p-2">داشبورد</a></div>
            </div>
            <hr>
            <form action="{{route('business.update',$business->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name"> نام املاکی: *</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$business->name}}" placeholder="نام املاکی">
                    @error('name')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="province">استان املاک:</label>
                    <select class="form-control" id="province">
                        @foreach($provinces as $province)
                            <option value="{{$province->id}}" @selected($business->city->province_id === $province->id)>{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">شهر املاک:</label>
                    <select name="city_id" class="form-control" id="city">
                    </select>
                    @error('city_id')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="area">منطقه: *</label>
                    <input type="text" name="area" class="form-control" value="{{$business->area}}" id="area" placeholder="منطقه">
                    @error('area')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror

                </div>
                <div class="form-group">
                    <label for="address">آدرس: *</label>
                    <textarea name="address" class="form-control" id="address" placeholder="آدرس" rows="3">{{$business->address}}</textarea>
                    @error('address')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror

                </div>
                <div class="form-group ">
                    <label for="image">عکس: *</label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="عکس">
                    @error('image')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ویرایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection
