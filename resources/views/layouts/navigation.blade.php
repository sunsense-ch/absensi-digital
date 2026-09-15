@php
    $role = auth()->user()->role;

    $items = [];

    if ($role === 'admin') {
        $items[] = ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'grid'];
        $items[] = ['route' => 'admin.classes.index', 'pattern' => 'admin.classes.*', 'label' => 'Data Kelas', 'icon' => 'stack'];
        $items[] = ['route' => 'admin.students.index', 'pattern' => 'admin.students.*', 'label' => 'Data Siswa', 'icon' => 'users'];
        $items[] = ['route' => 'admin.qr-locations.index', 'pattern' => ['admin.qr-locations.*', 'admin.qr-tokens.*'], 'label' => 'Lokasi & QR', 'icon' => 'qr'];
        $items[] = ['route' => 'admin.attendance.index', 'pattern' => 'admin.attendance.*', 'label' => 'Laporan Absensi', 'icon' => 'chart'];
    } elseif ($role === 'siswa') {
        $items[] = ['route' => 'siswa.dashboard', 'pattern' => 'siswa.dashboard', 'label' => 'Dashboard', 'icon' => 'grid'];
    }

    $items[] = ['route' => 'profile.edit', 'pattern' => 'profile.edit', 'label' => 'Profil Saya', 'icon' => 'user'];

    $icons = [
        'grid' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 5.5A1.5 1.5 0 015.5 4h4A1.5 1.5 0 0111 5.5v4A1.5 1.5 0 019.5 11h-4A1.5 1.5 0 014 9.5v-4zM13 5.5A1.5 1.5 0 0114.5 4h4A1.5 1.5 0 0120 5.5v4a1.5 1.5 0 01-1.5 1.5h-4A1.5 1.5 0 0113 9.5v-4zM4 14.5A1.5 1.5 0 015.5 13h4a1.5 1.5 0 011.5 1.5v4A1.5 1.5 0 019.5 20h-4A1.5 1.5 0 014 18.5v-4zM13 14.5a1.5 1.5 0 011.5-1.5h4a1.5 1.5 0 011.5 1.5v4a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-4z"/>',
        'stack' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3.5l8 4-8 4-8-4 8-4zM4 12l8 4 8-4M4 16.5l8 4 8-4"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 19v-1.5a3.5 3.5 0 00-3.5-3.5h-5A3.5 3.5 0 004 17.5V19M10 11a3 3 0 100-6 3 3 0 000 6zM19 19v-1.2a3 3 0 00-2.2-2.9M15 4.3a3 3 0 010 5.4"/>',
        'qr' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 4.5h5v5H4v-5zM15 4.5h5v5h-5v-5zM4 15.5h5v5H4v-5zM6.3 6.8h.5M17.3 6.8h.5M6.3 17.8h.5M15 15.5h2v2M15 20h2M19.5 15.5v2M19.5 20h.5"/>',
        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.5 20V10M11 20V4.5M17.5 20v-6.5M4 20h16"/>',
        'user' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4.5 20a7.5 7.5 0 0115 0"/>',
    ];
@endphp

<div x-data="{ mobileOpen: false }">

    <button
        @click="mobileOpen = !mobileOpen"
        class="lg:hidden fixed top-4 left-4 z-50 bg-dusk-900 text-sand-50 p-2.5 rounded-xl shadow-lifted"
        aria-label="Buka menu"
    >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div
        x-show="mobileOpen"
        x-transition.opacity
        @click="mobileOpen = false"
        style="display: none;"
        class="fixed inset-0 bg-dusk-900/50 z-30 lg:hidden"
    ></div>

    <aside
        class="w-72 bg-dusk-900 min-h-screen flex flex-col justify-between px-5 py-6 shrink-0
               fixed lg:sticky top-0 left-0 z-40 transition-transform duration-200 lg:translate-x-0"
        :class="mobileOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-9 px-2">
                <div class="w-11 h-11 rounded-2xl bg-clay-500 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                            d="M9 12.75l1.5 1.5L15 9m-3-6a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-white font-display font-semibold leading-tight tracking-tight">AbsensiKu</p>
                    <p class="text-dusk-400 text-xs truncate">SMK Negeri 1 Maja</p>
                </div>
            </a>

            <nav class="flex flex-col gap-1">
                @foreach ($items as $item)
                    @php $isActive = request()->routeIs($item['pattern']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors
                            {{ $isActive ? 'bg-clay-500 text-white' : 'text-dusk-300 hover:bg-dusk-800 hover:text-white' }}">
                        <svg class="w-[18px] h-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $icons[$item['icon']] !!}
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="px-2">
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                <div class="w-9 h-9 rounded-full bg-dusk-700 text-sand-100 flex items-center justify-center text-sm font-semibold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-dusk-400 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 text-sm font-medium text-dusk-300 hover:text-white px-2 py-2 rounded-lg hover:bg-dusk-800 transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15.5 8V6.5A2.5 2.5 0 0013 4H7a2.5 2.5 0 00-2.5 2.5v11A2.5 2.5 0 007 20h6a2.5 2.5 0 002.5-2.5V16M19 12H9m10 0l-3-3m3 3l-3 3" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>
</div>