<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register — NyumbaHub') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>

    <body>

        <!-- Left panel -->
<div class="panel-left">
    <div class="panel-slideshow">
        <div class="panel-slide"></div>
        <div class="panel-slide"></div>
        <div class="panel-slide"></div>
    </div>
    <div class="brand">
        <div class="brand-name">{{ __('Nyumba') }} <span>{{ __('Hub') }}</span></div>
        <div class="brand-tagline">{{ __('Your Next Home. Found') }}</div>
    </div>

    <div class="panel-content">
        <h2 class="panel-heading">{{ __('Join') }} <em>{{ __('NyumbaHub') }}</em></h2>
        <p class="panel-desc">{{ __('Whether you\'re searching, renting, buying, or listing, NyumbaHub connects you to the right people.') }}</p>
    </div>

    <ul class="panel-features">
        <li>
            <span class="feature-dot"></span>
            {{ __('Browse verified rental and sale listings across Arusha') }}</li>

            <li>
                <span class="feature-dot"></span>
                {{ __('Book property viewings with trusted Agents') }}</li>

                <li>
                    <span class="feature-dot"></span>
                    {{ __('Pay securely via Mobile Money') }}</li>

                    <li>
                        <span class="feature-dot"></span>
                        {{ __('Manage your listings and appointments in one place') }}</li>

                        <li>
                            <span class=featire-dot></span>
                            {{ __('Manage your listings and appointments in one place') }}</li>
                        </ul>
</div>

<!-- Right panel -->
<div class="panel-right">
    <div class="form-card">
        <h1 class=form-title>{{ __('Create your account') }}</h1>
        <p class="form-subtitle">{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign in here') }}</a></p>

        {{-- Session auth message --}}
        @if (session('auth_message'))
            <div style="background: rgba(27,67,50,0.08); border: 1px solid var(--primary); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; color: var(--primary); font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-info" style="font-size: 16px;"></i>
                {{ session('auth_message') }}
            </div>
        @endif

        {{--VALIDATION ERRORS--}}
        @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all () as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME ROW--}}
            <div class="field-row">
                <div class="field">
                    <label for="first_name">{{ __('First Name') }}</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                    placeholder="{{ __('Joe') }}" autocomplete="given-name"

                    class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}" required>

                    @error('first_name')
                    <div class="field-error">{{ $message}}
                </div>
                @enderror
                </div>

                <div class="field">
                    <label for="last_name">{{ __('Last Name') }}</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                    placeholder="{{ __('Smith') }}" autocomplete="family-name"

                    class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}" required>

                    @error('last_name')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- EMAIL FIELD --}}
            <div class="field">
                <label for="email">{{ __('Email Address') }}</label>
                <input type="email" name="email" value="{{ old('email') }}"
                placeholder="{{ __('joesmith@example.com') }}" autocomplete="email"

                class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>

                @error('email')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{--PHONE FIELD--}}
            <div class="field">
                <label for="phone">{{ __('Phone Number') }}</label>

                <input type="text" name="phone" value="{{ old('phone') }}"
                placeholder="{{ __('+255 7X XXX XXX') }}" autocomplete="tel"

                class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" required>

                @error('phone')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD FIELD --}}
            <div class="field-row">
                <div class="field">
                <label for="password">{{ __('Password') }}</label>
                <div style="position: relative;">
                    <input type="password" id="reg-password" name="password" placeholder="{{ __('Min 8 characters') }}" autocomplete="new-password"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}" style="padding-right: 40px; width: 100%; box-sizing: border-box;" required>
                    <button type="button" onclick="togglePassword('reg-password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('password')
                <div class="field-error">{{ $message }}</div>
                @enderror
                </div>

                {{-- PASSWORD CONFIRMATION FIELD --}}
                <div class="field">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <div style="position: relative;">
                        <input type="password" id="reg-password-confirm" name="password_confirmation" placeholder="{{ __('Repeat your password') }}" autocomplete="new-password"
                        class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" style="padding-right: 40px; width: 100%; box-sizing: border-box;" required>
                        <button type="button" onclick="togglePassword('reg-password-confirm', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>

                    @error('password_confirmation')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

{{-- Role is now always 'user' — agents apply separately --}}

{{-- Terms --}}
<div class="terms-row">
    <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
    <span class="terms-text">
        {{ __('I agree to the') }} <a href="#">{{ __('Terms of Service') }}</a> {{ __('and') }} <a href="#">{{ __('Privacy Policy') }}</a>
    </span>
</div>
@error('terms')
    <div class="field-error" style="margin-top: -16px; margin-bottom: 16px;">{{ $message }}</div>
@enderror

<button type="submit" class="btn-primary">
    <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>
    {{ __('Create account') }}
</button>

</form>

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
</script>
</html>
