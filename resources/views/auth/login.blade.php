<x-guest-layout>
    <div class="mb-7">
        <h2 class="font-display text-xl font-semibold text-dusk-900">Masuk ke akun kamu</h2>
        <p class="text-sm text-dusk-500 mt-1">Gunakan email dan kata sandi yang terdaftar.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-mist-300 text-clay-600 shadow-sm focus:ring-clay-500" name="remember">
                <span class="text-sm text-dusk-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-clay-600 hover:text-clay-700 font-medium" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="mt-2">
            {{ __('Masuk') }}
        </x-primary-button>
    </form>
</x-guest-layout>