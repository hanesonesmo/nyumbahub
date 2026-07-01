<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login — NyumbaHub') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>

<body>

    <!-- Left decorative panel -->
    <div class="panel-left">
        <div class="panel-slideshow">
            <div class="panel-slide"></div>
            <div class="panel-slide"></div>
            <div class="panel-slide"></div>
        </div>
        <div class="brand" style="margin-bottom: 20px;">
            <div style="font-family: var(--font-display); font-size: 32px; font-weight: 800; color: white;">
                Nyumba<span style="color: var(--accent);">Hub</span>
            </div>
            <div class="brand-tagline">{{ __('Your Next Home. Found') }}</div>
        </div>

        <div class="panel-content">
            <h2 class="panel-heading">{{ __('Find your') }} <em>{{ __('perfect') }}</em> {{ __('home in Arusha') }}</h2>
            <p class="panel-desc">{{ __('Browse hundreds of verified listings for rent and sale. Connect with trusted agents across Arusha.') }}</p>
        </div>

        <div class="panel-stats">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">{{ __('Listings') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">120+</div>
                <div class="stat-label">{{ __('Agents') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ __('3K+') }}</div>
                <div class="stat-label">{{ __('Users') }}</div>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="panel-right">
        <div class="form-card">

            <h1 class="form-title">{{ __('Welcome back') }}</h1>
            <p class="form-subtitle">
                {{ __('Don\'t have an account?') }} <a href="{{ route('register') }}">{{ __('Sign up free') }}</a>
            </p>

            {{-- Session auth message --}}
            @if (session('auth_message'))
                <div style="background: rgba(27,67,50,0.08); border: 1px solid var(--primary); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; color: var(--primary); font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 16px;"></i>
                    {{ session('auth_message') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session error --}}
            @if (session('error'))
                <div class="alert-error" style="margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Session success --}}
            @if (session('success'))
                <div class="alert-success" style="margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('auth.google') }}" class="btn-google" style="margin-bottom: 24px;">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo">
                {{ __('Continue with Google') }}
            </a>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">{{ __('or Continue with Email') }}</span>
                <div class="divider-line"></div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">{{ __('Email address') }}</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="{{ __('you@example.com') }}"
                        autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">{{ __('Password') }}</label>
                    <div style="position: relative;">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="{{ __('Enter your password') }}"
                            autocomplete="current-password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            style="padding-right: 40px; width: 100%; box-sizing: border-box;"
                            required
                        >
                        <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-meta">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember me') }}
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">{{ __('Forgot password?') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">{{ __('Sign in here') }}</button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">{{ __('or') }}</span>
                <div class="divider-line"></div>
            </div>

            <p class="register-prompt">
                {{ __('New to NyumbaHub?') }} <a href="{{ route('register') }}">{{ __('Create an account') }}</a>
            </p>

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/') }}" style="color: var(--text-muted, #717171); text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('Continue Browsing') }}
                </a>
            </div>

        </div>
    </div>

</body>
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
<script src="{{ asset('js/pwa.js') }}"></script>
</html>
