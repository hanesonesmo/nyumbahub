<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <!-- Left decorative panel -->
    <div class="panel-left">
        <div class="brand">
            <div class="brand-name">Nyumba<span>Hub</span></div>
            <div class="brand-tagline">Your Next Home. Found</div>
        </div>

        <div class="panel-content">
            <h2 class="panel-heading">Find your <em>perfect</em> home in Arusha</h2>
            <p class="panel-desc">Browse hundreds of verified listings for rent and sale. Connect with trusted agents across Arusha.</p>
        </div>

        <div class="panel-stats">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Listings</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">120+</div>
                <div class="stat-label">Agents</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3K+</div>
                <div class="stat-label">Users</div>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="panel-right">
        <div class="form-card">

            <h1 class="form-title">Welcome back</h1>
            <p class="form-subtitle">
                Don't have an account? <a href="{{ route('register') }}">Sign up free</a>
            </p>

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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-meta">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">Sign in here</button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">or</span>
                <div class="divider-line"></div>
            </div>

            <p class="register-prompt">
                New to NyumbaHub? <a href="{{ route('register') }}">Create an account</a>
            </p>

        </div>
    </div>

</body>
</html>
