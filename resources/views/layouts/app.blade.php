<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NyumbaHub')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="nav-container">

        {{-- Logo + Tagline --}}
        <div style="display:flex;align-items:center;gap:16px;">
            <a href="{{ url('/') }}" class="nav-brand" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <div style="width:44px;height:44px;border-radius:50%;background:#D4A853;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                    <img src="{{ asset('images/logo.png') }}" alt="NyumbaHub" style="width:60px;height:60px;object-fit:cover;">
                </div>
                <span style="font-family:Georgia,serif;font-size:22px;font-weight:700;color:#fff;letter-spacing:-0.5px;">Nyumba<span style="color:#D4A853;">Hub</span></span>
            </a>
        </div>

        {{-- Desktop nav links --}}
        <div class="nav-links">
            <a href="{{ route('listings.index') }}" class="nav-link">
                <i class="fa-solid fa-building"></i> Listings
            </a>

            @auth
                {{-- Role based navigation --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-shield-halved"></i> Admin Panel
                    </a>

                @elseif(auth()->user()->role === 'agent')
                    <a href="{{ route('agent.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                    <a href="{{ route('agent.listings.create') }}" class="nav-link">
                        <i class="fa-solid fa-plus"></i> Add Listing
                    </a>

                @elseif(auth()->user()->role === 'tenant')
                    <a href="{{ route('tenant.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>

                @elseif(auth()->user()->role === 'buyer')
                    <a href="{{ route('buyer.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                @endif

                {{-- User dropdown --}}
                <div class="nav-dropdown">
                    <button class="nav-dropdown-btn">
                        <i class="fa-solid fa-circle-user"></i>
                        {{ auth()->user()->first_name }}
                        <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('appointments.index') }}" class="dropdown-item">
                            <i class="fa-solid fa-calendar"></i> My Bookings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="btn-nav">Register</a>
            @endauth
        </div>

        {{-- Mobile menu toggle --}}
        <button class="nav-toggle" onclick="toggleMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>

    </div>

    {{-- Mobile menu --}}
    <div class="nav-mobile" id="mobileMenu">
        <a href="{{ route('listings.index') }}" class="nav-mobile-link">
            <i class="fa-solid fa-building"></i> Listings
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-shield-halved"></i> Admin Panel
                </a>
            @elseif(auth()->user()->role === 'agent')
                <a href="{{ route('agent.dashboard') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="{{ route('agent.listings.create') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-plus"></i> Add Listing
                </a>
            @elseif(auth()->user()->role === 'tenant')
                <a href="{{ route('tenant.dashboard') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            @elseif(auth()->user()->role === 'buyer')
                <a href="{{ route('buyer.dashboard') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            @endif
            <a href="{{ route('appointments.index') }}" class="nav-mobile-link">
                <i class="fa-solid fa-calendar"></i> My Bookings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-mobile-link nav-mobile-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-mobile-link">Login</a>
            <a href="{{ route('register') }}" class="nav-mobile-link">Register</a>
        @endauth
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main class="main-content">

    {{-- Flash messages --}}
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

    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;border-radius:50%;background:#D4A853;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                    <img src="{{ asset('images/logo.png') }}" alt="NyumbaHub" style="width:52px;height:52px;object-fit:cover;">
                </div>
                <span style="font-family:Georgia,serif;font-size:18px;font-weight:700;color:#fff;">Nyumba<span style="color:#D4A853;">Hub</span></span>
            </div>
            <p style="margin-top:6px;font-size:12px;color:rgba(255,255,255,0.45);font-style:italic;">Your Next Home, Found.</p>
        </div>

        <div class="footer-links">
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="#">Privacy Policy</a>
        </div>

        <p class="footer-copy">&copy; {{ date('Y') }} NyumbaHub. Arusha, Tanzania.</p>
    </div>
</footer>

<script>
    // Dropdown toggle
    document.querySelectorAll('.nav-dropdown-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            btn.nextElementSibling.classList.toggle('show');
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', e => {
        if (!e.target.closest('.nav-dropdown')) {
            document.querySelectorAll('.nav-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });

    // Mobile menu
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('show');
    }
</script>

@stack('scripts')
</body>
</html>
