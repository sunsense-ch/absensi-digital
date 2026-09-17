<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Absensi Digital') }}</title>

<<<<<<< HEAD
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      :root{
        --primary:#404E3B; --primary-dark:#2C362A; --secondary:#7B9669;
        --accent:#BAC8B1; --muted:#6C8480; --surface:#E6E6E6; --surface-white:#FBFBFA;
        --success:#6B8F71; --danger:#B23A2E; --line:#DCE3D8;
      }
      *{box-sizing:border-box;}
      body{margin:0;font-family:-apple-system,Segoe UI,Roboto,Poppins,sans-serif;background:var(--surface);color:var(--primary-dark);}
      a{text-decoration:none;color:var(--secondary);}
      a:hover{color:var(--primary);}

      .guest-wrap{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;}
      .brand-mark{
        width:52px;height:52px;border-radius:13px;background:var(--primary);color:#fff;
        display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;margin-bottom:16px;
      }
      .guest-title{font-size:14px;color:var(--muted);margin:0 0 22px;text-align:center;}
      .guest-card{
        width:100%;max-width:380px;background:var(--surface-white);border:1px solid var(--line);
        border-radius:14px;padding:26px 24px;
      }

      .field label{display:block;font-size:12.5px;font-weight:600;color:var(--primary-dark);margin:0 0 6px;}
      .field{margin-bottom:16px;}
      .field input{
        width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:8px;font-size:13.5px;
        background:var(--surface-white);
      }
      .field input:focus{outline:none;border-color:var(--secondary);box-shadow:0 0 0 2px rgba(123,150,105,.15);}
      .field .error{display:block;font-size:11.5px;color:var(--danger);margin-top:5px;}
      .field-inline{display:flex;align-items:center;gap:7px;margin-bottom:16px;}
      .field-inline input{width:auto;}
      .field-inline label{font-size:12.5px;color:var(--muted);margin:0;}

      .btn{border:none;border-radius:8px;padding:10px 16px;font-size:13.5px;font-weight:600;cursor:pointer;width:100%;}
      .btn-primary{background:var(--secondary);color:#fff;}
      .btn-primary:hover{background:var(--primary);}

      .row-between{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
      .link-small{font-size:12px;}

      .status-msg{background:#E3EBE0;color:var(--success);border:1px solid #CFE0CA;border-radius:8px;padding:9px 12px;font-size:12.5px;margin-bottom:16px;}

      .guest-footer{margin-top:20px;font-size:11.5px;color:var(--muted);text-align:center;}
    </style>
</head>
<body>
    <div class="guest-wrap">
        <a href="/" style="text-decoration:none;">
            <div class="brand-mark">AD</div>
        </a>
        <p class="guest-title">Sistem Absensi Digital — SMKN 1 Maja</p>

        <div class="guest-card">
            {{ $slot }}
        </div>

        <p class="guest-footer">&copy; {{ date('Y') }} SMKN 1 Maja</p>
    </div>
</body>
</html>
=======
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
>>>>>>> d1cfeae65df5680cfdaf1ca51e81779c22824f0d
