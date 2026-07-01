@extends('admin.layouts.app')

@section('title', __('Users — NyumbaHub Admin'))
@section('page-title', __('Manage Users'))

@section('content')
<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Joined') }}</th>
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
            <tr><td colspan="6" class="table-empty">{{ __('No users found') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:20px;">{{ $users->links() }}</div>
@endsection
