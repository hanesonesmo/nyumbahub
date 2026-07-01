<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset Password — NyumbaHub') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>
<body>
<div class="bg-slideshow">
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
</div>


<div class="panel-right" style="min-height:100vh;">
    <div class="form-card" style="max-width:420px;">

        {{-- Icon --}}
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-light));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fa-solid fa-key" style="font-size:28px;color:#fff;"></i>
            </div>
            <h1 class="form-title">{{ __('Reset Password') }}</h1>
            <p class="form-subtitle" style="margin-bottom:0;">
                {{ __('Enter your new password below.') }}
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
                <label for="email">{{ __('Email address') }}</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $email) }}"
                    placeholder="{{ __('you@example.com') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">{{ __('New Password') }}</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password"
                        placeholder="{{ __('Min. 8 characters') }}"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        style="padding-right: 40px; width: 100%; box-sizing: border-box;"
                        required>
                    <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation"
                        name="password_confirmation"
                        placeholder="{{ __('Repeat new password') }}"
                        style="padding-right: 40px; width: 100%; box-sizing: border-box;"
                        required>
                    <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                <i class="fa-solid fa-lock"></i> {{ __('Reset Password') }}
            </button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-muted);">
            <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;text-decoration:none;">
                {{ __('← Back to login') }}
            </a>
        </p>

    </div>
</div>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>
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
