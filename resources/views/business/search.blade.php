<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ایجاد محصول جدید') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">


                    @if($business)
                        <p>نام بیزینس: {{ $business->name }}</p>
                        <p>شماره بیزینس: {{ $business->user->number }}</p>
                        <form action="{{ route('business.join') }}" method="POST">
                            @csrf
                            <input type="hidden" name="business_id" value="{{ $business->id}}">
                            <button type="submit">پیوستن</button>
                        </form>
                    @else
                        <p>هیچ بیزینسی پیدا نشد</p>
                    @endif

                </div>
                <a href="{{route('customers')}}">بازگشت</a>

            </div>
        </div>
    </div>

</x-app-layout>
