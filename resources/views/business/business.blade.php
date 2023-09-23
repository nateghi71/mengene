<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row-reverse">
            {{ __('بیزینس') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    <p> نام: {{$business->name}}  </p>
                    <p> {{$business->en_name}} :نام انگلیسی </p>
                    <p> {{$user->name}} :نام مالک </p>
                    <p> شهر: {{$business->city}}  </p>
                    <p> منطقه: {{$business->area}}  </p>
                    <p> آدرس: {{$business->address}}  </p>
                    <p>:عکس مجوز
                        <img src="{{$business->image}}" style="max-width: 80%; height: 400px"></p>
                    @if($business->user_id == auth()->id())
                        <p>
                            <a href="{{route('business.edit',['business'=>$business->id])}}">ویرایش</a>
                        </p>
                    @endif
                    <br>
                    {{--                    {{dd($business)}}--}}
                    <p><a href="{{route('business.delete',['business'=>$business->id])}}">لغو همکاری</a>
                    </p>
                </div>
                <br>
                <br>
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    :اعضای بیزینس
                    <table style="border: 2px black solid; width: 100%; text-align: center">
                        <tr style="border:1px black solid">
                            <th>انتخاب مالک</th>
                            <th>غیرفعال کردن</th>
                            <th>شهر</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>
                            <th>نام</th>
                        </tr>
                        @foreach($members as $member)
                            @if($member->isBusinessMember())
                                <tr>

                                    <td>
                                        <a
                                            href="{{ route('business.chooseOwner', ['userId' => $member->id]) }}">انتخاب
                                            مالک</a>

                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('business.toggleUserAcceptance', ['userId' => $member->id]) }}">غیرفعال</a>

                                    </td>
                                    <td>{{$member->city}}</td>
                                    <td>{{$member->number}}</td>
                                    <td>{{$member->email}}</td>
                                    <td>{{$member->name}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
                <br>
                @if($business->user_id === auth()->id())
                    <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                        :درخواست های جدید
                        <table style="border: 2px black solid; width: 100%; text-align: center">
                            <tr style="border:1px black solid">
                                <th>رد کردن</th>
                                <th>قبول کردن</th>
                                <th>شهر</th>
                                <th>شماره تماس</th>
                                <th>ایمیل</th>
                                <th>نام</th>
                            </tr>

                            @php foreach($members as $member){
                            if (!$member->isBusinessMember()){
                            @endphp

                            <tr>

                                <td>
                                    <a href="{{route('business.remove.member',['userId'=>$member->id])}}">حذف</a>
                                </td>
                                <td>
                                    <a href="{{ route('business.toggleUserAcceptance', ['userId' => $member->id]) }}">قبول</a>
                                </td>
                                <td>{{$member->city}}</td>
                                <td>{{$member->number}}</td>
                                <td>{{$member->email}}</td>
                                <td>{{$member->name}}</td>
                            </tr>
                            @php

                                }}
                            @endphp
                        </table>
                    </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
