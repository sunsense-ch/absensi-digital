<section>
    <header>
        <h2 class="section-title !mb-1">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="text-sm" style="color:var(--muted);">
            {{ __('Pastikan akun kamu memakai kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('put')

        <div class="field !mt-0">
            <label for="update_password_current_password">{{ __('Kata Sandi Saat Ini') }}</label>
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-0" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="field">
            <label for="update_password_password">{{ __('Kata Sandi Baru') }}</label>
            <x-text-input id="update_password_password" name="password" type="password" class="mt-0" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="field">
            <label for="update_password_password_confirmation">{{ __('Konfirmasi Kata Sandi') }}</label>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-0" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="!w-auto">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success-600 font-medium"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>