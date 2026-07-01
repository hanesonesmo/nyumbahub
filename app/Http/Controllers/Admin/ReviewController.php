<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReport;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for moderation.
     */
    public function index(Request $request)
    {
        $query = Review::with(['agent', 'user', 'appointment.listing']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the review and its reports.
     */
    public function show(Review $review)
    {
        $review->load(['agent', 'user', 'appointment.listing', 'reports.reporter']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Update review status (approve, hide).
     */
    public function updateStatus(Request $request, Review $review)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,hidden'],
        ]);

        $review->update(['status' => $validated['status']]);

        \App\Services\AuditService::log('Review Status Changed', 'Moderation', "Review ID {$review->id} status changed to {$validated['status']}");

        return back()->with('success', "Review has been {$validated['status']}.");
    }

    /**
     * Delete a review entirely.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        \App\Services\AuditService::log('Review Deleted', 'Moderation', "Review ID {$review->id} was deleted by admin.");

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    /**
     * View review reports.
     */
    public function reports()
    {
        $reports = ReviewReport::with(['review', 'reporter'])
            ->latest()
            ->paginate(20);

        return view('admin.reviews.reports', compact('reports'));
    }

    /**
     * Dismiss or resolve a report.
     */
    public function updateReportStatus(Request $request, ReviewReport $report)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:reviewed,dismissed'],
        ]);

        $report->update(['status' => $validated['status']]);

        return back()->with('success', "Report status updated to {$validated['status']}.");
    }
}
