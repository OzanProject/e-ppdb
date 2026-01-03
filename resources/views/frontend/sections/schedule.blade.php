<div id="jadwal" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-12">
            <h2 class="text-base text-primary-custom font-semibold tracking-wide uppercase">Agenda</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Jadwal Kegiatan PPDB
            </p>
        </div>

        <div class="relative max-w-4xl mx-auto">
            <div class="border-l-4 border-primary-custom ml-3 space-y-8">
                @forelse($schedules as $schedule)
                <div class="relative flex items-center">
                    <div class="absolute -left-3 bg-white h-6 w-6 rounded-full border-4 border-primary-custom"></div>
                    <div class="ml-6 w-full bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                        <h3 class="text-lg font-bold text-gray-900">{{ $schedule->activity }}</h3>
                        <p class="text-sm text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $schedule->start_date->format('d M Y') }} 
                            @if($schedule->end_date)
                                s/d {{ $schedule->end_date->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                 <div class="ml-6 text-gray-500">Jadwal belum dirilis.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
