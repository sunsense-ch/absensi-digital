<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-serif text-2xl text-stone-800">Edit Kelas</h2>
            <p class="text-sm text-stone-500">Perbarui data kelas "{{ $class->class_name }}".</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg border border-stone-200 bg-white p-6">
                <form method="POST" action="{{ route('admin.classes.update', $class) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="class_name" class="mb-1 block text-sm font-medium text-stone-700">
                            Nama Kelas
                        </label>
                        <input
                            id="class_name"
                            type="text"
                            name="class_name"
                            value="{{ old('class_name', $class->class_name) }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('class_name')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="major" class="mb-1 block text-sm font-medium text-stone-700">
                            Jurusan <span class="font-normal text-stone-400">(opsional)</span>
                        </label>
                        <input
                            id="major"
                            type="text"
                            name="major"
                            value="{{ old('major', $class->major) }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('major')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="rounded-md bg-emerald-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                            Update
                        </button>
                        <a href="{{ route('admin.classes.index') }}" class="text-sm text-stone-500 hover:text-stone-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
