@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 overflow-hidden card-shadow">
            <div class="p-8 text-center">
                <!-- Logo -->
                <div class="mx-auto flex items-center justify-center mb-6 p-4">
                    <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-64 h-auto">
                </div>

                <!-- Pending Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30 mb-6">
                    <svg class="h-8 w-8 text-yellow-600 dark:text-yellow-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Processing Your Subscription
                </h1>

                <!-- Message -->
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    We're setting up your subscription. This usually takes just a few moments.
                </p>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                    If you're still seeing this message after a few minutes, please try refreshing the page or contact support.
                </p>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('subscription.success') }}"
                       class="block w-full btn-primary py-3 px-6 rounded-xl font-semibold text-center transition-colors duration-200">
                        Check Again
                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 py-3 px-6 rounded-xl font-semibold text-center transition-colors duration-200">
                        Go to Dashboard
                    </a>
                </div>

                <!-- Support -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Still having issues?
                        <a href="mailto:support@openhouse.com" class="text-indigo-600 hover:text-indigo-500 font-medium">Contact Support</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh the page every 5 seconds to check subscription status
setTimeout(function() {
    window.location.reload();
}, 5000);
</script>
@endsection
