@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Header -->
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Detail Pendaftaran #{{ $registration->registration_code }}</h5>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left me-2"></i>Kembali</a>
        </div>

        <!-- Status Card -->
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 h-100">
                <h6 class="mb-4 text-primary">Status Pendaftaran</h6>
                
                <div class="mb-3 text-center">
                    @if($registration->status == 'new')
                        <h1 class="text-warning mb-2"><i class="fa fa-clock"></i></h1>
                        <h4 class="text-white">Menunggu Verifikasi</h4>
                    @elseif($registration->status == 'verified')
                        <h1 class="text-info mb-2"><i class="fa fa-check-circle"></i></h1>
                        <h4 class="text-white">Terverifikasi</h4>
                    @elseif($registration->status == 'rejected')
                        <h1 class="text-danger mb-2"><i class="fa fa-times-circle"></i></h1>
                        <h4 class="text-white">Ditolak</h4>
                    @elseif($registration->status == 'accepted')
                        <h1 class="text-success mb-2"><i class="fa fa-graduation-cap"></i></h1>
                        <h4 class="text-white">Diterima</h4>
                    @endif
                    <p class="text-muted">{{ $registration->updated_at->format('d M Y H:i') }}</p>
                </div>

                <hr class="bg-dark">

                <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Update Status</label>
                        <select class="form-select" name="status">
                            <option value="new" {{ $registration->status == 'new' ? 'selected' : '' }}>Baru / Menunggu</option>
                            <option value="verified" {{ $registration->status == 'verified' ? 'selected' : '' }}>Verifikasi Berkas OK</option>
                            <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>Tolak Pendaftaran</option>
                            <!-- Accepted is usually set by system ranking, but manual override is okay -->
                            <option value="accepted" {{ $registration->status == 'accepted' ? 'selected' : '' }}>Lolos Seleksi</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan Verifikator</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Alasan penolakan atau catatan...">{{ $registration->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Biodata Card -->
        <div class="col-md-8">
            <div class="bg-secondary rounded p-4 h-100">
                <h6 class="mb-4 text-primary">Data Diri Calon Siswa</h6>
                
                @php $profile = $registration->user->studentProfile; @endphp
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nama Lengkap</label>
                        <div class="fw-bold text-white">{{ $registration->user->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">NISN</label>
                        <div class="fw-bold text-white">{{ $profile->nisn ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Jenis Kelamin</label>
                        <div class="fw-bold text-white">{{ $profile->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tempat, Tanggal Lahir</label>
                        <div class="fw-bold text-white">{{ $profile->birth_place }}, {{ $profile->birth_date ? $profile->birth_date->format('d F Y') : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nomor Telepon</label>
                        <div class="fw-bold text-white">{{ $profile->phone ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Asal Sekolah</label>
                        <div class="fw-bold text-white">{{ $profile->school_origin ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Alamat Lengkap</label>
                        <div class="fw-bold text-white">{{ $profile->address ?? '-' }}</div>
                    </div>
                </div>

                <hr class="bg-dark">

                <h6 class="mb-3 text-primary">Informasi Sekolah Tujuan</h6>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted small">Sekolah</label>
                        <div class="fw-bold text-white">{{ $registration->school->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Jalur Pendaftaran</label>
                        <div class="fw-bold text-white">{{ $registration->track->name }}</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Documents Verification -->
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 text-primary">Verifikasi Berkas Persyaratan</h6>
                </div>
                
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Jenis Dokumen</th>
                                <th>Preview</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registration->documents as $doc)
                            <tr>
                                <td class="text-uppercase fw-bold">{{ $doc->type }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fa fa-eye me-1"></i> Lihat File
                                    </a>
                                </td>
                                <td>
                                    @if($doc->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($doc->status == 'valid')
                                        <span class="badge bg-success">Valid</span>
                                    @elseif($doc->status == 'invalid')
                                        <span class="badge bg-danger">Tidak Valid</span>
                                    @endif
                                </td>
                                <td>{{ $doc->feedback ?? '-' }}</td>
                                <td>
                                    @if($doc->status != 'valid')
                                    <form action="{{ route('admin.registrations.documents.update', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="valid">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Valid</button>
                                    </form>
                                    @endif

                                    @if($doc->status != 'invalid')
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#invalidDoc{{ $doc->id }}">
                                        <i class="fa fa-times"></i> Tolak
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Invalid Modal -->
                            <div class="modal fade" id="invalidDoc{{ $doc->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-secondary">
                                        <form action="{{ route('admin.registrations.documents.update', $doc->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="invalid">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger">Tolak Dokumen {{ strtoupper($doc->type) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Penolakan</label>
                                                    <textarea class="form-control" name="feedback" rows="3" required placeholder="Contoh: Foto buram, dokumen tidak terbaca..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Simpan Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada dokumen yang diunggah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
