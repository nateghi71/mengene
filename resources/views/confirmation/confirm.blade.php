@extends('layouts.auth')

@section('title' , 'تاییدیه')

@section('scripts')
@endsection

@section('content')
    @if($type === 'expired')
        <p  class="mb-4 text-center">{{$requestedPerson instanceof \App\Models\Landowner
                             ? 'ایا هنوز برای زمین خود به دنبال مشتری هستید؟'
                             : 'ایا هنوز به دنبال خانه می گردید؟'}}
        </p>
        <form action="{{route('confirmation.handle.expired')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <input type="hidden" name="type" value="{{$type}}">
            <div class="d-flex justify-content-around">
                <div class="">
                    <div class="form-check">
                        <label class="form-check-label" for="response1">
                            <input type="radio" class="form-check-input" name="response" id="response1" value="0"> خیر </label>
                    </div>
                </div>
                <div class="">
                    <div class="form-check">
                        <label class="form-check-label" for="response2">
                            <input type="radio" class="form-check-input" name="response" id="response2" value="1"> بله </label>
                    </div>
                </div>
            </div>

            <button class="btn w-100 btn-primary mt-4" type="submit"> ارسال </button>
        </form>
    @elseif($type === 'remove_from_suggestion')
        <p>{{$requestedPerson instanceof \App\Models\Landowner
                             ? 'ایا به '. $suggestionPerson->name .' مشتری خانه می فروشید؟'
                             : 'ایا '.$suggestionPerson->name.' خانه را همچنان مدنظر دارید؟'}}
        </p>

        <form action="{{route('confirmation.handle.suggestion')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <input type="hidden" name="type" value="{{$type}}">
            <div class="d-flex justify-content-around">
                <div class="">
                    <div class="form-check">
                        <label class="form-check-label" for="response1">
                            <input type="radio" class="form-check-input" name="response" id="response1" value="0"> خیر </label>
                    </div>
                </div>
                <div class="">
                    <div class="form-check">
                        <label class="form-check-label" for="response2">
                            <input type="radio" class="form-check-input" name="response" id="response2" value="1"> بله </label>
                    </div>
                </div>
            </div>
            <button class="btn w-100 btn-primary mt-4" type="submit"> ارسال </button>
        </form>
    @endif
@endsection
