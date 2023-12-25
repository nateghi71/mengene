    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    @if($type === 'expired')
                        <p>{{$requestedPerson instanceof \App\Models\Landowner
                             ? 'ایا هنوز برای زمین خود به دنبال مشتری هستید؟'
                             : 'ایا هنوز به دنبال خانه می گردید؟'}}
                        </p>
                        <form action="{{route('confirmation.handle.expired')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{$token}}">
                            <input type="hidden" name="type" value="{{$type}}">
                            <div>
                                <input type="radio" id="response1" name="response" value="1">
                                <label for="response1">بله</label>
                            </div>
                            <div>
                                <input type="radio" id="response2" name="response" value="0">
                                <label for="response2">خیر</label>
                            </div>
                            <button type="submit"> ارسال </button>
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
                            <div>
                                <input type="radio" id="response1" name="response" value="1">
                                <label for="response1">بله</label>
                            </div>
                            <div>
                                <input type="radio" id="response2" name="response" value="0">
                                <label for="response2">خیر</label>
                            </div>
                            <button type="submit"> ارسال </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
