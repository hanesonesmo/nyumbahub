<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NyumbaHub — Your Next Home, Found.')</title>

    {{-- PWA Meta Tags --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2E7D32">
    <link rel="apple-touch-icon" href="{{ asset('images/nyumbahublogo.png') }}">

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
    <link rel="stylesheet" href="{{ asset('css/navbar-premium.css') }}?v={{ time() }}">
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
@include('components.navbar')

{{-- MAIN CONTENT --}}
<main class="main-content">

    @if(session('success'))
        <div class="container-wide" style="padding-top: 32px;">
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-wide" style="padding-top: 32px;">
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @yield('content')
</main>
{{-- FOOTER --}}
@include('components.footer')

{{-- Session timeout warning --}}
<div id="session-warning" style="display:none;position:fixed;bottom:24px;right:24px;background:var(--primary-dark,#0F2D1F);color:#fff;padding:20px 24px;border-radius:16px;box-shadow:0 8px 28px rgba(0,0,0,0.2);z-index:9999;max-width:300px;border:1px solid rgba(255,255,255,0.1);">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <i class="fa-solid fa-clock" style="color:var(--accent,#D4A853);font-size:18px;"></i>
        <strong style="font-size:14px;">{{ __('Session expiring soon') }}</strong>
    </div>
    <p style="font-size:13px;color:rgba(255,255,255,0.7);margin-bottom:14px;">
        {{ __('Logging out in') }} <span id="countdown" style="color:var(--accent,#D4A853);font-weight:700;">30</span> {{ __('seconds.') }}
    </p>
    <button onclick="resetSession()" style="background:var(--accent,#D4A853);color:#0F2D1F;border:none;padding:10px 20px;border-radius:9999px;font-weight:700;font-size:13px;cursor:pointer;width:100%;font-family:inherit;">
        <i class="fa-solid fa-rotate-right"></i> {{ __('Stay Logged In') }}
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
                        <input type="password" id="delete_account_password_app" name="password" required placeholder="{{ __('Enter password to confirm') }}" style="width:100%; padding:10px; padding-right:40px; border:1px solid #cbd5e1; border-radius:6px; outline:none; box-sizing:border-box;">
                        <button type="button" onclick="togglePasswordModalApp('delete_account_password_app', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 0;">
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
function togglePasswordModalApp(inputId, btn) {
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
