<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelulusan - {{ $track->name }}</title>
    <style>
        @page { size: {{ str_replace('_', ' ', request('paper_size', 'a4 landscape')) }}; margin: 10mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: {{ str_contains(request('paper_size', 'landscape'), 'landscape') ? '10pt' : '11pt' }}; background: #fff; margin: 0; padding: 0; -webkit-print-color-adjust: exact; }
        .container { width: 100%; max-width: {{ str_contains(request('paper_size', 'landscape'), 'landscape') ? '280mm' : '210mm' }}; margin: 0 auto; }
        
        /* Header Layout using padded container */
        .header { 
            position: relative; 
            padding-bottom: 5px; 
            margin-bottom: 15px; 
            border-bottom: 3px double #000; 
            text-align: center;
            padding-left: 100px; 
            padding-right: 100px; 
        }
        .header-content {
            display: block; 
            text-align: center;
            word-wrap: break-word;
        }
        .logo { 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%);
            width: 70px; 
            height: auto; 
            object-fit: contain;
        }
        
        .header h3 { margin: 0; font-size: 13pt; font-weight: normal; text-transform: uppercase; line-height: 1.1; }
        .header h2 { margin: 3px 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; line-height: 1.1; }
        .header p { margin: 1px 0; font-size: 10pt; line-height: 1.3; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; page-break-inside: auto; font-size: {{ str_contains(request('paper_size', 'landscape'), 'landscape') ? '10pt' : '11pt' }}; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        th, td { border: 1px solid #000; padding: 4px 6px; text-align: left; vertical-align: middle; word-wrap: break-word; }
        th { background-color: #e0e0e0 !important; text-align: center; font-weight: bold; height: 30px; }
        
        .signature { margin-top: 40px; float: right; text-align: center; width: 250px; page-break-inside: avoid; }
        .signature p { margin-bottom: 70px; }
        .print-btn { position: fixed; top: 10px; right: 10px; padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px; z-index: 9999; }

        @media print {
            .print-btn { display: none; }
            body { margin: 0; }
            .container { width: 100%; max-width: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Print Button (Hidden on Print) -->
    <button class="print-btn" onclick="window.print()">Cetak Halaman ({{ ucfirst(request('paper_size', 'A4 Landscape')) }})</button>

    <div class="container">
        <!-- Letterhead -->
        <div class="header">
            @if(isset($school->logo) && $school->logo)
                <img src="{{ asset('storage/' . $school->logo) }}" class="logo" alt="Logo">
            @endif
            
            <div class="header-content">
                <h2>{{ request('header_line1') ?: ($school->name ?? 'NAMA SEKOLAH') }}</h2>
                <p>{{ request('header_line2') ?: ($school->alamat ?? 'Alamat Sekolah') }}</p>
                <p>Telp: {{ $school->phone ?? '-' }} | Email: {{ $school->email }} | Web: {{ $school->website ?? '-' }}</p>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 15px;">
            <h3 style="text-decoration: underline;">DAFTAR HASIL SELEKSI PESERTA DIDIK BARU</h3>
            <p style="font-size: 10pt;">Jalur: <strong>{{ $track->name }}</strong> | Tahun Ajaran: {{ $school->tahun_ajaran ?? date('Y') . '/' . (date('Y')+1) }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="12%">No. Daftar</th>
                    <th width="20%">Nama Siswa</th>
                    <th width="8%">NISN</th>
                    <th width="4%">L/P</th>
                    <th width="15%">Tempat, Tgl Lahir</th>
                    <th width="20%">Alamat</th>
                    <th width="10%">Asal Sekolah</th>
                    <th width="7%">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $reg)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $reg->registration_code }}</td>
                    <td>{{ $reg->user->name }}</td>
                    <td>{{ $reg->user->studentProfile->nisn ?? '-' }}</td>
                    <td style="text-align: center;">{{ $reg->user->studentProfile->gender ?? '-' }}</td>
                    <td>
                        {{ $reg->user->studentProfile->birth_place ?? '-' }}, 
                        {{ isset($reg->user->studentProfile->birth_date) ? $reg->user->studentProfile->birth_date->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $reg->user->studentProfile->address ?? '-' }}</td>
                    <td>{{ $reg->user->studentProfile->school_origin ?? '-' }}</td>
                    <td style="text-align: center;">{{ $reg->score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <p>Ditetapkan di: {{ request('sign_city') ?: ($school->city_name ?? 'Kota') }}<br>Pada Tanggal: {{ \Carbon\Carbon::parse(request('sign_date', now()))->translatedFormat('d F Y') }}</p>
            <br>
            <br>
            <br>
            <p><u class="fw-bold">{{ request('sign_name') ?: ($school->headmaster_name ?? '( ......................................... )') }}</u><br>NIP. {{ request('sign_nip') ?: ($school->headmaster_nip ?? '-') }}</p>
        </div>
    </div>

</body>
</html>
