@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
@endsection

@section('content')
    <form action="{{ route('2fa.confirm') }}" method="post" autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="code">ورود کد</label>
            <input type="text" name="code" value="{{old('code')}}" class="form-control" id="code">
            @error('code')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="text-center d-flex justify-content-between">
            <button type="submit" class="btn btn-primary enter-btn">تایید</button>
            <div>
                <a href="{{ route('2fa.resend') }}" class="btn btn-danger enter-btn">ارسال مجدد</a>
            </div>
        </div>
    </form>
@endsection
