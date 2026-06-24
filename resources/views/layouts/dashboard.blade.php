<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — NyumbaHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <a href="{{ url('/') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="NyumbaHub">
            </div>
            <div>
                <div class="sidebar-brand-name">Nyumba<span>Hub</span></div>
                <span class="sidebar-brand-tag">{{ ucfirst(auth()->user()->role) }} Portal</span>
            </div>
        </a>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            @if(auth()->user()->role === 'agent')
                <span class="sidebar-section-label">Main</span>
                <a href="{{ route('agent.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="{{ route('listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-building"></i> Browse Listings
                </a>

                <span class="sidebar-section-label">My Listings</span>
                <a href="{{ route('agent.listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('agent.listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i> All Listings
                </a>
                <a href="{{ route('agent.listings.create') }}"
                    class="sidebar-link {{ request()->routeIs('agent.listings.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-plus-circle"></i> Add New Listing
                </a>

                <span class="sidebar-section-label">Bookings</span>
                <a href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Appointments
                </a>

            @elseif(auth()->user()->role === 'tenant')
                <span class="sidebar-section-label">Main</span>
                <a href="{{ route('tenant.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="{{ route('listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass"></i> Browse Listings
                </a>

                <span class="sidebar-section-label">My Activity</span>
                <a href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar"></i> My Bookings
                </a>

            @elseif(auth()->user()->role === 'buyer')
                <span class="sidebar-section-label">Main</span>
                <a href="{{ route('buyer.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="{{ route('listings.index', ['type' => 'sale']) }}"
                    class="sidebar-link">
                    <i class="fa-solid fa-tag"></i> Properties for Sale
                </a>

                <span class="sidebar-section-label">My Activity</span>
                <a href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar"></i> My Viewings
                </a>

            @elseif(auth()->user()->role === 'admin')
                <span class="sidebar-section-label">Overview</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>

                <span class="sidebar-section-label">Manage</span>
                <a href="{{ route('admin.users') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Users
                </a>
                <a href="{{ route('admin.listings') }}"
                    class="sidebar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}">
                    <i class="fa-solid fa-building"></i> Listings
                </a>
                <a href="{{ route('admin.appointments') }}"
                    class="sidebar-link {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar"></i> Appointments
                </a>
            @endif

            <div class="sidebar-divider"></div>

            <a href="{{ route('profile') }}"
                class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user-pen"></i> My Profile
            </a>

            <a href="{{ route('listings.index') }}" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Public Site
            </a>

        </nav>

        {{-- ── Bottom: User info + Logout ── --}}
        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </div>
                    <div class="sidebar-user-role">{{ auth()->user()->role }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sign Out
                </button>
            </form>
        </div>

    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <div class="dashboard-main">

        {{-- Top bar --}}
        <header class="dashboard-topbar">
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-subtitle">@yield('page-subtitle', '')</div>
            </div>
            <div class="topbar-right">
                {{-- Mobile sidebar toggle --}}
                <button class="btn-icon" onclick="toggleSidebar()"
                    style="background:var(--gray-100);color:var(--gray-600);display:none;" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                @yield('topbar-actions')
            </div>
        </header>

        {{-- Flash messages --}}
        <div style="padding:0 28px;">
            @if(session('success'))
                <div class="alert alert-success" style="margin-top:20px;">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" style="margin-top:20px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <div class="dashboard-content">
            @yield('content')
        </div>

    </div>

</div>

{{-- Session timeout warning --}}
<div id="session-warning" style="display:none;">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <i class="fa-solid fa-clock" style="color:var(--accent);font-size:16px;"></i>
        <strong style="font-size:14px;">Session expiring soon</strong>
    </div>
    <p style="font-size:13px;color:rgba(255,255,255,0.7);margin-bottom:12px;">
        Logging out in <span id="countdown" style="color:var(--accent);font-weight:700;">30</span> seconds.
    </p>
    <button onclick="resetSession()"
        style="background:var(--accent);color:var(--primary-dark);border:none;padding:8px 18px;border-radius:var(--radius-full);font-weight:700;font-size:13px;cursor:pointer;width:100%;font-family:inherit;">
        <i class="fa-solid fa-rotate-right"></i> Stay Logged In
    </button>
</div>

<script>
// Sidebar toggle for mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

// Show toggle on mobile
if (window.innerWidth <= 768) {
    document.getElementById('sidebarToggle').style.display = 'flex';
}
window.addEventListener('resize', () => {
    const toggle = document.getElementById('sidebarToggle');
    if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
});

// Session timeout
@auth
let warningTimeout, countdownInterval, countdown = 30;

function showWarning() {
    countdown = 30;
    document.getElementById('session-warning').style.display = 'block';
    countdownInterval = setInterval(() => {
        countdown--;
        const el = document.getElementById('countdown');
        if (el) el.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            window.location.href = '{{ route("login") }}';
        }
    }, 1000);
}

function hideWarning() {
    document.getElementById('session-warning').style.display = 'none';
    clearInterval(countdownInterval);
}

function resetSession() {
    hideWarning();
    resetTimer();
    fetch('{{ url("/ping") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
}

function resetTimer() {
    clearTimeout(warningTimeout);
    warningTimeout = setTimeout(showWarning, 30000);
}

['mousemove','keydown','click','scroll','touchstart'].forEach(e => {
    document.addEventListener(e, resetTimer, { passive: true });
});
resetTimer();
@endauth
</script>

@stack('scripts')
</body>
</html>
