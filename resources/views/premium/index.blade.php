@extends('layouts.auth')

@section('title' , 'ورود')

@section('scripts')
@endsection

@section('content')
    <div class="row content-wrapper full-page-wrapper d-flex align-items-center auth register-half-bg">
        @foreach($packages as $package)
            <div class="col-lg-3 mx-auto mb-3">
                <div class="card">
                    <div class="card-body">
                        @if($package->name === 'free')
                            <h3 class="text-center pt-3">سرویس رایگان</h3>
                            <h4 class="text-center pt-3">یکساله رایگان</h4>
                        @elseif($package->name === 'bronze')
                            <h3 class="text-center pt-3">سرویس برنزی</h3>
                            <h4 class="text-center pt-3">سه ماهه 599,000 تومان</h4>
                        @elseif($package->name === 'silver')
                            <h3 class="text-center pt-3">سرویس نقره ای</h3>
                            <h4 class="text-center pt-3">6 ماهه 899,000 تومان</h4>
                        @elseif($package->name === 'golden')
                            <h3 class="text-center pt-3">سرویس طلایی</h3>
                            <h4 class="text-center pt-3">سالانه 1,199,000 تومان</h4>
                        @endif
                        <ul class="list-unstyled px-2 py-5">
                            <li class="pb-2">
                                <i class="mdi mdi-check text-success"></i>
                                <span class="pe-3"> ثبت اطلاعات متقاضی</span>
                            </li>
                            <li class="pb-2">
                                <i class="mdi mdi-check text-success"></i>
                                <span class="pe-3">ثبت اطلاعات ملک</span>
                            </li>
                            <li class="pb-2">
                                <i @class(['mdi mdi-check' , 'text-success' => $package->name !== 'free' ,  'text-muted' => $package->name === 'free'])></i>
                                <span @class(['pe-3' , 'text-muted text-decoration-line-through' => $package->name === 'free'])>
                                    سامانه پیامکی
                                </span>
                            </li>
                            <li class="pb-2">
                                <i @class(['mdi mdi-check' , 'text-success' => $package->name !== 'free' ,  'text-muted' => $package->name === 'free'])></i>
                                <span @class(['pe-3' , 'text-muted text-decoration-line-through' => $package->name === 'free'])>
                                    مدیریت مشاورین
                                    @if($package->name === 'bronze')
                                        (تا 2 عدد مشاور)
                                    @elseif($package->name === 'silver')
                                        (تا 3 عدد مشاور)
                                    @elseif($package->name === 'golden')
                                        (نامحدود)
                                    @endif
                                </span>
                            </li>
                            <li class="pb-2">
                                <i @class(['mdi mdi-check' , 'text-success' => $package->name !== 'free' ,  'text-muted' => $package->name === 'free'])></i>
                                <span @class(['pe-3' , 'text-muted text-decoration-line-through' => $package->name === 'free'])>
                                    ثبت هشدار پیامکی
                                </span>
                            </li>
                            <li class="pb-2">
                                <i @class(['mdi mdi-check' , 'text-success' => $package->name !== 'free' ,  'text-muted' => $package->name === 'free'])></i>
                                <span @class(['pe-3' , 'text-muted text-decoration-line-through' => $package->name === 'free'])>
                                    دسترسی به فایل های ویژه
                                </span>
                            </li>
                        </ul>
                        <div class="text-center pb-4">
                            @if($package->name === auth()->user()->business()->premium->package->name)
                                <button type="button" class="btn btn-success">پلن فعلی</button>
                            @elseif($package->price < auth()->user()->business()->premium->package->price)
                                <button type="button" class="btn text-danger">غیرفعال</button>
                            @else
{{--                                @php--}}
{{--                                session()->put('packageName' , $package->name);--}}
{{--                                @endphp--}}
{{--                                <a href="{{route('packages.checkout')}}" class="btn btn-outline-success p-2">پرداخت</a>--}}
                                <form action="{{route('packages.get_package')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="package_name" value="{{$package->name}}">
                                    <button type="submit" class="btn btn-outline-success">پرداخت</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
