@extends('layouts.app')

@section('title', 'Buyer Dashboard — NyumbaHub')

@section('content')
<div class="dashboard">

    {{-- Welcome header --}}
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="dashboard-subtitle">Find your dream property to buy in Arusha</p>
        </div>
        <a href="{{ route('listings.index') }}" class="btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i> Browse Properties
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(27,67,50,0.1);color:#1B4332;">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Saved Properties</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(212,168,83,0.1);color:#D4A853;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Viewings Booked</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(45,106,79,0.1);color:#2D6A4F;">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">0</div>
                <div class="stat-label">Offers Made</div>
            </div>
        </div>
    </div>

    {{-- Main sections --}}
    <div class="dashboard-grid">

        {{-- Saved properties --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-heart"></i> Saved Properties</h2>
                <a href="{{ route('listings.index') }}" class="card-link">Browse all</a>
            </div>
            <div class="card-empty">
                <i class="fa-solid fa-house-circle-xmark"></i>
                <p>No saved properties yet</p>
                <a href="{{ route('listings.index') }}" class="btn-outline">Find a property</a>
            </div>
        </div>

        {{-- Appointments --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-calendar"></i> Viewing Appointments</h2>
                <a href="#" class="card-link">View all</a>
            </div>
            <div class="card-empty">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p>No upcoming viewings</p>
            </div>
        </div>

    </div>

    {{-- Properties for sale --}}
    <div class="dashboard-card" style="margin-top:24px;">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-tag"></i> Properties For Sale in Arusha</h2>
            <a href="{{ route('listings.index') }}" class="card-link">See all</a>
        </div>
        <div class="card-empty">
            <i class="fa-solid fa-building-circle-xmark"></i>
            <p>Sale listings will appear here once agents add them</p>
        </div>
    </div>

</div>
@endsection
