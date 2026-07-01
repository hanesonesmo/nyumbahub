<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionPaymentService
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Initiate a subscription payment via M-Pesa STK Push.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubscriptionPlan $plan
     * @param string $phoneNumber
     * @return array
     */
    public function initiateSubscription($user, SubscriptionPlan $plan, $phoneNumber)
    {
        return DB::transaction(function () use ($user, $plan, $phoneNumber) {
            // Generate a unique reference for the transaction
            $reference = 'SUB-' . strtoupper(Str::random(8));

            // Create a pending subscription
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status' => 'pending',
            ]);

            // Create the pending payment record
            $payment = Payment::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'transaction_reference' => $reference,
                'payment_provider' => 'mpesa',
                'amount' => $plan->price,
                'currency' => 'TZS',
                'payment_status' => 'pending',
                'payment_method' => 'mpesa_stk',
            ]);

            Log::info('Initiating STK Push for Subscription', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'reference' => $reference,
            ]);

            // Call Mpesa Service
            $response = $this->mpesaService->stkPush(
                $phoneNumber,
                $plan->price,
                $reference,
                "Sub: {$plan->name}"
            );

            if (isset($response['error']) && $response['error'] === true) {
                // If API fails immediately, mark as failed
                $payment->update([
                    'payment_status' => 'failed',
                    'callback_response' => $response,
                ]);
                $subscription->update(['status' => 'cancelled']);

                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Payment initiation failed.',
                ];
            }

            // Save the gateway transaction ID (CheckoutRequestID) for callback matching
            $payment->update([
                'gateway_transaction_id' => $response['CheckoutRequestID'] ?? null,
            ]);

            return [
                'success' => true,
                'message' => 'Payment initiated. Please check your phone to enter your PIN.',
                'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
                'payment_id' => $payment->id,
            ];
        });
    }
}
