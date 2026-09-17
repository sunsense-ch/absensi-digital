<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-xl font-semibold text-dusk-900">Lupa kata sandi?</h2>
        <p class="text-sm text-dusk-500 mt-2 leading-relaxed">
            {{ __('Tidak masalah. Masukkan alamat email kamu, kami akan mengirimkan tautan untuk membuat kata sandi baru.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button>
            {{ __('Kirim Tautan Reset Kata Sandi') }}
        </x-primary-button>
    </form>
</x-guest-layout>