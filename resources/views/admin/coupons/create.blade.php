@extends('layouts.admin' , ['sectionName' => 'ایجاد کوپن'])

@section('title' , 'ایجاد کوپن')

@section('head')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#expire_date").persianDatepicker({
                initialValue: false,
                minDate: new persianDate(),
                format: 'YYYY/MM/DD',
                autoClose: true
            });
        });
    </script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mb-3">ایجاد کوپن</h3></div>
                <div><a href="{{route('admin.coupons.index')}}" class="btn btn-primary p-2">نمایش کوپن ها</a></div>
            </div>
            <hr>
            <form action="{{route('admin.coupons.store')}}" method="post">
                @csrf

                <div class="row">
                    <div class="mb-3">
                        <label class="form-label" for="name">نام</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="نام"/>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="code">کد</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{old('code')}}" placeholder="کد"/>
                        @error('code')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="percentage">درصد</label>
                        <input type="text" name="percentage" id="percentage" class="form-control" value="{{old('percentage')}}" placeholder="درصد"/>
                        @error('percentage')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="expire_date">تاریخ انقضا</label>
                        <input type="text" name="expire_date" id="expire_date" class="form-control" value="{{old('expire_date')}}" onkeypress="return false"/>
                        @error('expired_at')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">توضیحات</label>
                        <textarea name="description" id="description" class="form-control" value="{{old('description')}}" placeholder="توضیحات"></textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary w-100 enter-btn">ایجاد</button>
                </div>
            </form>
        </div>
    </div>
@endsection
