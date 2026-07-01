<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PropertyReservation;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:release-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release property reservations that have passed their validity period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired reservations...');
        
        $expiredReservations = PropertyReservation::where('status', 'active')
            ->where('expires_at', '<=', Carbon::now())
            ->get();
            
        $count = 0;
        
        foreach ($expiredReservations as $reservation) {
            $reservation->update(['status' => 'expired']);
            
            // Unlock the listing
            $listing = Listing::find($reservation->listing_id);
            if ($listing && $listing->status === 'reserved') {
                $listing->update(['status' => 'active']);
            }
            
            $count++;
            $this->info("Released reservation {$reservation->id} for listing {$reservation->listing_id}");
            Log::info("Released expired reservation {$reservation->id} for listing {$reservation->listing_id}");
        }
        
        $this->info("Successfully released {$count} expired reservations.");
    }
}
