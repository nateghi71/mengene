@extends('layouts.auth')

@section('title' , 'ورود')

@section('scripts')
@endsection

@section('content')
    <div class="row content-wrapper full-page-wrapper d-flex align-items-center auth register-half-bg">
        <div class="col-lg-3 mx-auto mb-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center pt-3">رایگان</h3>
                    <ul class="list-unstyled px-3 py-5">
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> ثبت اطلاعات متقاضی</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">ثبت اطلاعات ملک</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> سامانه پیامکی(فقط برای مشتری)</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">مدیریت مشاورین(ندارد)</span></li>
                    </ul>
                    <div class="text-center pb-4">
                        @if(auth()->user()->isFreeUser())
                            <button type="button" class="btn btn-success">پلن فعلی</button>
                        @else
                            <button type="button" class="btn text-danger">غیرفعال</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3 mx-auto mb-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center pt-3">سه ماهه 299 تومان</h3>
                    <ul class="list-unstyled px-2 py-5">
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> ثبت اطلاعات متقاضی</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">ثبت اطلاعات ملک</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> سامانه پیامکی(تا ماهانه 1000 sms)</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">مدیریت مشاورین(تا 4 عدد مشاور)</span></li>
                    </ul>
                    <div class="text-center pb-4">
                        @if(auth()->user()->isFreeUser())
                            <form action="{{route('packages.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="level" value="midLevel">
                                <button type="submit" class="btn btn-outline-success">پرداخت</button>
                            </form>
                        @elseif(auth()->user()->isMidLevelUser())
                            <button type="button" class="btn btn-success">پلن فعلی</button>
                        @else
                            <button type="button" class="btn text-danger">غیرفعال</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3 mx-auto mb-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center pt-3">سالانه 899 تومان</h3>
                    <ul class="list-unstyled px-3 py-5">
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> ثبت اطلاعات متقاضی</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">ثبت اطلاعات ملک</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">سامانه پیامکی(نامحدود)</span></li>
                        <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">مدیریت مشاورین(نامحدود)</span></li>
                    </ul>
                    <div class="text-center pb-4">
                        @if(auth()->user()->isFreeUser() || auth()->user()->isMidLevelUser())
                            <form action="{{route('packages.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="level" value="vip">
                                <button type="submit" class="btn btn-outline-success">پرداخت</button>
                            </form>
                        @else
                            <button type="button" class="btn btn-success">پلن فعلی</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <a class="text-decoration-none text-white" href="{{route('dashboard')}}">
                    <div class="card bg-danger bg-gradient">
                        <div class="card-body text-center px-0 py-2">
                            بازگشت
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
