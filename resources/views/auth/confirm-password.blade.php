<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-xl font-semibold text-dusk-900">Konfirmasi kata sandi</h2>
        <p class="text-sm text-dusk-500 mt-2">
            {{ __('Ini adalah area aman. Konfirmasi kata sandi kamu sebelum melanjutkan.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button>
            {{ __('Konfirmasi') }}
        </x-primary-button>
    </form>
</x-guest-layout>