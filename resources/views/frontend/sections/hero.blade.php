<div class="relative bg-white overflow-hidden">
    <!-- Decorative Background Shapes -->
    <div class="hidden lg:block absolute top-0 right-0 -mr-20 -mt-20">
        <svg width="404" height="404" fill="none" viewBox="0 0 404 404" aria-hidden="true">
             <defs>
                <pattern id="de316486-4a29-4312-bdfc-fbce2132a2c1" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-100" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="404" fill="url(#de316486-4a29-4312-bdfc-fbce2132a2c1)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 bg-opacity-90 backdrop-filter backdrop-blur-lg">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left animate-fade-in-up">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-primary-custom text-sm font-semibold tracking-wide uppercase mb-4">
                        Penerimaan Peserta Didik Baru
                    </span>
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl mb-6">
                        <span class="block xl:inline">Wujudkan Masa Depan</span>
                        <span class="block text-gradient xl:inline">Bersama {{ $school->name ?? 'Sekolah Unggulan' }}</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 delay-100 animate-fade-in-up">
                        Tahun Ajaran {{ $school->tahun_ajaran ?? date('Y') }}. 
                        Kami berkomitmen mencetak generasi yang cerdas, berkarakter mulia, dan siap bersaing di era global. Bergabunglah sekarang!
                    </p>
                    <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start delay-200 animate-fade-in-up">
                        <div class="rounded-md shadow">
                            <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-lg text-white bg-primary-custom md:py-4 md:text-lg md:px-10 hover:shadow-lg transition-all transform hover:-translate-y-1">
                                <i class="fas fa-rocket mr-2"></i> Daftar Sekarang
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#jalur" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-lg text-primary-custom bg-indigo-50 hover:bg-indigo-100 md:py-4 md:text-lg md:px-10 transition-all">
                                <i class="fas fa-info-circle mr-2"></i> Info Jalur
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Hero Image -->
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-100">
         @if($school->hero_image)
             <div class="h-56 w-full sm:h-72 md:h-96 lg:w-full lg:h-full relative overflow-hidden">
                <img class="absolute inset-0 w-full h-full object-cover filter brightness-90 transform transition hover:scale-105 duration-1000" src="{{ asset('storage/' . $school->hero_image) }}" alt="School Environment">
                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent lg:via-white/20"></div>
             </div>
         @elseif($school->logo)
             <div class="h-56 w-full sm:h-72 md:h-96 lg:w-full lg:h-full relative overflow-hidden flex items-center justify-center bg-gray-50">
                 <!-- Use logo as fallback pattern or centered if no hero image -->
                 <img class="w-1/2 h-1/2 object-contain opacity-50" src="{{ asset('storage/' . $school->logo) }}" alt="School Logo">
                 <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
             </div>
         @else
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Students">
         @endif
    </div>
</div>
