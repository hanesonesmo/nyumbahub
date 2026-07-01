<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Verify Your Email — NyumbaHub') }}</title>

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


<div class="panel-right" style="min-height:100vh; width: 100%;">
    <div class="form-card" style="max-width:540px; text-align: center; background: var(--surface); padding: 48px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); margin: auto; z-index: 2; position: relative;">
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-light));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fa-solid fa-envelope-open-text" style="font-size:28px;color:#fff;"></i>
            </div>
            <h1 class="form-title">{{ __('Verify Your Email Address') }}</h1>
            <p class="form-subtitle" style="margin-bottom:24px;">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('success'))
            <div class="alert-success" style="margin-bottom:24px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        
        @if (session('status') == 'verification-link-sent')
            <div class="alert-success" style="margin-bottom:24px;">
                <i class="fa-solid fa-circle-check"></i> {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 16px; align-items: center;">
            <form method="POST" action="{{ route('verification.send') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" style="background: none; border: none; color: var(--text-muted); cursor: pointer; text-decoration: underline; font-weight: 500;">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>

    </div>
</div>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>

</body>
</html>
