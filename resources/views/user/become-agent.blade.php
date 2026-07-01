@extends('layouts.dashboard')

@section('title', 'Become an Agent')
@section('page-title', 'Become an Agent')
@section('page-subtitle', 'Join our verified agent network and start listing properties')

@section('content')

@php $user = auth()->user(); @endphp

{{-- ── Already an agent ── --}}
@if($user->role === 'agent')
<div style="max-width:640px;margin:0 auto;text-align:center;padding:60px 20px;">
    <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary),#2D6A4F);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
        <i class="fa-solid fa-shield-halved" style="color:white;font-size:36px;"></i>
    </div>
    <h2 style="font-size:26px;font-weight:800;color:var(--gray-900);margin-bottom:10px;">{{ __('You\'re a Verified Agent') }}</h2>
    <p style="font-size:15px;color:var(--gray-500);margin-bottom:28px;">{{ __('You already have full access to the Agent Dashboard, listings management, and appointment tools.') }}</p>
    <a href="{{ route('agent.dashboard') }}" class="btn-primary" style="padding:12px 32px;font-size:15px;">
        <i class="fa-solid fa-gauge"></i> {{ __('Go to Agent Dashboard') }}
    </a>
</div>

{{-- ── Pending application ── --}}
@elseif($application && $application->isPending())
<div style="max-width:640px;margin:0 auto;">
    <div style="background:linear-gradient(135deg,#FFFBEB,#FEF3C7);border:2px solid #F59E0B;border-radius:20px;padding:36px;text-align:center;margin-bottom:24px;">
        <div style="width:70px;height:70px;background:#F59E0B;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="fa-solid fa-hourglass-half" style="color:white;font-size:28px;"></i>
        </div>
        <h2 style="font-size:22px;font-weight:800;color:#92400E;margin-bottom:8px;">{{ __('Application Under Review') }}</h2>
        <p style="font-size:14px;color:#B45309;margin-bottom:16px;">{{ __('Your application was submitted on') }} <strong>{{ $application->created_at->format('d M Y \a\t H:i') }}</strong>{{ __('. Our team typically reviews applications within 24–48 hours.') }}</p>
        <div style="display:inline-flex;align-items:center;gap:8px;background:#F59E0B;color:white;padding:8px 20px;border-radius:9999px;font-size:13px;font-weight:700;">
            <i class="fa-solid fa-clock"></i> {{ __('Pending Review') }}
        </div>
    </div>

    {{-- Application summary --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __('Your Submission Details') }}</div>
        </div>
        <div style="padding:20px;display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            @foreach([
                ['Full Name', $application->full_name],
                ['Phone', $application->phone],
                ['Email', $application->email],
                ['NIDA Number', $application->nida_number],
                ['Agency', $application->agency_name ?? '—'],
                ['Experience', $application->years_experience . ' years'],
            ] as [$label, $value])
            <div style="background:var(--gray-50);border-radius:10px;padding:12px 14px;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:4px;">{{ $label }}</div>
                <div style="font-size:14px;font-weight:600;color:var(--gray-800);">{{ $value }}</div>
            </div>
            @endforeach
        </div>
        @if($application->profile_photo)
        <div style="padding:0 20px 20px;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--gray-400);margin-bottom:8px;">{{ __('Profile Photo') }}</div>
            <img src="{{ asset('storage/' . $application->profile_photo) }}"
                style="width:80px;height:80px;object-fit:cover;border-radius:12px;border:2px solid var(--gray-200);">
        </div>
        @endif
    </div>
</div>

{{-- ── Application form (new or re-apply after rejection) ── --}}
@else

