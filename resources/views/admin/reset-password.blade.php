<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset Admin Password — NyumbaHub') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <style>
        body {
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-wrap {
            width: 100%;
            max-width: 420px;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
        }
        .login-icon {
            width: 56px; height: 56px;
            background: var(--primary);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: var(--accent);
            margin-bottom: 20px;
        }
        .login-title { font-family: var(--font-display); font-size: 26px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
        .login-sub   { font-size: 14px; color: var(--gray-500); margin-bottom: 28px; }
    </style>
</head>
<body>

<div class="login-wrap">

    {{-- Logo --}}
    <div style="text-align:center;margin-bottom:24px;">
        <div style="display:inline-flex;align-items:center;gap:8px;">

            <span style="font-family:var(--font-display);font-size:20px;font-weight:700;color:var(--primary);">
                {{ __('Nyumba') }}<span style="color:var(--accent);">{{ __('Hub') }}</span>
            </span>
        </div>
    </div>

    <div class="login-card">
        <div class="login-icon">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h1 class="login-title">{{ __('Set New Password') }}</h1>
        <p class="login-sub">{{ __('Enter your new password below.') }}</p>

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <label>{{ __('Email address') }}</label>
                <input type="email" name="email"
                    value="{{ old('email', $email ?? '') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required readonly>
            </div>

            <div class="field">
                <label>{{ __('New Password') }}</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password"
                        placeholder="{{ __('Enter new password') }}"
                        style="padding-right: 40px; width: 100%; box-sizing: border-box;"
                        required autofocus>
                    <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="field">
                <label>{{ __('Confirm Password') }}</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="{{ __('Confirm new password') }}"
                        style="padding-right: 40px; width: 100%; box-sizing: border-box;"
                        required>
                    <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:44px;font-size:15px;margin-top:8px;">
                <i class="fa-solid fa-check"></i> {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
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
</body>
</html>
