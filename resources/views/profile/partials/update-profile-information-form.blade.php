<section>
    <header>
        <h2 class="section-title !mb-1">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="text-sm" style="color:var(--muted);">
            {{ __("Perbarui informasi profil dan alamat email akun kamu.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('patch')

        <div class="field !mt-0">
            <label for="name">{{ __('Nama') }}</label>
            <x-text-input id="name" name="name" type="text" class="mt-0" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="field">
            <label for="email">{{ __('Email') }}</label>
            <x-text-input id="email" name="email" type="email" class="mt-0" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2" style="color:var(--primary-dark);">
                        {{ __('Alamat email kamu belum diverifikasi.') }}

                        <button form="send-verification" class="underline font-medium" style="color:var(--secondary);">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email kamu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="!w-auto">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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