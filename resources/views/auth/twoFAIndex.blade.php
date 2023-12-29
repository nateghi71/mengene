@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
@endsection

@section('content')
    <form action="{{ route('2fa.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="number">تلفن همراه</label>
            <input type="text" name="number" value="{{old('number')}}" class="form-control" id="number">
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
@endsection
