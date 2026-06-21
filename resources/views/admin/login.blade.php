<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
   <style>
* { margin:0;padding:0;box-sizing:border-box; }

/* Background slider */
.bg-slider { position:fixed;inset:0;z-index:0;overflow:hidden; }
.bg-slider-slide { position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.5s ease-in-out; }
.bg-slider-slide.active { opacity:0.35; }
.bg-slider-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.88),rgba(255,255,255,0.82));z-index:1; }

.admin-login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    position: relative;
    z-index: 10;
    padding: 20px;
}

.admin-login-card {
    background: rgba(255,255,255,0.97);
    border-radius: 20px;
    padding: 48px 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    border-top: 4px solid #1B4332;
    position: relative;
    z-index: 10;
    backdrop-filter: blur(10px);
}

.admin-login-icon {
    width: 56px;
    height: 56px;
    background-color: #1B4332;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #D4A853;
    margin-bottom: 20px;
}
</style>
</head>

<body>
{{-- Background slider --}}
<div class="bg-slider" id="bgSlider">
    <div class="bg-slider-slide active" style="background-image:url('{{ asset('images/themes/bg1.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg2.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg3.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg4.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg5.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/light.jpg') }}')"></div>
    <div class="bg-slider-overlay"></div>
</div>


<div class="bg-slideshow">
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
</div>
    <button class="theme-picker-btn" id="themePickerBtn" aria-label="Choose theme">
        <i class="fa-solid fa-sun"></i>
    </button>
    <div class="theme-picker-dropdown" id="themePickerDropdown"></div>

<div class="admin-login-wrap">
    <div class="admin-login-card">

        <div class="admin-login-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h1 class="form-title">Admin Login</h1>
        <p class="form-subtitle">NyumbaHub Control Panel</p>

        @if ($errors->any())
            <div class="alert-error" style="margin-bottom:20px;">
                <ul style="padding-left:16px;margin:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="field">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@nyumbahub.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    placeholder="Enter admin password"
                    required>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary" style="margin-top:8px;">
                <i class="fa-solid fa-right-to-bracket"></i> Sign in as Admin
            </button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:13px;color:var(--text-muted);">
            <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;text-decoration:none;">
                ← Back to user login
            </a>
        </p>

    </div>
</div>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>
<script>
(function() {
    const slides = document.querySelectorAll('.bg-slider-slide');
    if (!slides.length) return;
    let current = 0;
    setInterval(() => {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }, 5000);
})();
</script>
</body>
</html>
