@extends('layouts.auth')

@section('title' , 'ورود')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">ورود</h3>
                <form action="{{route('login.handle')}}" method="post" autocomplete="off">
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
                        <input type="password" name="password" value="{{old('password')}}" class="form-control" id="password">
                        @error('password')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" name="remember_me" class="form-check-input">مرا بخاطر بسپار
                            </label>
                        </div>
                        <a href="#" class="forgot-pass text-decoration-none">فراموشی پسورد</a>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">ورود</button>
                    </div>
                    <p class="sign-up">ایا ثبت نام نکرده اید؟<a class="text-decoration-none" href="{{route('2fa.enter_number')}}"> ثبت نام</a></p>
                </form>

            </div>
        </div>
    </div>

@endsection
