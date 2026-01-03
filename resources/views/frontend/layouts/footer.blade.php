<footer class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-primary-custom relative overflow-hidden">
    <!-- Decorative Background Pattern -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
        <svg width="100%" height="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="footer-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#footer-pattern)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- School Info -->
            <div class="col-span-1 lg:col-span-2">
                <div class="flex items-center mb-6">
                    @if(isset($school->logo) && $school->logo)
                        <img class="h-12 w-12 rounded-full object-cover mr-4 bg-white p-1 shadow-lg" src="{{ asset('storage/' . $school->logo) }}" alt="Logo">
                    @endif
                    <div>
                        <span class="block font-bold text-2xl tracking-tight">{{ $school->name ?? 'PPDB Online' }}</span>
                        <span class="text-sm text-gray-400">Penerimaan Peserta Didik Baru</span>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-6 leading-relaxed max-w-md">
                    {{ $school->description ?? 'Isi dari admin' }}
                </p>
                <div class="text-gray-400 text-sm space-y-3">
                    <div class="flex items-start">
                        <i class="fa fa-map-marker-alt mt-1 mr-3 w-5 text-center text-primary-custom"></i>
                        <span>{{ $school->alamat ?? 'Alamat Sekolah' }} @if($school->district), {{ $school->district }}@endif</span>
                    </div>
                    @if($school->phone)
                    <div class="flex items-center">
                        <i class="fa fa-phone mr-3 w-5 text-center text-primary-custom"></i>
                        <span>{{ $school->phone }}</span>
                    </div>
                    @endif
                    @if($school->email)
                    <div class="flex items-center">
                        <i class="fa fa-envelope mr-3 w-5 text-center text-primary-custom"></i>
                        <span>{{ $school->email }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-bold text-lg mb-6 text-white border-b border-gray-700 pb-2 inline-block">Menu Utama</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="{{ url('/') }}" class="hover:text-primary-custom transition flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i> Beranda</a></li>
                    <li><a href="#jalur" class="hover:text-primary-custom transition flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i> Informasi Jalur</a></li>
                    <li><a href="#jadwal" class="hover:text-primary-custom transition flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i> Jadwal Penting</a></li>
                    <li><a href="#faq" class="hover:text-primary-custom transition flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i> Bantuan / FAQ</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-primary-custom transition flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i> Login Siswa</a></li>
                </ul>
            </div>

            <!-- Social / Branding -->
            <div>
                <h3 class="font-bold text-lg mb-6 text-white border-b border-gray-700 pb-2 inline-block">Terhubung</h3>
                <div class="flex flex-wrap gap-3 mb-8">
                    @if(isset($school->social_media) && is_array($school->social_media))
                        @foreach($school->social_media as $social)
                            @php
                                $icon = match($social['platform']) {
                                    'facebook' => 'fab fa-facebook-f',
                                    'instagram' => 'fab fa-instagram',
                                    'youtube' => 'fab fa-youtube',
                                    'tiktok' => 'fab fa-tiktok',
                                    'twitter' => 'fab fa-twitter',
                                    'linkedin' => 'fab fa-linkedin',
                                    default => 'fas fa-link'
                                };
                            @endphp
                            <a href="{{ $social['url'] }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-custom hover:text-white transition transform hover:-translate-y-1">
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endforeach
                    @else
                       <p class="text-sm text-gray-500 italic">Ikuti kami di media sosial.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ $school->name ?? 'Sekolah' }}. All rights reserved.</p>
            <p class="mt-2 md:mt-0 flex items-center">
                Powered by 
                <a href="https://ozanproject.site/" target="_blank" class="ml-1 font-bold text-white hover:text-primary-custom transition flex items-center">
                    <i class="fas fa-rocket mr-1"></i> Ozan Project
                </a>
            </p>
        </div>
    </div>
</footer>
