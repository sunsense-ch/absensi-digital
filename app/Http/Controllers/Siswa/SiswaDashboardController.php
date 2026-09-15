<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $student = Student::with('classRoom')->where('user_id', auth()->id())->first();

        $attendanceToday = null;
        $riwayat = collect();
        $rekapBulanIni = collect();

        if ($student) {
            $attendanceToday = Attendance::with('qrLocation')
                ->where('student_id', $student->id)
                ->whereDate('attendance_date', today())
                ->first();

            $riwayat = Attendance::with('qrLocation')
                ->where('student_id', $student->id)
                ->latest('attendance_date')
                ->latest('attendance_time')
                ->take(10)
                ->get();

            $rekapBulanIni = Attendance::where('student_id', $student->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
        }

        return view('siswa.dashboard', compact('student', 'attendanceToday', 'riwayat', 'rekapBulanIni'));
    }
}