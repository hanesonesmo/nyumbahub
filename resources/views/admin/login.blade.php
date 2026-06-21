<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <style>
        .admin-login-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            transition: background 0.3s;
        }
        .admin-login-card {
            background: var(--surface);
            border-radius: var(--radius-xl);
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow-xl);
            border-top: 4px solid var(--accent);
            transition: background 0.3s;
        }
        .admin-login-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            margin-bottom: 20px;
        }

    </style>
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

</body>
</html>
