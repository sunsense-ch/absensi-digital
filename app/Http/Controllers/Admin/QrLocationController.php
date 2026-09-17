<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use Illuminate\Http\Request;

class QrLocationController extends Controller
{
    public function index(Request $request)
    {
        $qrLocations = QrLocation::with('tokens')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'aktif'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.qr-locations.index', compact('qrLocations'));
    }

    public function create()
    {
        return view('admin.qr-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        QrLocation::create($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil ditambahkan.');
    }

    public function edit(QrLocation $qrLocation)
    {
        return view('admin.qr-locations.edit', compact('qrLocation'));
    }

    public function update(Request $request, QrLocation $qrLocation)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:50', 'unique:qr_locations,code,' . $qrLocation->id],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $qrLocation->update($validated);

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil diperbarui.');
    }

    public function destroy(QrLocation $qrLocation)
    {
        $qrLocation->delete();

        return redirect()
            ->route('admin.qr-locations.index')
            ->with('success', 'Lokasi QR berhasil dihapus.');
    }
}