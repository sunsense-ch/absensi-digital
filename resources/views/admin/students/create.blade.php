<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-serif text-2xl text-stone-800">Tambah Siswa</h2>
            <p class="text-sm text-stone-500">Daftarkan siswa baru dan tempatkan pada kelasnya.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg border border-stone-200 bg-white p-6">
                <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nis" class="mb-1 block text-sm font-medium text-stone-700">
                            NIS
                        </label>
                        <input
                            id="nis"
                            type="text"
                            name="nis"
                            value="{{ old('nis') }}"
                            placeholder="Nomor Induk Siswa"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('nis')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="full_name" class="mb-1 block text-sm font-medium text-stone-700">
                            Nama Lengkap
                        </label>
                        <input
                            id="full_name"
                            type="text"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('full_name')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="class_id" class="mb-1 block text-sm font-medium text-stone-700">
                            Kelas
                        </label>
                        <select
                            id="class_id"
                            name="class_id"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                                    {{ $class->class_name }} — {{ $class->major }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="rounded-md bg-emerald-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                            Simpan
                        </button>
                        <a href="{{ route('admin.students.index') }}" class="text-sm text-stone-500 hover:text-stone-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
