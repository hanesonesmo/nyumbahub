<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired agent subscriptions and mark them as expired.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredSubscriptions = Subscription::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'expired']);
            Log::info("Subscription {$subscription->id} has expired.");
            
            // TODO: Optional - Dispatch an event or send notification email
            // event(new \App\Events\SubscriptionExpired($subscription));
            
            $count++;
        }

        $this->info("Successfully expired {$count} subscriptions.");
        Log::info("Ran subscriptions:expire. {$count} subscriptions expired.");

        return Command::SUCCESS;
    }
}
