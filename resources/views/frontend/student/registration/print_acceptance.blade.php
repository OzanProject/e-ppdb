<!DOCTYPE html>
<html>
<head>
    <title>Surat Keterangan Lulus - {{ $registration->registration_code }} - {{ $registration->user->name }}</title>
    @if(isset($registration->school->logo) && $registration->school->logo)
        <link rel="icon" href="{{ asset('storage/' . $registration->school->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px; /* Reduced padding */
            line-height: 1.4; /* Slightly tighter line height */
            font-size: 11pt; /* Optimized for A4 */
        }
        
        /* Ensure A4 size and clear margins */
        @page {
            size: A4;
            margin: 1.5cm;
        }

        /* Kop Surat Styles */
        table.header-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 20px; }
        table.header-table td { vertical-align: middle; }
        
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header h2 { margin: 3px 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 0; font-size: 11px; }
        
        .content { margin-bottom: 10px; }
        .meta-table { width: 100%; margin: 15px 0; border-collapse: collapse; }
        .meta-table td { padding: 3px; vertical-align: top; }
        .meta-table td:first-child { width: 150px; font-weight: bold; }
        
        .status-box { 
            text-align: center; 
            border: 2px solid #000; 
            padding: 10px; 
            margin: 20px 0; 
            font-weight: bold; 
            font-size: 18px; 
        }
        
        .footer { margin-top: 30px; text-align: right; }
        .signature { margin-top: 60px; text-decoration: underline; font-weight: bold; }
        
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Surat</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <!-- Kop Surat with Logo -->
    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center;">
                @if(isset($registration->school->logo))
                    <img src="{{ asset('storage/' . $registration->school->logo) }}" style="width: 80px; height: auto;">
                @endif
            </td>
            <td width="85%" style="text-align: center;">
                <div class="header">
                    <h1>PANITIA PENERIMAAN PESERTA DIDIK BARU</h1>
                    <h2>{{ $registration->school->name ?? 'NAMA SEKOLAH' }}</h2>
                    <p>{{ $registration->school->alamat ?? 'Alamat sekolah belum diisi' }}</p>
                    <p>Telp: {{ $registration->school->phone ?? '-' }} | Email: {{ $registration->school->email ?? '-' }}</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="content">
        <p>Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Pelajaran {{ $registration->school->tahun_ajaran ?? date('Y').'/'.(date('Y')+1) }}, Kepala {{ $registration->school->name }} menerangkan bahwa:</p>

        <table class="meta-table">
            <tr>
                <td>No. Pendaftaran</td>
                <td>: {{ $registration->registration_code }}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: {{ strtoupper($registration->user->name) }}</td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>: {{ $registration->user->studentProfile->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>: {{ $registration->user->studentProfile->school_origin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jalur Pendaftaran</td>
                <td>: {{ $registration->track->name }}</td>
            </tr>
        </table>

        <p>Dinyatakan:</p>

        <div class="status-box">
            LULUS SELEKSI / DITERIMA
        </div>

        <p>Sebagai peserta didik baru di {{ $registration->school->name }} Tahun Pelajaran {{ $registration->school->tahun_ajaran ?? date('Y').'/'.(date('Y')+1) }}.</p>
        
        <p>Peserta didik yang dinyatakan diterima <strong>WAJIB</strong> melakukan daftar ulang pada tanggal yang telah ditentukan. Bagi peserta yang tidak melakukan daftar ulang dianggap mengundurkan diri.</p>
    </div>

    <div class="footer">
        <p>Ditetapkan di: {{ $registration->school->district ?? '.........' }}</p>
        <p>Pada Tanggal: {{ date('d F Y') }}</p>
        <br>
        <p>Kepala Sekolah,</p>
        <div class="signature">
            <br><br><br>
            <strong><u>{{ $registration->school->headmaster_name ?? '( ................................ )' }}</u></strong>
        </div>
        <p>NIP. {{ $registration->school->headmaster_nip ?? '......................' }}</p>
    </div>
</body>
</html>
