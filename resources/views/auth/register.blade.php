<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>

    <body>
    <!-- Theme toggle for auth pages -->
    <button class="theme-picker-btn" id="themePickerBtn" aria-label="Choose theme">
        <i class="fa-solid fa-sun"></i>
    </button>
    <div class="theme-picker-dropdown" id="themePickerDropdown"></div>
        <!-- Left panel -->
<div class="panel-left">
    <div class="panel-slideshow">
        <div class="panel-slide"></div>
        <div class="panel-slide"></div>
        <div class="panel-slide"></div>
    </div>
    <div class="brand">
        <div class="brand-name">Nyumba <span>Hub</span></div>
        <div class="brand-tagline">Your Next Home. Found</div>
    </div>

    <div class="panel-content">
        <h2 class="panel-heading">Join <em>NyumbaHub</em></h2>
        <p class="panel-desc">Whether you're searching, renting, buying, or listing, NyumbaHub connects you to the right people.</p>
    </div>

    <ul class="panel-features">
        <li>
            <span class="feature-dot"></span>
            Browse verified rental and sale listings across Arusha</li>

            <li>
                <span class="feature-dot"></span>
                Book property viewings with trusted Agents</li>

                <li>
                    <span class="feature-dot"></span>
                    Pay securely via Mobile Money</li>

                    <li>
                        <span class="feature-dot"></span>
                        Manage your listings and appointments in one place</li>

                        <li>
                            <span class=featire-dot></span>
                            Manage your listings and appointments in one place</li>
                        </ul>
</div>

<!-- Right panel -->
<div class="panel-right">
    <div class="form-card">
        <h1 class=form-title>Create your account</h1>
        <p class="form-subtitle">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME ROW--}}
            <div class="field-row">
                <div class="field">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                    placeholder="Joe" autocomplete="given-name"

                    class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}" required>

                    @error('first_name')
                    <div class="field-error">{{ $message}}
                </div>
                @enderror
                </div>

                <div class="field">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                    placeholder="Smith" autocomplete="family-name"

                    class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}" required>

                    @error('last_name')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- EMAIL FIELD --}}
            <div class="field">
                <label for="email">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                placeholder="joesmith@example.com" autocomplete="email"

                class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>

                @error('email')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{--PHONE FIELD--}}
            <div class="field">
                <label for="phone">Phone Number</label>

                <input type="text" name="phone" value="{{ old('phone') }}"
                placeholder="+255 7X XXX XXX" autocomplete="tel"

                class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" required>

                @error('phone')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD FIELD --}}
            <div class="field-row">
                <div class="field">
                <label for="password">Password</label>

                <input type="password" name="password" placeholder="Min 8 characters" autocomplete="new-password"

                class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required>

                @error('password')
                <div class="field-error">{{ $message }}</div>
                @enderror
                </div>

                {{-- PASSWORD CONFIRMATION FIELD --}}
                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat your password" autocomplete="new-password"

                    class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" required>

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
        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
    </span>
</div>
@error('terms')
    <div class="field-error" style="margin-top: -16px; margin-bottom: 16px;">{{ $message }}</div>
@enderror

<button type="submit" class="btn-primary">
    <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>
    Create account
</button>

</form>

        </div>
    </div>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>
</body>
</html>
