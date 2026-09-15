<x-app-layout>
    <x-slot name="header"><h2>Dashboard Siswa</h2></x-slot>

    @if(session('success'))
        <div style="background:#F1F5EF;color:var(--success);border:1px solid #DCE9D9;border-radius:10px;padding:10px 14px;font-size:12.5px;font-weight:500;margin-bottom:14px;">{{ session('success') }}</div>
    @endif

    @if(!$student)
        <div class="card">
            <p style="font-weight:600;color:var(--danger);margin:0 0 6px;">Akun kamu belum terhubung dengan data siswa.</p>
            <p style="font-size:12.5px;color:var(--muted);margin:0;">Hubungi admin sekolah supaya akunmu bisa dipakai untuk absen.</p>
        </div>
    @else
        <div class="card" style="margin-bottom:16px;background:var(--primary-dark);border:none;color:#fff;">
            <p style="font-size:13px;color:#C7D3D3;margin:0 0 4px;">Halo,</p>
            <p style="font-family:'Sora',sans-serif;font-size:20px;font-weight:600;margin:0 0 14px;">{{ $student->full_name }}</p>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <span style="font-size:12.5px;color:#C7D3D3;">{{ $student->classRoom->class_name ?? '—' }} &middot; NIS {{ $student->nis }}</span>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            @if($attendanceToday)
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:48px;height:48px;border-radius:50%;background:#F1F5EF;color:var(--success);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                        &#10003;
                    </div>
                    <div>
                        <p style="font-weight:600;color:var(--primary-dark);margin:0 0 3px;">Kamu sudah absen hari ini</p>
                        <p style="font-size:12.5px;color:var(--muted);margin:0;">
                            {{ $attendanceToday->qrLocation->name ?? '—' }} &middot; pukul {{ $attendanceToday->attendance_time }}
                        </p>
                    </div>
                    <span class="badge ok" style="margin-left:auto;">{{ ucfirst($attendanceToday->status) }}</span>
                </div>
            @else
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:48px;height:48px;border-radius:50%;background:#FBF3E7;color:var(--warning);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                        !
                    </div>
                    <div>
                        <p style="font-weight:600;color:var(--primary-dark);margin:0 0 3px;">Kamu belum absen hari ini</p>
                        <p style="font-size:12.5px;color:var(--muted);margin:0;">
                            Pindai kode QR yang tersedia di lokasi sekolah menggunakan kamera HP kamu untuk mencatat kehadiran.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @php
            $statusLabels = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'];
        @endphp
        <div class="grid-4" style="margin-bottom:16px;">
            @foreach($statusLabels as $key => $label)
                <div class="card stat">
                    <span>{{ $label }} Bulan Ini</span>
                    <b>{{ $rekapBulanIni[$key] ?? 0 }}</b>
                </div>
            @endforeach
        </div>

        <div class="card">
            <p class="section-title">Riwayat Absensi Terbaru</p>
            <table>
                <thead>
                    <tr><th>Tanggal</th><th>Lokasi</th><th>Waktu</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                        <tr>
                            <td>{{ $item->attendance_date->format('d-m-Y') }}</td>
                            <td>{{ $item->qrLocation->name ?? '—' }}</td>
                            <td>{{ $item->attendance_time }}</td>
                            <td>
                                @php
                                    $badge = match($item->status) {
                                        'hadir' => 'ok',
                                        'izin', 'sakit' => 'warn',
                                        default => 'danger',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($item->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="empty-state">Belum ada riwayat absensi.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>