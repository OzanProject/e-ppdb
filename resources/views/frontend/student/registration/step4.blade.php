@extends('frontend.student.registration.layout', ['step' => 4])

@section('form-content')
<div class="space-y-6">
    <div class="border-b border-gray-200 pb-4">
        <h2 class="text-lg font-medium text-gray-900">Upload Dokumen Persyaratan</h2>
        <p class="mt-1 text-sm text-gray-500">
            Silakan unggah dokumen yang diperlukan. Format yang diperbolehkan: JPG, PNG, PDF. Maksimal 2MB per file.
            <br>Dokumen bertanda bintang (*) wajib diisi (namun sistem saat ini mengizinkan upload menyusul jika belum lengkap, harap lengkapi sebelum verifikasi).
        </p>
    </div>

    <form action="{{ route('student.registration.storeStep4') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Kartu Keluarga --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
            <div class="mt-1 flex items-center space-x-4">
                <input type="file" name="kk" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            @if(isset($documents['kk']))
                <p class="mt-1 text-xs text-green-600">
                    <i class="fas fa-check-circle me-1"></i> File tersimpan. Upload ulang untuk mengganti.
                    <a href="{{ asset('storage/' . $documents['kk']->file_path) }}" target="_blank" class="underline ms-1">Lihat File</a>
                </p>
            @endif
            @error('kk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Akta Kelahiran --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Akta Kelahiran <span class="text-red-500">*</span></label>
             <div class="mt-1 flex items-center space-x-4">
                <input type="file" name="akta" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100" accept=".jpg,.jpeg,.png,.pdf">
            </div>
             @if(isset($documents['akta']))
                <p class="mt-1 text-xs text-green-600">
                    <i class="fas fa-check-circle me-1"></i> File tersimpan. Upload ulang untuk mengganti.
                     <a href="{{ asset('storage/' . $documents['akta']->file_path) }}" target="_blank" class="underline ms-1">Lihat File</a>
                </p>
            @endif
             @error('akta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Ijazah / SKL --}}
        <div>
             <label class="block text-sm font-medium text-gray-700">Ijazah / Surat Keterangan Lulus (SKL)</label>
             <div class="mt-1 flex items-center space-x-4">
                <input type="file" name="ijazah" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            @if(isset($documents['ijazah']))
                <p class="mt-1 text-xs text-green-600">
                    <i class="fas fa-check-circle me-1"></i> File tersimpan. Upload ulang untuk mengganti.
                     <a href="{{ asset('storage/' . $documents['ijazah']->file_path) }}" target="_blank" class="underline ms-1">Lihat File</a>
                </p>
            @endif
             @error('ijazah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

         {{-- Pas Foto --}}
        <div>
             <label class="block text-sm font-medium text-gray-700">Pas Foto (3x4)</label>
             <div class="mt-1 flex items-center space-x-4">
                 <input type="file" name="foto" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100" accept="image/*">
            </div>
             @if(isset($documents['foto']))
                <p class="mt-1 text-xs text-green-600">
                    <i class="fas fa-check-circle me-1"></i> File tersimpan. Upload ulang untuk mengganti.
                     <a href="{{ asset('storage/' . $documents['foto']->file_path) }}" target="_blank" class="underline ms-1">Lihat File</a>
                </p>
            @endif
             @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>


        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('student.registration.step3') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Kembali
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-custom hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Selanjutnya &rarr;
            </button>
        </div>
    </form>
</div>
@endsection
