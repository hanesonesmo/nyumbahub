@extends('layouts.dashboard')

@section('title', 'My Favorites')
@section('page-title', 'My Favorites')
@section('page-subtitle', 'Properties you have saved')

@push('styles')
<style>
.favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}
.listing-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}
.listing-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-light);
}
.listing-image {
    position: relative;
    height: 200px;
}
.listing-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.listing-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 4px 10px;
    border-radius: var(--radius);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    z-index: 2;
    color: #fff;
}
.badge-rent { background: rgba(59, 130, 246, 0.9); }
.badge-sale { background: rgba(16, 185, 129, 0.9); }
.favorite-btn-card {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--error);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 2;
}
.favorite-btn-card:hover {
    transform: scale(1.1);
}
.listing-info {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.listing-title {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
    line-height: 1.3;
}
.listing-location {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.listing-price {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 16px;
}
.price-period {
    font-size: 13px;
    color: var(--text-muted);
    font-weight: 500;
}
.listing-footer {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}
.view-btn {
    display: block;
    width: 100%;
    text-align: center;
    padding: 10px;
    background: rgba(27, 67, 50, 0.05);
    color: var(--primary);
    border-radius: var(--radius);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
}
.view-btn:hover {
    background: var(--primary);
    color: #fff;
}
</style>
@endpush

@section('content')

@if($favorites->count() > 0)
    <div class="favorites-grid">
        @foreach($favorites as $listing)
            <div class="listing-card" id="favorite-card-{{ $listing->id }}">
                <div class="listing-image">
                    @if($listing->images->first())
                        <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg-soft);color:var(--border);">
                            <i class="fa-solid fa-building" style="font-size:48px;"></i>
                        </div>
                    @endif
                    <span class="listing-badge {{ $listing->type === 'rent' ? 'badge-rent' : 'badge-sale' }}">
                        {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                    </span>
                    <form action="{{ route('favorites.toggle', $listing->slug) }}" method="POST" class="favorite-form" data-id="{{ $listing->id }}">
                        @csrf
                        <button type="submit" class="favorite-btn-card" aria-label="Remove from favorites">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </form>
                </div>
                <div class="listing-info">
                    <h3 class="listing-title">{{ $listing->title }}</h3>
                    <div class="listing-location">
                        <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}, Arusha
                    </div>
                    <div class="listing-price">
                        TZS {{ number_format($listing->price) }}
                        @if($listing->type === 'rent')
                            <span class="price-period">{{ __('/month') }}</span>
                        @endif
                    </div>
                    <div class="listing-footer">
                        <a href="{{ route('listings.show', $listing->slug) }}" class="view-btn">
                            {{ __('View Property') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 32px;">
        {{ $favorites->links() }}
    </div>
@else
    <div class="empty-state" style="text-align: center; padding: 64px 20px; background: var(--surface); border: 1px dashed var(--border); border-radius: var(--radius-lg);">
        <div style="width: 80px; height: 80px; background: var(--bg-soft); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--border);">
            <i class="fa-regular fa-heart" style="font-size: 32px;"></i>
        </div>
        <h3 style="font-family: var(--font-display); font-size: 20px; color: var(--text); margin-bottom: 8px;">{{ __('No favorites yet') }}</h3>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">{{ __('You haven\'t saved any properties to your favorites.') }}</p>
        <a href="{{ route('listings.index') }}" class="btn-primary" style="display: inline-flex; width: auto; padding: 0 24px;">
            <i class="fa-solid fa-magnifying-glass"></i> {{ __('Browse Properties') }}
        </a>
    </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.favorite-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const listingId = this.dataset.id;
            const btn = this.querySelector('button');
            const icon = btn.querySelector('i');
            
            // Optimistic UI update
            const card = document.getElementById('favorite-card-' + listingId);
            card.style.opacity = '0.5';
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || this.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && !data.is_favorited) {
                    // Removed from favorites
                    card.remove();
                    
                    // Check if empty
                    if (document.querySelectorAll('.listing-card').length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                card.style.opacity = '1';
                alert('An error occurred. Please try again.');
            });
        });
    });
});
</script>
@endpush
