<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('agent.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('agent.listings.create');
    }

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
            'amenities'   => ['nullable', 'array'],
            'amenities.*' => ['string'],
            'images'      => ['required', 'array', 'min:1', 'max:5'],
            'images.*'    => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'video'       => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm', 'max:102400'],
            'remove_video'=> ['nullable', 'boolean'],
            'video'       => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm', 'max:102400'],
        ]);

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
            'amenities'   => $validated['amenities'] ?? [],
            'status'      => 'pending',
        ]);

        if ($request->hasFile('video')) {
            $listing->update([
                'video_path' => $request->file('video')->store('listings/videos', 'public')
            ]);
        }

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('listings', 'public');
            ListingImage::create([
                'listing_id' => $listing->id,
                'image_path' => $path,
                'is_primary' => $index === 0,
            ]);
        }

        \App\Services\AuditService::log('Created', 'Listings', "Agent submitted a new listing: {$listing->title}", $listing->id);

        return redirect()->route('agent.listings.index')
            ->with('success', __('Listing submitted! It will be visible after admin approval.'));
    }

    public function edit($id)
    {
        $listing = Listing::where('user_id', Auth::id())
            ->with('images')
            ->findOrFail($id);

        return view('agent.listings.edit', compact('listing'));
    }

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
            'amenities'   => ['nullable', 'array'],
            'amenities.*' => ['string'],
            'images'      => ['nullable', 'array', 'max:5'],
            'images.*'    => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'video'       => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm', 'max:102400'],
            'remove_video'=> ['nullable', 'boolean'],
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
            'amenities'   => $validated['amenities'] ?? [],
        ]);

        if ($request->has('remove_video') && $request->remove_video) {
            if ($listing->video_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($listing->video_path);
                $listing->update(['video_path' => null]);
            }
        }

        if ($request->hasFile('video')) {
            if ($listing->video_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($listing->video_path);
            }
            $listing->update([
                'video_path' => $request->file('video')->store('listings/videos', 'public')
            ]);
        }

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
                    'is_primary' => false,
                ]);
            }
        }

        \App\Services\AuditService::log('Updated', 'Listings', "Agent updated listing: {$listing->title}", $listing->id);

        return redirect()->route('agent.listings.index')
            ->with('success', __('Listing updated successfully.'));
    }

    public function destroy($id)
    {
        $listing = Listing::where('user_id', Auth::id())->findOrFail($id);

        \App\Services\AuditService::log('Deleted', 'Listings', "Agent deleted listing: {$listing->title}", $listing->id);

        if ($listing->video_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($listing->video_path);
        }

        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('agent.listings.index')
            ->with('success', __('Listing deleted successfully.'));
    }

    public function deleteImage($id)
    {
        $image = ListingImage::findOrFail($id);
        $listing = Listing::where('user_id', Auth::id())->findOrFail($image->listing_id);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        $firstImage = $listing->images()->first();
        if ($firstImage) {
            $firstImage->update(['is_primary' => true]);
        }

        return back()->with('success', __('Image removed.'));
    }

    // Mark as sold
    public function markSold($id)
    {
        $listing = Listing::where('user_id', Auth::id())->findOrFail($id);
        $listing->update(['status' => 'sold']);

        Appointment::where('listing_id', $listing->id)
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        return back()->with('success', __('Property marked as sold. All pending appointments cancelled.'));
    }

    // Mark as rented
    public function markRented($id)
    {
        $listing = Listing::where('user_id', Auth::id())->findOrFail($id);
        $listing->update(['status' => 'rented']);

        Appointment::where('listing_id', $listing->id)
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        return back()->with('success', __('Property marked as rented. All pending appointments cancelled.'));
    }
}
