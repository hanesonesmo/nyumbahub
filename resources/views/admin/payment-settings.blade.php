@extends('admin.layouts.app')
@section('title', __('Payment Settings'))
@section('page-title', __('Payment Settings'))

@section('content')
<p class="dashboard-subtitle" style="margin-bottom:20px;">{{ __('Configure M-Pesa Booking and Reservation Fees.') }}</p>

<div class="card" style="max-width:800px;">
    <form action="{{ route('admin.payment-settings.update') }}" method="POST">
        @csrf
        


        <h3 style="margin-bottom:20px; font-weight:700;">{{ __('Property Reservation Fee') }}</h3>

        <div style="display:flex; gap:20px; margin-bottom:20px;">
            <div style="flex:1;">
                <label class="form-label">{{ __('Enable Reservation Fee') }}</label>
                <select name="reservation_fee_enabled" class="form-control">
                    <option value="1" {{ ($settings['reservation_fee_enabled'] ?? '0') == '1' ? 'selected' : '' }}>{{ __('Enabled (Users can reserve properties)') }}</option>
                    <option value="0" {{ ($settings['reservation_fee_enabled'] ?? '0') == '0' ? 'selected' : '' }}>{{ __('Disabled (No reservations allowed)') }}</option>
                </select>
            </div>
            <div style="flex:1;">
                <label class="form-label">{{ __('Reservation Fee Amount') }}</label>
                <input type="number" name="reservation_fee_amount" class="form-control" value="{{ $settings['reservation_fee_amount'] ?? 5000 }}" required>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label class="form-label">{{ __('Reservation Validity (Hours)') }}</label>
            <select name="reservation_hours_validity" class="form-control">
                <option value="24" {{ ($settings['reservation_hours_validity'] ?? '48') == '24' ? 'selected' : '' }}>24 {{ __('Hours') }}</option>
                <option value="48" {{ ($settings['reservation_hours_validity'] ?? '48') == '48' ? 'selected' : '' }}>48 {{ __('Hours') }}</option>
                <option value="72" {{ ($settings['reservation_hours_validity'] ?? '48') == '72' ? 'selected' : '' }}>72 {{ __('Hours') }}</option>
            </select>
            <p style="font-size:13px; color:var(--gray-500); margin-top:8px;">{{ __('The property will be locked for this amount of time. If no further action is taken, it will automatically unlock.') }}</p>
        </div>

        <hr style="margin:30px 0; border:none; border-top:1px solid var(--border);">

        <h3 style="margin-bottom:20px; font-weight:700;">{{ __('General Payment Settings') }}</h3>

        <div style="margin-bottom:24px; max-width:300px;">
            <label class="form-label">{{ __('Currency Code') }}</label>
            <input type="text" name="currency" class="form-control" value="{{ $settings['currency'] ?? 'KES' }}" maxlength="3" required>
        </div>

        <button type="submit" class="btn-primary">{{ __('Save Payment Settings') }}</button>
    </form>
</div>

@endsection
