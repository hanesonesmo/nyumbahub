@extends('admin.layouts.app')
@section('title', 'Active Subscriptions')
@section('page-title', 'Agent Subscriptions')

@section('content')
<p class="dash-subtitle" style="margin-bottom: 20px;">Manage agent subscriptions and their status.</p>

<div class="dash-card">
    <div style="overflow-x:auto;">
        <table style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid var(--dash-border);">
                    <th style="padding:16px;">Agent</th>
                    <th style="padding:16px;">Plan</th>
                    <th style="padding:16px;">Starts</th>
                    <th style="padding:16px;">Expires</th>
                    <th style="padding:16px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr style="border-bottom:1px solid var(--dash-border);">
                    <td style="padding:16px; font-weight:600;">
                        {{ $sub->user->first_name ?? 'N/A' }} {{ $sub->user->last_name ?? '' }}<br>
                        <span style="font-size:12px; font-weight:400; color:var(--dash-muted);">{{ $sub->user->email ?? '' }}</span>
                    </td>
                    <td style="padding:16px;">{{ $sub->plan->name ?? 'Unknown Plan' }}</td>
                    <td style="padding:16px;">{{ $sub->start_date ? $sub->start_date->format('M d, Y') : 'N/A' }}</td>
                    <td style="padding:16px;">{{ $sub->expiry_date ? $sub->expiry_date->format('M d, Y') : 'N/A' }}</td>
                    <td style="padding:16px;">
                        @if($sub->status === 'active')
                            <span style="display:inline-block; padding:4px 10px; background:#ECFDF5; color:#059669; border-radius:6px; font-size:12px; font-weight:600;">Active</span>
                        @elseif($sub->status === 'expired')
                            <span style="display:inline-block; padding:4px 10px; background:#FEF2F2; color:#DC2626; border-radius:6px; font-size:12px; font-weight:600;">Expired</span>
                        @else
                            <span style="display:inline-block; padding:4px 10px; background:#F1F5F9; color:#475569; border-radius:6px; font-size:12px; font-weight:600; text-transform:capitalize;">{{ $sub->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach

                @if($subscriptions->isEmpty())
                <tr>
                    <td colspan="5" style="padding:40px; text-align:center; color:var(--dash-muted);">No subscriptions found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div style="margin-top:24px;">
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
