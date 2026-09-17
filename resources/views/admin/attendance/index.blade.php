<x-app-layout>
    <x-slot name="header"><h2>Laporan Absensi</h2></x-slot>

    @if(session('success'))
        <div class="flash-success" style="background:#F1F5EF;color:var(--success);border:1px solid #DCE9D9;border-radius:10px;padding:10px 14px;font-size:12.5px;font-weight:500;margin-bottom:14px;">{{ session('success') }}</div>
    @endif

    @php
        $statusOptions = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'];
        $totalFiltered = $summary->sum();
    @endphp

    <div class="card" style="margin-bottom:16px;">
        <p class="section-title">Filter Laporan</p>
        <form method="GET" action="{{ route('admin.attendance.index') }}" style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;align-items:end;" class="md:!grid-cols-2">
            <div class="field !mt-0">
                <label>Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}">
            </div>
            <div class="field !mt-0">
                <label>Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}">
            </div>
            <div class="field !mt-0">
                <label>Kelas</label>
                <select name="class_id">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->class_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field !mt-0">
                <label>Status</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusOptions as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') == $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field !mt-0">
                <label>Cari Nama / NIS</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Surya">
            </div>

            <div style="grid-column:1/-1;display:flex;gap:8px;margin-top:4px;">
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline">Reset</a>
                <a href="{{ route('admin.attendance.export', request()->query()) }}" class="btn btn-outline" style="margin-left:auto;">
                    Unduh CSV
                </a>
            </div>
        </form>
    </div>

    <div class="grid-4" style="margin-bottom:16px;">
        <div class="card stat">
            <span>Total Sesuai Filter</span>
            <b>{{ $totalFiltered }}</b>
        </div>
        <div class="card stat">
            <span>Hadir</span>
            <b style="color:var(--success);">{{ $summary['hadir'] ?? 0 }}</b>
        </div>
        <div class="card stat">
            <span>Izin / Sakit</span>
            <b style="color:var(--warning);">{{ ($summary['izin'] ?? 0) + ($summary['sakit'] ?? 0) }}</b>
        </div>
        <div class="card stat">
            <span>Alpha</span>
            <b style="color:var(--danger);">{{ $summary['alpha'] ?? 0 }}</b>
        </div>
    </div>

    <div class="card">
        <div class="toolbar">
            <p style="font-size:12.5px;color:var(--muted);margin:0;">{{ $attendances->total() }} catatan ditemukan</p>
        </div>

        <table>
            <thead>
                <tr><th>Siswa</th><th>NIS</th><th>Kelas</th><th>Lokasi</th><th>Tanggal</th><th>Waktu</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td style="font-weight:600;color:var(--primary-dark);">
                            <span class="av"></span>{{ $attendance->student->full_name ?? '—' }}
                        </td>
                        <td>{{ $attendance->student->nis ?? '—' }}</td>
                        <td>{{ $attendance->student->classRoom->class_name ?? '—' }}</td>
                        <td>{{ $attendance->qrLocation->name ?? '—' }}</td>
                        <td>{{ $attendance->attendance_date->format('d-m-Y') }}</td>
                        <td>{{ $attendance->attendance_time }}</td>
                        <td>
                            @php
                                $badge = match($attendance->status) {
                                    'hadir' => 'ok',
                                    'izin', 'sakit' => 'warn',
                                    default => 'danger',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($attendance->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">
                        <div class="empty-state">Tidak ada data absensi yang cocok dengan filter ini.</div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>

        @if($attendances->hasPages())
            <div style="margin-top:14px;">{{ $attendances->links() }}</div>
        @endif
    </div>
</x-app-layout>