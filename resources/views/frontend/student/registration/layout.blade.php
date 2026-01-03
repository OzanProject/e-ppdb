@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Wizard Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Formulir Pendaftaran PPDB</h1>
            <p class="text-gray-600 mt-2">Nomor Pendaftaran akan diterbitkan setelah semua data lengkap.</p>
        </div>

        <!-- Progress Steps -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                
                <!-- Step 1 -->
                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white mb-2 {{ $step >= 1 ? 'bg-primary-custom' : 'bg-gray-300' }}">
                        1
                    </div>
                    <span class="text-xs font-medium {{ $step >= 1 ? 'text-primary-custom' : 'text-gray-500' }}">Biodata</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white mb-2 {{ $step >= 2 ? 'bg-primary-custom' : 'bg-gray-300' }}">
                        2
                    </div>
                    <span class="text-xs font-medium {{ $step >= 2 ? 'text-primary-custom' : 'text-gray-500' }}">Alamat & Ortu</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white mb-2 {{ $step >= 3 ? 'bg-primary-custom' : 'bg-gray-300' }}">
                        3
                    </div>
                    <span class="text-xs font-medium {{ $step >= 3 ? 'text-primary-custom' : 'text-gray-500' }}">Sekolah Asal</span>
                </div>

                 <!-- Step 4 -->
                 <div class="flex flex-col items-center bg-white px-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white mb-2 {{ $step >= 4 ? 'bg-primary-custom' : 'bg-gray-300' }}">
                        4
                    </div>
                    <span class="text-xs font-medium {{ $step >= 4 ? 'text-primary-custom' : 'text-gray-500' }}">Finalisasi</span>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                 @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Terdapat kesalahan pengisian data. Silakan periksa kembali.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('form-content')
            </div>
        </div>

    </div>
</div>
@endsection
