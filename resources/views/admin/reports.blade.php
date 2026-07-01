@extends('admin.layouts.app')

@section('title', __('Reports — NyumbaHub Admin'))
@section('page-title', __('System Reports'))

@push('styles')
<style>
    .report-card { background:white; border:1px solid var(--gray-200); border-radius:20px; padding:32px; margin-bottom:20px; box-shadow:var(--shadow-xs); }
    .type-option { border:2px solid var(--gray-200); border-radius:14px; padding:20px; cursor:pointer; transition:all 0.2s; text-align:center; }
    .type-option:hover { border-color:var(--primary); background:var(--primary-50); }
    .type-option input[type="radio"] { display:none; }
    .type-option.selected { border-color:var(--primary); background:rgba(27,67,50,0.06); }
    .type-option .type-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; margin:0 auto 12px; }
    #customDates { display:none; }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('admin.reports.generate') }}">
    @csrf

    {{-- Report Type --}}
    <div class="report-card">
        <h2 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-calendar" style="color:var(--primary);"></i>
            {{ __('Select Report Period') }}
        </h2>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px;">

            <label class="type-option selected" id="opt-weekly" onclick="selectType('weekly')">
                <input type="radio" name="type" value="weekly" checked>
                <div class="type-icon" style="background:#EFF6FF;color:#2563EB;">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <div style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">{{ __('Weekly') }}</div>
                <div style="font-size:12px;color:var(--gray-500);">{{ __('This week\'s activity') }}</div>
            </label>

            <label class="type-option" id="opt-monthly" onclick="selectType('monthly')">
                <input type="radio" name="type" value="monthly">
                <div class="type-icon" style="background:#ECFDF5;color:#059669;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">{{ __('Monthly') }}</div>
                <div style="font-size:12px;color:var(--gray-500);">{{ __('This month\'s activity') }}</div>
            </label>

            <label class="type-option" id="opt-custom" onclick="selectType('custom')">
                <input type="radio" name="type" value="custom">
                <div class="type-icon" style="background:#FFFBEB;color:#D97706;">
                    <i class="fa-solid fa-calendar-range"></i>
                </div>
                <div style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">{{ __('Custom Range') }}</div>
                <div style="font-size:12px;color:var(--gray-500);">{{ __('Pick your own dates') }}</div>
            </label>

        </div>

        {{-- Custom date inputs --}}
        <div id="customDates">
            <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:500px;">
                <div class="field">
                    <label>{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" value="{{ date('Y-m-01') }}">
                </div>
                <div class="field">
                    <label>{{ __('End Date') }}</label>
                    <input type="date" name="end_date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- Output Format --}}
    <div class="report-card">
        <h2 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-file-export" style="color:var(--primary);"></i>
            {{ __('Output Format') }}
        </h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:400px;">
            <label style="border:2px solid var(--primary);border-radius:12px;padding:16px;cursor:pointer;text-align:center;background:rgba(27,67,50,0.04);">
                <input type="radio" name="format" value="view" checked style="display:none;">
                <i class="fa-solid fa-eye" style="font-size:20px;color:var(--primary);margin-bottom:8px;display:block;"></i>
                <div style="font-size:14px;font-weight:700;color:var(--gray-900);">{{ __('View Online') }}</div>
                <div style="font-size:11px;color:var(--gray-500);margin-top:2px;">{{ __('View in browser') }}</div>
            </label>
            <label style="border:2px solid var(--gray-200);border-radius:12px;padding:16px;cursor:pointer;text-align:center;" onclick="this.style.borderColor='var(--primary)';this.parentElement.querySelector('[value=view]').parentElement.style.borderColor='var(--gray-200)'">
                <input type="radio" name="format" value="csv" style="display:none;">
                <i class="fa-solid fa-file-csv" style="font-size:20px;color:#059669;margin-bottom:8px;display:block;"></i>
                <div style="font-size:14px;font-weight:700;color:var(--gray-900);">{{ __('Download CSV') }}</div>
                <div style="font-size:11px;color:var(--gray-500);margin-top:2px;">{{ __('Export spreadsheet') }}</div>
            </label>
        </div>
    </div>

    {{-- Submit --}}
    <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-primary" style="padding:14px 32px;font-size:15px;">
            <i class="fa-solid fa-chart-bar"></i> {{ __('Generate Report') }}
        </button>
    </div>

</form>
@endsection

@push('scripts')
<script>
function selectType(type) {
    ['weekly','monthly','custom'].forEach(t => {
        document.getElementById('opt-' + t).classList.remove('selected');
    });
    document.getElementById('opt-' + type).classList.add('selected');
    document.getElementById('customDates').style.display = type === 'custom' ? 'block' : 'none';
}
</script>
@endpush
