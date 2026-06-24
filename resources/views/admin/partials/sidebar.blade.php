<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="NyumbaHub">
        </div>
        <div>
            <div class="sidebar-brand-name">Nyumba<span>Hub</span></div>
            <span class="sidebar-brand-tag">Admin Panel</span>
        </div>
    </a>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <span class="sidebar-section-label">Overview</span>
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>

        <span class="sidebar-section-label">Manage</span>
        <a href="{{ route('admin.users') }}"
            class="sidebar-link {{ ($active ?? '') === 'users' ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Users
        </a>
        <a href="{{ route('admin.listings') }}"
            class="sidebar-link {{ ($active ?? '') === 'listings' ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i> Listings
        </a>
        <a href="{{ route('admin.appointments') }}"
            class="sidebar-link {{ ($active ?? '') === 'appointments' ? 'active' : '' }}">
            <i class="fa-solid fa-calendar"></i> Appointments
        </a>

        <div class="sidebar-divider"></div>

        <a href="{{ url('/') }}" class="sidebar-link">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Public Site
        </a>
    </nav>

    {{-- Bottom: User + Logout --}}
    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">A</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">NyumbaHub Admin</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sign Out
            </button>
        </form>
    </div>

</aside>
