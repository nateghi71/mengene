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
                        <img src="{{asset(env('BUSINESS_IMAGES_UPLOAD_PATH')) . '/' . $business->image}}" style="max-width: 80%; height: 400px">
                    </p>

                    <p>
                        <a href="{{route('business.edit',['business'=>$business->id])}}">ویرایش</a>
                    </p>
                    <br>
                    <form action="{{route('business.destroy',['business'=>$business->id])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">لغو همکاری</button>
                    </form>
                </div>
                <br>
                <br>
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    :اعضای بیزینس
                    <table style="border: 2px black solid; width: 100%; text-align: center">
                        <tr style="border:1px black solid">
                            <th>انتخاب مالک</th>
                            <th>غیرفعال کردن</th>
                            <th>تعداد آگهی های ثبت کرده</th>
                            <th>شهر</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>
                            <th>نام</th>
                        </tr>
                        @foreach($acceptedMember as $member)
                                <tr>

                                    <td>
                                        <a
                                            href="{{ route('business.chooseOwner', ['user' => $member->id]) }}">انتخاب
                                            مالک</a>

                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}">غیرفعال</a>

                                    </td>
                                    <td>{{$member->added}}</td>
                                    <td>{{$member->city}}</td>
                                    <td>{{$member->number}}</td>
                                    <td>{{$member->email}}</td>
                                    <td>{{$member->name}}</td>
                                </tr>
                        @endforeach
                    </table>
                </div>
                <br>
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

                        @foreach($notAcceptedMember as $member)
                        <tr>

                            <td>
                                <a href="{{route('business.remove.member',['user'=>$member->id])}}">حذف</a>
                            </td>
                            <td>
                                <a href="{{ route('business.toggleUserAcceptance', ['user' => $member->id]) }}">قبول</a>
                            </td>
                            <td>{{$member->city}}</td>
                            <td>{{$member->number}}</td>
                            <td>{{$member->email}}</td>
                            <td>{{$member->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
