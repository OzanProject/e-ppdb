@extends('backend.layouts.app')

@section('content')
<style>
    /* Force date picker icon to be visible and white in dark mode */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
</style>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Header -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Konfigurasi PPDB - {{ $school->name }}</h6>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <!-- Tab Navigation -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-tracks-tab" data-bs-toggle="pill" data-bs-target="#pills-tracks" type="button" role="tab">Jalur & Kuota</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-schedules-tab" data-bs-toggle="pill" data-bs-target="#pills-schedules" type="button" role="tab">Jadwal Kegiatan</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="pills-tabContent">
                    
                    <!-- TAB JALUR & KUOTA -->
                    <div class="tab-pane fade show active" id="pills-tracks" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0 text-primary">Daftar Jalur Pendaftaran</h6>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTrackModal"><i class="fa fa-plus me-2"></i>Tambah Jalur</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr class="text-white">
                                        <th>Nama Jalur</th>
                                        <th>Kuota</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tracks as $track)
                                    <tr>
                                        <td>{{ $track->name }}</td>
                                        <td>{{ $track->quota }} Siswa</td>
                                        <td>{{ Str::limit($track->description, 50) }}</td>
                                        <td>
                                            @if($track->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editTrackModal{{ $track->id }}"><i class="fa fa-edit"></i></button>
                                            <form action="{{ route('admin.ppdb.tracks.destroy', $track->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jalur ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Track Modal -->
                                    <div class="modal fade" id="editTrackModal{{ $track->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-secondary">
                                                <form action="{{ route('admin.ppdb.tracks.update', $track->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-primary">Edit Jalur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Jalur</label>
                                                            <input type="text" class="form-control" name="name" value="{{ $track->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kuota</label>
                                                            <input type="number" class="form-control" name="quota" value="{{ $track->quota }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" name="description" rows="2">{{ $track->description }}</textarea>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $track->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label">Status Aktif</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr><td colspan="5" class="text-center">Belum ada jalur pendaftaran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB JADWAL KEGIATAN -->
                    <div class="tab-pane fade" id="pills-schedules" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0 text-primary">Agenda & Jadwal Kegiatan</h6>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal"><i class="fa fa-plus me-2"></i>Tambah Kegiatan</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr class="text-white">
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->activity }}</td>
                                        <td>{{ $schedule->start_date->format('d M Y') }}</td>
                                        <td>{{ $schedule->end_date->format('d M Y') }}</td>
                                        <td>
                                            @if($schedule->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal{{ $schedule->id }}"><i class="fa fa-edit"></i></button>
                                            <form action="{{ route('admin.ppdb.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kegiatan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Schedule Modal -->
                                    <div class="modal fade" id="editScheduleModal{{ $schedule->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-secondary">
                                                <form action="{{ route('admin.ppdb.schedules.update', $schedule->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-primary">Edit Kegiatan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Kegiatan</label>
                                                            <input type="text" class="form-control" name="activity" value="{{ $schedule->activity }}" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Tanggal Mulai</label>
                                                                <input type="date" class="form-control" name="start_date" value="{{ $schedule->start_date->format('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Tanggal Selesai</label>
                                                                <input type="date" class="form-control" name="end_date" value="{{ $schedule->end_date->format('Y-m-d') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $schedule->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label">Status Aktif</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr><td colspan="5" class="text-center">Belum ada jadwal kegiatan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Track Modal -->
<div class="modal fade" id="addTrackModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('admin.ppdb.tracks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="school_id" value="{{ $school->id }}">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Tambah Jalur Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jalur</label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: Zonasi, Prestasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota</label>
                        <input type="number" class="form-control" name="quota" placeholder="Jumlah Siswa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="2" placeholder="Keterangan singkat..."></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('admin.ppdb.schedules.store') }}" method="POST">
                @csrf
                <input type="hidden" name="school_id" value="{{ $school->id }}">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="activity" placeholder="Contoh: Pendaftaran Gelombang 1" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
