@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <form action="{{ route('2fa.store') }}" method="post" autocomplete="off">
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

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 enter-btn">ارسال کد</button>
                    </div>
                    <p class="sign-up text-center">حساب کاربری دارید؟<a class="text-decoration-none" href="{{route('login')}}"> ورود</a></p>
                </form>

            </div>
        </div>
    </div>

@endsection
