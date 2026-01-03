@extends('frontend.student.registration.layout', ['step' => 3])

@section('form-content')
<form action="{{ route('student.registration.storeStep3') }}" method="POST">
    @csrf
    
    <div class="space-y-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2">Data Sekolah Asal</h3>
        
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
            
            <!-- School Name -->
            <div class="sm:col-span-2">
                <label for="school_origin" class="block text-sm font-medium text-gray-700">Nama Sekolah Asal (SMP/MTs)</label>
                <div class="mt-1">
                    <input type="text" name="school_origin" id="school_origin" value="{{ old('school_origin', $studentProfile->school_origin ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: SMP Negeri 1 Konoha">
                </div>
                @error('school_origin') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- NPSN -->
            <div class="sm:col-span-1">
                <label for="npsn_origin" class="block text-sm font-medium text-gray-700">NPSN Sekolah Asal</label>
                <div class="mt-1">
                    <input type="text" name="npsn_origin" id="npsn_origin" value="{{ old('npsn_origin', $studentProfile->npsn_origin ?? '') }}" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md" placeholder="8 Digit Angka">
                </div>
                <p class="mt-1 text-xs text-gray-500">Cek NPSN di: <a href="https://referensi.data.kemdikbud.go.id/" target="_blank" class="text-blue-600 hover:underline">Data Kemdikbud</a></p>
                @error('npsn_origin') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Graduation Year -->
            <div class="sm:col-span-1">
                <label for="graduation_year" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                <div class="mt-1">
                    <select id="graduation_year" name="graduation_year" class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Pilih Tahun</option>
                        @for($i = date('Y'); $i >= date('Y')-3; $i--)
                            <option value="{{ $i }}" {{ old('graduation_year', $studentProfile->graduation_year ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                @error('graduation_year') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Grades Section -->
        <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-2 pt-6">Nilai Rapor (Rata-rata Semester 1-5)</h3>
        <p class="text-sm text-gray-500 mb-4">Masukkan nilai rata-rata (skala 0-100) untuk mata pelajaran utama.</p>
        
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
            @foreach(['indonesia' => 'Bahasa Indonesia', 'inggris' => 'Bahasa Inggris', 'matematika' => 'Matematika', 'ipa' => 'Ilmu Pengetahuan Alam (IPA)'] as $key => $label)
            <div class="sm:col-span-1">
                <label for="grade_{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                <div class="mt-1">
                    <input type="number" step="0.01" min="0" max="100" name="grades[{{ $key }}]" id="grade_{{ $key }}" 
                        value="{{ old('grades.'.$key, $grades[$key] ?? '') }}" 
                        class="shadow-sm focus:ring-primary-custom focus:border-primary-custom block w-full sm:text-sm border-gray-300 rounded-md" 
                        placeholder="00.00">
                </div>
                 @error('grades.'.$key) <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            @endforeach
        </div>

        <div class="pt-5 border-t border-gray-200">
             <div class="flex justify-between">
                <a href="{{ route('student.registration.step2') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                     <i class="fas fa-arrow-left mr-2 mt-1"></i> Kembali
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-custom hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-custom">
                    Simpan & Lanjut ke Tahap Akhir <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
