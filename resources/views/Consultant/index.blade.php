<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row-reverse">
            {{ __('بیزینس') }}
        </h2>
    </x-slot>
    {{--    {{dd($business->owner()->first()->id)}}--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    @if($user->isBusinessMemberDeactive())
                        <p style="color: red">
                            در انتظار تایید مالک بیزینس
                        </p>
                    @endif
                    <p> نام: {{$business->name}}  </p>

                    <p> {{$business->en_name}} :نام انگلیسی </p>

                    <p> @php
                            if($business->user_id == $business->owner()->first()->id){
                                echo $business->owner()->first()->name;}
                        @endphp
                        :نام مالک
                    </p>
                    <p> شهر: {{$business->city}}  </p>
                    <p> منطقه: {{$business->area}}  </p>
                    <p> آدرس: {{$business->address}}  </p>
                    <p>:عکس مجوز
                        <img src="{{$business->image}}" style="max-width: 80%; height: 400px">
                    </p>
                    <br>


                </div>
                <br>
                @if($user->isBusinessMember())
                    <p>
                        <a href="{{route('consultant.leave.member',['user'=>auth()->id()])}}">لغو همکاری</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
