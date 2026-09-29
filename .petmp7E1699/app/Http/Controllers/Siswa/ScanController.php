<?php

namespace App\Http\Controllers\Siswa;

use App\Helpers\GeoHelper;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QrToken;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScanController extends Controller
{
    public function scan(Request $request, string $token)
    {
        // 1) Cari token di database
        $qrToken = QrToken::with('location')->where('token', $token)->first();

        // 2) Token tidak ditemukan, nonaktif, atau lokasinya nonaktif -> tolak
        if (!$qrToken || !$qrToken->is_active || !$qrToken->location || !$qrToken->location->is_active) {
            return $this->gagal('QR sudah kadaluarsa.');
        }

        // 3) Token bukan untuk hari ini, atau sudah lewat jam berlakunya -> tolak
        $isToday = $qrToken->date->toDateString() === today()->toDateString();
        // between() dengan $equal = true (default) berarti batas awal/akhir ikut dihitung valid
        $isWithinWindow = now()->between($qrToken->valid_from, $qrToken->valid_until);

        if (!$isToday || !$isWithinWindow) {
            return $this->gagal('QR sudah kadaluarsa.');
        }

        // 4) Pastikan akun yang login terhubung ke data siswa
        $student = Student::where('user_id', auth()->id())->first();

        if (!$student) {
            return $this->gagal('Akun kamu belum terhubung dengan data siswa. Hubungi admin.');
        }

        // 5) Cegah absen dua kali di hari yang sama
        $sudahAbsen = Attendance::where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->exists();

        if ($sudahAbsen) {
            return $this->gagal('Kamu sudah absen hari ini.');
        }

        // 6) GPS: kalau browser belum mengirim koordinat, minta dulu lewat halaman scan.locate.
        //    Halaman itu akan membuka URL ini lagi dengan ?latitude=...&longitude=...
        if (!$request->filled('latitude') || !$request->filled('longitude')) {
            return view('scan.locate', ['token' => $token]);
        }

        $validator = Validator::make($request->only(['latitude', 'longitude']), [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        if ($validator->fails()) {
            return $this->gagal('Koordinat GPS tidak valid.');
        }

        $location = $qrToken->location;

        if (is_null($location->latitude) || is_null($location->longitude)) {
            return $this->gagal('Lokasi QR belum memiliki koordinat. Hubungi admin.');
        }

        // 7) Hitung jarak di server (Haversine) dan bandingkan dengan radius lokasi QR
        $distance = GeoHelper::distance(
            (float) $request->latitude,
            (float) $request->longitude,
            (float) $location->latitude,
            (float) $location->longitude
        );

        if ($distance > $location->radius) {
            return $this->gagal(
                'Kamu berada di luar radius lokasi absensi (jarak ' . round($distance) .
                ' m, radius ' . $location->radius . ' m).'
            );
        }

        // 8) Semua valid -> catat absensi beserta koordinat
        Attendance::create([
            'student_id' => $student->id,
            'qr_location_id' => $qrToken->qr_location_id,
            'qr_token_id' => $qrToken->id,
            'attendance_date' => today(),
            'attendance_time' => now()->format('H:i:s'),
            'status' => 'hadir',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return view('scan.result', [
            'success' => true,
            'message' => 'Kamu berhasil absen!',
            'lokasi' => $location->name,
            'waktu' => now()->format('H:i:s'),
        ]);
    }

    private function gagal(string $message)
    {
        return view('scan.result', [
            'success' => false,
            'message' => $message,
        ]);
    }
}
