<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QrLocationController;
use App\Http\Controllers\Admin\QrTokenController;
use App\Http\Controllers\Admin\QrDisplayController;
use App\Http\Controllers\Admin\AttendanceReportController;
use App\Http\Controllers\Siswa\ScanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('classes', ClassRoomController::class);
        Route::resource('students', StudentController::class);
        Route::resource('qr-locations', QrLocationController::class);

        Route::post('/qr-tokens/generate', [QrTokenController::class, 'generate'])
            ->name('qr-tokens.generate');

        Route::post('/qr-tokens/{qrToken}/deactivate', [QrTokenController::class, 'deactivate'])
            ->name('qr-tokens.deactivate');

        Route::post('/qr-tokens/{qrToken}/activate', [QrTokenController::class, 'activate'])
            ->name('qr-tokens.activate');

        Route::get('/qr-tokens/{qrToken}/display', [QrDisplayController::class, 'show'])
            ->name('qr-tokens.display');

        Route::get('/laporan-absensi', [AttendanceReportController::class, 'index'])
            ->name('attendance.index');
        Route::get('/laporan-absensi/export', [AttendanceReportController::class, 'export'])
            ->name('attendance.export');
    });

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/scan', function () {
            return view('siswa.scan');
        })->name('scan');
    });

Route::get('/scan/{token}', [ScanController::class, 'scan'])
    ->middleware(['auth', 'role:siswa'])
    ->name('qr.scan');

require __DIR__.'/auth.php';