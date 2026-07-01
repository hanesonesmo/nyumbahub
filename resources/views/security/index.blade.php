@extends('layouts.app')

@section('content')
<div class="container-1600 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="mb-4">Security & Sessions</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <!-- Active Sessions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Active Sessions</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">You are currently logged in on these devices. If you recognize any unfamiliar activity, you can log out of all other devices.</p>
                    
                    <ul class="list-group mb-4">
                        @foreach($sessions as $session)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    {{ $session->platform }} - {{ $session->browser }}
                                    @if($session->is_current_device)
                                        <span class="badge bg-success ms-2">This Device</span>
                                    @endif
                                </h6>
                                <small class="text-muted">
                                    IP: {{ $session->ip_address }} • Last Active: {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                </small>
                            </div>
                            <i class="fas fa-desktop text-muted fa-2x"></i>
                        </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('security.logout_other_devices') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Enter your current password to confirm" required>
                            <button class="btn btn-danger" type="submit">Log Out Other Devices</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Login History -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Login History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>IP Address</th>
                                    <th>Device</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loginHistory as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        @if($history->status === 'success')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($history->status === 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @elseif($history->status === 'lockout')
                                            <span class="badge bg-warning">Lockout</span>
                                        @elseif($history->status === 'logout')
                                            <span class="badge bg-secondary">Logged Out</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($history->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->ip_address }}</td>
                                    <td>
                                        <small>{{ $history->platform }} • {{ $history->browser }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent login history found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
