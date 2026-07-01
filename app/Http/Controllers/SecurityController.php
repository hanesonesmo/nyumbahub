<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginHistory;
use Illuminate\Validation\ValidationException;

class SecurityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Active Sessions
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();
            
        // Parse user agent minimally for display
        $sessions->transform(function ($session) {
            $agent = $session->user_agent;
            $browser = 'Unknown Browser';
            $platform = 'Unknown Platform';
            
            if (preg_match('/windows/i', $agent)) $platform = 'Windows';
            elseif (preg_match('/macintosh|mac os x/i', $agent)) $platform = 'Mac';
            elseif (preg_match('/linux/i', $agent)) $platform = 'Linux';
            elseif (preg_match('/android/i', $agent)) $platform = 'Android';
            elseif (preg_match('/iphone|ipad|ipod/i', $agent)) $platform = 'iOS';

            if (preg_match('/edg/i', $agent)) $browser = 'Edge';
            elseif (preg_match('/opr|opera/i', $agent)) $browser = 'Opera';
            elseif (preg_match('/chrome/i', $agent)) $browser = 'Chrome';
            elseif (preg_match('/safari/i', $agent)) $browser = 'Safari';
            elseif (preg_match('/firefox/i', $agent)) $browser = 'Firefox';

            $session->browser = $browser;
            $session->platform = $platform;
            $session->is_current_device = $session->id === request()->session()->getId();
            
            return $session;
        });

        // Login History
        $loginHistory = LoginHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('security.index', compact('sessions', 'loginHistory'));
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($request->password);
        
        \App\Services\AuditService::log('Session Revoked', 'Authentication', 'User logged out of other devices');

        return back()->with('success', __('You have been successfully logged out of all other devices.'));
    }
}
