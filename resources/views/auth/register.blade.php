@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
@endsection

@section('content')
    <h3 class="card-title text-center mb-3">ثبت نام</h3>
    <form action="{{ route('register.handle') }}" method="post" autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="name"> نام *</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="نام">
            @error('name')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="city">شهر *</label>
            <input type="text" name="city" value="{{old('city')}}" class="form-control" id="city" placeholder="شهر">
            @error('city')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">ایمیل</label>
            <input type="text" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="ایمیل">
            @error('email')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>
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
@endsection
