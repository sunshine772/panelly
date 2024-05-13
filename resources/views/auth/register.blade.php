@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <a href="/" class="flex-shrink-0 flex items-center">
                <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company">
            </a>
            {{-- <h2 class="mt-1 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Registra tu cuenta
            </h2> --}}
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="last_name" value="{{ __('Apellido') }}" />
                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                    :value="old('last_name')" autocomplete="last_name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-jet-label for="phone" value="{{ __('Número de teléfono') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                    autocomplete="phone" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <div class="flex items-center">
                    <x-jet-checkbox name="terms" id="terms" />
                    <div class="ml-2">
                        {!! __('Acepto los :terms_of_service y la :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                            class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Términos del servicio').'</a>',
                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                            class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Política de privacidad').'</a>',
                        ]) !!}
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-6">
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Registrar') }}
                </button>
            </div>
        </form>

        <div class="mt-4 flex items-center justify-end">
            <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
