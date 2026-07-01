<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorites.
     */
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()->with(['images', 'agent'])->latest('favorites.created_at')->paginate(12);
        
        return view('user.favorites', compact('favorites'));
    }

    /**
     * Toggle a listing's favorite status for the authenticated user.
     */
    public function toggle(Request $request, Listing $listing)
    {
        $user = $request->user();
        
        // Toggle the favorite status
        $user->favorites()->toggle($listing->id);
        
        $isFavorited = $user->favorites()->where('listing_id', $listing->id)->exists();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_favorited' => $isFavorited,
                'message' => $isFavorited ? __('Added to favorites') : __('Removed from favorites')
            ]);
        }
        
        return back()->with('success', $isFavorited ? __('Added to favorites') : __('Removed from favorites'));
    }

    /**
     * Intended route for guests logging in to save a favorite.
     */
    public function addFavoriteIntent(Request $request, Listing $listing)
    {
        $user = $request->user();
        
        // Add favorite if not already exists
        if (!$user->favorites()->where('listing_id', $listing->id)->exists()) {
            $user->favorites()->attach($listing->id);
        }
        
        // Redirect back to listing with success
        return redirect()->route('listings.show', $listing->slug)->with('success', __('Added to favorites'));
    }
}
