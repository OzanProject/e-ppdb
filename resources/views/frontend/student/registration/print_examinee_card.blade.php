<!DOCTYPE html>
<html>
<head>
    <title>Kartu Peserta PPDB - {{ $registration->registration_code }} - {{ $registration->user->name }}</title>
    @if(isset($registration->school->logo) && $registration->school->logo)
        <link rel="icon" href="{{ asset('storage/' . $registration->school->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .card {
            width: 10cm; /* Standard card size approximation */
            height: 14cm;
            border: 2px solid #333;
            padding: 20px;
            box-sizing: border-box;
            background: #fff;
            margin: 0 auto;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .photo {
            width: 3cm;
            height: 4cm;
            background: #eee;
            border: 1px solid #999;
            float: right;
            margin-left: 10px;
            overflow: hidden;
        }
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .content {
            font-size: 12px;
            line-height: 1.5;
        }
        .row {
            margin-bottom: 5px;
            clear: left;
        }
        .label {
            width: 110px;
            display: inline-block;
            font-weight: bold;
        }
        .value {
            display: inline-block;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }
        .qrcode {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border: 1px dashed #ccc;
        }
        @media print {
            body {
                background: none;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Kartu</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <div class="card">
        <div class="header" style="position: relative;">
            @if(isset($registration->school->logo))
                <img src="{{ asset('storage/' . $registration->school->logo) }}" style="position: absolute; left: 0; top: 0; width: 40px; height: 40px; object-fit: contain;">
            @endif
            <div style="margin-left: 0;"> <!-- Align center is default, just ensuring logo doesn't push it weirdly if using float -->
                <h2>KARTU PESERTA PPDB</h2>
                <h3>{{ $registration->school->name }}</h3>
                <p style="font-size: 10px; margin-top: 5px;">Tahun Ajaran {{ $registration->school->tahun_ajaran ?? date('Y').'/'.(date('Y')+1) }}</p>
            </div>
        </div>

        <div class="photo">
            @if(isset($registration->user->avatar) && Storage::disk('public')->exists($registration->user->avatar))
                <img src="{{ asset('storage/' . $registration->user->avatar) }}" alt="Foto">
            @else
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999; font-size: 10px; text-align: center;">Pas Foto<br>3x4</div>
            @endif
        </div>

        <div class="content">
            <div class="row">
                <span class="label">NO. PESERTA</span>: 
                <span class="value">{{ $registration->registration_code }}</span>
            </div>
            <div class="row">
                <span class="label">NAMA LENGKAP</span>: 
                <div style="margin-left: 118px; margin-top: -18px;">{{ strtoupper($registration->user->name) }}</div>
            </div>
            <div class="row">
                <span class="label">NISN</span>: 
                <span class="value">{{ $registration->user->studentProfile->nisn ?? '-' }}</span>
            </div>
             <div class="row">
                <span class="label">ASAL SEKOLAH</span>: 
                <div style="margin-left: 118px; margin-top: -18px;">{{ $registration->user->studentProfile->school_origin ?? '-' }}</div>
            </div>
            <div class="row">
                <span class="label">JALUR</span>: 
                <span class="value">{{ $registration->track->name }}</span>
            </div>
             <div class="row">
                <span class="label">STATUS</span>: 
                <span class="value" style="background: #eee; padding: 2px 5px; border-radius: 3px;">TERVERIFIKASI</span>
            </div>
        </div>

        <div style="clear: both; margin-top: 30px; font-size: 12px;">
            <div style="float: left; width: 60%;">
                <p><strong>Catatan:</strong></p>
                <ul style="padding-left: 15px; margin: 0; font-size: 10px;">
                    <li>Wajib dibawa saat tes seleksi.</li>
                    <li>Datang 30 menit sebelum jadwal.</li>
                    <li>Berpakaian rapi dan sopan.</li>
                </ul>
            </div>
             <div style="float: right; width: 40%; text-align: center;">
                <p style="margin-bottom: 40px;">Panitia PPDB,</p>
                <p style="text-decoration: underline; font-weight: bold;">( ........................... )</p>
            </div>
        </div>
        
        <div class="footer">
            Dicetak pada: {{ date('d F Y H:i') }}
        </div>
    </div>
</body>
</html>
