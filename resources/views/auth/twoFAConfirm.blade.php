@extends('layouts.auth')

@section('title' , 'ثبت نام')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <form action="{{ route('2fa.confirm') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="code">ورود کد</label>
                        <input type="text" name="code" value="{{old('code')}}" class="form-control" id="code"
                               onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
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

            </div>
        </div>
    </div>

@endsection
