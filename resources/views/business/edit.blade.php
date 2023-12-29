@extends('layouts.dashboard' , ['showBanner' => false , 'sectionName' => 'ویرایش بیزنس'])

@section('title' , 'ویرایش بیزنس')

@section('scripts')
@endsection

@section('content')
    <div class="card col-md-6 mx-auto">
        <div class="card-body px-5 py-4">
            <h3 class="card-title text-center mb-3">ویرایش املاکی</h3>
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
                    <label for="en_name">نام انگلیسی: *</label>
                    <input type="text" name="en_name" class="form-control" value="{{$business->en_name}}" id="en_name" placeholder="نام انگلیسی">
                    @error('en_name')
                    <div class="alert-danger">{{$message}}</div>
                    @enderror

                </div>
                <div class="form-group">
                    <label for="city">شهر:</label>
                    <input type="text" name="city" class="form-control" value="{{$business->city}}" id="city" placeholder="شهر">
                    @error('city')
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
