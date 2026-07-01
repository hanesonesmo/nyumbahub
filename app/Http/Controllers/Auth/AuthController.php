<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    // ── SHOW FORMS ──

    public function showLogin()
    {
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // ── LOGIN ──

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new \Illuminate\Auth\Events\Lockout($request));
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            session(['last_activity' => time()]);
            
            \App\Services\AuditService::log('Login', 'Authentication', 'User successfully logged in');
            
            return $this->redirectByRole(Auth::user());
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    // ── REGISTER ──

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'password'   => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            'terms'      => ['accepted'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'password'   => Hash::make($validated['password']),
            'role'       => 'user', // Always register as user; become agent via application
        ]);

        Auth::login($user);
        session(['last_activity' => time()]);

        \App\Services\AuditService::log('Registered', 'Authentication', 'User created an account');

        event(new \Illuminate\Auth\Events\Registered($user));

        return $this->redirectByRole($user);
    }

    // ── LOGOUT ──

    public function logout(Request $request)
    {
        \App\Services\AuditService::log('Logout', 'Authentication', 'User logged out');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('listings.index')
            ->with('success', __('You have been logged out successfully.'));
    }

    // ── FORGOT PASSWORD ──

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('success', __('If that email address exists in our database, we will send you a password reset link.'));
    }

    // ── RESET PASSWORD ──

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __('Password reset successfully! Please login.'))
            : back()->withErrors(['email' => __($status)]);
    }

    // ── EMAIL VERIFICATION ──

    public function showVerifyEmail(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended($this->getRedirectUrl($request->user()))
            : view('auth.verify-email');
    }

    public function verifyEmail(\Illuminate\Foundation\Auth\EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->intended($this->getRedirectUrl($request->user()))
            ->with('success', __('Your email address has been verified successfully.'));
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->getRedirectUrl($request->user()));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', __('A new verification link has been sent to the email address you provided during registration.'));
    }

    // ── HELPERS ──

    private function getRedirectUrl($user)
    {
        return match ($user->role) {
            'admin'  => route('admin.dashboard'),
            'agent'  => route('agent.dashboard'),
            default  => url('/'), // 'user', 'tenant' (legacy), 'buyer' (legacy)
        };
    }

    private function redirectByRole($user)
    {
        return redirect()->intended($this->getRedirectUrl($user));
    }
}
