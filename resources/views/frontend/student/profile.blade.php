@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Profil Akun</h1>
            <a href="{{ route('student.dashboard') }}" class="text-primary-custom hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Avatar Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                             @if($user->avatar && Storage::disk('public')->exists($user->avatar))
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-20 w-20 rounded-full object-cover border border-gray-300">
                            @else
                                <div class="h-20 w-20 rounded-full bg-primary-custom flex items-center justify-center text-white font-bold text-3xl">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="avatar" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-primary-custom
                                hover:file:bg-blue-100
                            "/>
                            <p class="mt-1 text-xs text-gray-500">JPG, GIF or PNG. Max 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                         @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Password <span class="text-sm font-normal text-gray-500">(Opsional)</span></h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                         <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                             @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-1 hidden sm:block"></div> {{-- Spacer --}}

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                             @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-5">
                    <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-primary-custom py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
