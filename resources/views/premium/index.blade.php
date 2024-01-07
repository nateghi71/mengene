@extends('layouts.auth')

@section('title' , 'ورود')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth register-half-bg">
        <div class="card col-lg-3 mx-auto">
            <div class="card-body">
                <h3 class="text-center pt-3">سه ماهه 299 تومان</h3>
                <ul class="list-unstyled px-3 py-5">
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> ثبت اطلاعات متقاضی</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">ثبت اطلاعات ملک</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> سامانه پیامکی(تا ماهانه 1000 sms)</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">مدیریت مشاورین(تا 4 عدد مشاور)</span></li>
                </ul>
                <div class="text-center pb-4">
                    <form action="{{route('packages.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="level" value="midLevel">
                        <button type="submit" class="btn btn-outline-success">پرداخت</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card col-lg-3 mx-auto">
            <div class="card-body">
                <h3 class="text-center pt-3">سالانه 899 تومان</h3>
                <ul class="list-unstyled px-3 py-5">
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3"> ثبت اطلاعات متقاضی</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">ثبت اطلاعات ملک</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">سامانه پیامکی(نامحدود)</span></li>
                    <li class="pb-2"><i class="mdi mdi-check text-success"></i><span class="pe-3">مدیریت مشاورین(نامحدود)</span></li>
                </ul>
                <div class="text-center pb-4">
                    <form action="{{route('packages.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="level" value="vip">
                        <button type="submit" class="btn btn-outline-success">پرداخت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
