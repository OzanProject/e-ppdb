<div id="jalur" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-custom font-semibold tracking-wide uppercase text-sm">Pilihan Pendaftaran</span>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Jalur Penerimaan Siswa Baru
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Kami menyediakan berbagai jalur masuk yang dapat disesuaikan dengan prestasi dan domisili Anda.
            </p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            @forelse($tracks as $track)
            <div class="flex flex-col rounded-2xl shadow-lg overflow-hidden bg-white transition hover:shadow-2xl hover:-translate-y-2 border border-gray-100 group">
                <div class="h-2 bg-gradient-to-r from-blue-500 to-primary-custom w-full"></div>
                <div class="flex-1 p-8 flex flex-col relative">
                    <div class="absolute top-0 right-0 mt-4 mr-4 bg-blue-100 text-primary-custom text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        Sisa Kuota: {{ $track->quota }}
                    </div>
                    
                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-primary-custom mb-6 group-hover:bg-primary-custom group-hover:text-white transition-colors">
                        <i class="fas fa-road fa-lg"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $track->name }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-grow">
                        {{ Str::limit($track->description ?? 'Jalur ini dibuka untuk calon siswa yang memenuhi kriteria khusus.', 120) }}
                    </p>
                    
                    <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-gray-50 hover:bg-primary-custom hover:text-white text-center rounded-lg text-primary-custom font-semibold transition-all border border-gray-200 hover:border-transparent">
                        Daftar Jalur Ini <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow-sm border border-dashed border-gray-300">
                <i class="fas fa-info-circle text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-500">Belum ada jalur pendaftaran yang dibuka saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
