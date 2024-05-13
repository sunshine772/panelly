<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <a href="/" class="flex-shrink-0 flex items-center">
                <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company">
            </a>
            <h2 class="mt-1 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Iniciar sesión en tu cuenta
            </h2>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4 flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" type="checkbox"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                </label>
                @if (Route::has('password.request'))
                <div class="flex items-center">
                    <a class="font-semibold text-indigo-600 hover:text-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
