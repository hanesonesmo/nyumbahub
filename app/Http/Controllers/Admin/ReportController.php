<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Show reports page
    public function index()
    {
        return view('admin.reports');
    }

    // Generate report
    public function generate(Request $request)
    {
        $request->validate([
            'type'   => ['required', 'in:weekly,monthly,custom'],
            'format' => ['required', 'in:view,csv'],
        ]);

        // Determine date range
        if ($request->type === 'weekly') {
            $start = Carbon::now()->startOfWeek();
            $end   = Carbon::now()->endOfWeek();
            $label = 'Weekly Report — ' . $start->format('d M') . ' to ' . $end->format('d M Y');
        } elseif ($request->type === 'monthly') {
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::now()->endOfMonth();
            $label = 'Monthly Report — ' . $start->format('F Y');
        } else {
            $request->validate([
                'start_date' => ['required', 'date'],
                'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            ]);
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
            $label = 'Custom Report — ' . $start->format('d M Y') . ' to ' . $end->format('d M Y');
        }

        // Gather data
        $data = [
            'label'        => $label,
            'start'        => $start,
            'end'          => $end,
            'type'         => $request->type,

            // User stats
            'new_users'    => User::whereBetween('created_at', [$start, $end])->count(),
            'new_agents'   => User::where('role', 'agent')->whereBetween('created_at', [$start, $end])->count(),
            'new_tenants'  => User::where('role', 'tenant')->whereBetween('created_at', [$start, $end])->count(),
            'new_buyers'   => User::where('role', 'buyer')->whereBetween('created_at', [$start, $end])->count(),
            'total_users'  => User::count(),

            // Listing stats
            'new_listings'      => Listing::whereBetween('created_at', [$start, $end])->count(),
            'approved_listings' => Listing::where('status', 'active')->whereBetween('updated_at', [$start, $end])->count(),
            'rejected_listings' => Listing::where('status', 'rejected')->whereBetween('updated_at', [$start, $end])->count(),
            'total_active'      => Listing::where('status', 'active')->count(),
            'total_pending'     => Listing::where('status', 'pending')->count(),
            'sold_listings'     => Listing::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->count(),
            'rented_listings'   => Listing::where('status', 'rented')->whereBetween('updated_at', [$start, $end])->count(),

            // Appointment stats
            'new_appointments'       => Appointment::whereBetween('created_at', [$start, $end])->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->whereBetween('updated_at', [$start, $end])->count(),
            'cancelled_appointments' => Appointment::where('status', 'cancelled')->whereBetween('updated_at', [$start, $end])->count(),

            // Recent data
            'recent_listings'     => Listing::with(['agent'])->whereBetween('created_at', [$start, $end])->latest()->take(10)->get(),
            'recent_users'        => User::whereBetween('created_at', [$start, $end])->latest()->take(10)->get(),
            'recent_appointments' => Appointment::with(['user', 'listing'])->whereBetween('created_at', [$start, $end])->latest()->take(10)->get(),

            // Listing by type
            'rent_count' => Listing::where('type', 'rent')->whereBetween('created_at', [$start, $end])->count(),
            'sale_count' => Listing::where('type', 'sale')->whereBetween('created_at', [$start, $end])->count(),

            // By category
            'by_category' => Listing::whereBetween('created_at', [$start, $end])
                ->selectRaw('category, count(*) as total')
                ->groupBy('category')
                ->pluck('total', 'category'),
        ];

        if ($request->format === 'csv') {
            return $this->downloadCsv($data);
        }

        return view('admin.report-view', compact('data'));
    }

    // Download CSV
    private function downloadCsv($data)
    {
        $filename = 'nyumbahub-report-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Title
            fputcsv($file, ['NyumbaHub System Report']);
            fputcsv($file, [$data['label']]);
            fputcsv($file, ['Generated on', now()->format('d M Y H:i')]);
            fputcsv($file, []);

            // Users
            fputcsv($file, ['USERS']);
            fputcsv($file, ['Metric', 'Count']);
            fputcsv($file, ['New Users',   $data['new_users']]);
            fputcsv($file, ['New Agents',  $data['new_agents']]);
            fputcsv($file, ['New Tenants', $data['new_tenants']]);
            fputcsv($file, ['New Buyers',  $data['new_buyers']]);
            fputcsv($file, ['Total Users', $data['total_users']]);
            fputcsv($file, []);

            // Listings
            fputcsv($file, ['LISTINGS']);
            fputcsv($file, ['Metric', 'Count']);
            fputcsv($file, ['New Listings',      $data['new_listings']]);
            fputcsv($file, ['Approved',          $data['approved_listings']]);
            fputcsv($file, ['Rejected',          $data['rejected_listings']]);
            fputcsv($file, ['Sold',              $data['sold_listings']]);
            fputcsv($file, ['Rented',            $data['rented_listings']]);
            fputcsv($file, ['Total Active',      $data['total_active']]);
            fputcsv($file, ['Total Pending',     $data['total_pending']]);
            fputcsv($file, ['For Rent',          $data['rent_count']]);
            fputcsv($file, ['For Sale',          $data['sale_count']]);
            fputcsv($file, []);

            // Appointments
            fputcsv($file, ['APPOINTMENTS']);
            fputcsv($file, ['Metric', 'Count']);
            fputcsv($file, ['New Bookings',      $data['new_appointments']]);
            fputcsv($file, ['Confirmed',         $data['confirmed_appointments']]);
            fputcsv($file, ['Cancelled',         $data['cancelled_appointments']]);
            fputcsv($file, []);

            // Recent listings
            fputcsv($file, ['RECENT LISTINGS IN PERIOD']);
            fputcsv($file, ['Title', 'Agent', 'Type', 'Category', 'Price (TZS)', 'Location', 'Status', 'Date']);
            foreach ($data['recent_listings'] as $listing) {
                fputcsv($file, [
                    $listing->title,
                    $listing->agent->first_name . ' ' . $listing->agent->last_name,
                    ucfirst($listing->type),
                    ucfirst($listing->category),
                    number_format($listing->price),
                    $listing->location,
                    ucfirst($listing->status),
                    $listing->created_at->format('d M Y'),
                ]);
            }
            fputcsv($file, []);

            // Recent users
            fputcsv($file, ['NEW USERS IN PERIOD']);
            fputcsv($file, ['Name', 'Email', 'Role', 'Joined']);
            foreach ($data['recent_users'] as $user) {
                fputcsv($file, [
                    $user->first_name . ' ' . $user->last_name,
                    $user->email,
                    ucfirst($user->role),
                    $user->created_at->format('d M Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
