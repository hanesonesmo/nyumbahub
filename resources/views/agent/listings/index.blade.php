@extends('layouts.app')

@section('title', 'My Listings — NyumbaHub')

@section('content')

<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">My Listings</h1>
        <p class="dashboard-subtitle">Manage your property listings</p>
    </div>
    <a href="{{ route('agent.listings.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Add New Listing
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="dashboard-card">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
        <thead>
            <tr style="background:var(--bg);">
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Image</th>
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Title</th>
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Type</th>
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Price (TZS)</th>
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Status</th>
                <th style="padding:12px 16px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);border-bottom:1px solid var(--border);">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listings as $listing)
            <tr style="border-bottom:1px solid var(--border);">
                <td style="padding:12px 16px;">
                    @if($listing->images->first())
                        <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                            style="width:60px;height:45px;object-fit:cover;border-radius:6px;">
                    @else
                        <div style="width:60px;height:45px;background:var(--bg);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                </td>
                <td style="padding:12px 16px;font-weight:600;">{{ $listing->title }}</td>
                <td style="padding:12px 16px;">
                    <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $listing->type === 'rent' ? '#1B4332' : '#D4A853' }};color:{{ $listing->type === 'rent' ? '#fff' : '#1B4332' }};">
                        {{ ucfirst($listing->type) }}
                    </span>
                </td>
                <td style="padding:12px 16px;">{{ number_format($listing->price) }}</td>
                <td style="padding:12px 16px;">
                  @if($listing->status === 'active')
    @if($listing->type === 'sale')
        <form method="POST" action="{{ route('agent.listings.markSold', $listing->id) }}"
            onsubmit="return confirm('Mark this property as sold?')">
            @csrf
            <button type="submit"
                style="padding:5px 12px;background:#D4A853;color:#1B4332;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;">
                <i class="fa-solid fa-circle-check"></i> Mark Sold
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('agent.listings.markRented', $listing->id) }}"
            onsubmit="return confirm('Mark this property as rented?')">
            @csrf
            <button type="submit"
                style="padding:5px 12px;background:#D4A853;color:#1B4332;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;">
                <i class="fa-solid fa-circle-check"></i> Mark Rented
            </button>
        </form>
    @endif
@endif
                </td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('agent.listings.edit', $listing->id) }}"
                            style="padding:5px 12px;background:var(--primary);color:#fff;border-radius:6px;font-size:12px;text-decoration:none;font-weight:600;">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('agent.listings.destroy', $listing->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this listing?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="padding:5px 12px;background:#C0392B;color:#fff;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:48px;text-align:center;color:var(--text-muted);">
                    <i class="fa-solid fa-building-circle-xmark" style="font-size:32px;display:block;margin-bottom:12px;opacity:0.3;"></i>
                    No listings yet. <a href="{{ route('agent.listings.create') }}" style="color:var(--primary);font-weight:600;">Add your first listing</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">{{ $listings->links() }}</div>

@endsection
