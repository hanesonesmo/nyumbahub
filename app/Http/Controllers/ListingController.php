<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Public listings page — no login required
    public function index(Request $request)
    {
        $query = Listing::with(['agent', 'images'])->active();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Price filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Bedrooms filter
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Sort
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $listings = $query->paginate(12);

        return view('listings.index', compact('listings'));
    }

    // Single listing detail
    public function show(Listing $listing)
    {
        // Load relationships
        $listing->load(['agent', 'images']);

        // Only show active, sold, or rented
        if (!in_array($listing->status, ['active', 'sold', 'rented', 'reserved'])) {
            abort(404);
        }

        return view('listings.show', compact('listing'));
    }

    public function showReserveForm($listingId)
    {
        $listing = Listing::active()->findOrFail($listingId);
        
        $feeEnabled = \App\Models\Setting::get('reservation_fee_enabled', false);
        if (!$feeEnabled) {
            return back()->with('error', __('Reservations are currently disabled.'));
        }

        return view('listings.reserve', compact('listing'));
    }

    public function processReserve(Request $request, $listingId, \App\Services\MpesaService $mpesaService)
    {
        $listing = Listing::active()->findOrFail($listingId);

        $feeEnabled = \App\Models\Setting::get('reservation_fee_enabled', false);
        $feeAmount = $listing->price * 0.05; // 5% of the listing price

        if (!$feeEnabled || $feeAmount <= 0) {
            return back()->with('error', __('Reservations are currently disabled.'));
        }

        $request->validate([
            'phone_number' => ['required', 'string'],
        ]);

        $response = $mpesaService->stkPush(
            $request->phone_number, 
            $feeAmount, 
            'NH-RESV-' . $listing->id, 
            'Property Reservation'
        );

        if (isset($response['error']) || !isset($response['CheckoutRequestID'])) {
            return back()->withErrors(['phone_number' => 'Payment initiation failed: ' . ($response['message'] ?? 'Unknown error')])->withInput();
        }

        \App\Models\PaymentTransaction::create([
            'transaction_id' => $response['CheckoutRequestID'],
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'agent_id' => $listing->agent_id,
            'listing_id' => $listing->id,
            'type' => 'reservation',
            'amount' => $feeAmount,
            'currency' => \App\Models\Setting::get('currency', 'KES'),
            'phone_number' => $request->phone_number,
            'status' => 'pending'
        ]);

        return redirect()->route('listings.show', $listing->slug)
            ->with('success', __('Please check your phone for the M-Pesa prompt to complete the reservation payment. Once paid, the property will be locked for you!'));
    }
}
