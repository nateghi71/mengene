@extends('layouts.auth')

@section('title' , 'تغییر پسورد')

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <form action="{{ route('password.send') }}" method="post">
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
                        <button type="submit" class="btn btn-primary w-100 enter-btn">تایید</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
