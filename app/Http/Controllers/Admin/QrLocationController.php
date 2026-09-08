<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use Illuminate\Http\Request;

class QrLocationController extends Controller
{
    // Menampilkan daftar semua lokasi QR
    public function index()
    {
        $qrLocations = QrLocation::latest()->paginate(10);

        return view('admin.qr-locations.index', compact('qrLocations'));
    }

    // Menampilkan form tambah lokasi QR
    public function create()
    {
        return view('admin.qr-locations.create');
    }

    // Memproses data dari form tambah lokasi QR
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],

            // code harus unik, karena dipakai untuk identifikasi lokasi (misal: "GERBANG")
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code'],

            // between:-90,90 = latitude bumi valid antara -90 sampai 90 derajat
            'latitude' => ['required', 'numeric', 'between:-90,90'],

            // between:-180,180 = longitude bumi valid antara -180 sampai 180 derajat
            'longitude' => ['required', 'numeric', 'between:-180,180'],

            // radius dalam meter, dibatasi wajar antara 1 - 500 meter
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        QrLocation::create($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil ditambahkan.');
    }

    // Menampilkan form edit lokasi QR tertentu
    public function edit(QrLocation $qrLocation)
    {
        return view('admin.qr-locations.edit', compact('qrLocation'));
    }

    // Memproses data dari form edit lokasi QR
    public function update(Request $request, QrLocation $qrLocation)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],

            // code boleh sama dengan milik lokasi ini sendiri, tapi tidak boleh sama dengan lokasi lain
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code,' . $qrLocation->id],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $qrLocation->update($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil diperbarui.');
    }

    // Menghapus data lokasi QR
    public function destroy(QrLocation $qrLocation)
    {
        $qrLocation->delete();

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil dihapus.');
    }
}