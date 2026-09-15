<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Absensi Digital') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|sora:500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      :root{
        --primary:#3D4B4D; --primary-dark:#293233; --secondary:#955B51;
        --accent:#E6D4D1; --muted:#667D80; --surface:#F3EEEA; --surface-white:#FFFEFC;
        --success:#5B7857; --warning:#A5732E; --danger:#98332A; --line:#E7E0DA;
      }
      *{box-sizing:border-box;}
      body{margin:0;font-family:'Plus Jakarta Sans',-apple-system,Segoe UI,Roboto,sans-serif;background:var(--surface);color:var(--primary-dark);}
      a{text-decoration:none;color:inherit;}

      .app{display:flex;min-height:100vh;}
      .main{flex:1;display:flex;flex-direction:column;min-width:0;}
      .topbar{
        background:rgba(255,254,252,.9);backdrop-filter:blur(6px);border-bottom:1px solid var(--line);
        padding:16px 28px;display:flex;align-items:center;justify-content:space-between;
        position:sticky;top:0;z-index:20;
      }
      .topbar h1, .topbar h2{margin:0;font-family:'Sora',sans-serif;font-size:18px;font-weight:600;color:var(--primary-dark);}
      .topbar .right{display:flex;align-items:center;gap:12px;}
      .avatar{width:34px;height:34px;border-radius:50%;background:var(--secondary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:12.5px;font-weight:700;}

      .content{padding:28px;max-width:1180px;width:100%;margin:0 auto;}

      .card{background:var(--surface-white);border:1px solid var(--line);border-radius:16px;padding:20px;box-shadow:0 1px 2px rgba(41,50,51,.03), 0 10px 26px -18px rgba(41,50,51,.18);}
      .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
      .stat{position:relative;overflow:hidden;}
      .stat b{display:block;font-family:'Sora',sans-serif;font-size:26px;color:var(--primary-dark);line-height:1.2;}
      .stat span{font-size:12.5px;color:var(--muted);font-weight:500;}
      .toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap;}
      .search{background:var(--surface);border:1px solid var(--line);border-radius:10px;padding:9px 14px;font-size:13px;color:var(--primary-dark);flex:1;max-width:280px;}
      .search:focus{outline:none;border-color:var(--secondary);}
      .btn{border:none;border-radius:10px;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s ease, color .15s ease, border-color .15s ease;}
      .btn-primary{background:var(--secondary);color:#fff;}
      .btn-primary:hover{background:var(--primary-dark);}
      .btn-outline{background:#fff;color:var(--primary-dark);border:1px solid var(--line);}
      .btn-outline:hover{border-color:var(--secondary);color:var(--secondary);}

      table{width:100%;border-collapse:collapse;font-size:13.5px;}
      th{text-align:left;color:var(--muted);font-weight:600;font-size:12px;padding:10px 10px;border-bottom:1px solid var(--line);}
      td{padding:11px 10px;border-bottom:1px solid #F1ECE7;}
      tr:last-child td{border-bottom:none;}
      tbody tr:hover{background:#FAF7F4;}
      .av{width:26px;height:26px;border-radius:50%;background:var(--accent);display:inline-block;margin-right:9px;vertical-align:middle;}
      .badge{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap;}
      .badge.ok{background:#F1F5EF;color:var(--success);}
      .badge.warn{background:#FBF3E7;color:var(--warning);}
      .badge.danger{background:#FBEEEC;color:var(--danger);}
      .icon-btn{background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;padding:4px 6px;font-weight:600;}
      .icon-btn:hover{color:var(--secondary);}

      .section-title{font-family:'Sora',sans-serif;font-size:15px;font-weight:600;color:var(--primary-dark);margin:0 0 14px;}

      .empty-state{padding:36px 8px;text-align:center;color:var(--muted);font-size:13px;}
      .empty-state a{color:var(--secondary);font-weight:600;}

      .field label{display:block;font-size:12.5px;font-weight:600;color:var(--primary-dark);margin:14px 0 6px;}
      .field input, .field select{
        width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;font-size:13.5px;background:var(--surface-white);font-family:inherit;
      }
      .field input:focus, .field select:focus{outline:none;border-color:var(--secondary);}
      .field small{display:block;font-size:11px;color:var(--muted);margin-top:4px;}
      .field .error{display:block;font-size:11.5px;color:var(--danger);margin-top:4px;}
      .form-actions{display:flex;gap:8px;margin-top:20px;flex-wrap:wrap;}

      @media print{
        aside, .topbar, .no-print{display:none !important;}
        .main{margin-left:0 !important;}
        body{background:#fff !important;}
        .content{padding:0 !important;}
        .card{border:none !important;box-shadow:none !important;}
      }

      @media (max-width: 860px){
        .grid-4{grid-template-columns:repeat(2,1fr);}
        .content{padding:20px;}
      }
    </style>
</head>
<body>

<div class="app">

    @include('layouts.navigation')

    <div class="main">
        <div class="topbar">
            <div style="display:flex;align-items:center;gap:10px;padding-left:44px;" class="lg:!pl-0">
                {{ $header ?? '' }}
            </div>
            <div class="right">
                <span style="font-size:12.5px;color:var(--muted);" class="hidden sm:inline">{{ Auth::user()->name }}</span>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            </div>
        </div>

        <div class="content">
            {{ $slot }}
        </div>
    </div>
</div>

<x-toast />

</body>
</html>