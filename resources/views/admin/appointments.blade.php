@extends('admin.layouts.app')

@section('title', __('Appointments — NyumbaHub Admin'))
@section('page-title', __('Appointments'))

@push('styles')
<style>
    @media(max-width:768px) {
        .data-table thead { display:none; }
        .data-table tr { display:block; background:white; border-radius:var(--radius-lg); border:1px solid var(--gray-200); margin-bottom:12px; padding:16px; }
        .data-table td { display:block; padding:4px 0; border:none; font-size:13px; }
        .data-table td::before { content:attr(data-label); font-weight:700; color:var(--gray-500); font-size:11px; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:2px; }
    }
</style>
@endpush

@section('topbar-actions')
<div style="display:flex;gap:8px;">
    <span style="background:var(--warning-bg);color:var(--warning);border:1px solid var(--warning-border);padding:5px 12px;border-radius:var(--radius-full);font-size:12px;font-weight:600;">
        {{ $pending }} Pending
    </span>
    <span style="background:var(--success-bg);color:var(--success);border:1px solid var(--success-border);padding:5px 12px;border-radius:var(--radius-full);font-size:12px;font-weight:600;">
        {{ $confirmed }} Confirmed
    </span>
</div>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;">
            <i class="fa-solid fa-calendar"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $appointments->total() }}</div>
            <div class="stat-label">{{ __('Total Appointments') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--warning-bg);color:var(--warning);">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $pending }}</div>
            <div class="stat-label">{{ __('Pending') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--success-bg);color:var(--success);">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $confirmed }}</div>
            <div class="stat-label">{{ __('Confirmed') }}</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Property') }}</th>
                    <th>{{ __('Date & Time') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td data-label="ID" style="color:var(--gray-400);font-size:12px;">
                        #{{ $appointment->id }}
                    </td>
                    <td data-label="User">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($appointment->user->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:13px;color:var(--gray-900);">
                                    {{ $appointment->user->first_name ?? '—' }} {{ $appointment->user->last_name ?? '' }}
                                </div>
                                <div style="font-size:11px;color:var(--gray-500);">{{ $appointment->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td data-label="Property">
                        <div style="font-weight:600;font-size:13px;color:var(--gray-900);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $appointment->listing->title ?? '—' }}
                        </div>
                        <div style="font-size:11px;color:var(--gray-500);">{{ $appointment->listing->location ?? '' }}</div>
                    </td>
                    <td data-label="Date & Time">
                        <div style="font-size:13px;font-weight:600;color:var(--gray-800);">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                        </div>
                        <div style="font-size:12px;color:var(--gray-500);">{{ $appointment->time }}</div>
                    </td>
                    <td data-label="Message" style="max-width:160px;">
                        <div style="font-size:12px;color:var(--gray-500);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px;">
                            {{ $appointment->message ?? '—' }}
                        </div>
                    </td>
                    <td data-label="Status">
                        <span class="badge badge-{{ $appointment->status }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="table-empty">{{ __('No appointments yet') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:20px;">{{ $appointments->links() }}</div>

@endsection
