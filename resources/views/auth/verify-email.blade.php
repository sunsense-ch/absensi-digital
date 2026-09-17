<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-xl font-semibold text-dusk-900">Verifikasi email kamu</h2>
        <p class="text-sm text-dusk-500 mt-2 leading-relaxed">
            {{ __('Terima kasih sudah mendaftar! Sebelum memulai, mohon verifikasi alamat email kamu dengan mengklik tautan yang baru saja kami kirim. Jika belum menerima emailnya, kami akan dengan senang hati mengirimkan yang baru.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-success-600 bg-success-50 rounded-xl px-4 py-3">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang kamu daftarkan.') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="!w-auto">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-dusk-500 hover:text-dusk-800 font-medium">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>