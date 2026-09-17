<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // with('classRoom', 'user') = eager loading, supaya index bisa cek status
        // akun terhubung tanpa query database berulang per baris, 
        // sekaligus mendukung fitur pencarian dan filter kelas.
        $students = Student::with(['classRoom', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            })
            ->when($request->filled('class_id'), fn ($query) => $query->where('class_id', $request->integer('class_id')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        // Hanya tampilkan akun dengan role 'siswa' yang BELUM terhubung ke siswa manapun
        $availableUsers = User::where('role', 'siswa')
            ->whereDoesntHave('student')
            ->orderBy('name')
            ->get();

        return view('admin.students.create', compact('classes', 'availableUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis'],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
            // nullable = boleh tidak dihubungkan ke akun mana pun dulu
            // unique:students,user_id = satu akun user tidak boleh dipakai 2 siswa
            'user_id' => ['nullable', 'exists:users,id', Rule::unique('students', 'user_id')],
        ]);

        Student::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        // Tampilkan akun yang belum terhubung ke siapa pun, DITAMBAH akun yang
        // sedang terhubung ke siswa ini sendiri (supaya tidak hilang dari pilihan)
        $availableUsers = User::where('role', 'siswa')
            ->where(function ($query) use ($student) {
                $query->whereDoesntHave('student')
                    ->orWhere('id', $student->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('admin.students.edit', compact('student', 'classes', 'availableUsers'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis,' . $student->id],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::unique('students', 'user_id')->ignore($student->id),
            ],
        ]);

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}