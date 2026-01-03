@extends('frontend.student.registration.layout', ['step' => 2])

@section('form-content')
<form action="{{ route('student.registration.storeStep2') }}" method="POST">
    @csrf
    
    <div class="space-y-8">
        <!-- Student Address -->
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 mb-4">Alamat Siswa</h3>
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-1">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap (Sesuai KK)</label>
                    <div class="mt-1">
                        <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten">{{ old('address', $studentProfile->address ?? '') }}</textarea>
                    </div>
                    @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Father Info -->
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 mb-4">Data Ayah Kandung</h3>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <label for="father_name" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                    <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $parentInfo->father_name ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('father_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div class="sm:col-span-1">
                    <label for="father_job" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                    <input type="text" name="father_job" id="father_job" value="{{ old('father_job', $parentInfo->father_job ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('father_job') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-1">
                    <label for="father_phone" class="block text-sm font-medium text-gray-700">No. HP Ayah</label>
                    <input type="text" name="father_phone" id="father_phone" value="{{ old('father_phone', $parentInfo->father_phone ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('father_phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Mother Info -->
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 mb-4">Data Ibu Kandung</h3>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <label for="mother_name" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                    <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $parentInfo->mother_name ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('mother_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div class="sm:col-span-1">
                    <label for="mother_job" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                    <input type="text" name="mother_job" id="mother_job" value="{{ old('mother_job', $parentInfo->mother_job ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('mother_job') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-1">
                    <label for="mother_phone" class="block text-sm font-medium text-gray-700">No. HP Ibu</label>
                    <input type="text" name="mother_phone" id="mother_phone" value="{{ old('mother_phone', $parentInfo->mother_phone ?? '') }}" class="mt-1 shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                    @error('mother_phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Parent Address -->
         <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 mb-4">Alamat Orang Tua</h3>
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-1">
                <div>
                     <label for="address_parent" class="block text-sm font-medium text-gray-700">Alamat Orang Tua (Jika berbeda dengan siswa)</label>
                    <div class="mt-1">
                        <textarea id="address_parent" name="address_parent" rows="3" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Kosongkan jika sama dengan alamat siswa">{{ old('address_parent', $parentInfo->address_parent ?? '') }}</textarea>
                    </div>
                     <p class="mt-2 text-sm text-gray-500">Biarkan kosong jika alamat orang tua sama dengan alamat siswa.</p>
                </div>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-200">
            <div class="flex justify-between">
                <a href="{{ route('student.registration.step1') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                     <i class="fas fa-arrow-left mr-2 mt-1"></i> Kembali
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-custom hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                    Simpan & Lanjut ke Tahap 3 <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
