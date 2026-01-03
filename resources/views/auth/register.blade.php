@extends('frontend.layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Akun Baru</h2>
            <p class="text-sm text-gray-600">Buat akun untuk memulai proses PPDB.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap Siswa</label>
                <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            
            <!-- Hidden Role Input (Force user to be 'siswa' or logic handled in controller) -->
            <!-- Note: Controller usually defaults to 'user' or we assign 'siswa' role after registration -->

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Sudah terdaftar?') }}
                </a>

                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-primary-custom border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Daftar Sekarang') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
