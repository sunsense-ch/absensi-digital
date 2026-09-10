<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek user ditemukan DAN password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        // API mobile ini khusus siswa -> tolak kalau role-nya bukan siswa
        // (misalnya admin mencoba login lewat endpoint mobile)
        if ($user->role !== 'siswa') {
            return response()->json([
                'message' => 'Akun ini bukan akun siswa',
            ], 403);
        }

        // Buat token Sanctum baru untuk user ini
        $token = $user->createToken('mobile-siswa')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function me(Request $request)
    {
        // $request->user() otomatis terisi oleh middleware auth:sanctum
        // berdasarkan Bearer Token yang dikirim
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        // Menghapus HANYA token yang sedang dipakai request ini
        // (bukan semua token milik user, kalau-kalau dia login dari beberapa device)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
