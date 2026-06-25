<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['label'] }} — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <style>
        body { background:var(--gray-50); }
        @media print {
            .no-print { display:none !important; }
            .dashboard-wrapper { display:block; }
            .dashboard-main { margin-left:0 !important; }
            .dashboard-topbar { display:none; }
            body { background:white; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="no-print">
        @include('admin.partials.sidebar', ['active' => 'reports'])
    </div>

    <div class="dashboard-main">
        <header class="dashboard-topbar no-print">
            <div>
                <div class="topbar-title">{{ $data['label'] }}</div>
                <div class="topbar-subtitle">Generated on {{ now()->format('d M Y H:i') }}</div>
            </div>
            <div class="topbar-right">
                <button onclick="window.print()" class="btn-outline btn-sm">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <form method="POST" action="{{ route('admin.reports.generate') }}" style="display:inline;" class="no-print">
                    @csrf
                    <input type="hidden" name="type" value="{{ $data['type'] }}">
                    <input type="hidden" name="format" value="csv">
                    @if($data['type'] === 'custom')
                        <input type="hidden" name="start_date" value="{{ $data['start']->format('Y-m-d') }}">
                        <input type="hidden" name="end_date" value="{{ $data['end']->format('Y-m-d') }}">
                    @endif
                    <button type="submit" class="btn-primary btn-sm">
                        <i class="fa-solid fa-download"></i> Download CSV
                    </button>
                </form>
                <a href="{{ route('admin.reports') }}" class="btn-outline btn-sm no-print">
                    <i class="fa-solid fa-arrow-left"></i> New Report
                </a>
            </div>
        </header>

        <div class="dashboard-content">

            {{-- Report header --}}
            <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:16px;padding:28px 32px;margin-bottom:24px;color:white;">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                    <div>
                        <div style="font-size:12px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">NyumbaHub System Report</div>
                        <h1 style="font-family:var(--font-display);font-size:24px;font-weight:700;margin-bottom:4px;">{{ $data['label'] }}</h1>
                        <div style="font-size:13px;color:rgba(255,255,255,0.65);">
                            {{ $data['start']->format('d M Y') }} — {{ $data['end']->format('d M Y') }}
                        </div>
                    </div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.5);">
                        Generated {{ now()->format('d M Y \a\t H:i') }}
                    </div>
                </div>
            </div>

            {{-- Stats summary --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

                {{-- Users card --}}
                <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:24px;box-shadow:var(--shadow-xs);">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:#EFF6FF;display:flex;align-items:center;justify-content:center;font-size:18px;color:#2563EB;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div style="font-size:15px;font-weight:700;color:var(--gray-900);">Users</div>
                    </div>
                    @foreach([
                        ['New Users', $data['new_users']],
                        ['New Agents', $data['new_agents']],
                        ['New Tenants', $data['new_tenants']],
                        ['New Buyers', $data['new_buyers']],
                        ['Total Users', $data['total_users']],
                    ] as [$label, $value])
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--gray-100);">
                        <span style="font-size:13px;color:var(--gray-600);">{{ $label }}</span>
                        <span style="font-size:14px;font-weight:700;color:var(--gray-900);">{{ number_format($value) }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Listings card --}}
                <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:24px;box-shadow:var(--shadow-xs);">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:#ECFDF5;display:flex;align-items:center;justify-content:center;font-size:18px;color:#059669;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div style="font-size:15px;font-weight:700;color:var(--gray-900);">Listings</div>
                    </div>
                    @foreach([
                        ['New Listings', $data['new_listings']],
                        ['Approved', $data['approved_listings']],
                        ['Rejected', $data['rejected_listings']],
                        ['Sold', $data['sold_listings']],
                        ['Rented', $data['rented_listings']],
                        ['Total Active', $data['total_active']],
                    ] as [$label, $value])
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--gray-100);">
                        <span style="font-size:13px;color:var(--gray-600);">{{ $label }}</span>
                        <span style="font-size:14px;font-weight:700;color:var(--gray-900);">{{ number_format($value) }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Appointments card --}}
                <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:24px;box-shadow:var(--shadow-xs);">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:#FFFBEB;display:flex;align-items:center;justify-content:center;font-size:18px;color:#D97706;">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <div style="font-size:15px;font-weight:700;color:var(--gray-900);">Appointments</div>
                    </div>
                    @foreach([
                        ['New Bookings', $data['new_appointments']],
                        ['Confirmed', $data['confirmed_appointments']],
                        ['Cancelled', $data['cancelled_appointments']],
                        ['For Rent', $data['rent_count']],
                        ['For Sale', $data['sale_count']],
                    ] as [$label, $value])
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--gray-100);">
                        <span style="font-size:13px;color:var(--gray-600);">{{ $label }}</span>
                        <span style="font-size:14px;font-weight:700;color:var(--gray-900);">{{ number_format($value) }}</span>
                    </div>
                    @endforeach
                </div>

            </div>

            {{-- Recent Listings --}}
            @if($data['recent_listings']->count() > 0)
            <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;margin-bottom:20px;overflow:hidden;box-shadow:var(--shadow-xs);">
                <div style="padding:16px 20px;border-bottom:1px solid var(--gray-100);background:var(--gray-50);">
                    <h2 style="font-size:15px;font-weight:700;color:var(--gray-900);display:flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-building" style="color:var(--primary);"></i>
                        New Listings in This Period
                    </h2>
                </div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Agent</th>
                                <th>Type</th>
                                <th>Price (TZS)</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_listings'] as $listing)
                            <tr>
                                <td style="font-weight:600;font-size:13px;">{{ $listing->title }}</td>
                                <td style="font-size:13px;">{{ $listing->agent->first_name ?? '—' }} {{ $listing->agent->last_name ?? '' }}</td>
                                <td><span class="badge badge-{{ $listing->type === 'rent' ? 'active' : 'pending' }}">{{ ucfirst($listing->type) }}</span></td>
                                <td style="font-size:13px;font-weight:600;">{{ number_format($listing->price) }}</td>
                                <td style="font-size:13px;color:var(--gray-600);">{{ $listing->location }}</td>
                                <td><span class="badge badge-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span></td>
                                <td style="font-size:12px;color:var(--gray-500);">{{ $listing->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Recent Users --}}
            @if($data['recent_users']->count() > 0)
            <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:var(--shadow-xs);">
                <div style="padding:16px 20px;border-bottom:1px solid var(--gray-100);background:var(--gray-50);">
                    <h2 style="font-size:15px;font-weight:700;color:var(--gray-900);display:flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-users" style="color:var(--primary);"></i>
                        New Users in This Period
                    </h2>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['recent_users'] as $user)
                        <tr>
                            <td style="font-weight:600;font-size:13px;">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td style="font-size:13px;color:var(--gray-600);">{{ $user->email }}</td>
                            <td><span class="badge badge-active">{{ ucfirst($user->role) }}</span></td>
                            <td style="font-size:12px;color:var(--gray-500);">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
