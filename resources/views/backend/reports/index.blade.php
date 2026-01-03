@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Header -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <h6 class="mb-4">Pusat Laporan & Export Data</h6>
                <p class="text-muted mb-0">Silakan pilih jalur pendaftaran untuk mencetak laporan kelulusan siswa.</p>
            </div>
        </div>

        <!-- Filter & Actions -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <form id="reportForm" action="#" method="POST" target="_blank">
                    @csrf
                    
                    <div class="row">
                        <!-- 1. Data Selection -->
                        <div class="col-md-6 mb-4">
                            <h6 class="text-white mb-3">1. Pilih Data</h6>
                            <div class="mb-3">
                                <label class="form-label">Jalur Pendaftaran</label>
                                <select name="track_id" class="form-select bg-dark text-white" required>
                                    <option value="" disabled selected>-- Pilih Jalur --</option>
                                    @foreach($tracks as $track)
                                        <option value="{{ $track->id }}">{{ $track->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- 2. Print Settings -->
                        <div class="col-md-6 mb-4">
                            <h6 class="text-white mb-3">2. Pengaturan Cetak</h6>
                            <div class="mb-3">
                                <label class="form-label">Ukuran Kertas</label>
                                <select name="paper_size" class="form-select bg-dark text-white">
                                    <option value="a4_portrait">A4 Portrait (Tegak)</option>
                                    <option value="a4_landscape" selected>A4 Landscape (Mendatar - Data Lengkap)</option>
                                    <option value="f4_portrait">F4 Portrait (Tegak)</option>
                                    <option value="f4_landscape">F4 Landscape (Mendatar)</option>
                                </select>
                            </div>
                        </div>

                        <hr class="dropdown-divider mb-4 border-secondary">

                        <!-- 3. Kop Surat Override -->
                        <div class="col-md-6 mb-4">
                            <h6 class="text-white mb-3">3. Kustomisasi Kop Surat (Opsional)</h6>
                            <p class="text-muted small">Kosongkan jika ingin menggunakan data default sekolah.</p>
                            <div class="mb-2">
                                <label class="small text-muted">Judul Kop (Baris 1)</label>
                                <input type="text" name="header_line1" class="form-control form-control-sm bg-dark text-white" placeholder="{{ $school->name }}">
                            </div>
                            <div class="mb-2">
                                <label class="small text-muted">Alamat (Baris 2)</label>
                                <input type="text" name="header_line2" class="form-control form-control-sm bg-dark text-white" placeholder="{{ $school->alamat }}">
                            </div>
                        </div>

                        <!-- 4. Signature Override -->
                        <div class="col-md-6 mb-4">
                            <h6 class="text-white mb-3">4. Penandatangan (Opsional)</h6>
                            <p class="text-muted small">Kosongkan jika ingin menggunakan data default Kepala Sekolah.</p>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="small text-muted">Kota Penetapan</label>
                                    <input type="text" name="sign_city" class="form-control form-control-sm bg-dark text-white" value="{{ $school->city_name ?? 'Kota' }}">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="small text-muted">Tanggal</label>
                                    <input type="date" name="sign_date" class="form-control form-control-sm bg-dark text-white" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="small text-muted">Nama Penandatangan</label>
                                    <input type="text" name="sign_name" class="form-control form-control-sm bg-dark text-white" placeholder="{{ $school->headmaster_name }}" value="{{ $school->headmaster_name }}">
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="small text-muted">NIP / Jabatan</label>
                                    <input type="text" name="sign_nip" class="form-control form-control-sm bg-dark text-white" placeholder="{{ $school->headmaster_nip }}" value="{{ $school->headmaster_nip }}">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 text-end">
                            <button type="submit" onclick="setAction('{{ route('admin.reports.excel') }}')" class="btn btn-success me-2">
                                <i class="fa fa-file-excel me-2"></i>Export Excel
                            </button>
                            <button type="submit" onclick="setAction('{{ route('admin.reports.print') }}')" class="btn btn-primary px-4">
                                <i class="fa fa-print me-2"></i>Cetak Laporan PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function setAction(url) {
        document.getElementById('reportForm').action = url;
    }
</script>
@endsection
