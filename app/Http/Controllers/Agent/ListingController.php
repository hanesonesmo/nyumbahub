<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    // Show all agent's listings
    public function index()
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('agent.listings.index', compact('listings'));
    }

    // Show create form
    public function create()
    {
        return view('agent.listings.create');
    }

    // Store new listing
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:20'],
            'type'        => ['required', 'in:rent,sale'],
            'category'    => ['required', 'in:apartment,house,villa,land,commercial'],
            'price'       => ['required', 'numeric', 'min:1'],
            'location'    => ['required', 'string', 'max:100'],
            'address'     => ['nullable', 'string', 'max:200'],
            'bedrooms'    => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms'   => ['nullable', 'integer', 'min:0', 'max:20'],
            'area'        => ['nullable', 'numeric', 'min:1'],
            'images'      => ['required', 'array', 'min:1', 'max:5'],
            'images.*'    => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'], // 2MB per image
        ]);

        // Create listing
        $listing = Listing::create([
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'type'        => $validated['type'],
            'category'    => $validated['category'],
            'price'       => $validated['price'],
            'location'    => $validated['location'],
            'address'     => $validated['address'] ?? null,
            'bedrooms'    => $validated['bedrooms'] ?? null,
            'bathrooms'   => $validated['bathrooms'] ?? null,
            'area'        => $validated['area'] ?? null,
            'status'      => 'pending', // awaits admin approval
        ]);

        // Store images
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('listings', 'public');
            ListingImage::create([
                'listing_id' => $listing->id,
                'image_path' => $path,
                'is_primary'  => $index === 0, // first image is primary
            ]);
        }

        return redirect()->route('agent.listings.index')
            ->with('success', 'Listing submitted successfully! It will be visible after admin approval.');
    }

    // Show edit form
    public function edit($id)
    {
        $listing = Listing::where('user_id', Auth::id())
            ->with('images')
            ->findOrFail($id);

        return view('agent.listings.edit', compact('listing'));
    }

    // Update listing
    public function update(Request $request, $id)
    {
        $listing = Listing::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:20'],
            'type'        => ['required', 'in:rent,sale'],
            'category'    => ['required', 'in:apartment,house,villa,land,commercial'],
            'price'       => ['required', 'numeric', 'min:1'],
            'location'    => ['required', 'string', 'max:100'],
            'address'     => ['nullable', 'string', 'max:200'],
            'bedrooms'    => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms'   => ['nullable', 'integer', 'min:0', 'max:20'],
            'area'        => ['nullable', 'numeric', 'min:1'],
            'images'      => ['nullable', 'array', 'max:5'],
            'images.*'    => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $listing->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'type'        => $validated['type'],
            'category'    => $validated['category'],
            'price'       => $validated['price'],
            'location'    => $validated['location'],
            'address'     => $validated['address'] ?? null,
            'bedrooms'    => $validated['bedrooms'] ?? null,
            'bathrooms'   => $validated['bathrooms'] ?? null,
            'area'        => $validated['area'] ?? null,
            'status'      => 'pending', // re-submit for approval
        ]);

        // Add new images if uploaded
        if ($request->hasFile('images')) {
            $existingCount = $listing->images()->count();
            $newCount = count($request->file('images'));

            if ($existingCount + $newCount > 5) {
                return back()->withErrors(['images' => 'You can only have up to 5 images per listing.']);
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'is_primary'  => false,
                ]);
            }
        }

        return redirect()->route('agent.listings.index')
            ->with('success', 'Listing updated and resubmitted for approval.');
    }

    // Delete listing
    public function destroy($id)
    {
        $listing = Listing::where('user_id', Auth::id())->findOrFail($id);

        // Delete images from storage
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('agent.listings.index')
            ->with('success', 'Listing deleted successfully.');
    }

    // Delete single image
    public function deleteImage($id)
    {
        $image = ListingImage::findOrFail($id);
        $listing = Listing::where('user_id', Auth::id())->findOrFail($image->listing_id);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // If deleted image was primary, set first remaining as primary
        $firstImage = $listing->images()->first();
        if ($firstImage) {
            $firstImage->update(['is_primary' => true]);
        }

        return back()->with('success', 'Image removed.');
    }
}
