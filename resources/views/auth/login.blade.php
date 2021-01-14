<x-guest-layout>
    <div class="flex justify-center w-8/12 shadow-2xl">
        <img class="items-stretch hidden w-8/12 md:block" src="{{ asset('images/logo fiter barber.png') }}">
    </div>
    <div class="flex flex-col w-full md:w-1/3">
        <x-jet-authentication-card>
            <x-slot name="logo">
                <div class="flex justify-center">
                    <img class="hidden object-cover w-full md:block" src="{{ asset('images/logobarber.png') }}">
                </div>
                {{-- <x-jet-authentication-card-logo /> --}}
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-label value="{{ __('Email') }}" />
                    <x-jet-input class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label value="{{ __('Password') }}" />
                    <x-jet-input class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ __('Login') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
    

</x-guest-layout>
