@extends('layouts.dashboard')

@section('title', 'Manage My Profile')
@section('page-title', 'Manage My Profile')
@section('page-subtitle', 'Update your personal details and agency information')

@section('content')
<style>
.profile-layout { display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 900px) {
    .profile-layout { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
</style>
<div class="content-grid" style="display: block;">
    <div class="mb-4 d-flex justify-content-end">
        <a href="{{ route('agent.dashboard') }}" class="btn-outline btn-sm"><i class="fa-solid fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}</a>
    </div>

    @if(session('success'))
        <div style="background:#ECFDF5;border:1px solid #10B981;color:#047857;padding:12px 16px;border-radius:6px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="profile-layout">
        <!-- Left Side: Avatar/Preview -->
        <div class="card" style="padding:24px;text-align:center;">
            @if($profile && $profile->profile_photo)
                <img id="profilePhotoPreview" src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ __('Profile Photo') }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #f1f5f9;margin-bottom:16px;">
            @else
                <div id="profilePhotoPlaceholder" style="width:120px;height:120px;background:#e2e8f0;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:3rem;color:#64748b;margin:0 auto 16px;">
                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                </div>
                <img id="profilePhotoPreview" src="" alt="{{ __('Profile Photo') }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #f1f5f9;margin-bottom:16px;display:none;">
            @endif
            <h3 style="margin:0 0 4px;font-size:1.2rem;">{{ $user->first_name }} {{ $user->last_name }}</h3>
            <p style="margin:0 0 16px;color:#64748b;font-size:0.9rem;">{{ $user->email }}</p>
            <div style="display:inline-block;padding:4px 10px;background:#ECFDF5;color:#059669;border-radius:20px;font-size:0.8rem;font-weight:600;">
                <i class="fa-solid fa-check-circle"></i> {{ __('Verified Agent') }}
            </div>
            <div style="margin-top:20px;border-top:1px solid #f1f5f9;padding-top:20px;">
                <a href="{{ route('agent.profile.show', $user->id) }}" class="btn-outline" style="width:100%;text-align:center;display:block;" target="_blank">
                    <i class="fa-solid fa-eye me-2"></i> {{ __('View Public Profile') }}
                </a>
            </div>
        </div>

        <!-- Right Side: Forms -->
        <div style="display:flex;flex-direction:column;gap:24px;">

            <!-- Personal Information (User Model) -->
            <div class="card" style="padding:24px;">
                <h2 style="font-size:1.1rem;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">{{ __('Personal Information') }}</h2>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('First Name') }} <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                            @error('first_name')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Last Name') }} <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                            @error('last_name')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Email Address') }} <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                            @error('email')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Phone Number') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+255..." style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                            @error('phone')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('WhatsApp Number') }}</label>
                            <input type="tel" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="+255..." style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                            @error('whatsapp')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <button type="submit" class="btn-primary" style="padding:8px 20px;font-size:0.95rem;">{{ __('Save Personal Info') }}</button>
                    </div>
                </form>
            </div>

            <!-- Professional Details (Agent Profile) -->
            <div class="card" style="padding:24px;">
                <h2 style="font-size:1.1rem;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">{{ __('Professional Details') }}</h2>
                <form action="{{ route('agent.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Agency Name (Optional)') }}</label>
                            <input type="text" name="agency_name" value="{{ old('agency_name', $profile->agency_name ?? '') }}" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Years of Experience') }} <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="years_experience" value="{{ old('years_experience', $profile->years_experience ?? 0) }}" min="0" max="50" required style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                        </div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Service Regions') }}</label>
                        <input type="text" name="service_regions" value="{{ old('service_regions', $profile->service_regions ?? '') }}" placeholder="{{ __('e.g. Dar es Salaam, Dodoma') }}" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;">
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">{{ __('Comma separated list of cities or regions you serve.') }}</div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('About You (Bio)') }}</label>
                        <textarea name="bio" rows="5" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:6px;resize:vertical;">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Update Profile Photo') }}</label>
                        <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/jpeg,image/png,image/webp" style="width:100%;padding:8px 10px;border:1px dashed #cbd5e1;border-radius:6px;" onchange="previewProfilePhoto(event)">
                        <div style="font-size:0.8rem;color:#64748b;margin-top:4px;">{{ __('Maximum size 3MB. Leave empty to keep your current photo.') }}</div>
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="btn-primary" style="padding:8px 20px;font-size:0.95rem;">{{ __('Save Professional Details') }}</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="card" style="padding:24px;">
                <h2 style="font-size:1.1rem;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">{{ __('Change Password') }}</h2>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Current Password') }}</label>
                        <div style="position: relative;">
                            <input type="password" id="agent_current_password" name="current_password" required style="width:100%;padding:10px 14px;padding-right:40px;border:1px solid #cbd5e1;border-radius:6px;box-sizing:border-box;">
                            <button type="button" onclick="togglePassword('agent_current_password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('New Password') }}</label>
                            <div style="position: relative;">
                                <input type="password" id="agent_password" name="password" required style="width:100%;padding:10px 14px;padding-right:40px;border:1px solid #cbd5e1;border-radius:6px;box-sizing:border-box;">
                                <button type="button" onclick="togglePassword('agent_password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 0;">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')<div style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label style="display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;">{{ __('Confirm New Password') }}</label>
                            <div style="position: relative;">
                                <input type="password" id="agent_password_confirmation" name="password_confirmation" required style="width:100%;padding:10px 14px;padding-right:40px;border:1px solid #cbd5e1;border-radius:6px;box-sizing:border-box;">
                                <button type="button" onclick="togglePassword('agent_password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 0;">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="btn-primary" style="padding:8px 20px;font-size:0.95rem;">{{ __('Update Password') }}</button>
                    </div>
                </form>
            </div>
            
        </div>

        
</div>
@endsection

@push('scripts')
<script>
    function previewProfilePhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profilePhotoPreview');
                const placeholder = document.getElementById('profilePhotoPlaceholder');
                
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                
                preview.src = e.target.result;
                preview.style.display = 'inline-block';
            }
            reader.readAsDataURL(file);
        }
    }
    
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
