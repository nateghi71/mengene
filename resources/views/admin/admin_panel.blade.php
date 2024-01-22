@extends('layouts.admin' , ['sectionName' => 'نقش ها'])

@section('title' , 'نقش ها')

@section('head')

@endsection

@section('scripts')
    <script>
        $('.btn-close').on('click' , function (){
            $('#message').remove()
        })
    </script>
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success d-flex justify-content-between" id="message">
            {{session()->get('message')}}
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">ادمین پنل</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
