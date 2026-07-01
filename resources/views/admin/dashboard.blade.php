@extends('admin.layouts.app')

@section('title', __('Admin Dashboard'))
@section('page-title', __('Admin Overview'))

@section('content')
    
    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Total Users') }}</h3>
                <div class="kpi-value">{{ number_format($totalUsers) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-arrow-trend-up"></i> +12% this month</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-info); background: rgba(59, 130, 246, 0.1);">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Total Properties') }}</h3>
                <div class="kpi-value">{{ number_format($totalListings) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-arrow-trend-up"></i> +5% this month</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-primary); background: rgba(27, 67, 50, 0.1);">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Total Agents') }}</h3>
                <div class="kpi-value">{{ number_format($totalAgents) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-arrow-trend-up"></i> +2% this month</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-accent); background: rgba(212, 168, 83, 0.1);">
                <i class="fa-solid fa-user-tie"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Pending Approvals') }}</h3>
                <div class="kpi-value">{{ number_format($pendingAgents) }}</div>
                @if($pendingAgents > 0)
                    <div class="kpi-trend negative"><i class="fa-solid fa-circle-exclamation"></i> Action required</div>
                @else
                    <div class="kpi-trend positive"><i class="fa-solid fa-check"></i> All caught up</div>
                @endif
            </div>
            <div class="kpi-icon" style="color: var(--dash-warning); background: rgba(245, 158, 11, 0.1);">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
        </div>
    </div>

    {{-- Charts Area --}}
    <div class="charts-grid" style="grid-template-columns: 1fr 1fr;">
        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Platform Growth') }}</h2>
            </div>
            <div style="height: 250px;">
                <canvas id="growthChart" height="250"></canvas>
            </div>
        </div>

        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Property Distribution') }}</h2>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 10px;">
                @php
                    $totalTypes = max(1, array_sum($typesData));
                    $aptPct = round(($typesData['apartment'] / $totalTypes) * 100);
                    $housePct = round(($typesData['house'] / $totalTypes) * 100);
                    $commPct = round(($typesData['commercial'] / $totalTypes) * 100);
                    $landPct = round(($typesData['land'] / $totalTypes) * 100);
                @endphp

                <div class="pipeline-group" style="margin-top: 15px;">
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-building" style="color: var(--dash-primary); width: 20px;"></i> {{ __('Apartments') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $typesData['apartment'] ?? 0 }} ({{ $aptPct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $aptPct }}%; height: 100%; background: var(--dash-primary); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-house" style="color: var(--dash-accent); width: 20px;"></i> {{ __('Houses & Villas') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $typesData['house'] ?? 0 }} ({{ $housePct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $housePct }}%; height: 100%; background: var(--dash-accent); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-store" style="color: var(--dash-info); width: 20px;"></i> {{ __('Commercial') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $typesData['commercial'] ?? 0 }} ({{ $commPct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $commPct }}%; height: 100%; background: var(--dash-info); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-map" style="color: var(--dash-success); width: 20px;"></i> {{ __('Land') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $typesData['land'] ?? 0 }} ({{ $landPct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $landPct }}%; height: 100%; background: var(--dash-success); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Grid --}}
    <div class="charts-grid" style="grid-template-columns: 1fr 1fr;">
        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Recent Audit Logs') }}</h2>
                <a href="{{ route('admin.audit-logs') }}" style="font-size: 13px; font-weight: 600; color: var(--dash-primary); text-decoration: none;">View All &rarr;</a>
            </div>
            
            <div class="timeline">
                @forelse(\App\Models\AuditLog::with('user')->latest()->take(5)->get() as $log)
                    <div class="timeline-item">
                        <div class="timeline-dot">
                            @if($log->action === 'created')
                                <i class="fa-solid fa-plus" style="color: var(--dash-success);"></i>
                            @elseif($log->action === 'updated')
                                <i class="fa-solid fa-pen" style="color: var(--dash-info);"></i>
                            @elseif($log->action === 'deleted')
                                <i class="fa-solid fa-trash" style="color: var(--dash-danger);"></i>
                            @else
                                <i class="fa-solid fa-circle-info" style="color: var(--dash-text-muted);"></i>
                            @endif
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-user">
                                    {{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System' }}
                                    <span class="timeline-badge bg-{{ $log->action === 'deleted' ? 'danger' : ($log->action === 'created' ? 'success' : 'primary') }}">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                </div>
                                <div class="timeline-time">{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="timeline-body">
                                {{ ucfirst($log->action) }} {{ class_basename($log->auditable_type) }} (ID: {{ $log->auditable_id }})
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--dash-text-muted);">{{ __('No recent activity.') }}</p>
                @endforelse
            </div>
        </div>

        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Quick Actions') }}</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <a href="{{ route('admin.users') }}" style="padding: 20px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                    <i class="fa-solid fa-user-plus" style="font-size: 24px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                    Manage Users
                </a>
                <a href="{{ route('admin.listings') }}" style="padding: 20px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                    <i class="fa-solid fa-building-circle-check" style="font-size: 24px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                    Review Listings
                </a>
                <a href="{{ route('admin.agent-applications') }}" style="padding: 20px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                    <i class="fa-solid fa-id-card" style="font-size: 24px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                    Agent Approvals
                </a>
                <a href="{{ route('admin.reports') }}" style="padding: 20px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                    <i class="fa-solid fa-chart-line" style="font-size: 24px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                    System Reports
                </a>
            </div>
        </div>
    
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const rawChartData = @json($chartData ?? []);
    
    // Platform Growth Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: rawChartData.months || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Users',
                data: rawChartData.users || [0, 0, 0, 0, 0, 0],
                borderColor: '#1B4332',
                backgroundColor: 'rgba(27, 67, 50, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Properties Added',
                data: rawChartData.listings || [0, 0, 0, 0, 0, 0],
                borderColor: '#D4A853',
                backgroundColor: 'transparent',
                borderWidth: 3,
                borderDash: [5, 5],
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush
