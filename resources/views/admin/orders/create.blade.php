@extends('layouts.admin' , ['sectionName' => 'ایجاد سفارش'])

@section('title' , 'ایجاد سفارش')

@section('head')
@endsection

@section('scripts')
    <script>
    </script>

@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mb-3">ایجاد سفارش</h3></div>
                <div><a href="{{route('admin.orders.index')}}" class="btn btn-primary p-2">نمایش سفارش ها</a></div>
            </div>
            <hr>
            <form action="{{route('admin.orders.store')}}" method="post">
                @csrf

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="user_id">کاربر:</label>
                        <select class="form-control" name="user_id" id="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" @selected(old('user_id') == $user->id)>{{$user->name . ' ('. $user->number .')'}}</option>
                            @endforeach
                        </select>
                        @error('payment_type')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-group col-md-3">
                        <label class="form-label" for="amount">قیمت محصول</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{old('amount')}}" placeholder="قیمت محصول"/>
                        @error('amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-group col-md-3">
                        <label class="form-label" for="tax_amount">مبلغ مالیات</label>
                        <input type="text" name="tax_amount" id="tax_amount" class="form-control" value="{{old('tax_amount')}}" placeholder="مبلغ مالیات"/>
                        @error('tax_amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-group col-md-3">
                        <label class="form-label" for="paying_amount">مبلغ پرداختی</label>
                        <input type="text" name="paying_amount" id="paying_amount" class="form-control" value="{{old('paying_amount')}}" placeholder="مبلغ پرداختی"/>
                        @error('paying_amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="payment_type">شیوه ی پرداخت:</label>
                        <select class="form-control" name="payment_type" id="payment_type">
                            <option value="pos" @selected(old('payment_type') == 'pos')>ستگاه پوز</option>
                            <option value="cash" @selected(old('payment_type') == 'cash')>پول نقد</option>
                            <option value="shabaNumber" @selected(old('payment_type') == 'shabaNumber')>شماره شبا</option>
                            <option value="cardToCard" @selected(old('payment_type') == 'cardToCard')>کارت به کارت</option>
                            <option value="online" @selected(old('payment_type') == 'online')>انلاین</option>
                        </select>
                        @error('payment_type')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="order_type">نوع سفارش:</label>
                        <select class="form-control" name="order_type" id="order_type">
                            <option value="buy_file" @selected(old('order_type') == 'buy_file')>خرید فایل</option>
                            <option value="buy_package" @selected(old('order_type') == 'buy_package')>خرید پکیج</option>
                            <option value="buy_credit" @selected(old('order_type') == 'buy_credit')>شارژ حساب</option>
                        </select>
                        @error('order_type')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-group col-md-6">
                        <label class="form-label" for="description">توضیحات</label>
                        <textarea name="description" id="description" class="form-control" value="{{old('description')}}" placeholder="توضیحات"></textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-3">
                        <div class="form-check">
                            <label for="payment_status" class="form-check-label">
                                <input type="checkbox" name="payment_status" id="payment_status" class="form-check-input" @checked(old('payment_status') == 'on')>پرداخت موفق
                            </label>
                        </div>
                        @error('payment_status')
                        <div class="alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
                </div>
            </form>
        </div>
    </div>
@endsection
