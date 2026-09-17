<x-guest-layout>
<<<<<<< HEAD
    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif
=======
    <div class="mb-7">
        <h2 class="font-display text-xl font-semibold text-dusk-900">Masuk ke akun kamu</h2>
        <p class="text-sm text-dusk-500 mt-1">Gunakan email dan kata sandi yang terdaftar.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />
>>>>>>> d1cfeae65df5680cfdaf1ca51e81779c22824f0d

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

<<<<<<< HEAD
        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field-inline">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary">Masuk</button>

        <div class="row-between" style="margin-top:16px;margin-bottom:0;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-small">Lupa password?</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="link-small">Daftar akun siswa</a>
=======
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
>>>>>>> d1cfeae65df5680cfdaf1ca51e81779c22824f0d
            @endif
        </div>

        <x-primary-button class="mt-2">
            {{ __('Masuk') }}
        </x-primary-button>
    </form>
</x-guest-layout>