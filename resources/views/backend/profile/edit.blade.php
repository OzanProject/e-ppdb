@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Update Profile Information -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Perbarui Profil</h6>
                
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Profil berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <div class="d-flex align-items-center mb-2">
                            @if($user->avatar && Storage::disk('public')->exists($user->avatar))
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center bg-primary text-white" style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>
                        @error('avatar')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 text-warning">
                                Your email address is unverified.
                                <button form="send-verification" class="btn btn-link p-0 text-warning">Click here to re-send the verification email.</button>
                                
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-success small">A new verification link has been sent to your email address.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Ganti Password</h6>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Password berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                        @error('current_password')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                        @error('password')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
