@extends('layouts.auth')

@section('title' , 'تغییر پسورد')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">ورود</h3>
                <form action="{{route('password.update')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="number">تلفن همراه</label>
                        <input type="text" name="number" value="{{old('number')}}" class="form-control" id="number"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        @error('number')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">رمز ورود</label>
                        <input type="password" name="password" value="{{old('password')}}" class="form-control" id="password" placeholder="رمز ورود">
                        @error('password')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تکرار رمز ورود</label>
                        <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" id="password_confirmation" placeholder="تکرار رمز ورود">
                        <input type="hidden" name="token" value="{{$token}}">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">تایید</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
