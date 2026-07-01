@php
    $dashRole = 'admin';
    $dashFirstName = 'Admin';
    $dashLastName = '';
    $dashFullName = session('admin_name', 'System Admin');
    $dashInitials = 'A';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Admin Dashboard')) — NyumbaHub</title>
    {{-- PWA Meta Tags --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2E7D32">
    <link rel="apple-touch-icon" href="{{ asset('images/nyumbahublogo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-premium.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <a href="{{ url('/') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/nyumbahublogo.png') }}" alt="{{ __('NyumbaHub') }}">
            </div>
            <div>
                <div class="sidebar-brand-name">{{ __('Nyumba') }}<span>{{ __('Hub') }}</span></div>
                <span class="sidebar-brand-tag">{{ ucfirst($dashRole) }} Portal</span>
            </div>
        </a>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <span class="sidebar-section-label">{{ __('Overview') }}</span>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
            </a>

            <span class="sidebar-section-label">{{ __('Manage') }}</span>
            <a href="{{ route('admin.users') }}"
                class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> {{ __('Users') }}
            </a>
            <a href="{{ route('admin.listings') }}"
                class="sidebar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> {{ __('Listings') }}
            </a>
            <a href="{{ route('admin.appointments') }}"
                class="sidebar-link {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar"></i> {{ __('Appointments') }}
            </a>

            <span class="sidebar-section-label">{{ __('Subscriptions & Billing') }}</span>
            <a href="{{ route('admin.subscriptions.plans') }}"
                class="sidebar-link {{ request()->routeIs('admin.subscriptions.plans') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> {{ __('Pricing Plans') }}
            </a>
            <a href="{{ route('admin.subscriptions.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.subscriptions.index') ? 'active' : '' }}">
                <i class="fa-solid fa-id-badge"></i> {{ __('Active Subscriptions') }}
            </a>
            <a href="{{ route('admin.subscriptions.payments') }}"
                class="sidebar-link {{ request()->routeIs('admin.subscriptions.payments') ? 'active' : '' }}">
                <i class="fa-solid fa-money-check-dollar"></i> {{ __('All Payments') }}
            </a>

            <span class="sidebar-section-label">{{ __('Other') }}</span>
            <a href="{{ route('admin.agent-applications') }}"
                class="sidebar-link {{ request()->routeIs('admin.agent-applications') ? 'active' : '' }}" style="position:relative;">
                <i class="fa-solid fa-id-card-clip"></i> {{ __('Agent Applications') }}
                @php $pendingApps = \Illuminate\Support\Facades\Schema::hasTable('agent_applications') ? \App\Models\AgentApplication::where('status','pending')->count() : 0; @endphp
                @if($pendingApps > 0)
                    <span style="margin-left:auto;padding:2px 7px;background:#DC2626;color:white;border-radius:9999px;font-size:10px;font-weight:700;">{{ $pendingApps }}</span>
                @endif
            </a>
            <a href="{{ route('admin.reports') }}"
                class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar"></i> {{ __('Reports') }}
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('listings.index') }}" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('Public Site') }}
            </a>

        </nav>

        {{-- ── Bottom: User info + Logout ── --}}
        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar" style="overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    {{ strtoupper(substr($dashFirstName, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        {{ $dashFirstName }} {{ $dashLastName }}
                    </div>
                    <div class="sidebar-user-role">{{ $dashRole }}</div>
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

    {{-- ── MAIN CONTENT ── --}}
    <div class="dashboard-main">

        {{-- Top bar --}}
        <header class="dashboard-topbar">
            <div class="dashboard-container" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:100%;">
                <div>
                    <div class="topbar-title" style="font-size:20px; font-weight:800; color:var(--dash-text);">@yield('page-title', __('Dashboard'))</div>
                </div>
                <div class="topbar-right">
                    {{-- Language Toggle --}}
                    @if(app()->getLocale() === 'sw')
                        <a href="{{ route('lang.switch', 'en') }}" class="btn-icon" title="{{ __('Switch to English') }}" style="background:var(--gray-100);color:var(--gray-700);text-decoration:none;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center;">{{ __('EN') }}</a>
                    @else
                        <a href="{{ route('lang.switch', 'sw') }}" class="btn-icon" title="{{ __('Badili kwenda Kiswahili') }}" style="background:var(--gray-100);color:var(--gray-700);text-decoration:none;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center;">{{ __('SW') }}</a>
                    @endif

                    {{-- Mobile sidebar toggle --}}
                    <button class="btn-icon" onclick="toggleSidebar()"
                        style="background:var(--gray-100);color:var(--gray-600);display:none;" id="sidebarToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    @yield('topbar-actions')
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="dashboard-container" style="padding:0 40px; margin-top:20px; width:100%;">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
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
        <strong style="font-size:14px;">{{ __('Session expiring soon') }}</strong>
    </div>
    <p style="font-size:13px;color:rgba(255,255,255,0.7);margin-bottom:12px;">
        {{ __('Logging out in') }} <span id="countdown" style="color:var(--accent);font-weight:700;">30</span> {{ __('seconds.') }}
    </p>
    <button onclick="resetSession()"
        style="background:var(--accent);color:var(--primary-dark);border:none;padding:8px 18px;border-radius:var(--radius-full);font-weight:700;font-size:13px;cursor:pointer;width:100%;font-family:inherit;">
        <i class="fa-solid fa-rotate-right"></i> {{ __('Stay Logged In') }}
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
            window.location.href = '{{ route("admin.login") }}';
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
    warningTimeout = setTimeout(showWarning, 3600000); 
}

['mousemove','keydown','click','scroll','touchstart'].forEach(e => {
    document.addEventListener(e, resetTimer, { passive: true });
});
resetTimer();
</script>

@stack('scripts')
@include('components.pwa-install')
<script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>
