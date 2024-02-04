@extends('layouts.dashboard' , ['sectionName' => 'تغییر رمز ورود'])

@section('title' , 'تغییر رمز ورود')

@section('scripts')
@endsection

@section('content')
    <div class="card col-md-6 mx-auto">
        <div class="card-body px-5 py-4">
            <h3 class="card-title mb-3">تغییر رمز ورود</h3>
            <hr class="my-4">
            <form action="{{ route('profile.update_password') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="old_password">رمز ورود فعلی*</label>
                    <input type="password" name="old_password" value="{{old('old_password')}}" class="form-control" id="old_password" placeholder="رمز ورود فعلی">
                    @error('old_password')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password">رمز ورود جدید *</label>
                    <input type="password" name="new_password" value="{{old('new_password')}}" class="form-control" id="new_password" placeholder="رمز ورود جدید">
                    @error('new_password')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">تکرار رمز ورود جدید *</label>
                    <input type="password" name="new_password_confirmation" value="{{old('new_password_confirmation')}}" class="form-control" id="new_password_confirmation" placeholder="تکرار رمز ورود جدید">
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">تایید</button>
                </div>
            </form>
        </div>
    </div>
@endsection
