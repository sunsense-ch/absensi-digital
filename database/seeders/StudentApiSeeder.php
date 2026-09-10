<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Hash;

class StudentApiSeeder extends Seeder
{
    public function run(): void
    {
        // firstOrCreate = aman dijalankan berkali-kali, tidak akan membuat
        // duplikat / error "duplicate entry" kalau seeder ini dijalankan ulang
        $user = User::firstOrCreate(
            ['email' => 'siswa@absensi.test'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );

        // Pastikan ada minimal satu kelas untuk dipasangkan ke siswa demo ini,
        // supaya seeder tidak gagal kalau tabel classes masih kosong
        $class = ClassRoom::firstOrCreate(
            ['class_name' => 'Kelas Demo'],
            ['major' => 'Umum']
        );

        Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nis' => '123456789',
                'full_name' => 'Siswa Demo',
                'class_id' => $class->id,
            ]
        );
    }
}
