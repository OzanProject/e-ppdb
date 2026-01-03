@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Header & Filter -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manajemen Pengumuman Seleksi</h6>
                <form action="{{ route('admin.announcements.index') }}" method="GET" class="d-flex">
                    <select class="form-select me-2" name="track_id" onchange="this.form.submit()">
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" {{ isset($selectedTrack) && $selectedTrack->id == $track->id ? 'selected' : '' }}>
                                {{ $track->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        @if($selectedTrack)
        
        <!-- Status Card -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4 text-center">
                @if($selectedTrack->is_announced)
                    <div class="mb-3">
                        <i class="fa fa-lock fa-4x text-success"></i>
                    </div>
                    <h3 class="text-success fw-bold">PENGUMUMAN SUDAH DITERBITKAN</h3>
                    <p class="text-muted">Hasil seleksi jalur <strong>{{ $selectedTrack->name }}</strong> sudah dapat dilihat oleh siswa.</p>
                    <p class="text-white small">Data seleksi terkunci demi integritas.</p>
                    
                    <form action="{{ route('admin.announcements.unpublish') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MEMBATALKAN pengumuman? Data akan terbuka kembali.')">
                        @csrf
                        <input type="hidden" name="track_id" value="{{ $selectedTrack->id }}">
                        <button type="submit" class="btn btn-outline-danger btn-sm mt-3"><i class="fa fa-unlock me-2"></i>Batal Publish (Darurat)</button>
                    </form>
                @else
                    <div class="mb-3">
                        <i class="fa fa-bullhorn fa-4x text-warning"></i>
                    </div>
                    <h3 class="text-warning fw-bold">BELUM DIUMUMKAN</h3>
                    <p class="text-muted">Hasil seleksi jalur <strong>{{ $selectedTrack->name }}</strong> masih bersifat draft.</p>
                    <p class="text-white small">Pastikan semua data sudah benar sebelum mempublikasikan.</p>
                    
                    <form action="{{ route('admin.announcements.publish') }}" method="POST" onsubmit="return confirm('Yakin ingin mempublikasikan? Setelah ini data akan TERKUNCI.')">
                        @csrf
                        <input type="hidden" name="track_id" value="{{ $selectedTrack->id }}">
                        <button type="submit" class="btn btn-success btn-lg mt-3 px-5"><i class="fa fa-check-circle me-2"></i>PUBLISH SEKARANG</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Accepted List -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <h6 class="mb-4">Daftar Siswa Lolos Seleksi - {{ $selectedTrack->name }}</h6>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="text-center">Rank</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Asal Sekolah</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                            <tr>
                                <td class="text-center fw-bold">#{{ $reg->rank }}</td>
                                <td>{{ $reg->registration_code }}</td>
                                <td>{{ $reg->user->name }}</td>
                                <td>{{ $reg->user->studentProfile->school_origin ?? '-' }}</td>
                                <td>{{ $reg->score }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada siswa yang dinyatakan lolos pada jalur ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
