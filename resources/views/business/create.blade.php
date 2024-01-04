@extends('layouts.auth')

@section('title' , 'ایجاد املاکی')

@section('scripts')
@endsection

@section('content')
    <h3 class="card-title text-center mb-3">ایجاد املاکی</h3>
    <form action="{{ route('business.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="name"> نام املاکی: *</label>
            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="نام املاکی">
            @error('name')
            <div class="alert-danger">{{$message}}</div>
            @enderror

        </div>
        <div class="form-group">
            <label for="en_name">نام انگلیسی: *</label>
            <input type="text" name="en_name" class="form-control" value="{{old('en_name')}}" id="en_name" placeholder="نام انگلیسی">
            @error('en_name')
            <div class="alert-danger">{{$message}}</div>
            @enderror

        </div>
        <div class="form-group">
            <label for="city">شهر املاک:</label>
            <input type="text" name="city" class="form-control" value="{{old('city')}}" id="city" placeholder="شهر">
            @error('city')
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
            <label for="image">عکس مجوز کسب: *</label>
            <input type="file" name="image" class="form-control" id="image" placeholder="عکس">
            @error('image')
            <div class="alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="text-center pt-3">
            <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
        </div>
        <p class="sign-up">ایا می خواهید به یک بیزنس بپیوندید؟<a class="text-decoration-none" href="{{route('consultant.find')}}"> یافتن</a></p>
    </form>
@endsection
