<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AbsensiKu') }} — Absensi Digital SMKN 1 Maja</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|sora:500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-dusk-900 antialiased bg-sand-50">

    <header class="max-w-6xl mx-auto flex items-center justify-between px-6 py-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-clay-500 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12.75l1.5 1.5L15 9m-3-6a9 9 0 100 18 9 9 0 000-18z" />
                </svg>
            </div>
            <span class="font-display font-semibold">AbsensiKu</span>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-dusk-900 hover:text-clay-600">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-dusk-700 hover:text-clay-600">Masuk</a>
            @endauth
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-6 pt-10 pb-20 grid lg:grid-cols-2 gap-14 items-center">
        <div>
            <h1 class="font-display text-4xl sm:text-5xl font-semibold leading-[1.1] tracking-tight text-dusk-900">
                Absen sekolah selesai dalam satu pindaian.
            </h1>
            <p class="mt-6 text-dusk-600 text-base leading-relaxed max-w-md">
                SMK Negeri 1 Maja mencatat kehadiran siswa lewat kode QR yang terikat ke lokasi dan waktu tertentu, jadi datanya akurat tanpa perlu absen manual di kertas.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-clay-600 text-white rounded-xl font-semibold text-sm hover:bg-clay-700 transition">
                    Masuk ke akun
                </a>
                <a href="#cara-kerja" class="text-sm font-semibold text-dusk-700 hover:text-clay-600">
                    Lihat cara kerjanya
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-peach-200 rounded-full blur-2xl opacity-70"></div>
            <div class="relative bg-dusk-900 rounded-3xl p-8 shadow-lifted">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-dusk-400 text-xs">Absen hari ini</p>
                        <p class="text-white font-display text-lg font-semibold">Gerbang Utama</p>
                    </div>
                    <span class="text-xs font-semibold bg-clay-500 text-white px-3 py-1 rounded-full">Aktif</span>
                </div>
                <div class="bg-white rounded-2xl p-5 flex items-center justify-center mb-6">
                    <div class="grid grid-cols-5 grid-rows-5 gap-1 w-32 h-32">
                        @php
                            $cells = [1,1,1,0,1,1,0,0,1,0,1,1,1,0,1,0,1,0,0,1,1,1,1,0,1];
                        @endphp
                        @foreach($cells as $c)
                            <div class="rounded-sm {{ $c ? 'bg-dusk-900' : 'bg-transparent' }}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-dusk-300">Radius 20m &middot; berlaku sampai 23:59</span>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-y border-mist-200">
        <div class="max-w-6xl mx-auto px-6 py-16 grid sm:grid-cols-3 gap-8">
            <div>
                <div class="w-10 h-10 rounded-xl bg-clay-100 text-clay-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 4.5h5v5H4v-5zM15 4.5h5v5h-5v-5zM4 15.5h5v5H4v-5zM15 15.5h5v5h-5v-5z"/></svg>
                </div>
                <h3 class="font-display font-semibold text-dusk-900 mb-2">Terikat lokasi</h3>
                <p class="text-sm text-dusk-600 leading-relaxed">Setiap kode QR hanya berlaku di titik dan radius yang ditentukan admin, sehingga absen dari luar sekolah tidak akan tercatat.</p>
            </div>
            <div>
                <div class="w-10 h-10 rounded-xl bg-clay-100 text-clay-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 7v5l3 2M4.5 12a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0z"/></svg>
                </div>
                <h3 class="font-display font-semibold text-dusk-900 mb-2">Kode QR harian</h3>
                <p class="text-sm text-dusk-600 leading-relaxed">Token dibuat ulang setiap hari dan otomatis kedaluwarsa, jadi kode lama tidak bisa dipakai untuk absen di hari lain.</p>
            </div>
            <div>
                <div class="w-10 h-10 rounded-xl bg-clay-100 text-clay-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.5 19V9M11 19V4.5M17.5 19v-6"/></svg>
                </div>
                <h3 class="font-display font-semibold text-dusk-900 mb-2">Laporan siap unduh</h3>
                <p class="text-sm text-dusk-600 leading-relaxed">Admin bisa memantau kehadiran secara real-time dan mengunduh rekap absensi per kelas atau rentang tanggal.</p>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="max-w-6xl mx-auto px-6 py-20">
        <h2 class="font-display text-2xl font-semibold text-dusk-900 mb-10">Cara kerjanya</h2>
        <div class="grid sm:grid-cols-3 gap-8">
            <div class="flex gap-4">
                <span class="font-display text-2xl font-semibold text-clay-400">01</span>
                <p class="text-sm text-dusk-600 leading-relaxed pt-1">Admin membuat kode QR harian untuk tiap lokasi absen yang aktif.</p>
            </div>
            <div class="flex gap-4">
                <span class="font-display text-2xl font-semibold text-clay-400">02</span>
                <p class="text-sm text-dusk-600 leading-relaxed pt-1">Siswa memindai kode QR memakai kamera HP saat tiba di lokasi tersebut.</p>
            </div>
            <div class="flex gap-4">
                <span class="font-display text-2xl font-semibold text-clay-400">03</span>
                <p class="text-sm text-dusk-600 leading-relaxed pt-1">Kehadiran tercatat otomatis dan langsung terlihat di dashboard admin.</p>
            </div>
        </div>
    </section>

    <footer class="border-t border-mist-200">
        <div class="max-w-6xl mx-auto px-6 py-8 text-xs text-dusk-500">
            &copy; {{ date('Y') }} AbsensiKu &middot; SMK Negeri 1 Maja
        </div>
    </footer>

</body>
</html>