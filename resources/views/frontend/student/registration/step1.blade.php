@extends('frontend.student.registration.layout', ['step' => 1])

@section('form-content')
<form action="{{ route('student.registration.storeStep1') }}" method="POST">
    @csrf
    
    <div class="space-y-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2">Data Pribadi Siswa</h3>
        
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
            <!-- NISN -->
            <div class="sm:col-span-1">
                <label for="nisn" class="block text-sm font-medium text-gray-700">NISN (Nomor Induk Siswa Nasional)</label>
                <div class="mt-1">
                    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $studentProfile->nisn ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 0012345678">
                </div>
                @error('nisn') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Gender -->
            <div class="sm:col-span-1">
                <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <div class="mt-1">
                    <select id="gender" name="gender" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender', $studentProfile->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender', $studentProfile->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                @error('gender') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Place of Birth -->
            <div class="sm:col-span-1">
                <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <div class="mt-1">
                    <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $studentProfile->place_of_birth ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                @error('place_of_birth') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Date of Birth -->
            <div class="sm:col-span-1">
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <div class="mt-1">
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $studentProfile->date_of_birth ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                @error('date_of_birth') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div class="sm:col-span-1">
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon / WhatsApp</label>
                <div class="mt-1">
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $studentProfile->phone ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 08123456789">
                </div>
                @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-5 border-t border-gray-200">
            <div class="flex justify-end">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-custom hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                    Simpan & Lanjut ke Tahap 2 <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
