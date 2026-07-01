<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-logo">
            <img src="{{ asset('images/nyumbahublogo.png') }}" alt="{{ __('NyumbaHub') }}">
        </div>
        <div>
            <div class="sidebar-brand-name">{{ __('Nyumba') }}<span>{{ __('Hub') }}</span></div>
            <span class="sidebar-brand-tag">{{ __('Admin Panel') }}</span>
        </div>
    </a>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <span class="sidebar-section-label">{{ __('Overview') }}</span>
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
        </a>

        <span class="sidebar-section-label">{{ __('Manage') }}</span>
        <a href="{{ route('admin.users') }}"
            class="sidebar-link {{ ($active ?? '') === 'users' ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> {{ __('Users') }}
        </a>
        <a href="{{ route('admin.listings') }}"
            class="sidebar-link {{ ($active ?? '') === 'listings' ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i> {{ __('Listings') }}
        </a>
        <a href="{{ route('admin.appointments') }}"
            class="sidebar-link {{ ($active ?? '') === 'appointments' ? 'active' : '' }}">
            <i class="fa-solid fa-calendar"></i> {{ __('Appointments') }}
        </a>

        <a href="{{ route('admin.reports') }}"
    class="sidebar-link {{ ($active ?? '') === 'reports' ? 'active' : '' }}">
    <i class="fa-solid fa-chart-bar"></i> {{ __('Reports') }}
</a>

        <a href="{{ route('admin.audit-logs') }}"
            class="sidebar-link {{ ($active ?? '') === 'audit-logs' ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i> {{ __('Audit Logs') }}
        </a>

        <div class="sidebar-divider"></div>

        <a href="{{ url('/') }}" class="sidebar-link">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('Public Site') }}
        </a>
    </nav>

    {{-- Bottom: User + Logout --}}
    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ __('A') }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ __('NyumbaHub Admin') }}</div>
                <div class="sidebar-user-role">{{ __('Administrator') }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                {{ __('Sign Out') }}
            </button>
        </form>
    </div>

</aside>
