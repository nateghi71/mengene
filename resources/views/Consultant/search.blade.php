@extends('layouts.auth')

@section('title' , 'یافتن املاکی')

@section('scripts')
@endsection

@section('content')
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
            <td>{{$business->city}}</td>
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
@endsection
