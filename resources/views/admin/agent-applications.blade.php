@extends('admin.layouts.app')

@section('title', 'Agent Applications')
@section('page-title', 'Agent Applications')
@section('page-subtitle', 'Review and manage agent verification requests')

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB;color:#D97706;"><i class="fa-solid fa-hourglass-half"></i></div>
        <div class="stat-info">
            <div class="stat-number">{{ $pending }}</div>
            <div class="stat-label">{{ __('Pending Review') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;color:#059669;"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-info">
            <div class="stat-number">{{ $approved }}</div>
            <div class="stat-label">{{ __('Approved') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF2F2;color:#DC2626;"><i class="fa-solid fa-circle-xmark"></i></div>
        <div class="stat-info">
            <div class="stat-number">{{ $rejected }}</div>
            <div class="stat-label">{{ __('Rejected') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;"><i class="fa-solid fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-number">{{ $applications->total() }}</div>
            <div class="stat-label">{{ __('Total Applications') }}</div>
        </div>
    </div>
</div>

{{-- Applications Table --}}
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-briefcase" style="color:var(--primary);"></i> {{ __('All Applications') }}</div>
    </div>

    @if($applications->isEmpty())
    <div class="card-empty" style="padding:60px 20px;">
        <i class="fa-solid fa-inbox"></i>
        <p>{{ __('No agent applications yet') }}</p>
    </div>
    @else
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:var(--gray-50);border-bottom:1px solid var(--gray-200);">
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Applicant') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Contact') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Agency / Exp') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('NIDA') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Submitted') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Status') }}</th>
                    <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-500);">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr style="border-bottom:1px solid var(--gray-100);" id="app-row-{{ $app->id }}">
                    <td style="padding:14px 16px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($app->profile_photo)
                                <img src="{{ asset('storage/' . $app->profile_photo) }}"
                                    style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid var(--gray-200);">
                            @else
                                <div style="width:40px;height:40px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:15px;flex-shrink:0;">
                                    {{ strtoupper(substr($app->full_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:700;font-size:14px;color:var(--gray-900);">{{ $app->full_name }}</div>
                                <div style="font-size:12px;color:var(--gray-500);">Account: {{ $app->user->first_name }} {{ $app->user->last_name }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:13px;color:var(--gray-800);">{{ $app->phone }}</div>
                        <div style="font-size:12px;color:var(--gray-500);">{{ $app->email }}</div>
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:13px;color:var(--gray-800);">{{ $app->agency_name ?? '—' }}</div>
                        <div style="font-size:12px;color:var(--gray-500);">{{ $app->years_experience }} yrs exp</div>
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:12px;color:var(--gray-700);font-family:monospace;">{{ $app->nida_number }}</div>
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:13px;color:var(--gray-700);">{{ $app->created_at->format('d M Y') }}</div>
                        <div style="font-size:12px;color:var(--gray-400);">{{ $app->created_at->diffForHumans() }}</div>
                    </td>
                    <td style="padding:14px 16px;">
                        @if($app->status === 'pending')
                            <span style="padding:5px 12px;background:#FEF3C7;color:#92400E;border-radius:9999px;font-size:12px;font-weight:700;">
                                <i class="fa-solid fa-clock"></i> {{ __('Pending') }}
                            </span>
                        @elseif($app->status === 'approved')
                            <span style="padding:5px 12px;background:#D1FAE5;color:#065F46;border-radius:9999px;font-size:12px;font-weight:700;">
                                <i class="fa-solid fa-circle-check"></i> {{ __('Approved') }}
                            </span>
                        @else
                            <span style="padding:5px 12px;background:#FEE2E2;color:#991B1B;border-radius:9999px;font-size:12px;font-weight:700;">
                                <i class="fa-solid fa-circle-xmark"></i> {{ __('Rejected') }}
                            </span>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">

                            {{-- View Details button --}}
                            <button type="button"
                                onclick="toggleDetails({{ $app->id }})"
                                style="padding:6px 12px;background:var(--gray-100);color:var(--gray-700);border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                <i class="fa-solid fa-eye"></i> {{ __('Details') }}
                            </button>

                            @if($app->status === 'pending')
                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.agent-applications.approve', $app->id) }}"
                                onsubmit="return confirm('Approve this application and promote {{ $app->full_name }} to Agent?')">
                                @csrf
                                <input type="hidden" name="admin_notes" value="Application approved.">
                                <button type="submit" style="padding:6px 12px;background:#059669;color:white;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                    <i class="fa-solid fa-check"></i> {{ __('Approve') }}
                                </button>
                            </form>

                            {{-- Reject button (opens inline form) --}}
                            <button type="button" onclick="toggleReject({{ $app->id }})"
                                style="padding:6px 12px;background:#DC2626;color:white;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                <i class="fa-solid fa-xmark"></i> {{ __('Reject') }}
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- Expandable Details Row --}}
                <tr id="details-{{ $app->id }}" style="display:none;background:var(--gray-50);">
                    <td colspan="7" style="padding:0 16px 20px;">
                        <div style="border:1px solid var(--gray-200);border-radius:12px;overflow:hidden;margin-top:8px;">
                            <div style="padding:16px 20px;background:white;">

                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                                    {{-- Bio --}}
                                    <div>
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:6px;">{{ __('Professional Bio') }}</div>
                                        <div style="font-size:13px;color:var(--gray-700);line-height:1.6;background:var(--gray-50);border-radius:8px;padding:12px;">{{ $app->bio }}</div>
                                    </div>
                                    {{-- Files & Notes --}}
                                    <div style="display:flex;flex-direction:column;gap:12px;">
                                        @if($app->profile_photo)
                                        <div>
                                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:6px;">{{ __('Profile Photo') }}</div>
                                            <img src="{{ asset('storage/' . $app->profile_photo) }}"
                                                style="width:90px;height:90px;object-fit:cover;border-radius:12px;border:2px solid var(--gray-200);">
                                        </div>
                                        @endif
                                        @if($app->supporting_document)
                                        <div>
                                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:6px;">{{ __('Supporting Document') }}</div>
                                            <a href="{{ asset('storage/' . $app->supporting_document) }}" target="_blank"
                                                style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--primary);color:white;border-radius:9px;font-size:12px;font-weight:600;text-decoration:none;">
                                                <i class="fa-solid fa-file-arrow-down"></i> {{ __('View Document') }}
                                            </a>
                                        </div>
                                        @endif
                                        @if($app->admin_notes && $app->status !== 'pending')
                                        <div>
                                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:6px;">{{ __('Admin Notes') }}</div>
                                            <div style="font-size:13px;color:var(--gray-700);background:var(--gray-50);border-radius:8px;padding:10px;">{{ $app->admin_notes }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Reject Inline Form --}}
                <tr id="reject-{{ $app->id }}" style="display:none;background:#FEF2F2;">
                    <td colspan="7" style="padding:16px;">
                        <form method="POST" action="{{ route('admin.agent-applications.reject', $app->id) }}"
                            style="display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;">
                            @csrf
                            <div style="flex:1;min-width:240px;">
                                <label style="font-size:12px;font-weight:700;color:#991B1B;display:block;margin-bottom:6px;">
                                    {{ __('Rejection Reason') }} <span style="color:#DC2626;">*</span>
                                </label>
                                <textarea name="admin_notes" rows="2" required
                                    placeholder="{{ __('Explain why the application is being rejected (the applicant will see this)...') }}"
                                    style="width:100%;padding:10px;border:1.5px solid #FECACA;border-radius:8px;font-size:13px;font-family:inherit;resize:vertical;box-sizing:border-box;"></textarea>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <button type="submit" style="padding:10px 18px;background:#DC2626;color:white;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;"
                                    onclick="return confirm('Reject this application?')">
                                    <i class="fa-solid fa-xmark"></i> {{ __('Confirm Reject') }}
                                </button>
                                <button type="button" onclick="toggleReject({{ $app->id }})"
                                    style="padding:10px 18px;background:var(--gray-100);color:var(--gray-700);border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($applications->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--gray-100);">
        {{ $applications->links() }}
    </div>
    @endif
    @endif
</div>

@push('scripts')
<script>
function toggleDetails(id) {
    const row = document.getElementById('details-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
function toggleReject(id) {
    const row = document.getElementById('reject-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endpush

@endsection
