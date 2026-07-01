<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Subscription;

class PaymentController extends Controller
{
    public function payments()
    {
        $payments = Payment::with(['user', 'subscription.plan'])
            ->latest()
            ->paginate(15);
            
        return view('admin.subscriptions.payments', compact('payments'));
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::with(['user', 'plan'])
            ->latest()
            ->paginate(15);
            
        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}
