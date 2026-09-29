<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Absensi Digital') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|sora:500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-dusk-900 antialiased">
        <div class="min-h-screen grid lg:grid-cols-2 bg-sand-50">

            <div class="hidden lg:flex flex-col justify-between bg-dusk-900 text-white p-12 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-clay-500/20"></div>
                <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-dusk-800/60 to-transparent"></div>

                <a href="/" class="flex items-center gap-3 relative z-10">
                    <div class="w-11 h-11 rounded-2xl bg-clay-500 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12.75l1.5 1.5L15 9m-3-6a9 9 0 100 18 9 9 0 000-18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-display font-semibold tracking-tight">AbsensiKu</p>
                        <p class="text-dusk-400 text-xs">SMK Negeri 1 Maja</p>
                    </div>
                </a>

                <div class="relative z-10 max-w-sm">
                    <h1 class="font-display text-3xl font-semibold leading-snug mb-4">
                        Absensi sekolah, tercatat otomatis lewat QR.
                    </h1>
                    <p class="text-dusk-300 text-sm leading-relaxed">
                        Siswa cukup memindai kode QR di lokasi yang ditentukan, kehadirannya langsung tercatat dan bisa dipantau admin secara real-time.
                    </p>
                </div>

                <p class="text-dusk-500 text-xs relative z-10">&copy; {{ date('Y') }} AbsensiKu</p>
            </div>

            <div class="flex flex-col justify-center items-center px-6 py-12">
                <div class="w-full max-w-sm">
                    <a href="/" class="lg:hidden flex items-center gap-3 mb-10 justify-center">
                        <div class="w-10 h-10 rounded-xl bg-clay-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12.75l1.5 1.5L15 9m-3-6a9 9 0 100 18 9 9 0 000-18z" />
                            </svg>
                        </div>
                        <p class="font-display font-semibold text-dusk-900">AbsensiKu</p>
                    </a>

                    <div class="bg-white border border-mist-200 shadow-soft rounded-2xl px-7 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>