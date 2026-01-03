@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Sekolah</h6>
            <a href="{{ route('admin.schools.create') }}" class="btn btn-sm btn-primary">Tambah Sekolah</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="text-center" style="width: 80px;">Logo</th>
                        <th scope="col" style="min-width: 200px;">Nama Sekolah</th>
                        <th scope="col" class="text-center" style="width: 100px;">Jenjang</th>
                        <th scope="col" style="width: 150px;">Tahun Ajaran</th>
                        <th scope="col">Alamat</th>
                        <th scope="col" class="text-center" style="width: 120px;">Status</th>
                        <th scope="col" class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        <td class="text-center">
                            @if($school->logo)
                                <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fa fa-university text-primary"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $school->name }}</td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">{{ strtoupper($school->jenjang) }}</span>
                        </td>
                        <td>{{ $school->tahun_ajaran }}</td>
                        <td><small>{{ Str::limit($school->alamat, 50) }}</small></td>
                        <td class="text-center">
                            @if($school->is_active)
                                <span class="badge bg-success rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.schools.edit', $school->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data sekolah</h5>
                                <p class="text-muted mb-0">Silakan tambahkan data sekolah baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
