<?php

namespace App\Listeners;

use App\Events\SubscriptionPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ActivateAgentSubscription
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\SubscriptionPaid  $event
     * @return void
     */
    public function handle(SubscriptionPaid $event)
    {
        $payment = $event->payment;
        $subscription = $payment->subscription;
        $user = $payment->user;
        $plan = $subscription->plan;

        if (!$subscription || !$user || !$plan) {
            Log::error('Missing relations in ActivateAgentSubscription listener.', ['payment_id' => $payment->id]);
            return;
        }

        // Determine expiration date
        $startDate = now();
        $expiryDate = $plan->billing_cycle === 'yearly' 
            ? $startDate->copy()->addYear() 
            : $startDate->copy()->addMonth();

        // Update Subscription
        $subscription->update([
            'status' => 'active',
            'start_date' => $startDate,
            'expiry_date' => $expiryDate,
        ]);

        // Upgrade User Role if not already agent or admin
        if ($user->role === 'tenant' || $user->role === 'user') {
            $user->update(['role' => 'agent']);
        }

        Log::info('Subscription Activated and User Upgraded to Agent.', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'expiry_date' => $expiryDate->toDateTimeString()
        ]);

        // TODO: Send Email Notification to User
        // Mail::to($user->email)->queue(new SubscriptionActivatedMail($subscription));
    }
}
