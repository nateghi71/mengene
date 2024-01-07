@extends('layouts.auth')

@section('title' , 'تاییدیه')

@section('scripts')
@endsection

@section('content')
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">{{$message}}</h3>
            </div>
        </div>
    </div>
@endsection
