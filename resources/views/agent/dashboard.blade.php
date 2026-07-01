@extends('layouts.dashboard')

@section('title', __('Agent Dashboard'))
@section('page-title', __('Welcome back, ' . auth()->user()->first_name))
@section('page-subtitle', __('Here is what is happening with your properties today.'))

@section('content')

    {{-- Agent KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Total Listings') }}</h3>
                <div class="kpi-value">{{ number_format($totalListings) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-arrow-trend-up"></i> Active portfolio</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-primary); background: rgba(27, 67, 50, 0.1);">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Active Listings') }}</h3>
                <div class="kpi-value">{{ number_format($activeListings) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-eye"></i> Visible to public</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-success); background: rgba(16, 185, 129, 0.1);">
                <i class="fa-solid fa-house-circle-check"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Pending Approvals') }}</h3>
                <div class="kpi-value">{{ number_format($pendingListings) }}</div>
                @if($pendingListings > 0)
                    <div class="kpi-trend warning" style="color: var(--dash-warning);"><i class="fa-solid fa-hourglass-half"></i> Under admin review</div>
                @else
                    <div class="kpi-trend positive"><i class="fa-solid fa-check"></i> All approved</div>
                @endif
            </div>
            <div class="kpi-icon" style="color: var(--dash-warning); background: rgba(245, 158, 11, 0.1);">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ __('Total Appointments') }}</h3>
                <div class="kpi-value">{{ number_format($totalAppointments) }}</div>
                <div class="kpi-trend positive"><i class="fa-solid fa-calendar-check"></i> High engagement</div>
            </div>
            <div class="kpi-icon" style="color: var(--dash-accent); background: rgba(212, 168, 83, 0.1);">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>
    </div>

    {{-- Charts Area --}}
    <div class="charts-grid" style="grid-template-columns: 1fr 1fr;">
        
        {{-- Bookings Chart --}}
        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Monthly Bookings') }}</h2>
            </div>
            <div style="height: 250px;">
                <canvas id="bookingsChart" height="250"></canvas>
            </div>
        </div>

        {{-- Property Portfolio Pipeline --}}
        <div class="premium-panel">
            <div class="panel-header">
                <h2 class="panel-title">{{ __('Portfolio Pipeline') }}</h2>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 10px;">
                @php
                    $total = max(1, $totalListings);
                    $activePct = round(($activeListings / $total) * 100);
                    $pendingPct = round(($pendingListings / $total) * 100);
                    $rejectedPct = round(($rejectedListings / $total) * 100);
                @endphp

                <div class="pipeline-group" style="margin-top: 15px;">
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-house-circle-check" style="color: var(--dash-success); width: 20px;"></i> {{ __('Active') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $activeListings }} ({{ $activePct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $activePct }}%; height: 100%; background: var(--dash-success); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-clock-rotate-left" style="color: var(--dash-warning); width: 20px;"></i> {{ __('Pending') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $pendingListings }} ({{ $pendingPct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $pendingPct }}%; height: 100%; background: var(--dash-warning); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            <span style="color: var(--dash-text);"><i class="fa-solid fa-circle-xmark" style="color: var(--dash-danger); width: 20px;"></i> {{ __('Rejected') }}</span>
                            <span style="color: var(--dash-text-muted);">{{ $rejectedListings }} ({{ $rejectedPct }}%)</span>
                        </div>
                        <div style="height: 8px; border-radius: 4px; background: var(--dash-border); overflow: hidden;">
                            <div style="width: {{ $rejectedPct }}%; height: 100%; background: var(--dash-danger); border-radius: 4px; transition: width 1s ease-in-out;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Bottom Section --}}
    <div class="premium-panel" style="margin-top: 32px;">
        <div class="panel-header">
            <h2 class="panel-title">{{ __('Quick Actions') }}</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="{{ route('agent.listings.create') }}" style="padding: 24px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-primary); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: white; transition: var(--dash-transition); font-weight: 600; box-shadow: var(--dash-shadow);">
                <i class="fa-solid fa-plus-circle" style="font-size: 32px; margin-bottom: 12px; color: var(--dash-accent);"></i>
                Add New Listing
            </a>
            <a href="{{ route('agent.listings.index') }}" style="padding: 24px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                <i class="fa-solid fa-list" style="font-size: 32px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                Manage Portfolio
            </a>
            <a href="{{ route('agent.appointments.index') }}" style="padding: 24px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                <i class="fa-solid fa-calendar" style="font-size: 32px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                View Schedule
            </a>
            <a href="{{ route('agent.profile.edit') }}" style="padding: 24px; border-radius: var(--dash-radius-sm); border: 1px solid var(--dash-border); background: var(--dash-bg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--dash-text); transition: var(--dash-transition); font-weight: 600;" onmouseover="this.style.borderColor='var(--dash-primary)'" onmouseout="this.style.borderColor='var(--dash-border)'">
                <i class="fa-solid fa-user-pen" style="font-size: 32px; color: var(--dash-primary); margin-bottom: 12px;"></i>
                Update Profile
            </a>
        </div>
    
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const rawChartData = @json($chartData ?? []);
    
    // Bookings Chart
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: rawChartData.months || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Bookings',
                data: rawChartData.bookings || [0, 0, 0, 0, 0, 0],
                backgroundColor: '#1B4332',
                hoverBackgroundColor: '#D4A853',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
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
