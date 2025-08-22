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

        // Check if user has access (trial or subscription)
        if (!$user->hasAccess()) {
            // If trial expired and no subscription, redirect to subscription page
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your trial has expired. Please subscribe to continue using Open House.',
                    'trial_expired' => true
                ], 402);
            }

            return redirect()->route('subscription.create')
                ->with('warning', 'Your trial has expired. Please subscribe to continue using Open House.');
        }

        return $next($request);
    }
}
