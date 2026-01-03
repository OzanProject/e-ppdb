@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Tambah Sekolah</h6>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
        <form action="{{ route('admin.schools.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Sekolah</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select class="form-select" id="jenjang" name="jenjang" required>
                        <option value="" selected disabled>Pilih Jenjang</option>
                        <option value="sd">SD</option>
                        <option value="smp">SMP</option>
                        <option value="sma">SMA</option>
                        <option value="smk">SMK</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Contoh: 2024/2025" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="logo" class="form-label">Logo Sekolah</label>
                    <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, GIF (Max. 2MB). Disarankan rasio 1:1.</div>
                </div>

                <div class="col-12 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Status Aktif (Buka Pendaftaran)
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
