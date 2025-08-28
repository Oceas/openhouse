<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription plans page
     */
    public function create()
    {
        $user = Auth::user();

        return view('subscription.create', [
            'user' => $user,
            'hasSubscription' => $user->subscribed('default'),
            'isNewUser' => $user->created_at->diffInMinutes(now()) < 5, // Show welcome message for users who just registered
        ]);
    }

    /**
     * Create a checkout session for subscription
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Ensure user has a Stripe customer ID
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        try {
            $checkout = $user
                ->newSubscription('default', config('services.stripe.price_id'))
                ->allowPromotionCodes()
                ->checkout([
                    'success_url' => route('subscription.success'),
                    'cancel_url' => route('subscription.create'),
                    'metadata' => [
                        'user_id' => $user->id,
                    ],
                    'billing_address_collection' => 'required',
                ]);

            return redirect($checkout->url);
        } catch (\Exception $e) {
            return redirect()->route('subscription.create')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Handle successful subscription
     */
    public function success()
    {
        $user = Auth::user();

        // Check if user has a subscription
        if ($user->subscribed('default')) {
            return view('subscription.success');
        }

        // If no subscription found, check if they have a Stripe customer ID
        if ($user->hasStripeId()) {
            // Try to sync the subscription from Stripe
            try {
                $user->syncStripeCustomerDetails();

                // Check again after sync
                if ($user->subscribed('default')) {
                    return view('subscription.success');
                }
            } catch (\Exception $e) {
                // Log the error but continue
                \Log::error('Failed to sync Stripe customer: ' . $e->getMessage());
            }
        }

        // If still no subscription, show a pending page
        return view('subscription.pending');
    }

    /**
     * Show billing portal
     */
    public function billing()
    {
        $user = Auth::user();

        if (!$user->hasStripeId()) {
            return redirect()->route('subscription.create')
                ->with('error', 'You must have an active subscription to access the billing portal.');
        }

        return $user->redirectToBillingPortal(route('dashboard'));
    }

    /**
     * Cancel subscription
     */
    public function cancel()
    {
        $user = Auth::user();

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();

            return redirect()->route('dashboard')
                ->with('success', 'Your subscription has been cancelled. You will continue to have access until the end of your billing period.');
        }

        return redirect()->route('dashboard')
            ->with('error', 'You do not have an active subscription to cancel.');
    }

    /**
     * Resume subscription
     */
    public function resume()
    {
        $user = Auth::user();

        if ($user->subscription('default')->cancelled()) {
            $user->subscription('default')->resume();

            return redirect()->route('dashboard')
                ->with('success', 'Your subscription has been resumed!');
        }

        return redirect()->route('dashboard')
            ->with('error', 'Unable to resume subscription.');
    }
}
