<?php

namespace App\Helpers;

class GeoHelper
{
    /**
     * Menghitung jarak antara dua titik koordinat GPS menggunakan
     * algoritma Haversine.
     *
     * @param  float  $lat1  Latitude titik A (misal: lokasi QR)
     * @param  float  $lon1  Longitude titik A
     * @param  float  $lat2  Latitude titik B (misal: lokasi siswa)
     * @param  float  $lon2  Longitude titik B
     * @return float  Jarak dalam meter
     */
    public static function distance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371000; // radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2
            + cos($latFrom)
            * cos($latTo)
            * sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}