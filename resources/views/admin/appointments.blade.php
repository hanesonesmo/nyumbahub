<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

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
            <button type="submit" class="sidebar-link sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <h1 class="topbar-title">Appointments</h1>
        <div class="topbar-admin"><i class="fa-solid fa-shield-halved"></i> Admin</div>
    </header>

    <div class="admin-content">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2><i class="fa-solid fa-calendar"></i> All Appointments</h2>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Listing</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="table-empty">No appointments yet</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
