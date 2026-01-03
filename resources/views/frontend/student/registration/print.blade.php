<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Bukti Pendaftaran - {{ $registration->registration_code }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11pt; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; }
        .header { width: 100%; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-table { width: 100%; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .logo-cell img { width: 70px; }
        .text-cell { text-align: center; vertical-align: middle; }
        .text-cell h2 { font-size: 14pt; margin: 0; text-transform: uppercase; }
        .text-cell h1 { font-size: 18pt; margin: 5px 0; text-transform: uppercase; font-weight: bold; }
        .text-cell p { font-size: 10pt; margin: 0; }
        
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; font-size: 14pt; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .main-table td { padding: 4px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
        
        .box-note { border: 1px solid #000; padding: 10px; margin-top: 15px; font-size: 10pt; }
        
        .footer-table { width: 100%; margin-top: 40px; }
        .signature-cell { width: 40%; text-align: center; vertical-align: top; float: right; }
        .signature-line { margin-top: 60px; font-weight: bold; text-decoration: underline; }

        @media print {
            body { margin: 1cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="container">
        <!-- Header Table -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if($registration->school && $registration->school->logo)
                            <img src="{{ asset('storage/' . $registration->school->logo) }}" alt="Logo">
                        @else
                             <!-- Placeholder if no logo -->
                             <span style="font-size: 30pt; font-weight: bold; border: 2px solid #000; padding: 5px 15px; border-radius: 50%;">{{ substr($registration->school->name ?? 'S', 0, 1) }}</span>
                        @endif
                    </td>
                    <td class="text-cell">
                        <h2>PANITIA PENERIMAAN PESERTA DIDIK BARU</h2>
                        <h1>{{ $registration->school->name ?? 'NAMA SEKOLAH' }}</h1>
                        <p>{{ $registration->school->alamat ?? 'Alamat Sekolah Belum Diisi' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="title">TANDA BUKTI PENDAFTARAN</div>

        <table class="main-table">
            <tr>
                <td class="label">Nomor Pendaftaran</td><td>: <strong>{{ $registration->registration_code }}</strong></td>
            </tr>
            <tr>
                <td class="label">Tanggal Daftar</td><td>: {{ $registration->created_at->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Jalur Pendaftaran</td><td>: {{ $registration->track->name ?? '-' }}</td>
            </tr>
        </table>

        <div style="border-bottom: 1px dashed #000; margin: 10px 0;"></div>

        <table class="main-table">
            <tr><td class="label">NISN</td><td>: {{ $user->studentProfile->nisn ?? '-' }}</td></tr>
            <tr><td class="label">Nama Lengkap</td><td>: <strong>{{ $user->name }}</strong></td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>: {{ $user->studentProfile->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>: {{ $user->studentProfile->birth_place ?? '-' }}, {{ \Carbon\Carbon::parse($user->studentProfile->birth_date)->translatedFormat('d F Y') }}</td></tr>
            <tr><td class="label">Asal Sekolah</td><td>: {{ $user->studentProfile->school_origin ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>: {{ $user->studentProfile->address ?? '-' }}</td></tr>
        </table>

        <div class="box-note">
            <strong>Catatan Penting:</strong>
            <ul style="margin: 5px 0 0 15px; padding: 0;">
                <li>Simpan bukti pendaftaran ini sebagai syarat verifikasi.</li>
                <li>Pantau terus status pendaftaran Anda secara berkala.</li>
                <li>Bawa dokumen asli saat jadwal verifikasi fisik.</li>
            </ul>
        </div>

        <table class="footer-table">
            <tr>
                <td style="width: 50%;"></td>
                <td class="signature-cell">
                    <p>Dicetak pada: {{ now()->format('d F Y') }}</p>
                    <p>Calon Peserta Didik,</p>
                    <div class="signature-line">{{ $user->name }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
