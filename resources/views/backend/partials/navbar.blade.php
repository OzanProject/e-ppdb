<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <!-- Search Form (Optional/Future) 
    <form class="d-none d-md-flex ms-4">
        <input class="form-control bg-dark border-0" type="search" placeholder="Search">
    </form>
    -->
    <div class="navbar-nav align-items-center ms-auto">
        
        <!-- Future Implementation: Messages & Notifications -->
        
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                @if(Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar))
                    <img class="rounded-circle me-lg-2" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @elseif(Auth::user()->studentProfile && Auth::user()->studentProfile->foto)
                    <img class="rounded-circle me-lg-2" src="{{ asset('storage/' . Auth::user()->studentProfile->foto) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <div class="rounded-circle me-lg-2 d-inline-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">My Profile</a>
                <!-- <a href="#" class="dropdown-item">Settings</a> -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">Log Out</a>
                </form>
            </div>
        </div>
    </div>
</nav>
