@extends('layouts.auth')

@section('title' , 'یافتن املاکی')

@section('scripts')
@endsection

@section('content')
    <h3 class="card-title text-center mb-3">یافتن املاکی</h3>
    <form action="{{ route('consultant.search') }}" method="post" autocomplete="off">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" name="owner_number" value="{{old('owner_number')}}" placeholder="جستجوی بیزینس با شماره تلفن مالک" aria-label="Recipient's username" aria-describedby="searchBtn">
            <button class="btn btn-primary" type="submit" id="searchBtn">جست و جو</button>
            @error('owner_number')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <p class="sign-up">ایا می خواهید بیزنس بسازید؟<a class="text-decoration-none" href="{{route('business.create')}}"> ایجاد</a></p>
    </form>

@endsection