@if($application && $application->isRejected())
<div style="background:#FEF2F2;border:1.5px solid #FECACA;border-radius:14px;padding:18px 22px;margin-bottom:28px;max-width:760px;">
    <div style="display:flex;align-items:flex-start;gap:14px;">
        <i class="fa-solid fa-circle-exclamation" style="color:#DC2626;font-size:20px;margin-top:2px;"></i>
        <div>
            <div style="font-weight:700;font-size:14px;color:#991B1B;margin-bottom:4px;">{{ __('Previous Application Rejected') }}</div>
            <div style="font-size:13px;color:#7F1D1D;"><strong>{{ __('Reason:') }}</strong> {{ $application->admin_notes }}</div>
            <div style="font-size:12px;color:#B91C1C;margin-top:6px;">{{ __('Please address the feedback and submit a new application below.') }}</div>
        </div>
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 320px;gap:28px;max-width:1100px;align-items:start;">

    {{-- Form --}}
    <div class="card">
        <div style="padding:28px 28px 0;">
            <h2 style="font-size:20px;font-weight:800;color:var(--gray-900);margin-bottom:4px;">{{ __('Agent Application Form') }}</h2>
            <p style="font-size:14px;color:var(--gray-500);margin-bottom:0;">{{ __('Complete all required fields. We\'ll review your application and respond within 24–48 hours.') }}</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-error" style="margin:20px 28px 0;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul style="margin:4px 0 0 16px;padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('become.agent.store') }}" enctype="multipart/form-data" style="padding:24px 28px 28px;">
            @csrf

            {{-- Personal Info --}}
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--primary);margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--gray-100);">
                {{ __('Personal Information') }}
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="full_name">{{ __('Full Name') }} <span class="required">*</span></label>
                    <input type="text" id="full_name" name="full_name"
                        value="{{ old('full_name', $user->first_name . ' ' . $user->last_name) }}"
                        class="{{ $errors->has('full_name') ? 'is-invalid' : '' }}" required>
                    @error('full_name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="phone">{{ __('Phone Number') }} <span class="required">*</span></label>
                    <input type="text" id="phone" name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="{{ __('+255 7XX XXX XXX') }}"
                        class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" required>
                    @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="email">{{ __('Email Address') }} <span class="required">*</span></label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="nida_number">{{ __('NIDA / National ID Number') }} <span class="required">*</span></label>
                    <input type="text" id="nida_number" name="nida_number"
                        value="{{ old('nida_number') }}"
                        placeholder="{{ __('e.g. 19870101-12345-00001-7') }}"
                        class="{{ $errors->has('nida_number') ? 'is-invalid' : '' }}" required>
                    @error('nida_number') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Professional Info --}}
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--primary);margin:20px 0 14px;padding-bottom:8px;border-bottom:1px solid var(--gray-100);">
                {{ __('Professional Information') }}
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="agency_name">{{ __('Agency Name') }} <span style="color:var(--gray-400);font-weight:400;">{{ __('(Optional)') }}</span></label>
                    <input type="text" id="agency_name" name="agency_name"
                        value="{{ old('agency_name') }}"
                        placeholder="{{ __('e.g. Kilimanjaro Realty') }}"
                        class="{{ $errors->has('agency_name') ? 'is-invalid' : '' }}">
                    @error('agency_name') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="years_experience">{{ __('Years of Experience') }} <span class="required">*</span></label>
                    <input type="number" id="years_experience" name="years_experience"
                        value="{{ old('years_experience', 0) }}"
                        min="0" max="50"
                        class="{{ $errors->has('years_experience') ? 'is-invalid' : '' }}" required>
                    @error('years_experience') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="field">
                <label for="bio">{{ __('Professional Biography') }} <span class="required">*</span></label>
                <textarea id="bio" name="bio" rows="5"
                    placeholder="{{ __('Describe your real estate experience, specialties, areas you cover, and why you want to join NyumbaHub. Minimum 50 characters.') }}"
                    class="{{ $errors->has('bio') ? 'is-invalid' : '' }}" required>{{ old('bio') }}</textarea>
                <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">{{ __('Minimum 50 characters. Be specific about your experience and expertise.') }}</div>
                @error('bio') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            {{-- File Uploads --}}
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--primary);margin:20px 0 14px;padding-bottom:8px;border-bottom:1px solid var(--gray-100);">
                {{ __('Documents & Photo') }}
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="profile_photo">{{ __('Profile Photo') }} <span style="color:var(--gray-400);font-weight:400;">{{ __('(Optional)') }}</span></label>
                    <input type="file" id="profile_photo" name="profile_photo"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        class="{{ $errors->has('profile_photo') ? 'is-invalid' : '' }}"
                        style="padding:8px;">
                    <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">{{ __('JPG, PNG or WebP · Max 3MB') }}</div>
                    @error('profile_photo') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="supporting_document">{{ __('Supporting Document') }} <span style="color:var(--gray-400);font-weight:400;">{{ __('(Optional)') }}</span></label>
                    <input type="file" id="supporting_document" name="supporting_document"
                        accept=".pdf,image/jpeg,image/jpg,image/png"
                        class="{{ $errors->has('supporting_document') ? 'is-invalid' : '' }}"
                        style="padding:8px;">
                    <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">{{ __('License, certificate or ID copy · PDF or image · Max 5MB') }}</div>
                    @error('supporting_document') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:50px;font-size:15px;margin-top:8px;">
                <i class="fa-solid fa-paper-plane"></i> {{ __('Submit Application') }}
            </button>
        </form>
    </div>

    {{-- Sidebar Info --}}
    <div style="display:flex;flex-direction:column;gap:18px;position:sticky;top:24px;">
        <div style="background:linear-gradient(135deg,var(--primary),#2D6A4F);border-radius:16px;padding:24px;color:white;">
            <div style="font-size:16px;font-weight:800;margin-bottom:14px;">{{ __('Why become an Agent?') }}</div>
            @foreach([
                ['fa-building-circle-check','List unlimited properties'],
                ['fa-calendar-check','Manage appointments & viewings'],
                ['fa-chart-line','Track your earnings & analytics'],
                ['fa-shield-halved','Get a Verified Agent badge'],
                ['fa-bell','Real-time booking notifications'],
            ] as [$icon, $text])
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:28px;height:28px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid {{ $icon }}" style="font-size:12px;"></i>
                </div>
                <span style="font-size:13px;opacity:0.9;">{{ $text }}</span>
            </div>
            @endforeach
        </div>

        <div class="card">
            <div style="padding:20px;">
                <div style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:10px;"><i class="fa-solid fa-circle-info" style="color:var(--primary);"></i> {{ __('Review Process') }}</div>
                <ol style="font-size:13px;color:var(--gray-600);padding-left:18px;line-height:1.8;">
                    <li>{{ __('Submit your application') }}</li>
                    <li>{{ __('Admin reviews within 24–48 hrs') }}</li>
                    <li>{{ __('Receive email notification') }}</li>
                    <li>{{ __('Access Agent Dashboard immediately upon approval') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endif

@endsection
