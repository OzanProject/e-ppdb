<div class="relative -mt-24 z-20 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            
            <div class="bg-white rounded-xl shadow-xl p-6 flex items-center transform transition duration-500 hover:scale-105 border-b-4 border-blue-500">
                <div class="flex-shrink-0 p-3 rounded-lg bg-blue-50 text-blue-500">
                    <i class="fas fa-graduation-cap fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 uppercase">Jenjang</p>
                    <p class="text-xl font-bold text-gray-900">{{ strtoupper($school->jenjang ?? 'Sekolah') }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-xl p-6 flex items-center transform transition duration-500 hover:scale-105 border-b-4 border-green-500">
                <div class="flex-shrink-0 p-3 rounded-lg bg-green-50 text-green-500">
                    <i class="fas fa-certificate fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 uppercase">Akreditasi</p>
                    <p class="text-xl font-bold text-gray-900">{{ $school->accreditation ?? '-' }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-xl p-6 flex items-center transform transition duration-500 hover:scale-105 border-b-4 border-purple-500">
                <div class="flex-shrink-0 p-3 rounded-lg bg-purple-50 text-purple-500">
                    <i class="fas fa-calendar-alt fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 uppercase">Tahun Ajaran</p>
                    <p class="text-xl font-bold text-gray-900">{{ $school->tahun_ajaran ?? date('Y') }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-xl p-6 flex items-center transform transition duration-500 hover:scale-105 border-b-4 border-orange-500">
                <div class="flex-shrink-0 p-3 rounded-lg bg-orange-50 text-orange-500">
                    <i class="fas fa-laptop-code fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 uppercase">Sistem</p>
                    <p class="text-xl font-bold text-gray-900">Online 24 Jam</p>
                </div>
            </div>

        </div>
    </div>
</div>
