<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
        <form method="POST" action="{{ route('2fa.confirm') }}">
        @csrf

        <!-- Name -->
            <div style="text-align: right">
                <x-label for="code" :value="__(':کد فعال سازی')"/>

                <x-input minlength="6" maxlength="6" id="code" class="block mt-1 w-full" type="text" name="code"
                         required
                         autofocus/>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <input name="userNumber" type="hidden" value="{{$userNumber}}">

            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('تایید') }}
                </x-button>

            </div>

            <!-- Email Address -->

            <!-- Password -->

            <!-- Confirm Password -->


        </form>
        <div class="flex items-center justify-end mt-4">
            <form action="{{ route('2fa.resend') }}" method="POST">
                @csrf
                <input name="userNumber" type="hidden" value="{{$userNumber}}">
                <button class="underline text-sm text-gray-600 hover:text-gray-900"
                        type="submit">{{ __('ارسال مجدد') }}</button>

            </form>

        </div>
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('2fa.index') }}">
            {{ __('بازگشت') }}
        </a>
    </x-auth-card>
</x-guest-layout>
