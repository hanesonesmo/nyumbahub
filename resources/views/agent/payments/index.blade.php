@extends('layouts.dashboard')
@section('title', 'Payment History & Subscription')

@section('content')
<div class="dash-header">
    <h1 class="dash-title">Payment History</h1>
    <p class="dash-subtitle">Manage your subscription and view past transactions.</p>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; color:#059669; padding:16px; border-radius:12px; margin-bottom:24px; border:1px solid #A7F3D0;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#FEF2F2; color:#DC2626; padding:16px; border-radius:12px; margin-bottom:24px; border:1px solid #FECACA;">
        {{ session('error') }}
    </div>
@endif

{{-- Active Subscription Status --}}
<div class="dash-card" style="margin-bottom:32px;">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:24px;">Current Subscription</h2>
    @if($subscription && $subscription->isActive())
        <div style="display:flex; align-items:center; gap:24px; background:var(--dash-bg); padding:24px; border-radius:16px; border:1px solid var(--dash-border);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(5, 150, 105, 0.1); color:#059669; display:flex; align-items:center; justify-content:center; font-size:28px;">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:18px; font-weight:700; color:var(--dash-text); margin-bottom:4px;">{{ $subscription->plan->name ?? 'Agent Plan' }}</h3>
                <p style="font-size:14px; color:var(--dash-muted); margin-bottom:8px;">Valid until {{ $subscription->expiry_date->format('M d, Y') }} ({{ $subscription->expiry_date->diffForHumans() }})</p>
                <span style="display:inline-block; padding:4px 12px; background:#ECFDF5; color:#059669; border-radius:99px; font-size:12px; font-weight:600; border:1px solid #A7F3D0;">Active</span>
            </div>
            <div>
                <a href="{{ route('become-agent') }}" class="btn-primary" style="padding:10px 20px; font-size:14px;">Renew Subscription</a>
            </div>
        </div>
    @else
        <div style="display:flex; align-items:center; gap:24px; background:var(--dash-bg); padding:24px; border-radius:16px; border:1px solid var(--dash-border);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(220, 38, 38, 0.1); color:#DC2626; display:flex; align-items:center; justify-content:center; font-size:28px;">
                <i class="fa-solid fa-exclamation-circle"></i>
            </div>
            <div style="flex:1;">
                <h3 style="font-size:18px; font-weight:700; color:var(--dash-text); margin-bottom:4px;">No Active Subscription</h3>
                <p style="font-size:14px; color:var(--dash-muted); margin-bottom:8px;">You currently do not have an active subscription. Your listings may be hidden.</p>
                <span style="display:inline-block; padding:4px 12px; background:#FEF2F2; color:#DC2626; border-radius:99px; font-size:12px; font-weight:600; border:1px solid #FECACA;">Expired / Inactive</span>
            </div>
            <div>
                <a href="{{ route('become-agent') }}" class="btn-primary" style="padding:10px 20px; font-size:14px;">Subscribe Now</a>
            </div>
        </div>
    @endif
</div>

{{-- Payment History Table --}}
<div class="dash-card">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:24px;">Transaction History</h2>
    
    @if($payments->count() > 0)
        <div style="overflow-x:auto;">
            <table style="width:100%; text-align:left; border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:2px solid var(--dash-border);">
                        <th style="padding:16px; font-weight:600; color:var(--dash-muted);">Reference</th>
                        <th style="padding:16px; font-weight:600; color:var(--dash-muted);">Plan</th>
                        <th style="padding:16px; font-weight:600; color:var(--dash-muted);">Amount</th>
                        <th style="padding:16px; font-weight:600; color:var(--dash-muted);">Date</th>
                        <th style="padding:16px; font-weight:600; color:var(--dash-muted);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr style="border-bottom:1px solid var(--dash-border);">
                        <td style="padding:16px; font-family:monospace; color:var(--dash-text);">{{ $payment->transaction_reference }}</td>
                        <td style="padding:16px; color:var(--dash-text);">{{ $payment->subscription->plan->name ?? 'N/A' }}</td>
                        <td style="padding:16px; font-weight:600; color:var(--dash-text);">{{ $payment->currency }} {{ number_format($payment->amount) }}</td>
                        <td style="padding:16px; color:var(--dash-muted);">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                        <td style="padding:16px;">
                            @if($payment->payment_status === 'completed')
                                <span style="display:inline-block; padding:4px 10px; background:#ECFDF5; color:#059669; border-radius:6px; font-size:12px; font-weight:600;">Completed</span>
                            @elseif($payment->payment_status === 'failed')
                                <span style="display:inline-block; padding:4px 10px; background:#FEF2F2; color:#DC2626; border-radius:6px; font-size:12px; font-weight:600;">Failed</span>
                            @else
                                <span style="display:inline-block; padding:4px 10px; background:#FFFBEB; color:#D97706; border-radius:6px; font-size:12px; font-weight:600;">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:24px;">
            {{ $payments->links() }}
        </div>
    @else
        <div style="text-align:center; padding:40px; color:var(--dash-muted);">
            <i class="fa-solid fa-receipt" style="font-size:48px; margin-bottom:16px; opacity:0.5;"></i>
            <p>You have no transaction history.</p>
        </div>
    @endif
</div>
@endsection
