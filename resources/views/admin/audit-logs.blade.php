@extends('admin.layouts.app')

@section('title', __('Audit Logs'))
@section('page-title', __('System Audit Logs'))
@section('page-subtitle', __('Monitor system activity and security events.'))

@section('content')

    <div class="premium-panel" style="margin-bottom: 32px; padding: 16px 24px;">
        <form method="GET" action="{{ route('admin.audit-logs') }}" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label class="premium-label">{{ __('Search') }}</label>
                <div class="topbar-search" style="width: 100%;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by model, ID...') }}" class="premium-input" style="padding-left: 48px; border-radius: var(--dash-radius-sm);">
                </div>
            </div>
            
            <div style="width: 180px;">
                <label class="premium-label">{{ __('Action Filter') }}</label>
                <select name="action" class="premium-input">
                    <option value="">{{ __('All Actions') }}</option>
                    <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>{{ __('Created') }}</option>
                    <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>{{ __('Updated') }}</option>
                    <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                </select>
            </div>
            
            <button type="submit" class="premium-btn">
                <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
            </button>
            <a href="{{ route('admin.audit-logs') }}" class="btn-icon" title="Clear Filters" style="width: 48px; height: 48px; font-size: 18px;">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
        </form>
    </div>

    <div class="premium-panel">
        <div class="panel-header">
            <h2 class="panel-title">{{ __('Activity Timeline') }}</h2>
            <div style="font-size: 14px; color: var(--dash-text-muted);">
                Showing {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
            </div>
        </div>

        <div class="timeline" style="margin-top: 24px; padding-left: 40px;">
            @forelse($logs as $log)
                @php
                    $isCreate = $log->action === 'created';
                    $isUpdate = $log->action === 'updated';
                    $isDelete = $log->action === 'deleted';
                    
                    $dotColor = $isCreate ? 'var(--dash-success)' : ($isUpdate ? 'var(--dash-info)' : ($isDelete ? 'var(--dash-danger)' : 'var(--dash-text-muted)'));
                    $iconClass = $isCreate ? 'fa-plus' : ($isUpdate ? 'fa-pen' : ($isDelete ? 'fa-trash' : 'fa-info'));
                    $badgeClass = $isCreate ? 'bg-success' : ($isUpdate ? 'bg-primary' : ($isDelete ? 'bg-danger' : 'bg-warning'));
                @endphp

                <div class="timeline-item">
                    <div class="timeline-dot" style="border-color: {{ $dotColor }}; left: -40px;">
                        <i class="fa-solid {{ $iconClass }}" style="color: {{ $dotColor }};"></i>
                    </div>
                    <div class="timeline-content" style="padding: 24px; display: flex; flex-direction: column; gap: 12px;">
                        <div class="timeline-header" style="margin: 0;">
                            <div class="timeline-user" style="font-size: 16px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--dash-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">
                                    {{ $log->user ? strtoupper(substr($log->user->first_name, 0, 1)) : 'S' }}
                                </div>
                                {{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System Generated' }}
                            </div>
                            <div class="timeline-time" style="font-weight: 600;">
                                <i class="fa-regular fa-clock" style="margin-right: 4px;"></i>
                                {{ $log->created_at->format('M d, Y • h:i A') }}
                            </div>
                        </div>

                        <div style="font-size: 15px; color: var(--dash-text);">
                            <span class="timeline-badge {{ $badgeClass }}" style="margin-right: 8px;">{{ strtoupper($log->action) }}</span>
                            <strong>{{ class_basename($log->auditable_type) }}</strong> 
                            <span style="color: var(--dash-text-muted);">#{{ $log->auditable_id }}</span>
                        </div>

                        @if($log->old_values || $log->new_values)
                            <details style="margin-top: 8px;">
                                <summary style="cursor: pointer; color: var(--dash-primary); font-weight: 600; font-size: 13px; user-select: none;">
                                    <i class="fa-solid fa-code" style="margin-right: 4px;"></i> View Payload Data
                                </summary>
                                <div style="margin-top: 12px; padding: 16px; background: #1e293b; border-radius: var(--dash-radius-sm); color: #e2e8f0; font-family: monospace; font-size: 12px; overflow-x: auto;">
                                    @if($log->old_values)
                                        <div style="margin-bottom: 8px; color: #ef4444;">// Old Values<br>{!! nl2br(e(json_encode(is_string($log->old_values) ? json_decode($log->old_values) : $log->old_values, JSON_PRETTY_PRINT))) !!}</div>
                                    @endif
                                    @if($log->new_values)
                                        <div style="color: #10b981;">// New Values<br>{!! nl2br(e(json_encode(is_string($log->new_values) ? json_decode($log->new_values) : $log->new_values, JSON_PRETTY_PRINT))) !!}</div>
                                    @endif
                                </div>
                            </details>
                        @endif
                    </div>
                </div>
            @empty
                <div style="padding: 40px; text-align: center; color: var(--dash-text-muted);">
                    <i class="fa-solid fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <h3>{{ __('No audit logs found') }}</h3>
                    <p>{{ __('Try adjusting your search or filter criteria.') }}</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 32px; border-top: 1px solid var(--dash-border); padding-top: 24px;">
            {{ $logs->links() }}
        </div>
    
    </div>
@endsection
