<x-app-layout>
    <x-slot name="header"><h2>Dashboard Admin</h2></x-slot>

    <p style="font-size:13.5px;color:var(--muted);margin:0 0 20px;">
        Selamat datang, <strong style="color:var(--primary-dark);">{{ auth()->user()->name }}</strong>. Berikut ringkasan sistem hari ini, {{ now()->translatedFormat('l, d F Y') }}.
    </p>

    <div class="grid-4" style="margin-bottom:18px;">
        <div class="card stat">
            <span>Total Siswa</span>
            <b>{{ $totalSiswa }}</b>
        </div>
        <div class="card stat">
            <span>Total Kelas</span>
            <b>{{ $totalKelas }}</b>
        </div>
        <div class="card stat">
            <span>Lokasi QR Aktif</span>
            <b>{{ $totalLokasi }}</b>
        </div>
        <div class="card stat">
            <span>Hadir Hari Ini</span>
            <b style="color:var(--success);">{{ $absenHariIni }}</b>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;" class="lg:grid md:!grid-cols-1">
        <div class="card">
            <p class="section-title">Tren Kehadiran 7 Hari Terakhir</p>
            <canvas id="attendanceTrendChart" height="130"></canvas>
        </div>

        <div class="card">
            <p class="section-title">Status Absensi Bulan Ini</p>
            @php
                $statusLabels = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'];
                $statusColors = ['hadir' => 'var(--success)', 'izin' => 'var(--warning)', 'sakit' => 'var(--warning)', 'alpha' => 'var(--danger)'];
                $totalStatus = $statusBulanIni->sum();
            @endphp
            @if($totalStatus === 0)
                <div class="empty-state">Belum ada data absensi bulan ini.</div>
            @else
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($statusLabels as $key => $label)
                        @php $count = $statusBulanIni[$key] ?? 0; $pct = $totalStatus ? round($count / $totalStatus * 100) : 0; @endphp
                        <div>
                            <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:5px;">
                                <span style="color:var(--primary-dark);font-weight:600;">{{ $label }}</span>
                                <span style="color:var(--muted);">{{ $count }} ({{ $pct }}%)</span>
                            </div>
                            <div style="background:var(--surface);border-radius:99px;height:7px;overflow:hidden;">
                                <div style="width:{{ $pct }}%;background:{{ $statusColors[$key] }};height:100%;border-radius:99px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <p style="font-size:12px;color:var(--muted);margin:16px 0 0;padding-top:14px;border-top:1px solid var(--line);">
                {{ $belumAbsenHariIni }} siswa belum tercatat hadir hari ini.
            </p>
        </div>
    </div>

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <p class="section-title" style="margin:0;">Absensi Terbaru</p>
            <a href="{{ route('admin.attendance.index') }}" class="icon-btn" style="color:var(--secondary);">Lihat semua laporan &rarr;</a>
        </div>
        <table>
            <thead>
                <tr><th>Siswa</th><th>Lokasi</th><th>Tanggal</th><th>Waktu</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($recentAttendances as $attendance)
                    <tr>
                        <td>
                            <span class="av"></span>{{ $attendance->student->full_name ?? '—' }}
                        </td>
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
                    <tr><td colspan="5">
                        <div class="empty-state">Belum ada data absensi.</div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('attendanceTrendChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Absen',
                    data: @json($counts),
                    backgroundColor: '#D4B5B0',
                    hoverBackgroundColor: '#955B51',
                    borderRadius: 8,
                    maxBarThickness: 36,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0, color: '#667D80' }, grid: { color: '#F1ECE7' } },
                    x: { ticks: { color: '#667D80' }, grid: { display: false } },
                }
            }
        });
    </script>
</x-app-layout>npm install