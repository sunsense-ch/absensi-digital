<x-app-layout>
    <x-slot name="header"><h2>Scan QR Absensi</h2></x-slot>

    <div class="card" style="max-width:460px;margin:0 auto;">
        <p id="status-text" style="font-size:12.5px;color:var(--muted);text-align:center;margin:0 0 12px;">
            Arahkan kamera ke QR Code absensi.
        </p>

        <div id="reader" style="width:100%;border-radius:10px;overflow:hidden;"></div>

        <div id="result-box" style="display:none;margin-top:14px;padding:12px;border-radius:8px;text-align:center;font-size:13px;font-weight:600;"></div>

        <p style="margin-top:16px;text-align:center;">
            <a href="{{ route('siswa.dashboard') }}" style="font-size:12.5px;color:var(--secondary);">
                &larr; Kembali ke Dashboard
            </a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        const statusText = document.getElementById('status-text');
        const resultBox = document.getElementById('result-box');

        function showResult(text, ok) {
            resultBox.style.display = 'block';
            resultBox.textContent = text;
            resultBox.style.background = ok ? '#E3EBE0' : '#F5DEDA';
            resultBox.style.color = ok ? 'var(--success)' : 'var(--danger)';
        }

        const scanner = new Html5Qrcode('reader');

        function onScanSuccess(decodedText) {
            // Hentikan kamera dulu supaya tidak scan berkali-kali
            scanner.stop().then(() => {
                statusText.textContent = 'QR terbaca, memproses...';

                // decodedText berisi URL lengkap hasil generate admin,
                // contoh: http://192.168.1.5:8000/scan/AbCdEf123...
                // Kita arahkan browser langsung ke situ -- route /scan/{token}
                // di server yang akan memvalidasi & mencatat absensi.
                window.location.href = decodedText;
            }).catch(() => {
                window.location.href = decodedText;
            });
        }

        function onScanFailure() {
            // Dipanggil terus-menerus tiap frame kalau belum ketemu QR -- dibiarkan kosong,
            // ini normal dan bukan error.
        }

        Html5Qrcode.getCameras().then(cameras => {
            if (!cameras || cameras.length === 0) {
                showResult('Kamera tidak ditemukan di perangkat ini.', false);
                return;
            }

            // Pilih kamera belakang kalau ada (lebih cocok untuk scan)
            const backCamera = cameras.find(c => /back|rear/i.test(c.label)) || cameras[0];

            scanner.start(
                backCamera.id,
                { fps: 10, qrbox: { width: 240, height: 240 } },
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                showResult('Gagal mengakses kamera: ' + err, false);
            });
        }).catch(err => {
            showResult('Butuh izin kamera. Pastikan situs diakses lewat HTTPS atau localhost. (' + err + ')', false);
        });
    </script>
</x-app-layout>
