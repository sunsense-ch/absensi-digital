<x-app-layout>
    <x-slot name="header"><h2>Tambah Siswa</h2></x-slot>

    <div class="card" style="max-width:480px;">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="field">
                <label>NIS</label>
                <input type="text" name="nis" value="{{ old('nis') }}">
                @error('nis') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Nama Lengkap</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}">
                @error('full_name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Kelas</label>
                <select name="class_id">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                            {{ $class->class_name }} — {{ $class->major }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Akun User (opsional)</label>
                <select name="user_id">
                    <option value="">-- Tidak dihubungkan --</option>
                    @foreach($availableUsers as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <small>Hanya menampilkan akun siswa yang sudah mendaftar tapi belum terhubung ke data siswa manapun.</small>
                @error('user_id') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
