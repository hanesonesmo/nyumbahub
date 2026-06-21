<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">

<style>
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

</head>

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
        <a href="{{ route('admin.users') }}" class="sidebar-link active"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link"><i class="fa-solid fa-building"></i> Listings</a>
        <a href="{{ route('admin.appointments') }}" class="sidebar-link"><i class="fa-solid fa-calendar"></i> Appointments</a>
        <div class="sidebar-divider"></div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <h1 class="topbar-title">Manage Users</h1>
        <div class="topbar-admin">
            <div class="theme-picker-wrap" style="position:relative">
                <button class="theme-picker-btn" id="themePickerBtn" aria-label="Choose theme">
                    <i class="fa-solid fa-sun"></i>
                </button>
                <div class="theme-picker-dropdown" id="themePickerDropdown"></div>
            </div>
            <span><i class="fa-solid fa-shield-halved"></i> Admin</span>
        </div>
    </header>

    <div class="admin-content">
        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span class="role-badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="table-empty">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px;">{{ $users->links() }}</div>
    </div>
</div>

<style>
.role-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.badge-agent { background: var(--primary); color: #fff; }
.badge-admin { background: var(--accent); color: #fff; }
.badge-tenant, .badge-buyer { background: var(--bg-soft); color: var(--text); }
</style>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>
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
