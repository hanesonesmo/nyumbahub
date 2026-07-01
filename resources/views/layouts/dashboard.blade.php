@php
    $dashRole = 'guest';
    $dashFirstName = 'User';
    $dashLastName = '';
    $dashFullName = 'User';
    $dashInitials = 'U';

    if (auth()->check()) {
        $user = auth()->user();
        $dashRole = $user->role;
        $dashFirstName = $user->first_name;
        $dashLastName = $user->last_name;
        $dashFullName = $user->first_name . ' ' . $user->last_name;
        $dashInitials = strtoupper(substr($user->first_name, 0, 1));
    } elseif (session('admin_logged_in')) {
        $dashRole = 'admin';
        $dashFirstName = 'Admin';
        $dashLastName = '';
        $dashFullName = session('admin_name', 'System Admin');
        $dashInitials = 'A';
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Dashboard')) — NyumbaHub</title>
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

            @if($dashRole === 'agent')
                <span class="sidebar-section-label">{{ __('Main') }}</span>
                <a href="{{ route('agent.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('agent.payments.index') }}"
                    class="sidebar-link {{ request()->routeIs('agent.payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> {{ __('Payment History') }}
                </a>
                <a href="{{ route('listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-building"></i> {{ __('Browse Listings') }}
                </a>

                <span class="sidebar-section-label">{{ __('My Listings') }}</span>
                <a href="{{ route('agent.listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('agent.listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i> {{ __('All Listings') }}
                </a>
                <a href="{{ route('agent.listings.create') }}"
                    class="sidebar-link {{ request()->routeIs('agent.listings.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-plus-circle"></i> {{ __('Add New Listing') }}
                </a>

                <span class="sidebar-section-label">{{ __('Bookings') }}</span>
                <a href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> {{ __('Appointments') }}
                </a>

                <span class="sidebar-section-label">{{ __('Profile') }}</span>
                <a href="{{ route('agent.profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-pen"></i> {{ __('Manage Profile') }}
                </a>

            @elseif(in_array($dashRole, ['user', 'tenant', 'buyer']))
                @php
                    $agentApp = \Illuminate\Support\Facades\Schema::hasTable('agent_applications')
                        ? (auth()->check() ? auth()->user()->agentApplication : null)
                        : null;
                @endphp
                <span class="sidebar-section-label">{{ __('Main') }}</span>
                <a href="{{ route('user.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('listings.index') }}"
                    class="sidebar-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass"></i> {{ __('Browse Listings') }}
                </a>

                <span class="sidebar-section-label">{{ __('My Activity') }}</span>
                <a href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar"></i> {{ __('My Bookings') }}
                </a>

                <span class="sidebar-section-label">{{ __('Career') }}</span>
                <a href="{{ route('become.agent') }}"
                    class="sidebar-link {{ request()->routeIs('become.agent') ? 'active' : '' }}"
                    style="position:relative;">
                    <i class="fa-solid fa-briefcase"></i> {{ __('Become an Agent') }}
                    @if($agentApp && $agentApp->status === 'pending')
                        <span style="margin-left:auto;padding:2px 7px;background:#F59E0B;color:white;border-radius:9999px;font-size:10px;font-weight:700;">{{ __('Pending') }}</span>
                    @elseif($agentApp && $agentApp->status === 'approved')
                        <span style="margin-left:auto;padding:2px 7px;background:#059669;color:white;border-radius:9999px;font-size:10px;font-weight:700;">✓</span>
                    @endif
                </a>

            @elseif($dashRole === 'admin')
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
            @endif

            <div class="sidebar-divider"></div>

            @if($dashRole !== 'agent')
                <a href="{{ route('profile') }}"
                    class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-pen"></i> {{ __('My Profile') }}
                </a>
            @endif

            <a href="{{ route('listings.index') }}" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('Public Site') }}
            </a>

        </nav>

        {{-- ── Bottom: User info + Logout ── --}}
        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar" style="overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    @php
                        $hasProfilePhoto = false;
                        $profilePhotoUrl = '';
                        if($dashRole === 'agent' && \Illuminate\Support\Facades\Schema::hasTable('agent_profiles')) {
                            $agentProfile = (auth()->check() ? auth()->user()->agentProfile : null);
                            if($agentProfile && $agentProfile->profile_photo) {
                                $hasProfilePhoto = true;
                                $profilePhotoUrl = asset('storage/' . $agentProfile->profile_photo);
                            }
                        }
                    @endphp

                    @if($hasProfilePhoto)
                        <img src="{{ $profilePhotoUrl }}" alt="{{ __('Avatar') }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ strtoupper(substr($dashFirstName, 0, 1)) }}
                    @endif
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        {{ $dashFirstName }} {{ $dashLastName }}
                    </div>
                    <div class="sidebar-user-role">{{ $dashRole }}</div>
                </div>
            </div>

            
            <button type="button" onclick="document.getElementById('deleteAccountModal').style.display='flex'" class="sidebar-logout-btn" style="color:#ef4444; border:1px solid #ef4444; background:transparent; width:100%; margin-bottom:12px;">
                <i class="fa-solid fa-trash"></i> {{ __('Delete Account') }}
            </button>

            <form method="POST" action="{{ route('logout') }}">

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
    // Increased JS timeout to 1 hour (3600000 ms) so users don't get redirected
    // to login while using the OS file picker.
    warningTimeout = setTimeout(showWarning, 3600000); 
}

['mousemove','keydown','click','scroll','touchstart'].forEach(e => {
    document.addEventListener(e, resetTimer, { passive: true });
});
resetTimer();
@endauth
</script>

@stack('scripts')
    {{-- Delete Account Modal --}}
    <div id="deleteAccountModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; padding:24px; max-width:400px; width:90%; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
            <h3 style="margin-top:0; color:#ef4444; font-weight:700;"><i class="fa-solid fa-triangle-exclamation"></i> {{ __('Delete Account') }}</h3>
            <p style="color:#64748b; font-size:14px; margin-bottom:20px; line-height:1.5; white-space: normal;">
                {{ __('This action is irreversible. All your profile data, properties, and bookings will be permanently removed (except legally required financial records).') }}
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500; font-size:14px; color:#334155; white-space: normal;">{{ __('Confirm Password') }}</label>
                    <div style="position: relative;">
                        <input type="password" id="delete_account_password_dash" name="password" required placeholder="{{ __('Enter password to confirm') }}" style="width:100%; padding:10px; padding-right:40px; border:1px solid #cbd5e1; border-radius:6px; outline:none; box-sizing:border-box;">
                        <button type="button" onclick="togglePasswordModal('delete_account_password_dash', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 0;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <button type="button" onclick="document.getElementById('deleteAccountModal').style.display='none'" style="padding:8px 16px; background:#f1f5f9; color:#475569; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" style="padding:8px 16px; background:#ef4444; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                        {{ __('Delete') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
function togglePasswordModal(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
    @include('components.pwa-install')
    <script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>
