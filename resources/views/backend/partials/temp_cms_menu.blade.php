            <!-- CMS Menu -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.faqs.*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-newspaper me-2"></i>Manajemen Konten</a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.faqs.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.posts.index') }}" class="dropdown-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">Berita / Artikel</a>
                    <a href="{{ route('admin.faqs.index') }}" class="dropdown-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">FAQ</a>
                </div>
            </div>

            <div class="nav-item dropdown">
