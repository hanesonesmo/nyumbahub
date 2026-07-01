@extends('admin.layouts.app')
@section('title', 'Subscription Plans')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="dash-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
    <div>
        <p class="dash-subtitle">Manage agent pricing packages.</p>
    </div>
    <button class="btn-primary" onclick="document.getElementById('planModal').style.display='flex'">
        <i class="fa-solid fa-plus"></i> Add New Plan
    </button>
</div>

<div class="dash-card">
    <table style="width:100%; text-align:left; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:2px solid var(--dash-border);">
                <th style="padding:16px;">Name</th>
                <th style="padding:16px;">Price</th>
                <th style="padding:16px;">Cycle</th>
                <th style="padding:16px;">Listings</th>
                <th style="padding:16px;">Status</th>
                <th style="padding:16px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
            <tr style="border-bottom:1px solid var(--dash-border);">
                <td style="padding:16px; font-weight:600;">{{ $plan->name }}</td>
                <td style="padding:16px;">TZS {{ number_format($plan->price) }}</td>
                <td style="padding:16px; text-transform:capitalize;">{{ $plan->billing_cycle }}</td>
                <td style="padding:16px;">{{ $plan->maximum_listings }}</td>
                <td style="padding:16px;">
                    <form action="{{ route('admin.subscriptions.plans.toggle', $plan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background:none; border:none; cursor:pointer;">
                            @if($plan->active)
                                <span style="display:inline-block; padding:4px 10px; background:#ECFDF5; color:#059669; border-radius:6px; font-size:12px; font-weight:600;">Active</span>
                            @else
                                <span style="display:inline-block; padding:4px 10px; background:#FEF2F2; color:#DC2626; border-radius:6px; font-size:12px; font-weight:600;">Inactive</span>
                            @endif
                        </button>
                    </form>
                </td>
                <td style="padding:16px;">
                    <button class="btn-icon" style="background:var(--dash-bg); color:var(--dash-text);" title="Edit (Coming soon)">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            
            @if($plans->isEmpty())
            <tr>
                <td colspan="6" style="padding:32px; text-align:center; color:var(--dash-muted);">No plans created yet.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- Add Plan Modal --}}
<div id="planModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:32px; max-width:500px; width:90%;">
        <h2 style="font-size:20px; font-weight:700; margin-bottom:24px;">Create Subscription Plan</h2>
        <form method="POST" action="{{ route('admin.subscriptions.plans.store') }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:600;">Plan Name</label>
                <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:600;">Price (TZS)</label>
                    <input type="number" name="price" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:600;">Billing Cycle</label>
                    <select name="billing_cycle" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:600;">Maximum Listings</label>
                <input type="number" name="maximum_listings" value="10" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            
            <div style="margin-bottom:24px;">
                <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:600;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"></textarea>
            </div>
            
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('planModal').style.display='none'" style="padding:10px 16px; background:#f1f5f9; border:none; border-radius:6px; font-weight:600; cursor:pointer;">Cancel</button>
                <button type="submit" class="btn-primary" style="padding:10px 16px;">Save Plan</button>
            </div>
        </form>
    </div>
</div>
@endsection
