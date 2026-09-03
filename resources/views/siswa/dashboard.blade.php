<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl leading-tight">
        Dashboard Siswa</h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
           
                <h1 class="text-2xl font-bold">
Halo, {{ auth()->user()->name}}
</h1>
<p class="mt-2">
    Selamat datang di Aplikasi absensi Digital.</p>
<p class="mt-6">
    <button>
        class="px-4 py-2 bg-blue-600 text-white rounded">
        Scan QR absensi
    </button>
    
    </div>
    </div>
    </div>
    </div>
</x-app-layout>