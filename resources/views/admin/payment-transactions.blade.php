@extends('admin.layouts.app')
@section('title', __('Payment Transactions'))
@section('page-title', __('Payment Transactions'))

@section('content')
<p class="dashboard-subtitle" style="margin-bottom:20px;">{{ __('View all M-Pesa payments for bookings and reservations.') }}</p>

<div class="card">
    <div style="overflow-x:auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Transaction ID') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Receipt') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td style="white-space:nowrap;">{{ $trx->created_at->format('M d, Y H:i') }}</td>
                        <td><span style="font-family:monospace; font-size:12px; background:var(--gray-100); padding:2px 6px; border-radius:4px;">{{ Str::limit($trx->transaction_id, 15) }}</span></td>
                        <td>
                            <strong>{{ $trx->user->first_name }} {{ $trx->user->last_name }}</strong><br>
                            <span style="font-size:12px; color:var(--gray-500);">{{ $trx->phone_number ?? $trx->user->phone }}</span>
                        </td>
                        <td>
                            @if($trx->type === 'booking')
                                <span class="badge badge-info">{{ __('Booking') }}</span>
                            @else
                                <span class="badge badge-warning">{{ __('Reservation') }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $trx->amount }} {{ $trx->currency }}</strong></td>
                        <td>
                            @if($trx->status === 'completed')
                                <span class="badge badge-success">{{ __('Completed') }}</span>
                            @elseif($trx->status === 'failed')
                                <span class="badge badge-danger">{{ __('Failed') }}</span>
                            @else
                                <span class="badge badge-warning">{{ __('Pending') }}</span>
                            @endif
                        </td>
                        <td>{{ $trx->mpesa_receipt ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:var(--gray-500);">
                            {{ __('No payment transactions found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top:20px;">
        {{ $transactions->links() }}
    </div>
</div>

@endsection
