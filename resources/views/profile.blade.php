@extends('layouts.dashboard')

@section('title', __('My Profile'))
@section('page-title', __('Profile Settings'))
@section('page-subtitle', __('Manage your account information and security'))

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    {{-- Profile Header Card --}}
    <div class="profile-header-card">
        <div class="profile-cover" style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
            <div class="profile-cover-overlay"></div>
        </div>
        <div class="profile-info-row">
            <div style="display: flex; align-items: flex-end;">
                <div class="profile-avatar-large">
                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                </div>
                <div class="profile-title" style="margin-left: 24px; padding-bottom: 8px;">
                    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <p>{{ $user->email }} • <span style="text-transform: uppercase; font-weight: 700; color: var(--dash-primary);">{{ $user->role }}</span></p>
                </div>
            </div>
            <div>
                <span class="timeline-badge bg-success" style="font-size: 13px; padding: 6px 16px;">
                    <i class="fa-solid fa-check-circle" style="margin-right: 4px;"></i> {{ __('Active Account') }}
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); color: var(--dash-success); padding: 16px 24px; border-radius: var(--dash-radius-sm); margin-bottom: 24px; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
        
        {{-- Personal Information Form --}}
        <div class="premium-panel">
            <div class="panel-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--dash-border);">
                <h2 class="panel-title"><i class="fa-solid fa-user" style="color: var(--dash-primary); margin-right: 8px;"></i> {{ __('Personal Information') }}</h2>
            </div>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="premium-form-group">
                        <label class="premium-label">{{ __('First Name') }}</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="premium-input" required>
                        @error('first_name') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="premium-form-group">
                        <label class="premium-label">{{ __('Last Name') }}</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="premium-input" required>
                        @error('last_name') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="premium-form-group">
                    <label class="premium-label">{{ __('Email Address') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="premium-input" required>
                    @error('email') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>

                <div class="premium-form-group">
                    <label class="premium-label">{{ __('Phone Number') }}</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="premium-input" placeholder="{{ __('+255 7XX XXX XXX') }}">
                    @error('phone') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
                
                <div class="premium-form-group">
                    <label class="premium-label">{{ __('WhatsApp Number') }}</label>
                    <input type="tel" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="premium-input" placeholder="{{ __('+255 7XX XXX XXX') }}">
                    @error('whatsapp') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="premium-btn" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-floppy-disk"></i> {{ __('Save Changes') }}
                </button>
            </form>
        </div>

        {{-- Security / Password --}}
        <div>
            <div class="premium-panel" style="margin-bottom: 32px;">
                <div class="panel-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--dash-border);">
                    <h2 class="panel-title"><i class="fa-solid fa-lock" style="color: var(--dash-primary); margin-right: 8px;"></i> {{ __('Security & Password') }}</h2>
                </div>
                
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="premium-form-group">
                        <label class="premium-label">{{ __('Current Password') }}</label>
                        <div style="position: relative;">
                            <input type="password" id="current_password" name="current_password" class="premium-input" placeholder="{{ __('Enter current password') }}" style="padding-right: 40px; width: 100%; box-sizing: border-box;" required>
                            <button type="button" onclick="togglePassword('current_password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="premium-form-group">
                        <label class="premium-label">{{ __('New Password') }}</label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" class="premium-input" placeholder="{{ __('Min. 8 characters') }}" style="padding-right: 40px; width: 100%; box-sizing: border-box;" required>
                            <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <div style="color: var(--dash-danger); font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="premium-form-group">
                        <label class="premium-label">{{ __('Confirm New Password') }}</label>
                        <div style="position: relative;">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="premium-input" placeholder="{{ __('Repeat new password') }}" style="padding-right: 40px; width: 100%; box-sizing: border-box;" required>
                            <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="premium-btn" style="width: 100%; justify-content: center; background: var(--dash-text);">
                        <i class="fa-solid fa-key"></i> {{ __('Update Password') }}
                    </button>
                </form>
            </div>

            <div class="premium-panel" style="border-color: rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.02);">
                <div class="panel-header" style="margin-bottom: 16px;">
                    <h2 class="panel-title" style="color: var(--dash-danger);"><i class="fa-solid fa-triangle-exclamation"></i> {{ __('Danger Zone') }}</h2>
                </div>
                <p style="color: var(--dash-text-muted); font-size: 14px; margin-bottom: 24px; line-height: 1.6;">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
                <button type="button" onclick="document.getElementById('deleteAccountModal').style.display='flex'" class="premium-btn" style="background: var(--dash-danger); color: white;">
                    <i class="fa-solid fa-trash"></i> {{ __('Delete Account') }}
                </button>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection
