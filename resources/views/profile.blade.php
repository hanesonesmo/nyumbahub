@extends('layouts.app')

@section('title', 'My Profile — NyumbaHub')

@section('content')

<div style="max-width:700px;margin:0 auto;">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">My Profile</h1>
            <p class="dashboard-subtitle">Manage your account information</p>
        </div>
    </div>

    {{-- Profile info --}}
    <div class="dashboard-card" style="margin-bottom:24px;">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-user"></i> Personal Information</h2>
        </div>
        <div style="padding:24px;">

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:20px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Avatar --}}
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;padding-bottom:24px;border-bottom:1px solid var(--border-light,#EBEBEB);">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--primary,#1B4332);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:20px;font-weight:700;color:var(--text,#222);">{{ $user->first_name }} {{ $user->last_name }}</div>
                    <div style="font-size:14px;color:var(--text-muted,#717171);margin-top:2px;">{{ $user->email }}</div>
                    <span style="display:inline-block;margin-top:6px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(27,67,50,0.1);color:var(--primary,#1B4332);text-transform:uppercase;">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="field">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                        @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                        @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="field">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="field">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+255 7XX XXX XXX">
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>WhatsApp Number</label>
                        <input type="tel" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="+255 7XX XXX XXX">
                        @error('whatsapp') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    {{-- Change password --}}
    <div class="dashboard-card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-lock"></i> Change Password</h2>
        </div>
        <div style="padding:24px;">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label>Current Password</label>
                    <input type="password" name="current_password" placeholder="Enter current password" required>
                    @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" required>
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat new password" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-key"></i> Update Password
                </button>
            </form>
        </div>
    </div>

</div>

@endsection
