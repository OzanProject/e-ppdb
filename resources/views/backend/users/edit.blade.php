@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Edit User</h6>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="panitia" {{ $user->role == 'panitia' ? 'selected' : '' }}>Panitia</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check pt-4">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ $user->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Status Aktif (Login Enabled)
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <h6 class="text-primary mb-3">Reset Password (Opsional)</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak diganti">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Biarkan kosong jika tidak diganti">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</div>
@endsection
