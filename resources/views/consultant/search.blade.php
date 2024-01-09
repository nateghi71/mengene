@extends('layouts.auth')

@section('title' , 'یافتن املاکی')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth register-half-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <td>نام</td>
                        <td>{{$business->name}}</td>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>شهر</td>
                        <td>{{$business->city->name}}</td>
                    </tr>
                    <tr>
                        <td>ادرس</td>
                        <td>{{$business->address}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form action="{{ route('consultant.join') }}" method="POST">
                                @csrf
                                <input type="hidden" name="business_id" value="{{ $business->id}}">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100 enter-btn">پیوستن</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
