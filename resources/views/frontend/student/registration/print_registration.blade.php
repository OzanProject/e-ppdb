<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran - {{ $registration->registration_code }} - {{ $registration->user->name }}</title>
    @if(isset($registration->school->logo) && $registration->school->logo)
        <link rel="icon" href="{{ asset('storage/' . $registration->school->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            line-height: 1.5;
        }
        .header-container {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-right: 20px;
        }
        .header-text {
            text-align: center;
            flex: 1;
        }
        /* Fallback for older browsers/printers */
        table.header-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 20px; }
        table.header-table td { vertical-align: middle; }
        
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header h2 { margin: 5px 0; font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .content { margin-bottom: 30px; }
        .table-data { width: 100%; border-collapse: collapse; }
        .table-data td { padding: 8px 5px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
        .footer { margin-top: 50px; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-box .date { margin-bottom: 10px; }
        .signature-dash { margin-top: 70px; border-bottom: 1px solid #000; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f0f0f0;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Dokumen</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>

    <!-- Kop Surat with Logo -->
    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center;">
                @if(isset($registration->school->logo))
                    <img src="{{ asset('storage/' . $registration->school->logo) }}" style="width: 90px; height: auto;">
                @endif
            </td>
            <td width="85%" style="text-align: center;">
                <div class="header">
                    <h1>PANITIA PENERIMAAN PESERTA DIDIK BARU</h1>
                    <h2>{{ $registration->school->name ?? 'NAMA SEKOLAH BELUM DISET' }}</h2>
                    <p>{{ $registration->school->alamat ?? 'Alamat sekolah belum diisi' }}</p>
                    <p>Telp: {{ $registration->school->phone ?? '-' }} | Email: {{ $registration->school->email ?? '-' }} | Website: {{ $registration->school->website ?? '-' }}</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="title">TANDA BUKTI PENDAFTARAN</div>

    <div class="content">
        <table class="table-data">
            <tr>
                <td class="label">NOMOR PENDAFTARAN</td>
                <td>: <strong>{{ $registration->registration_code }}</strong></td>
            </tr>
            <tr>
                <td class="label">TANGGAL DAFTAR</td>
                <td>: {{ $registration->created_at->translatedFormat('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">JALUR PENDAFTARAN</td>
                <td>: {{ $registration->track->name }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr style="border: 0; border-top: 1px dashed #ccc; margin: 10px 0;"></td>
            </tr>
            <tr>
                <td class="label">NAMA LENGKAP</td>
                <td>: {{ strtoupper($registration->user->name) }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td>: {{ $registration->user->studentProfile->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">SEKOLAH ASAL</td>
                <td>: {{ $registration->user->studentProfile->school_origin ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div style="float: left; width: 400px; font-size: 11px; margin-top: 20px;">
            <strong>Catatan:</strong>
            <ol>
                <li>Simpan bukti pendaftaran ini dengan baik.</li>
                <li>Pantau terus status pendaftaran melalui dashboard siswa.</li>
                <li>Hubungi panitia jika ada kesalahan data.</li>
            </ol>
        </div>

        <div class="signature-box">
            <div class="date">{{ $registration->school->district ?? 'Jakarta' }}, {{ date('d F Y') }}</div>
            <div>Panitia PPDB,</div>
            <div class="signature-dash"></div>
            <div>( .................................... )</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
