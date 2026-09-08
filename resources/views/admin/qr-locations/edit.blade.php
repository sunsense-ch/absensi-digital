<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-serif text-2xl text-stone-800">Edit Lokasi QR</h2>
            <p class="text-sm text-stone-500">Perbarui data lokasi "{{ $qrLocation->name }}".</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg border border-stone-200 bg-white p-6">
                <form method="POST" action="{{ route('admin.qr-locations.update', $qrLocation) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-stone-700">
                            Nama Lokasi
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $qrLocation->name) }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('name')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="mb-1 block text-sm font-medium text-stone-700">
                            Kode Lokasi
                        </label>
                        <input
                            id="code"
                            type="text"
                            name="code"
                            value="{{ old('code', $qrLocation->code) }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('code')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="mb-1 block text-sm font-medium text-stone-700">
                                Latitude
                            </label>
                            <input
                                id="latitude"
                                type="number"
                                step="any"
                                name="latitude"
                                value="{{ old('latitude', $qrLocation->latitude) }}"
                                class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            @error('latitude')
                                <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="longitude" class="mb-1 block text-sm font-medium text-stone-700">
                                Longitude
                            </label>
                            <input
                                id="longitude"
                                type="number"
                                step="any"
                                name="longitude"
                                value="{{ old('longitude', $qrLocation->longitude) }}"
                                class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            @error('longitude')
                                <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="radius" class="mb-1 block text-sm font-medium text-stone-700">
                            Radius (meter)
                        </label>
                        <input
                            id="radius"
                            type="number"
                            name="radius"
                            value="{{ old('radius', $qrLocation->radius) }}"
                            class="block w-full rounded-md border-stone-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('radius')
                            <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="rounded-md bg-emerald-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                            Update
                        </button>
                        <a href="{{ route('admin.qr-locations.index') }}" class="text-sm text-stone-500 hover:text-stone-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
