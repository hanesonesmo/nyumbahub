<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\SubscriptionPaid::class,
            \App\Listeners\ActivateAgentSubscription::class
        );

        \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\AuthEventSubscriber::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address — NyumbaHub')
                ->greeting('Hello ' . $notifiable->first_name . '!')
                ->line('Welcome to NyumbaHub! Please click the button below to verify your email address.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.')
                ->salutation("Best regards,\nThe NyumbaHub Team");
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Reset Password Notification — NyumbaHub')
                ->greeting('Hello ' . $notifiable->first_name . '!')
                ->line('You are receiving this email because we received a password reset request for your account.')
                ->action('Reset Password', $url)
                ->line('This password reset link will expire in 60 minutes.')
                ->line('If you did not request a password reset, no further action is required.')
                ->salutation("Best regards,\nThe NyumbaHub Team");
        });
    }
}
