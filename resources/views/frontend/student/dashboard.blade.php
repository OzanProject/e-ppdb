@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Banner -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-90 transition group-hover:opacity-100"></div>
            <!-- Decorative Patterns -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 rounded-full bg-blue-300 opacity-20 blur-xl"></div>
            
            <div class="relative p-8 md:p-10 flex flex-col md:flex-row items-center justify-between z-10">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="relative mr-6">
                        @if(isset($user->avatar) && Storage::disk('public')->exists($user->avatar))
                            <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                        @else
                            <div class="h-20 w-20 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold text-3xl border-4 border-blue-100 shadow-md">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-0 w-5 h-5 bg-green-400 border-2 border-white rounded-full" title="Online"></div>
                    </div>
                    <div class="text-white text-center md:text-left">
                        <h1 class="text-3xl font-bold mb-1">Halo, {{ $user->name }}! 👋</h1>
                        <p class="text-blue-100 text-lg">Selamat datang di Dashboard Calon Siswa.</p>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-white border border-white/20 text-center min-w-[200px]">
                    <p class="text-xs uppercase tracking-wider font-semibold opacity-80 mb-1">Status Pendaftaran</p>
                    @if($registration)
                        @php
                            $isAnnounced = $registration->track->is_announced ?? false;
                        @endphp

                        @if($registration->status == 'new')
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-yellow-400 text-yellow-900 shadow-sm animate-pulse">
                                <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi
                            </span>
                        @elseif($registration->status == 'verified')
                             <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-blue-500 text-white shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> Terverifikasi
                            </span>
                        @elseif($registration->status == 'accepted')
                            @if($isAnnounced)
                                 <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-green-500 text-white shadow-sm">
                                    <i class="fas fa-trophy mr-2"></i> DITERIMA
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-blue-500 text-white shadow-sm">
                                    <i class="fas fa-hourglass-half mr-2"></i> Menunggu Pengumuman
                                </span>
                            @endif
                        @elseif($registration->status == 'rejected')
                            @if($isAnnounced)
                                 <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-red-500 text-white shadow-sm">
                                    <i class="fas fa-times-circle mr-2"></i> TIDAK LOLOS
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-blue-500 text-white shadow-sm">
                                    <i class="fas fa-hourglass-half mr-2"></i> Menunggu Pengumuman
                                </span>
                            @endif
                        @endif
                    @else
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-gray-200 text-gray-700 shadow-sm">
                           <i class="fas fa-user-edit mr-2"></i> Belum Mendaftar
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Registration Progress & Details -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform transition hover:shadow-xl">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-tasks text-blue-500 mr-3"></i> Progres & Data
                        </h3>
                        @if($registration)
                            <span class="text-sm text-gray-500 font-medium">Progress: {{ $progress }}%</span>
                        @endif
                    </div>
                    
                    <div class="p-8">
                        @if(!$registration)
                            <div class="text-center py-10">
                                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 mb-6 animate-bounce">
                                    <i class="fas fa-clipboard-list text-blue-600 text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Pendaftaran Belum Dimulai</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">
                                    Silakan lengkapi formulir pendaftaran untuk mendapatkan Nomor Registrasi dan mengikuti seleksi PPDB tahun ini.
                                </p>
                                <a href="{{ route('student.registration.step1') }}" class="inline-flex items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1">
                                    <i class="fas fa-rocket mr-2"></i> Mulai Pendaftaran Sekarang
                                </a>
                            </div>
                        @else
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-100 rounded-full h-3 mb-8 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                            </div>
                            
                            <!-- Detail Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-50 hover:border-blue-200 transition">
                                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wide mb-1">Nomor Peserta</p>
                                    <p class="text-xl font-bold text-gray-900 tracking-tight">{{ $registration->registration_code }}</p>
                                </div>
                                <div class="bg-purple-50/50 rounded-xl p-5 border border-purple-50 hover:border-purple-200 transition">
                                    <p class="text-xs font-bold text-purple-500 uppercase tracking-wide mb-1">Jalur Pilihan</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $registration->track->name ?? '-' }}</p>
                                </div>
                                <div class="bg-green-50/50 rounded-xl p-5 border border-green-50 hover:border-green-200 transition md:col-span-2">
                                    <p class="text-xs font-bold text-green-500 uppercase tracking-wide mb-1">Tanggal Mendaftar</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $registration->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                                <a href="{{ route('student.registration.print') }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-gray-200 shadow-sm text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:text-blue-600 transition">
                                    <i class="fas fa-print mr-2"></i> Bukti Daftar
                                </a>
                                @if($registration->status == 'verified' || $registration->status == 'accepted' || $registration->status == 'rejected')
                                <a href="{{ route('student.registration.print_card') }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-5 py-3 shadow-md text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition">
                                    <i class="fas fa-id-card mr-2"></i> Kartu Peserta
                                </a>
                                @endif
                                
                                @if($registration->status == 'accepted' && ($registration->track->is_announced ?? false))
                                <a href="{{ route('student.registration.print_acceptance') }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-5 py-3 shadow-md text-sm font-semibold rounded-xl text-white bg-green-600 hover:bg-green-700 transition">
                                    <i class="fas fa-certificate mr-2"></i> Bukti Lulus
                                </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Announcements -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-bullhorn text-orange-500 mr-3"></i> Pengumuman Terbaru
                    </h3>
                    <div class="space-y-6">
                        @forelse($announcements as $announcement)
                        <div class="relative pl-6 border-l-4 border-gray-200 hover:border-blue-500 transition-colors group">
                            <span class="text-xs font-semibold text-gray-400 block mb-1 group-hover:text-blue-500 transition">
                                <i class="far fa-calendar-alt mr-1"></i> 
                                {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->diffForHumans() : $announcement->created_at->diffForHumans() }}
                            </span>
                            <h4 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition">
                                <a href="{{ route('news.show', $announcement->slug) }}" class="hover:underline">{{ $announcement->title }}</a>
                            </h4>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-2">
                                {{ Str::limit(strip_tags($announcement->content), 120) }}
                            </p>
                            <a href="{{ route('news.show', $announcement->slug) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center mt-2">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                             <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500 text-sm">Belum ada pengumuman terbaru dari sekolah.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Profil Saya</h3>
                        
                        <div class="flex items-center mb-6">
                            @if(isset($user->avatar) && Storage::disk('public')->exists($user->avatar))
                                <img class="h-14 w-14 rounded-full object-cover mr-4 border-2 border-white shadow bg-gray-100" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                            @else
                                <div class="h-14 w-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl mr-4 border-2 border-white shadow">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <p class="text-base font-bold text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>

                        @if($studentProfile)
                        <div class="space-y-3 mb-6 bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">NISN</span>
                                <span class="font-semibold text-gray-800">{{ $studentProfile->nisn ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Asal Sekolah</span>
                                <span class="font-semibold text-gray-800 text-right truncate pl-2 max-w-[150px]">{{ $studentProfile->school_origin ?? '-' }}</span>
                            </div>
                        </div>
                        @endif

                        <a href="{{ route('student.profile') }}" class="block w-full text-center py-2.5 px-4 rounded-xl border border-blue-200 text-blue-600 font-semibold text-sm hover:bg-blue-50 transition">
                            Edit Profil Akun
                        </a>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                    <i class="fab fa-whatsapp absolute -bottom-4 -right-4 text-8xl text-white opacity-20"></i>
                    <h3 class="text-lg font-bold mb-2">Butuh Bantuan?</h3>
                    <p class="text-green-50 text-sm mb-6 leading-relaxed opacity-90">
                        Jika ada kendala saat mendaftar, jangan ragu hubungi panitia via WhatsApp.
                    </p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? '') }}" target="_blank" class="block w-full text-center py-3 bg-white text-green-600 font-bold rounded-xl shadow-md hover:bg-green-50 transition relative z-10">
                        <i class="fab fa-whatsapp mr-2"></i> Chat Panitia
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
