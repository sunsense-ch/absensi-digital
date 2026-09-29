<x-app-layout>
    <x-slot name="header"><h2>Memeriksa Lokasi</h2></x-slot>

    <div class="card" style="max-width:420px;margin:0 auto;text-align:center;">
        <p id="loc-title" style="font-size:16px;font-weight:700;color:var(--primary-dark);margin:0 0 6px;">
            Mengambil lokasi GPS kamu...
        </p>
        <p id="loc-text" style="font-size:12.5px;color:var(--muted);margin:0;">
            Izinkan akses lokasi saat browser meminta. Lokasi dipakai untuk memastikan kamu berada di area absensi.
        </p>

        <div id="loc-actions" style="display:none;margin-top:18px;">
            <button type="button" id="retry-btn" class="btn btn-primary">Coba lagi</button>
        </div>

        <p style="margin-top:18px;">
            <a href="{{ route('siswa.dashboard') }}" style="font-size:12.5px;color:var(--secondary);">
                &larr; Kembali ke Dashboard
            </a>
        </p>
    </div>

    <script>
        const baseUrl = @json(route('qr.scan', $token));
        const title = document.getElementById('loc-title');
        const text = document.getElementById('loc-text');
        const actions = document.getElementById('loc-actions');

        function showError(msg) {
            title.textContent = 'Lokasi tidak bisa diambil';
            title.style.color = 'var(--danger)';
            text.textContent = msg;
            actions.style.display = 'block';
        }

        function getLocation() {
            actions.style.display = 'none';
            title.textContent = 'Mengambil lokasi GPS kamu...';
            title.style.color = 'var(--primary-dark)';

            if (!navigator.geolocation) {
                showError('Browser ini tidak mendukung GPS.');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    title.textContent = 'Lokasi didapat, memproses absensi...';
                    const url = new URL(baseUrl);
                    url.searchParams.set('latitude', pos.coords.latitude);
                    url.searchParams.set('longitude', pos.coords.longitude);
                    window.location.replace(url.toString());
                },
                (err) => {
                    if (err.code === 1) {
                        showError('Izin lokasi ditolak. Aktifkan izin lokasi untuk situs ini di pengaturan browser, lalu coba lagi.');
                    } else if (err.code === 2) {
                        showError('Posisi tidak tersedia. Pastikan GPS/lokasi HP aktif, lalu coba lagi.');
                    } else {
                        showError('Waktu pengambilan lokasi habis. Coba lagi di tempat yang lebih terbuka.');
                    }
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        }

        document.getElementById('retry-btn').addEventListener('click', getLocation);
        getLocation();
    </script>
</x-app-layout>
