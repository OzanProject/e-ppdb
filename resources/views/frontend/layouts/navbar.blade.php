<nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                    @if(isset($school->logo) && $school->logo)
                        <img class="h-12 w-12 rounded-full object-cover mr-3" src="{{ asset('storage/' . $school->logo) }}" alt="Logo">
                    @else
                        <div class="h-12 w-12 rounded-full bg-primary-custom flex items-center justify-center text-white font-bold text-xl mr-3">
                            {{ substr($school->name ?? 'S', 0, 1) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-bold text-xl text-gray-900 leading-tight">{{ $school->name ?? 'PPDB Online' }}</span>
                        <span class="text-xs text-gray-500 font-medium tracking-wide">Penerimaan Peserta Didik Baru</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-primary-custom font-medium transition">Beranda</a>
                <a href="#jalur" class="text-gray-600 hover:text-primary-custom font-medium transition">Jalur</a>
                <a href="#jadwal" class="text-gray-600 hover:text-primary-custom font-medium transition">Jadwal</a>
                <a href="#berita" class="text-gray-600 hover:text-primary-custom font-medium transition">Berita</a>
                <a href="#faq" class="text-gray-600 hover:text-primary-custom font-medium transition">FAQ</a>
            </div>

            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                @if(isset(Auth::user()->avatar) && Storage::disk('public')->exists(Auth::user()->avatar))
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-primary-custom flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="hidden md:inline-block ml-2 text-sm font-medium text-gray-700 my-auto">{{ Auth::user()->name }} <i class="fas fa-chevron-down text-xs ml-1"></i></span>
                            </button>
                        </div>
                        
                        <div x-show="open" 
                             x-cloak
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                            
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Login sebagai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-tachometer-alt mr-2 text-gray-400"></i> Dashboard
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-custom font-medium px-3 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary-custom px-5 py-2 rounded-full font-semibold shadow-md transition transform hover:scale-105">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-custom hover:bg-gray-50">Beranda</a>
            <a href="#jalur" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-custom hover:bg-gray-50">Jalur</a>
            <a href="#jadwal" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-custom hover:bg-gray-50">Jadwal</a>
            <a href="#berita" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-custom hover:bg-gray-50">Berita</a>
            <a href="#faq" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-custom hover:bg-gray-50">FAQ</a>
            @guest
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col space-y-2 px-3">
                    <a href="{{ route('login') }}" class="w-full text-center text-primary-custom font-bold border border-current px-4 py-2 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center bg-primary-custom text-white font-bold px-4 py-2 rounded-lg">Daftar Akun</a>
                </div>
            @else
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-5 mb-3">
                        <div class="flex-shrink-0">
                            @if(isset(Auth::user()->avatar) && Storage::disk('public')->exists(Auth::user()->avatar))
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                            @else
                                <div class="h-10 w-10 rounded-full bg-primary-custom flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-1 px-2">
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-tachometer-alt mr-2 text-gray-400"></i> Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-900 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>
