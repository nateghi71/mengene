<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="display: flex; flex-direction:row-reverse">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">
                    <h3><b>{{$user->name}}</b> خوش آمدید</h3>
                    <p><b>{{$user->email}}</b> :ایمیل شما </p>
                    <p><b>{{$user->number}}</b> :تلفن همراه شما</p>
                </div>
            </div>
        </div>

</x-app-layout>
