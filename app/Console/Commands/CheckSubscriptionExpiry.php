<?php

namespace App\Console\Commands;

use App\Models\ShopSubscription;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiringSoon;
use App\Mail\SubscriptionExpired;

class CheckSubscriptionExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expiring subscriptions and send notifications';

    /**
     * Execute the console command.
     */
    public function handle(SubscriptionService $subscriptionService): int
    {
        $this->info('Checking subscription expiry...');

        // Find subscriptions expiring in 3 days
        $expiringSoonSubscriptions = ShopSubscription::active()
            ->where('ends_at', '<=', now()->addDays(3))
            ->where('ends_at', '>', now())
            ->whereNull('expiry_notified_at')
            ->get();

        foreach ($expiringSoonSubscriptions as $subscription) {
            try {
                $this->info("Sending expiry notification for subscription: {$subscription->id}");
                
                // Send email notification
                Mail::to($subscription->shop->user->email)
                    ->send(new SubscriptionExpiringSoon($subscription));

                // Mark as notified
                $subscription->update(['expiry_notified_at' => now()]);

                $this->info("Expiry notification sent to: {$subscription->shop->user->email}");
            } catch (\Exception $e) {
                Log::error('Failed to send expiry notification', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Failed to send expiry notification for subscription: {$subscription->id}");
            }
        }

        // Find subscriptions that have expired and need to enter grace period
        $expiredSubscriptions = ShopSubscription::active()
            ->where('ends_at', '<=', now())
            ->where('status', 'active')
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            try {
                $this->info("Moving subscription to grace period: {$subscription->id}");
                
                // Move to grace period
                $subscription->enterGracePeriod();

                // Send grace period notification
                Mail::to($subscription->shop->user->email)
                    ->send(new SubscriptionExpired($subscription));

                $this->info("Subscription moved to grace period: {$subscription->id}");
            } catch (\Exception $e) {
                Log::error('Failed to move subscription to grace period', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Failed to move subscription to grace period: {$subscription->id}");
            }
        }

        // Find subscriptions that have exceeded grace period and need to be expired
        $graceExpiredSubscriptions = ShopSubscription::where('status', 'grace')
            ->where('grace_period_ends_at', '<=', now())
            ->get();

        foreach ($graceExpiredSubscriptions as $subscription) {
            try {
                $this->info("Expiring subscription: {$subscription->id}");
                
                // Mark as expired
                $subscription->markAsExpired();

                $this->info("Subscription expired: {$subscription->id}");
            } catch (\Exception $e) {
                Log::error('Failed to expire subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Failed to expire subscription: {$subscription->id}");
            }
        }

        $this->info('Subscription expiry check completed.');
        $this->info("Expiring soon: {$expiringSoonSubscriptions->count()}");
        $this->info("Moved to grace period: {$expiredSubscriptions->count()}");
        $this->info("Expired: {$graceExpiredSubscriptions->count()}");

        return Command::SUCCESS;
    }
}