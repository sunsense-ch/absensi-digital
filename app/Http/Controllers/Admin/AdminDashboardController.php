<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\QrLocation;
use App\Models\Student;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Student::count();
        $totalKelas = ClassRoom::count();
        $totalLokasi = QrLocation::where('is_active', true)->count();
        $absenHariIni = Attendance::whereDate('attendance_date', today())->count();
        $belumAbsenHariIni = max($totalSiswa - $absenHariIni, 0);

        $recentAttendances = Attendance::with(['student', 'qrLocation'])
            ->whereDate('attendance_date', today())
            ->latest('attendance_time')
            ->take(6)
            ->get();

        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->translatedFormat('D, d M');
            $counts[] = Attendance::whereDate('attendance_date', $date)->count();
        }

        $statusBulanIni = Attendance::whereMonth('attendance_date', now()->month)
            ->whereYear('attendance_date', now()->year)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalKelas',
            'totalLokasi',
            'absenHariIni',
            'belumAbsenHariIni',
            'recentAttendances',
            'labels',
            'counts',
            'statusBulanIni'
        ));
    }
}