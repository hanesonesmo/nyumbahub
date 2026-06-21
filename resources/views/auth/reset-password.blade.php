<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — NyumbaHub</title>
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

        {{-- Icon --}}
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-light));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fa-solid fa-key" style="font-size:28px;color:#fff;"></i>
            </div>
            <h1 class="form-title">Reset Password</h1>
            <p class="form-subtitle" style="margin-bottom:0;">
                Enter your new password below.
            </p>
        </div>

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

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $email) }}"
                    placeholder="you@example.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password"
                    placeholder="Min. 8 characters"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    required>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Repeat new password"
                    required>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                <i class="fa-solid fa-lock"></i> Reset Password
            </button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-muted);">
            <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;text-decoration:none;">
                ← Back to login
            </a>
        </p>

    </div>
</div>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>

</body>
</html>
