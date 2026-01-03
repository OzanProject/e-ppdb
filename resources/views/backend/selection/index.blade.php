@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Header & Filter -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Seleksi & Perankingan</h6>
                <form action="{{ route('admin.selection.index') }}" method="GET" class="d-flex">
                    <select class="form-select me-2" name="track_id" onchange="this.form.submit()">
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" {{ isset($selectedTrack) && $selectedTrack->id == $track->id ? 'selected' : '' }}>
                                {{ $track->name }} (Kuota: {{ $track->quota }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        @if($selectedTrack)
        <!-- Dashboard Stats -->
        <div class="col-12">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-users fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Calon</p>
                            <h6 class="mb-0">{{ $registrations->count() }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-check-circle fa-3x text-success"></i>
                        <div class="ms-3">
                            <p class="mb-2">Diterima Sementara</p>
                            <h6 class="mb-0">{{ $registrations->where('status', 'accepted')->count() }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-6">
                     <div class="bg-secondary rounded p-4 h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2">Aksi Seleksi</h6>
                            <small class="text-muted">Jalankan mesin seleksi untuk mengurutkan ranking.</small>
                        </div>
                        <form action="{{ route('admin.selection.calculate') }}" method="POST" onsubmit="return confirm('Jalankan proses seleksi otomatis? Status siswa akan diupdate.')">
                            @csrf
                            <input type="hidden" name="track_id" value="{{ $selectedTrack->id }}">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-cogs me-2"></i>Proses Seleksi</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>

        <!-- Ranking Table -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <h6 class="mb-4">Hasil Perankingan - Jalur {{ $selectedTrack->name }}</h6>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="text-center">Peringkat</th>
                                <th>Nama Siswa</th>
                                <th>Nilai Akhir</th>
                                <th>Jarak (m)</th>
                                <th>Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                            <tr class="{{ $reg->status == 'accepted' ? 'table-success' : '' }}">
                                <td class="text-center fw-bold fs-5">
                                    @if($reg->rank)
                                        #{{ $reg->rank }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $reg->user->name }}<br>
                                    <small class="text-muted">{{ $reg->registration_code }}</small>
                                </td>
                                <td>{{ $reg->score }}</td>
                                <td>
                                    @if($reg->distance)
                                        {{ number_format($reg->distance, 0) }} m
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($reg->status == 'accepted')
                                        <span class="badge bg-success">Lolos Seleksi</span>
                                    @elseif($reg->status == 'rejected')
                                        <span class="badge bg-danger">Tidak Lolos</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data calon siswa yang terverifikasi.</td>
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
