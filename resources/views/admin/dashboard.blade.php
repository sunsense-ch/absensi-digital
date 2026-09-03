<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Admin</h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold">
                    Selamat datang, {{ auth()->user()->name}}
</h1>
<p class="mt-2">
    Anda login sebagai Administrator.</p>

    </div>
    </div>
    </div>
    </div>
</x-app-layout>