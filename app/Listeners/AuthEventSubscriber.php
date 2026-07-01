<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Request;
use App\Models\LoginHistory;
use App\Models\User;
use App\Notifications\SuspiciousLoginNotification;

class AuthEventSubscriber
{
    private function getDeviceInfo()
    {
        $userAgent = Request::header('User-Agent');
        $browser = 'Unknown';
        $platform = 'Unknown';
        $device = 'Desktop';

        // Basic parsing for fallback
        if (preg_match('/mobile/i', $userAgent)) {
            $device = 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            $device = 'Tablet';
        }

        if (preg_match('/windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            $platform = 'iOS';
        }

        if (preg_match('/edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/opr|opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Firefox';
        }

        return [
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
        ];
    }

    public function handleUserLogin(Login $event)
    {
        $deviceInfo = $this->getDeviceInfo();
        $ipAddress = Request::ip();
        $userAgent = Request::header('User-Agent');

        // Check if this IP or User Agent is new for this user
        $isNewActivity = !LoginHistory::where('user_id', $event->user->id)
            ->where('status', 'success')
            ->where(function($query) use ($ipAddress, $userAgent) {
                $query->where('ip_address', $ipAddress)
                      ->orWhere('user_agent', $userAgent);
            })->exists();

        $history = LoginHistory::create([
            'user_id' => $event->user->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'status' => 'success',
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'device' => $deviceInfo['device'],
        ]);

        if ($isNewActivity) {
            $event->user->notify(new SuspiciousLoginNotification($history));
        }
    }

    public function handleUserFailedLogin(Failed $event)
    {
        $deviceInfo = $this->getDeviceInfo();
        
        $userId = null;
        if ($event->user) {
            $userId = $event->user->id;
        } elseif ($event->credentials && isset($event->credentials['email'])) {
            $user = User::where('email', $event->credentials['email'])->first();
            if ($user) $userId = $user->id;
        }

        LoginHistory::create([
            'user_id' => $userId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'status' => 'failed',
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'device' => $deviceInfo['device'],
        ]);
        
        \App\Services\AuditService::log('Failed Login', 'Authentication', "Failed login attempt from IP: " . Request::ip());
    }

    public function handleUserLogout(Logout $event)
    {
        $deviceInfo = $this->getDeviceInfo();
        
        if ($event->user) {
            LoginHistory::create([
                'user_id' => $event->user->id,
                'ip_address' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
                'status' => 'logout',
                'browser' => $deviceInfo['browser'],
                'platform' => $deviceInfo['platform'],
                'device' => $deviceInfo['device'],
            ]);
        }
    }

    public function handleLockout(Lockout $event)
    {
        $email = $event->request->input('email');
        $user = User::where('email', $email)->first();
        $deviceInfo = $this->getDeviceInfo();

        LoginHistory::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'status' => 'lockout',
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'device' => $deviceInfo['device'],
        ]);

        \App\Services\AuditService::log('Lockout', 'Authentication', "Account locked due to too many attempts: {$email}");
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Login::class,
            [AuthEventSubscriber::class, 'handleUserLogin']
        );

        $events->listen(
            Failed::class,
            [AuthEventSubscriber::class, 'handleUserFailedLogin']
        );

        $events->listen(
            Logout::class,
            [AuthEventSubscriber::class, 'handleUserLogout']
        );

        $events->listen(
            Lockout::class,
            [AuthEventSubscriber::class, 'handleLockout']
        );
    }
}
