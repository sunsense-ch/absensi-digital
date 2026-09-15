<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);

        $attendances = $query->latest('attendance_date')
            ->latest('attendance_time')
            ->paginate(15)
            ->withQueryString();

        $classes = ClassRoom::orderBy('class_name')->get();

        $summary = (clone $this->filteredQuery($request))
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.attendance.index', compact('attendances', 'classes', 'summary'));
    }

    public function export(Request $request): StreamedResponse
    {
        $rows = $this->filteredQuery($request)
            ->latest('attendance_date')
            ->latest('attendance_time')
            ->get();

        $filename = 'laporan-absensi-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['NIS', 'Nama Siswa', 'Kelas', 'Lokasi', 'Tanggal', 'Waktu', 'Status']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->student->nis ?? '-',
                    $row->student->full_name ?? '-',
                    $row->student->classRoom->class_name ?? '-',
                    $row->qrLocation->name ?? '-',
                    optional($row->attendance_date)->format('d-m-Y'),
                    $row->attendance_time,
                    ucfirst($row->status),
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    private function filteredQuery(Request $request)
    {
        return Attendance::query()
            ->with(['student.classRoom', 'qrLocation'])
            ->when($request->filled('from'), fn ($q) => $q->whereDate('attendance_date', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('attendance_date', '<=', $request->date('to')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('class_id'), function ($q) use ($request) {
                $q->whereHas('student', fn ($sq) => $sq->where('class_id', $request->integer('class_id')));
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search');
                $q->whereHas('student', function ($sq) use ($search) {
                    $sq->where('full_name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            });
    }
}