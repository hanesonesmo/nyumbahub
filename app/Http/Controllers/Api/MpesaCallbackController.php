<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MpesaService;
use App\Models\PaymentTransaction;
use App\Models\Appointment;
use App\Models\PropertyReservation;
use App\Models\Listing;
use Illuminate\Support\Facades\Log;

class MpesaCallbackController extends Controller
{
    protected $mpesa;

    public function __construct(MpesaService $mpesa)
    {
        $this->mpesa = $mpesa;
    }

    public function handleCallback(Request $request)
    {
        Log::info('M-Pesa Webhook Hit');
        
        $result = $this->mpesa->processCallback($request);

        if (!isset($result['checkout_request_id'])) {
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid Request']);
        }

        $transaction = PaymentTransaction::where('transaction_id', $result['checkout_request_id'])->first();

        if (!$transaction) {
            // Check for Agent Subscription Payment
            $subscriptionPayment = \App\Models\Payment::where('gateway_transaction_id', $result['checkout_request_id'])->first();
            if ($subscriptionPayment) {
                return $this->handleSubscriptionPayment($subscriptionPayment, $result);
            }

            Log::warning('Transaction not found for CheckoutRequestID: ' . $result['checkout_request_id']);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Acknowledged']);
        }

        if ($transaction->status === 'completed') {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Already processed']);
        }

        if ($result['status'] === 'completed') {
            $transaction->update([
                'status' => 'completed',
                'mpesa_receipt' => $result['mpesa_receipt'],
                'phone_number' => $result['phone_number'],
                'result_desc' => $result['result_desc']
            ]);

            $this->fulfillTransaction($transaction);

        } else {
            $transaction->update([
                'status' => 'failed',
                'result_desc' => $result['result_desc'] ?? 'Payment failed or cancelled'
            ]);
            
            // Revert any hold state if needed
            if ($transaction->type === 'reservation' && $transaction->listing_id) {
                // Not really needed unless we pre-reserved it. We should only reserve AFTER payment.
            }
        }

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Success'
        ]);
    }

    private function fulfillTransaction(PaymentTransaction $transaction)
    {
        if ($transaction->type === 'booking') {
            // Find the pending appointment that belongs to this user and listing, assuming the latest pending one
            $appointment = Appointment::where('user_id', $transaction->user_id)
                ->where('listing_id', $transaction->listing_id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($appointment) {
                $appointment->update(['status' => 'confirmed']);
                // Todo: notify user and agent
                Log::info('Booking confirmed via M-Pesa for Appointment ID ' . $appointment->id);
            }
        } elseif ($transaction->type === 'reservation') {
            $listing = Listing::find($transaction->listing_id);
            if ($listing && $listing->status === 'active') {
                $listing->update(['status' => 'reserved']);

                $hours = \App\Models\Setting::get('reservation_hours_validity', 48);

                PropertyReservation::create([
                    'user_id' => $transaction->user_id,
                    'listing_id' => $transaction->listing_id,
                    'payment_transaction_id' => $transaction->id,
                    'expires_at' => now()->addHours($hours),
                    'status' => 'active'
                ]);

                Log::info('Property Reserved via M-Pesa for Listing ID ' . $listing->id);
            }
        }
    }

    private function handleSubscriptionPayment(\App\Models\Payment $payment, $result)
    {
        if ($payment->payment_status === 'completed') {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Already processed']);
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($payment, $result) {
            if ($result['status'] === 'completed') {
                $payment->update([
                    'payment_status' => 'completed',
                    'callback_response' => $result,
                    'paid_at' => now(),
                ]);

                event(new \App\Events\SubscriptionPaid($payment));
            } else {
                $payment->update([
                    'payment_status' => 'failed',
                    'callback_response' => $result,
                ]);
                
                if ($payment->subscription) {
                    $payment->subscription->update(['status' => 'cancelled']);
                }
            }
        });

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Success'
        ]);
    }
}
