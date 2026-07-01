<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected $environment;
    protected $consumerKey;
    protected $consumerSecret;
    protected $passkey;
    protected $shortcode;
    protected $callbackUrl;

    public function __construct()
    {
        $this->environment = env('MPESA_ENVIRONMENT', 'sandbox');
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->passkey = env('MPESA_PASSKEY');
        $this->shortcode = env('MPESA_SHORTCODE');
        $this->callbackUrl = env('MPESA_CALLBACK_URL', url('/api/mpesa/callback'));
    }

    private function getBaseUrl()
    {
        return $this->environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }

    public function getAccessToken()
    {
        $url = $this->getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('M-Pesa Access Token Failed', ['response' => $response->body()]);
        throw new \Exception('Could not generate M-Pesa access token.');
    }

    /**
     * Format phone number to 254xxxxxxxxx
     */
    public function formatPhone($phone)
    {
        // Remove +, spaces, dashes
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 254
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }
        // If starts with 255 (Tanzania) or other, we might need to adjust, 
        // but Safaricom Sandbox typically requires 254...
        // For Sandbox purposes, let's just ensure it's standard.
        return $phone;
    }

    public function stkPush($phone, $amount, $reference, $description)
    {
        $token = $this->getAccessToken();
        $url = $this->getBaseUrl() . '/mpesa/stkpush/v1/processrequest';

        $phone = $this->formatPhone($phone);
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => round($amount),
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => substr($reference, 0, 12),
            'TransactionDesc' => substr($description, 0, 13)
        ];

        Log::info('Initiating STK Push', $payload);

        $response = Http::withToken($token)->post($url, $payload);

        if ($response->successful()) {
            return $response->json(); // Returns CheckoutRequestID, MerchantRequestID, etc.
        }

        Log::error('M-Pesa STK Push Failed', ['response' => $response->body()]);
        return ['error' => true, 'message' => $response->json('errorMessage') ?? 'STK Push failed.'];
    }

    public function processCallback($request)
    {
        $data = $request->all();
        Log::info('M-Pesa Callback Received', $data);

        if (!isset($data['Body']['stkCallback'])) {
            return ['status' => 'failed', 'message' => 'Invalid callback payload'];
        }

        $callback = $data['Body']['stkCallback'];
        $checkoutRequestId = $callback['CheckoutRequestID'];
        $resultCode = $callback['ResultCode'];
        $resultDesc = $callback['ResultDesc'];

        if ($resultCode == 0) {
            // Successful payment
            $items = $callback['CallbackMetadata']['Item'];
            $meta = [];
            foreach ($items as $item) {
                if (isset($item['Name']) && isset($item['Value'])) {
                    $meta[$item['Name']] = $item['Value'];
                }
            }

            return [
                'status' => 'completed',
                'checkout_request_id' => $checkoutRequestId,
                'amount' => $meta['Amount'] ?? 0,
                'mpesa_receipt' => $meta['MpesaReceiptNumber'] ?? null,
                'phone_number' => $meta['PhoneNumber'] ?? null,
                'result_desc' => $resultDesc,
            ];
        }

        // Failed payment (e.g. user cancelled)
        return [
            'status' => 'failed',
            'checkout_request_id' => $checkoutRequestId,
            'result_desc' => $resultDesc,
        ];
    }
}
