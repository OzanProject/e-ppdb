<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3 d-flex align-items-center">
            @if(isset($school->logo) && $school->logo)
                <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" style="width: 45px; height: 45px; object-fit: contain;" class="rounded-circle me-2 bg-white p-1">
                <div class="d-flex flex-column">
                    <h3 class="text-primary mb-0 fs-5">{{ $school->name }}</h3>
                </div>
            @else
                <h3 class="text-primary mb-0"><i class="fa fa-user-edit me-2"></i>{{ $school->name ?? 'PPDB' }}</h3>
            @endif
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if(Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar))
                    <img class="rounded-circle" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">{{ Auth::user()->name }}</h6>
                <span class="text-muted text-xs">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
        
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.schools.*') || request()->routeIs('admin.users.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-database me-2"></i>Data Master
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.schools.*') || request()->routeIs('admin.users.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.schools.index') }}" class="dropdown-item {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">Sekolah</a>
                    <a href="{{ route('admin.users.index') }}" class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Pengguna</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-cogs me-2"></i>Konfigurasi
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.ppdb.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.ppdb.settings') }}" class="dropdown-item {{ request()->routeIs('admin.ppdb.settings') ? 'active' : '' }}">Jalur & Jadwal</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.registrations.*') || request()->routeIs('admin.selection.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.documents.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-user-graduate me-2"></i>Pendaftar
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.registrations.*') || request()->routeIs('admin.selection.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.documents.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.registrations.index') }}" class="dropdown-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">Data Siswa</a>
                    <!-- Proposed: Document Management separate or here -->
                    <a href="{{ route('admin.selection.index') }}" class="dropdown-item {{ request()->routeIs('admin.selection.*') ? 'active' : '' }}">Seleksi & Ranking</a>
                    <a href="{{ route('admin.announcements.index') }}" class="dropdown-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">Pengumuman</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-print me-2"></i>Laporan
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.reports.index') }}" class="dropdown-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">Export & Cetak</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.faqs.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-newspaper me-2"></i>Konten (CMS)
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.faqs.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.posts.index') }}" class="dropdown-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">Berita / Artikel</a>
                    <a href="{{ route('admin.faqs.index') }}" class="dropdown-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">FAQ</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-shield-alt me-2"></i>System
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.logs.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.logs.index') }}" class="dropdown-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">Security Logs</a>
                </div>
            </div>
        </div>
    </nav>
</div>
