@extends('layouts.app')

@section('title', 'Our Services — NyumbaHub')

@section('content')
<div class="page-header" style="background: var(--bg-soft); padding: 60px 20px; text-align: center; border-bottom: 1px solid var(--border);">
    <h1 style="font-family: var(--font-display); font-size: 36px; color: var(--text); margin-bottom: 16px;">Our Services</h1>
    <p style="color: var(--text-muted); font-size: 16px; max-width: 600px; margin: 0 auto;">Discover how NyumbaHub can help you find your dream home or grow your real estate business in Arusha.</p>
</div>

<div class="container" style="max-width: 1100px; margin: 0 auto; padding: 60px 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
        
        <div style="background: var(--surface); padding: 32px; border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(212, 168, 83, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 24px;">
                <i class="fa-solid fa-house-user"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text);">Property Search</h3>
            <p style="color: var(--text-muted); line-height: 1.6;">Browse hundreds of verified listings across Arusha. Filter by location, price, and property type to find exactly what you're looking for.</p>
        </div>

        <div style="background: var(--surface); padding: 32px; border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(27, 67, 50, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 24px;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text);">Direct Viewings</h3>
            <p style="color: var(--text-muted); line-height: 1.6;">Book property viewings directly through our platform. Choose a date and time that works for you and meet the agent on-site.</p>
        </div>

        <div style="background: var(--surface); padding: 32px; border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #3B82F6; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 24px;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--text);">Agent Portal</h3>
            <p style="color: var(--text-muted); line-height: 1.6;">Are you a real estate agent? List your properties, manage bookings, and reach thousands of potential clients in Arusha.</p>
        </div>

    </div>
</div>
@endsection
