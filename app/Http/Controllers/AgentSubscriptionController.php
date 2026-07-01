<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionPaymentService;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class AgentSubscriptionController extends Controller
{
    protected $paymentService;

    public function __construct(SubscriptionPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function becomeAgent()
    {
        $plans = SubscriptionPlan::where('active', true)->get();
        return view('pages.become-agent', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'phone_number' => 'required|string|min:10|max:15',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to subscribe.');
        }

        $plan = SubscriptionPlan::find($request->plan_id);

        $result = $this->paymentService->initiateSubscription($user, $plan, $request->phone_number);

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    public function history()
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()->where('status', 'active')->first();
        
        $payments = Payment::with('subscription.plan')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('agent.payments.index', compact('subscription', 'payments'));
    }
}
