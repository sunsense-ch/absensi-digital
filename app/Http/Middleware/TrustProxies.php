<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * '*' = percayai SEMUA proxy di depan aplikasi (aman untuk dev/testing
     * lewat ngrok, karena ngrok meneruskan request asli sebagai HTTP ke server
     * lokal -- tanpa ini, Laravel tidak tahu bahwa koneksi sebenarnya HTTPS,
     * sehingga cookie session/CSRF gagal tersimpan dengan benar -> "Page Expired".
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
