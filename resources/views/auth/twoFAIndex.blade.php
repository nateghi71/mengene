<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('2fa.store') }}">
        @csrf

        <!-- Name -->
            <div style="text-align: right">
                <x-label for="number" :value="__(':تلفن همراه')"/>

                <x-input minlength="11" maxlength="11" id="number" class="block mt-1 w-full" type="text" name="number"
                         :value="old('number')" required
                         autofocus/>
            </div>

            <!-- Email Address -->

            <!-- Password -->

            <!-- Confirm Password -->

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('حساب کاربری دارید؟') }}
                </a>

                <x-button class="ml-4">
                    {{ __('ارسال کد') }}
                </x-button>
            </div>
        </form>
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('welcome') }}">
            {{ __('بازگشت') }}
        </a>
    </x-auth-card>
</x-guest-layout>
