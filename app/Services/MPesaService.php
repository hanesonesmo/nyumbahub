<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MPesaService
{
    protected $environment;
    protected $consumerKey;
    protected $consumerSecret;
    protected $passkey;
    protected $shortcode;
    protected $callbackUrl;

    public function __construct()
    {
        $this->environment = config('services.mpesa.environment', 'sandbox');
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passkey = config('services.mpesa.passkey');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->callbackUrl = config('services.mpesa.callback_url');
    }

    protected function getBaseUrl()
    {
        return $this->environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }

    public function getAccessToken()
    {
        $url = $this->getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials';
        
        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($url);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('M-Pesa Access Token Error', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa Access Token Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function initiateStkPush($phoneNumber, $amount, $reference = 'Subscription')
    {
        // Format phone number to 2557XXXXXXXX format (Tanzania uses 255)
        // Note: Safaricom is Kenya (254) but M-Pesa is also in TZ via Vodacom. 
        // Assuming user passes correctly formatted number for the appropriate API gateway.
        
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Failed to retrieve access token.'
            ];
        }

        $url = $this->getBaseUrl() . '/mpesa/stkpush/v1/processrequest';
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => round($amount),
            'PartyA' => $phoneNumber,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => $reference,
            'TransactionDesc' => 'Agent Subscription Payment'
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('M-Pesa STK Push Error', [
                'status' => $response->status(),
                'response' => $response->json(),
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initiate STK Push.',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred during STK Push.'
            ];
        }
    }
}
