<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', __('Google authentication failed. Please try again.'));
        }

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Link the Google account to the existing user if not linked
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'provider' => 'google',
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Create a new user
            $user = User::create([
                'first_name' => $this->getFirstName($googleUser->getName()),
                'last_name' => $this->getLastName($googleUser->getName()),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'provider' => 'google',
                'avatar' => $googleUser->getAvatar(),
                'password' => null,
                'role' => 'user',
            ]);

            // Mark email as verified since it came from Google
            $user->markEmailAsVerified();

            \App\Services\AuditService::log('Registered', 'Authentication', 'User created an account via Google');
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        session(['last_activity' => time()]);

        \App\Services\AuditService::log('Login', 'Authentication', 'User successfully logged in via Google');

        return $this->redirectByRole($user);
    }

    private function getFirstName($name)
    {
        $parts = explode(' ', $name);
        return $parts[0] ?? '';
    }

    private function getLastName($name)
    {
        $parts = explode(' ', $name);
        if (count($parts) > 1) {
            array_shift($parts);
            return implode(' ', $parts);
        }
        return '';
    }

    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'agent'  => redirect()->route('agent.dashboard'),
            default  => redirect('/'),
        };
    }
}
