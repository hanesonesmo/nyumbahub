<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>
<body>
<div class="bg-slideshow">
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
</div>
    <button class="theme-picker-btn" id="themePickerBtn" aria-label="Choose theme">
        <i class="fa-solid fa-sun"></i>
    </button>
    <div class="theme-picker-dropdown" id="themePickerDropdown"></div>

<div class="panel-right" style="min-height:100vh;">
    <div class="form-card" style="max-width:420px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-light));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fa-solid fa-lock" style="font-size:28px;color:#fff;"></i>
            </div>
            <h1 class="form-title">Forgot Password?</h1>
            <p class="form-subtitle" style="margin-bottom:0;">
                Enter your email and we'll send you a reset link.
            </p>
        </div>

        {{-- Success message --}}
        @if(session('success'))
            <div class="alert-success" style="margin-bottom:24px;">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert-error" style="margin-bottom:24px;">
                <ul style="padding-left:16px;margin:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="field">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                <i class="fa-solid fa-paper-plane"></i> Send Reset Link
            </button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-muted);">
            Remember your password?
            <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;text-decoration:none;">Back to login</a>
        </p>

    </div>
</div>

<style>
.alert-success { background:rgba(0,138,5,0.08);border:1px solid rgba(0,138,5,0.15);border-radius:var(--radius);padding:14px 18px;font-size:14px;color:var(--success);display:flex;align-items:center;gap:10px; }
</style>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>

</body>
</html>
