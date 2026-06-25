<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NyumbaHub — Your Next Home, Found.')</title>

    {{-- Apply saved theme before CSS loads to prevent flash --}}
    <script>
        (function() {
            const dark = {
                '--bg':'#111111','--bg-soft':'#1A1A1A','--surface':'#1E1E1E',
                '--text':'#F5F5F5','--text-light':'#CCCCCC','--text-muted':'#888888',
                '--border':'#333333','--border-light':'#2A2A2A',
                '--primary':'#D4A853','--primary-light':'#E8C47A','--primary-dark':'#B8922E',
                '--accent':'#1B4332'
            };
            if (localStorage.getItem('nyumbahub-theme') === 'dark') {
                Object.entries(dark).forEach(([k,v]) => document.documentElement.style.setProperty(k,v));
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>

{{-- BACKGROUND IMAGE SLIDER --}}
<div class="bg-slider" id="bgSlider">
    <div class="bg-slider-slide active" style="background-image:url('{{ asset('images/themes/bg1.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg2.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg3.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg4.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg5.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg6.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg7.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg8.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/light.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/dark.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/green.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/gold.jpg') }}')"></div>
    <div class="bg-slider-overlay"></div>
</div>

{{-- NAVBAR --}}
<nav class="navbar" id="mainNav">
    <div class="nav-container">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="nav-brand">
            <div class="nav-brand-logo">
                <img src="{{ asset('images/nyumbahublogo.png') }}" alt="NyumbaHub">
            </div>
            <span class="nav-brand-name">Nyumba<span>Hub</span></span>
        </a>

        {{-- Search bar --}}
        <div class="nav-search" onclick="window.location='{{ route('listings.index') }}'">
            <div class="nav-search-text">
                <strong>Anywhere in Arusha</strong>
                Browse all properties
            </div>
            <button class="nav-search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        {{-- Desktop nav --}}
        <div class="nav-links">

            <a href="{{ route('listings.index') }}" class="nav-link">
                <i class="fa-solid fa-building"></i> Listings
            </a>

            @auth
                @if(auth()->user()->role === 'agent')
                    <a href="{{ route('agent.listings.create') }}" class="nav-link">
                        <i class="fa-solid fa-plus"></i> Add Listing
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-shield-halved"></i> Admin
                    </a>
                @endif
            @endauth

            {{-- Theme toggle --}}
            <button onclick="toggleTheme()" id="themeToggle" title="Toggle theme" class="theme-toggle-btn">
                <i class="fa-solid fa-sun" id="themeIcon"></i>
            </button>

            @auth
                {{-- User dropdown --}}
                <div class="nav-dropdown">
                    <button class="nav-dropdown-btn">
                        <i class="fa-solid fa-bars" style="font-size:13px;opacity:0.6;"></i>
                        <div class="nav-user-avatar">
                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                        </div>
                    </button>
                    <div class="nav-dropdown-menu">
                        <div class="dropdown-header">
                            <strong style="font-size:14px;">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
                            <div style="margin-top:2px;font-size:12px;">{{ auth()->user()->email }}</div>
                        </div>

                        @if(auth()->user()->role === 'agent')
                            <a href="{{ route('agent.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge"></i> Dashboard
                            </a>
                            <a href="{{ route('agent.listings.index') }}" class="dropdown-item">
                                <i class="fa-solid fa-building"></i> My Listings
                            </a>
                        @elseif(auth()->user()->role === 'tenant')
                            <a href="{{ route('tenant.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge"></i> Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'buyer')
                            <a href="{{ route('buyer.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge"></i> Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-shield-halved"></i> Admin Panel
                            </a>
                        @endif

                        <a href="{{ route('appointments.index') }}" class="dropdown-item">
                            <i class="fa-solid fa-calendar"></i> My Bookings
                        </a>

                        <a href="{{ route('themes') }}" class="dropdown-item">
                            <i class="fa-solid fa-palette"></i> Change Theme
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

        {{-- Mobile toggle --}}
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
            @if(auth()->user()->role === 'agent')
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
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-mobile-link">
                    <i class="fa-solid fa-shield-halved"></i> Admin Panel
                </a>
            @endif
            <a href="{{ route('appointments.index') }}" class="nav-mobile-link">
                <i class="fa-solid fa-calendar"></i> My Bookings
            </a>
            <a href="{{ route('themes') }}" class="nav-mobile-link">
                <i class="fa-solid fa-palette"></i> Change Theme
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
        <div class="footer-grid">
            <div>
                <div class="footer-brand-name">Nyumba<span>Hub</span></div>
                <p class="footer-brand-desc">Arusha's most trusted real estate platform. Find your perfect home for rent or sale across all neighbourhoods.</p>
               <div class="footer-social">
    <a href="#" aria-label="Facebook"
        style="background:#1877F2;border-color:#1877F2;color:white;">
        <i class="fa-brands fa-facebook-f"></i>
    </a>
    <a href="#" aria-label="Instagram"
        style="background:linear-gradient(45deg,#F58529,#DD2A7B,#8134AF,#515BD4);border-color:transparent;color:white;">
        <i class="fa-brands fa-instagram"></i>
    </a>
    <a href="#" aria-label="WhatsApp"
        style="background:#25D366;border-color:#25D366;color:white;">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <a href="#" aria-label="X / Twitter"
        style="background:#000000;border-color:#000;color:white;">
        <i class="fa-brands fa-x-twitter"></i>
    </a>
    <a href="#" aria-label="TikTok"
        style="background:#010101;border-color:#010101;color:white;">
        <i class="fa-brands fa-tiktok"></i>
    </a>
</div>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Explore</div>
                <div class="footer-links">
                    <a href="{{ route('listings.index') }}">All Properties</a>
                    <a href="{{ route('listings.index') }}?type=rent">For Rent</a>
                    <a href="{{ route('listings.index') }}?type=sale">For Sale</a>
                    <a href="{{ route('listings.index') }}?category=apartment">Apartments</a>
                    <a href="{{ route('listings.index') }}?category=house">Houses</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Company</div>
                <div class="footer-links">
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="{{ route('how-it-works') }}">How It Works</a>
                    <a href="{{ route('contact') }}">Contact Us</a>
                    <a href="{{ route('become-agent') }}">Become an Agent</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Support</div>
                <div class="footer-links">
                    <a href="{{ route('help-center') }}">Help Center</a>
                    <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                    <a href="{{ route('terms') }}">Terms of Service</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} NyumbaHub. All rights reserved. Arusha, Tanzania.</p>
            <p class="footer-copy">Made with <i class="fa-solid fa-heart" style="color:var(--accent);"></i> for Arusha</p>
        </div>
    </div>
</footer>

{{-- Session timeout warning --}}
<div id="session-warning" style="display:none;position:fixed;bottom:24px;right:24px;background:var(--primary-dark,#0F2D1F);color:#fff;padding:20px 24px;border-radius:16px;box-shadow:0 8px 28px rgba(0,0,0,0.2);z-index:9999;max-width:300px;border:1px solid rgba(255,255,255,0.1);">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <i class="fa-solid fa-clock" style="color:var(--accent,#D4A853);font-size:18px;"></i>
        <strong style="font-size:14px;">Session expiring soon</strong>
    </div>
    <p style="font-size:13px;color:rgba(255,255,255,0.7);margin-bottom:14px;">
        Logging out in <span id="countdown" style="color:var(--accent,#D4A853);font-weight:700;">30</span> seconds.
    </p>
    <button onclick="resetSession()" style="background:var(--accent,#D4A853);color:#0F2D1F;border:none;padding:10px 20px;border-radius:9999px;font-weight:700;font-size:13px;cursor:pointer;width:100%;font-family:inherit;">
        <i class="fa-solid fa-rotate-right"></i> Stay Logged In
    </button>
</div>

<script>
// ── THEME SYSTEM ──
const root = document.documentElement;

const themes = {
    light: {
        '--bg':'#FFFFFF','--bg-soft':'#F7F7F7','--surface':'#FFFFFF',
        '--text':'#222222','--text-light':'#484848','--text-muted':'#717171',
        '--border':'#DDDDDD','--border-light':'#EBEBEB',
        '--primary':'#1B4332','--primary-light':'#2D6A4F','--primary-dark':'#0F2D1F',
        '--accent':'#D4A853'
    },
    dark: {
        '--bg':'#111111','--bg-soft':'#1A1A1A','--surface':'#1E1E1E',
        '--text':'#F5F5F5','--text-light':'#CCCCCC','--text-muted':'#888888',
        '--border':'#333333','--border-light':'#2A2A2A',
        '--primary':'#D4A853','--primary-light':'#E8C47A','--primary-dark':'#B8922E',
        '--accent':'#1B4332'
    },
    green: {
        '--bg':'#E8F4F0','--bg-soft':'#D5EDE5','--surface':'#FFFFFF',
        '--text':'#0F2D1F','--text-light':'#1B4332','--text-muted':'#2D6A4F',
        '--border':'#C8E6DC','--border-light':'#D5EDE5',
        '--primary':'#1B4332','--primary-light':'#2D6A4F','--primary-dark':'#0F2D1F',
        '--accent':'#D4A853'
    },
    gold: {
        '--bg':'#FBF5E6','--bg-soft':'#F5EDD0','--surface':'#FFFFFF',
        '--text':'#0F2D1F','--text-light':'#3D2B00','--text-muted':'#8B6914',
        '--border':'#F0DCA0','--border-light':'#F5EDD0',
        '--primary':'#D4A853','--primary-light':'#E8C47A','--primary-dark':'#B8922E',
        '--accent':'#1B4332'
    }
};

function applyTheme(name) {
    const t = themes[name];
    if (!t) return;
    Object.entries(t).forEach(([k,v]) => root.style.setProperty(k,v));
    localStorage.setItem('nyumbahub-theme', name);
    updateIcon(name);
}

function toggleTheme() {
    const current = localStorage.getItem('nyumbahub-theme') || 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    applyTheme(next);
}

function updateIcon(theme) {
    const icon = document.getElementById('themeIcon');
    const mobileText = document.getElementById('mobileThemeText');
    if (icon) {
        icon.className = theme === 'dark'
            ? 'fa-solid fa-moon'
            : 'fa-solid fa-sun';
    }
    if (mobileText) {
        mobileText.textContent = theme === 'dark' ? 'Switch to Light' : 'Switch to Dark';
    }
}

// Apply on load
(function() {
    const saved = localStorage.getItem('nyumbahub-theme') || 'light';
    applyTheme(saved);
})();

// ── NAVBAR SCROLL ──
window.addEventListener('scroll', () => {
    document.getElementById('mainNav')?.classList.toggle('scrolled', window.scrollY > 10);
});

// ── DROPDOWN ──
<a href="{{ route('profile') }}" class="dropdown-item">
    <i class="fa-solid fa-user-pen"></i> Edit Profile
</a>

document.querySelectorAll('.nav-dropdown-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        btn.nextElementSibling.classList.toggle('show');
    });
});
document.addEventListener('click', e => {
    if (!e.target.closest('.nav-dropdown')) {
        document.querySelectorAll('.nav-dropdown-menu').forEach(m => m.classList.remove('show'));
    }
});

// ── MOBILE MENU ──
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('show');
}

// ── SESSION TIMEOUT ──
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
<script>
// ── BACKGROUND SLIDER ──
(function() {
    const slides = document.querySelectorAll('.bg-slider-slide');
    if (!slides.length) return;

    // Shuffle slides randomly
    const indices = Array.from({length: slides.length}, (_, i) => i);
    for (let i = indices.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [indices[i], indices[j]] = [indices[j], indices[i]];
    }

    let current = 0;

    // Set first slide based on shuffle
    slides.forEach(s => s.classList.remove('active'));
    slides[indices[0]].classList.add('active');

    setInterval(() => {
        slides[indices[current]].classList.remove('active');
        current = (current + 1) % indices.length;
        slides[indices[current]].classList.add('active');
    }, 5000);
})();
</script>
</body>
</html>
