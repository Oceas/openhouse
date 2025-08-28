<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If user is not authenticated, let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Allow specific email addresses to bypass subscription requirement (for development/testing)
        if ($user->email === 'oceass@gmail.com') {
            return $next($request);
        }

        // Check if user has access (subscription)
        if (!$user->hasAccess()) {
            // If user has a Stripe ID but no subscription, they might be in the process of subscribing
            if ($user->hasStripeId()) {
                // Try to sync their subscription status
                try {
                    $user->syncStripeCustomerDetails();

                    // Check again after sync
                    if ($user->hasAccess()) {
                        return $next($request);
                    }
                } catch (\Exception $e) {
                    // Log the error but continue
                    \Log::error('Failed to sync Stripe customer in middleware: ' . $e->getMessage());
                }
            }

            // If still no access, redirect to subscription page
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Subscription required. Please subscribe to continue using Open House.',
                    'subscription_required' => true
                ], 402);
            }

            return redirect()->route('subscription.create')
                ->with('warning', 'Subscription required. Please subscribe to continue using Open House.');
        }

        return $next($request);
    }
}
