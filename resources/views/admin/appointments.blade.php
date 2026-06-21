<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head><style>
* { margin:0;padding:0;box-sizing:border-box; }

/* Background slider */
.bg-slider { position:fixed;inset:0;z-index:0;overflow:hidden; }
.bg-slider-slide { position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.5s ease-in-out; }
.bg-slider-slide.active { opacity:0.35; }
.bg-slider-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.88),rgba(255,255,255,0.82));z-index:1; }

.admin-login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    position: relative;
    z-index: 10;
    padding: 20px;
}

.admin-login-card {
    background: rgba(255,255,255,0.97);
    border-radius: 20px;
    padding: 48px 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    border-top: 4px solid #1B4332;
    position: relative;
    z-index: 10;
    backdrop-filter: blur(10px);
}

.admin-login-icon {
    width: 56px;
    height: 56px;
    background-color: #1B4332;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #D4A853;
    margin-bottom: 20px;
}
</style>



<body>

{{-- Background slider --}}
<div class="bg-slider" id="bgSlider">
    <div class="bg-slider-slide active" style="background-image:url('{{ asset('images/themes/bg1.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg2.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg3.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg4.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/bg5.jpg') }}')"></div>
    <div class="bg-slider-slide" style="background-image:url('{{ asset('images/themes/light.jpg') }}')"></div>
    <div class="bg-slider-overlay"></div>
</div>

<aside class="sidebar">
    <div class="sidebar-brand">Nyumba<span>Hub</span><small>Admin Panel</small></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="sidebar-link"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link"><i class="fa-solid fa-building"></i> Listings</a>
        <a href="{{ route('admin.appointments') }}" class="sidebar-link active"><i class="fa-solid fa-calendar"></i> Appointments</a>
        <div class="sidebar-divider"></div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <h1 class="topbar-title">All Appointments</h1>
        <div class="topbar-admin"><i class="fa-solid fa-shield-halved"></i> Admin</div>
    </header>

    <div class="admin-content">

        {{-- Stats --}}
        <div class="admin-stats" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px;">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#1B4332;">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $appointments->total() }}</div>
                    <div class="admin-stat-label">Total</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#D4A853;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $pending }}</div>
                    <div class="admin-stat-label">Pending</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#008A05;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $confirmed }}</div>
                    <div class="admin-stat-label">Confirmed</div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Listing</th>
                        <th>Date & Time</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</div>
                            <div style="font-size:12px;color:#717171;">{{ $appointment->user->email }}</div>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $appointment->listing->title }}</div>
                            <div style="font-size:12px;color:#717171;">{{ $appointment->listing->location }}</div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}<br>
                            <span style="color:#717171;font-size:12px;">{{ $appointment->time }}</span>
                        </td>
                        <td style="max-width:150px;font-size:13px;color:#717171;">
                            {{ $appointment->message ?? '—' }}
                        </td>
                        <td>
                            <span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;
                                background:{{ $appointment->status === 'confirmed' ? '#D1FAE5' : ($appointment->status === 'cancelled' ? '#FEE2E2' : '#FEF9C3') }};
                                color:{{ $appointment->status === 'confirmed' ? '#065F46' : ($appointment->status === 'cancelled' ? '#991B1B' : '#854D0E') }};">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="table-empty">No appointments yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">{{ $appointments->links() }}</div>

    </div>
</div>
<script>
(function() {
    const slides = document.querySelectorAll('.bg-slider-slide');
    if (!slides.length) return;
    let current = 0;
    setInterval(() => {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }, 5000);
})();
</script>
</body>
</html>
