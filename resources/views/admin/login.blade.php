<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — NyumbaHub</title>
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
        .back-link   { display:block; text-align:center; margin-top:20px; font-size:13px; color:var(--gray-500); }
        .back-link a { color:var(--primary); font-weight:600; }
    </style>
</head>
<body>

<div class="login-wrap">

    {{-- Logo --}}
    <div style="text-align:center;margin-bottom:24px;">
        <div style="display:inline-flex;align-items:center;gap:8px;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;overflow:hidden;">
                <img src="{{ asset('images/nyumbahublogo.png') }}" style="width:48px;height:48px;object-fit:cover;">
            </div>
            <span style="font-family:var(--font-display);font-size:20px;font-weight:700;color:var(--primary);">
                Nyumba<span style="color:var(--accent);">Hub</span>
            </span>
        </div>
    </div>

    <div class="login-card">
        <div class="login-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <h1 class="login-title">Admin Login</h1>
        <p class="login-sub">Sign in to the NyumbaHub control panel</p>

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

        <form method="POST" action="{{ route('admin.login.submit') }}" target="_self">
            @csrf

            <div class="field">
                <label>Email address</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@nyumbahub.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required autofocus>
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password"
                    placeholder="Enter your password"
                    required>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:44px;font-size:15px;margin-top:8px;">
                <i class="fa-solid fa-right-to-bracket"></i> Sign in as Admin
            </button>
        </form>

        <p class="login-prompt" style="margin-top: 24px;">
            <a href="{{ route('login') }}" target="_self">← Back to User Login</a>
        </p>
    </div>
</div>

</body>
</html>
