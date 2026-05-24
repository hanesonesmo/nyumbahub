@extends('layouts.app')

@section('title', 'Agent Dashboard — NyumbaHub')

@section('content')
<div class="dashboard">

    {{-- Welcome header --}}
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="dashboard-subtitle">Manage your listings and appointments</p>
        </div>
        <a href="{{ route('agent.listings.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Listing
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(27,67,50,0.1);color:#1B4332;">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">My Listings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(212,168,83,0.1);color:#D4A853;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Appointments</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(45,106,79,0.1);color:#2D6A4F;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(192,57,43,0.1);color:#C0392B;">
                <i class="fa-solid fa-circle-dot"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Active Listings</div>
            </div>
        </div>
    </div>

    {{-- Main sections --}}
    <div class="dashboard-grid">

        {{-- My listings --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-building"></i> My Listings</h2>
                <a href="{{ route('agent.listings.create') }}" class="card-link">
                    <i class="fa-solid fa-plus"></i> Add new
                </a>
            </div>
            <div class="card-empty">
                <i class="fa-solid fa-building-circle-xmark"></i>
                <p>No listings yet</p>
                <a href="{{ route('agent.listings.create') }}" class="btn-outline">Add your first listing</a>
            </div>
        </div>

        {{-- Upcoming appointments --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-calendar"></i> Upcoming Appointments</h2>
                <a href="#" class="card-link">View all</a>
            </div>
            <div class="card-empty">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p>No upcoming appointments</p>
            </div>
        </div>

    </div>

    {{-- Recent activity --}}
    <div class="dashboard-card" style="margin-top:24px;">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-clock-rotate-left"></i> Recent Activity</h2>
        </div>
        <div class="card-empty">
            <i class="fa-solid fa-inbox"></i>
            <p>No recent activity</p>
        </div>
    </div>

</div>
@endsection
