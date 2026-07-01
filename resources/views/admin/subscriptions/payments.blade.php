@extends('admin.layouts.app')
@section('title', 'All Payments')
@section('page-title', 'All Payments')

@section('content')
<p class="dash-subtitle" style="margin-bottom: 20px;">View all platform transactions including subscriptions and bookings.</p>

<div class="dash-card">
    <div style="overflow-x:auto;">
        <table style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid var(--dash-border);">
                    <th style="padding:16px;">Reference</th>
                    <th style="padding:16px;">User</th>
                    <th style="padding:16px;">Type / Plan</th>
                    <th style="padding:16px;">Amount</th>
                    <th style="padding:16px;">Date</th>
                    <th style="padding:16px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr style="border-bottom:1px solid var(--dash-border);">
                    <td style="padding:16px; font-family:monospace; font-size:13px;">{{ $payment->transaction_reference }}</td>
                    <td style="padding:16px; font-weight:600;">
                        {{ $payment->user->first_name ?? 'N/A' }} {{ $payment->user->last_name ?? '' }}<br>
                        <span style="font-size:12px; font-weight:400; color:var(--dash-muted);">{{ $payment->user->email ?? '' }}</span>
                    </td>
                    <td style="padding:16px;">
                        @if($payment->subscription)
                            Subscription: {{ $payment->subscription->plan->name ?? 'Unknown' }}
                        @else
                            Other
                        @endif
                    </td>
                    <td style="padding:16px; font-weight:600;">{{ $payment->currency }} {{ number_format($payment->amount) }}</td>
                    <td style="padding:16px; color:var(--dash-muted); font-size:14px;">{{ $payment->created_at->format('M d, Y H:i') }}</td>
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

                @if($payments->isEmpty())
                <tr>
                    <td colspan="6" style="padding:40px; text-align:center; color:var(--dash-muted);">No payments found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div style="margin-top:24px;">
        {{ $payments->links() }}
    </div>
</div>
@endsection
