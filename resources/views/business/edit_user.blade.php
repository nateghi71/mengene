@extends('layouts.dashboard' , ['sectionName' => 'ویرایش حساب کاربری'])

@section('title' , 'ویرایش حساب کاربری')

@section('head')
@endsection

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
                                if(city.id == "{{$user->city_id}}")
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
            <h3 class="card-title mb-3">ویرایش حساب کاربری</h3>
            <hr class="my-4">
            <form action="{{ route('profile.update_user' , ['user' => $user->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name"> نام و نام خانوادگی *</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" id="name" placeholder="نام">
                    @error('name')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="number"> شماره موبایل *</label>
                    <input type="text" name="number" value="{{$user->number}}" class="form-control" id="number" placeholder="شماره موبایل">
                    @error('number')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="province">استان:</label>
                    <select class="form-control" id="province">
                        @foreach($provinces as $province)
                            <option value="{{$province->id}}" @selected($user->city->province_id === $province->id)>{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">شهر:</label>
                    <select name="city_id" class="form-control" id="city">
                    </select>
                    @error('city_id')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="text" name="email" value="{{$user->email}}" class="form-control" id="email" placeholder="ایمیل">
                    @error('email')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ویرایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection
