@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Tambah User Baru</h6>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" selected disabled>Pilih Role</option>
                        <option value="admin">Administrator</option>
                        <option value="panitia">Panitia</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check pt-4">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Status Aktif (Login Enabled)
                        </label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan User</button>
        </form>
    </div>
</div>
@endsection
