<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-serif text-2xl text-stone-800">Data Kelas</h2>
            <p class="text-sm text-stone-500">Kelola daftar kelas yang digunakan untuk mengelompokkan siswa.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-stone-500">
                    {{ $classes->total() }} kelas terdaftar
                </p>
                <a href="{{ route('admin.classes.create') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-emerald-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 4a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V5a1 1 0 011-1z" />
                    </svg>
                    Tambah Kelas
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0l-3.5-3.5a1 1 0 111.4-1.4l2.8 2.8 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-hidden rounded-lg border border-stone-200 bg-white">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-stone-200 bg-stone-50/60">
                            <th class="w-14 px-4 py-3 text-xs font-medium text-stone-500">No</th>
                            <th class="px-4 py-3 text-xs font-medium text-stone-500">Nama Kelas</th>
                            <th class="px-4 py-3 text-xs font-medium text-stone-500">Jurusan</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-stone-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr class="border-b border-stone-100 last:border-b-0 hover:bg-stone-50/70 transition-colors">
                                <td class="px-4 py-3 text-sm tabular-nums text-stone-400">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-stone-800">
                                    {{ $class->class_name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-stone-600">
                                    {{ $class->major ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm">
                                    <a href="{{ route('admin.classes.edit', $class) }}"
                                        class="text-emerald-700 hover:text-emerald-900 hover:underline underline-offset-2">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.classes.destroy', $class) }}"
                                        method="POST"
                                        class="inline-block ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-rose-700 hover:text-rose-900 hover:underline underline-offset-2"
                                            onclick="return confirm('Hapus data kelas ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center">
                                    <p class="text-sm text-stone-500">Belum ada kelas yang ditambahkan.</p>
                                    <a href="{{ route('admin.classes.create') }}" class="mt-2 inline-block text-sm text-emerald-700 hover:underline">
                                        Tambahkan kelas pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($classes->hasPages())
                    <div class="border-t border-stone-100 px-4 py-3">
                        {{ $classes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
