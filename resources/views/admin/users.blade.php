<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
</head>
<body style="background:var(--gray-50);">

<div class="dashboard-wrapper">
    @include('admin.partials.sidebar', ['active' => 'users'])

    <div class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <div class="topbar-title">Manage Users</div>
                <div class="topbar-subtitle">All registered users on NyumbaHub</div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="card">
                <table class="data-table">
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
                            <td style="color:var(--gray-400);font-size:13px;">{{ $user->id }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($user->first_name,0,1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--gray-600);font-size:13px;">{{ $user->email }}</td>
                            <td style="color:var(--gray-600);font-size:13px;">{{ $user->phone ?? '—' }}</td>
                            <td><span class="badge badge-active">{{ ucfirst($user->role) }}</span></td>
                            <td style="color:var(--gray-500);font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="table-empty">No users found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:20px;">{{ $users->links() }}</div>
        </div>
    </div>
</div>

</body>
</html>
