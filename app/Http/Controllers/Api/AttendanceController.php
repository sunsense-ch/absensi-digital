<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrToken;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'qr_token' => ['required', 'string'],
        ]);

        // $request->user() didapat dari Bearer Token (auth:sanctum),
        // BUKAN dari data yang dikirim mobile -> siswa tidak bisa mengaku-ngaku
        // jadi siswa lain dengan mengirim student_id palsu.
        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum terhubung dengan data siswa.',
            ], 422);
        }

        // Semua syarat token digabung dalam satu query:
        // ada, aktif, untuk hari ini, dan masih dalam jam berlaku
        $qrToken = QrToken::with('location')
            ->where('token', $request->qr_token)
            ->where('is_active', true)
            ->whereDate('date', today())
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        if (!$qrToken) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        // PENTING: pada tahap ini BELUM menyimpan absensi.
        // Endpoint ini baru memvalidasi + mengidentifikasi siswa & lokasi.
        // Penyimpanan absensi sungguhan akan dibuat setelah aturan GPS
        // (Pertemuan 8) dan aturan waktu masuk/pulang siap.
        return response()->json([
            'success' => true,
            'message' => 'QR Code valid.',
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'nis' => $student->nis,
                    'name' => $student->full_name,
                ],
                'qr' => [
                    'token_id' => $qrToken->id,
                    'location' => $qrToken->location->name,
                    'location_code' => $qrToken->location->code,
                    'date' => $qrToken->date,
                    'valid_from' => $qrToken->valid_from,
                    'valid_until' => $qrToken->valid_until,
                ],
            ],
        ]);
    }
}
