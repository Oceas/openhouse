<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SyncUserSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:sync {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user subscription from Stripe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $user = User::where('email', $email)->first();
        } else {
            // Get the first user with a Stripe ID
            $user = User::whereNotNull('stripe_id')->first();
        }

        if (!$user) {
            $this->error('No user found with Stripe ID');
            return 1;
        }

        $this->info("Syncing subscription for user: {$user->name} ({$user->email})");
        $this->info("Stripe Customer ID: {$user->stripe_id}");

        try {
            // Sync the customer details from Stripe
            $user->syncStripeCustomerDetails();
            
            // Check if user has subscription
            if ($user->subscribed('default')) {
                $subscription = $user->subscription('default');
                $this->info("✅ User has active subscription:");
                $this->info("   Subscription ID: {$subscription->stripe_id}");
                $this->info("   Status: {$subscription->stripe_status}");
                $this->info("   Price: {$subscription->stripe_price}");
            } else {
                $this->warn("⚠️  User does not have an active subscription");
                
                // Try to manually fetch subscriptions from Stripe
                $this->info("Attempting to fetch subscriptions from Stripe...");
                
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                
                $subscriptions = \Stripe\Subscription::all([
                    'customer' => $user->stripe_id,
                    'limit' => 10
                ]);
                
                if (count($subscriptions->data) > 0) {
                    $this->info("Found " . count($subscriptions->data) . " subscription(s) in Stripe:");
                    
                    foreach ($subscriptions->data as $stripeSubscription) {
                        $this->info("   - {$stripeSubscription->id} (Status: {$stripeSubscription->status})");
                        
                        // Check if subscription already exists locally
                        $existingSubscription = $user->subscriptions()->where('stripe_id', $stripeSubscription->id)->first();
                        
                        if ($existingSubscription) {
                            $this->info("   ⚠️  Subscription already exists locally, updating...");
                            $subscription = $existingSubscription;
                        } else {
                            // Try to create the subscription locally
                            try {
                                $subscription = $user->subscriptions()->create([
                                    'type' => 'default',
                                    'stripe_id' => $stripeSubscription->id,
                                    'stripe_status' => $stripeSubscription->status,
                                    'stripe_price' => $stripeSubscription->items->data[0]->price->id,
                                    'quantity' => $stripeSubscription->items->data[0]->quantity,
                                    'trial_ends_at' => $stripeSubscription->trial_end ? date('Y-m-d H:i:s', $stripeSubscription->trial_end) : null,
                                    'ends_at' => $stripeSubscription->ended_at ? date('Y-m-d H:i:s', $stripeSubscription->ended_at) : null,
                                ]);
                                
                                $this->info("   ✅ Created local subscription record");
                            } catch (\Exception $e) {
                                $this->error("   ❌ Failed to create local subscription: " . $e->getMessage());
                                continue;
                            }
                        }
                        
                        // Create subscription items
                        foreach ($stripeSubscription->items->data as $item) {
                            try {
                                $subscription->items()->create([
                                    'stripe_id' => $item->id,
                                    'stripe_product' => $item->price->product,
                                    'stripe_price' => $item->price->id,
                                    'quantity' => $item->quantity,
                                ]);
                                
                                $this->info("   ✅ Created subscription item: {$item->id}");
                            } catch (\Exception $e) {
                                $this->error("   ❌ Failed to create subscription item: " . $e->getMessage());
                            }
                        }
                    }
                } else {
                    $this->error("No subscriptions found in Stripe for this customer");
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error syncing subscription: " . $e->getMessage());
            Log::error('Subscription sync failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return 1;
        }

        return 0;
    }
}
