<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();
        return view('admin.subscriptions.plans', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'maximum_listings' => 'required|integer|min:1',
        ]);

        $validated['active'] = $request->has('active');

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscriptions.plans')->with('success', 'Subscription Plan created successfully.');
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'maximum_listings' => 'required|integer|min:1',
        ]);

        $validated['active'] = $request->has('active');

        $plan->update($validated);

        return redirect()->route('admin.subscriptions.plans')->with('success', 'Subscription Plan updated successfully.');
    }

    public function toggleActive(SubscriptionPlan $plan)
    {
        $plan->update(['active' => !$plan->active]);
        return redirect()->back()->with('success', 'Plan status updated.');
    }
}
