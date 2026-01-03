@extends('frontend.student.registration.layout', ['step' => 5])

@section('form-content')
<form action="{{ route('student.registration.storeStep5') }}" method="POST">
    @csrf
    
    <div class="space-y-6">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Harap periksa kembali data Anda. Data yang sudah difinalisasi <strong>tidak dapat diubah</strong> kecuali melalui Admin.
                    </p>
                </div>
            </div>
        </div>

        <!-- Data Summary -->
        <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2">Review Data Siswa</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                <dd class="mt-1 text-sm text-gray-900 font-bold bg-gray-50 p-2 rounded">{{ Auth::user()->name }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">NISN</dt>
                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ $studentProfile->nisn }}</dd>
            </div>
            <div class="sm:col-span-2">
                 <dt class="text-sm font-medium text-gray-500">Asal Sekolah</dt>
                 <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ $studentProfile->school_origin }} (NPSN: {{ $studentProfile->npsn_origin }})</dd>
            </div>
            <!-- Uploaded Docs Summary -->
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Dokumen</dt>
                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded">
                    @php
                        $docTypes = ['kk' => 'KK', 'akta' => 'Akta', 'ijazah' => 'Ijazah', 'foto' => 'Foto'];
                        $uploaded = [];
                        foreach($docTypes as $key => $label) {
                             if(isset($documents) && $documents->where('type', $key)->count() > 0) $uploaded[] = $label;
                        }
                    @endphp
                    {{ count($uploaded) > 0 ? implode(', ', $uploaded) : 'Tidak ada dokumen diupload' }}
                </dd>
             </div>
        </dl>

        <!-- Track Selection -->
        <div class="mt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 mb-4">Pilih Jalur Pendaftaran</h3>
            <div class="space-y-4">
                @foreach($activeTracks as $track)
                <div class="relative flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                    <div class="flex items-center h-5">
                        <input id="track_{{ $track->id }}" name="track_id" type="radio" value="{{ $track->id }}" class="focus:ring-primary-custom h-4 w-4 text-primary-custom border-gray-300" required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="track_{{ $track->id }}" class="font-medium text-gray-700 cursor-pointer text-base">{{ $track->name }}</label>
                        <p class="text-gray-500">{{ $track->description ?? 'Jalur pendaftaran untuk peserta didik baru.' }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                            Kuota: {{ $track->quota }} Siswa
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
             @error('track_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Declaration -->
        <div class="mt-6">
            <div class="relative flex items-start">
                <div class="flex items-center h-5">
                    <input id="declaration" name="declaration" type="checkbox" class="focus:ring-primary-custom h-4 w-4 text-primary-custom border-gray-300 rounded" required>
                </div>
                <div class="ml-3 text-sm">
                    <label for="declaration" class="font-medium text-gray-700">Pernyataan Kebenaran Data</label>
                    <p class="text-gray-500">Saya menyatakan bahwa data yang saya isikan adalah benar dan dapat dipertanggungjawabkan. Jika dikemudian hari ditemukan ketidaksesuaian, saya bersedia menerima sanksi pembatalan kelulusan.</p>
                </div>
            </div>
             @error('declaration') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-5 border-t border-gray-200">
             <div class="flex justify-between">
                <a href="{{ route('student.registration.step4') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                     <i class="fas fa-arrow-left mr-2 mt-1"></i> Kembali
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-custom hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom" onclick="return confirm('Apakah Anda yakin data sudah benar? Proses ini tidak dapat dibatalkan.');">
                    <i class="fas fa-check-circle mr-2"></i> Finalisasi Pendaftaran
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
