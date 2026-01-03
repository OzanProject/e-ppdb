@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Pendaftar PPDB</h6>
        </div>

        <!-- Filter & Search -->
        <form action="{{ route('admin.registrations.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" name="track_id" onchange="this.form.submit()">
                        <option value="">Semua Jalur</option>
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" {{ request('track_id') == $track->id ? 'selected' : '' }}>{{ $track->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari Kode / Nama Siswa..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-2"></i>Cari</button>
                </div>
            </div>
        </form>

        <form action="{{ route('admin.registrations.destroy_multiple') }}" method="POST" id="massDeleteForm" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?');">
            @csrf
            
            <div class="mb-3">
                <button type="submit" class="btn btn-danger" id="btnDeleteSelected" disabled>
                    <i class="fa fa-trash me-2"></i>Hapus Terpilih
                </button>
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" style="width: 40px;">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </th>
                            <th scope="col">Kode Daftar</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Jalur</th>
                            <th scope="col">Asal Sekolah</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                        <tr>
                            <td>
                                <input class="form-check-input select-item" type="checkbox" name="ids[]" value="{{ $reg->id }}">
                            </td>
                            <td><span class="fw-bold text-primary">{{ $reg->registration_code }}</span></td>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->track->name }}</td>
                            <td>{{ $reg->user->studentProfile->school_origin ?? '-' }}</td>
                            <td class="text-center">
                                @if($reg->status == 'new')
                                    <span class="badge bg-warning text-dark">Baru</span>
                                @elseif($reg->status == 'verified')
                                    <span class="badge bg-info text-dark">Terverifikasi</span>
                                @elseif($reg->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($reg->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.registrations.show', $reg->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data pendaftar yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <script>
            document.getElementById('selectAll').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('.select-item');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                }.bind(this));
                toggleDeleteButton();
            });

            var checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', toggleDeleteButton);
            });

            function toggleDeleteButton() {
                var selected = document.querySelectorAll('.select-item:checked').length;
                var btn = document.getElementById('btnDeleteSelected');
                if(selected > 0) {
                    btn.disabled = false;
                } else {
                    btn.disabled = true;
                }
            }
        </script>
        
        <div class="mt-3">
            {{ $registrations->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
