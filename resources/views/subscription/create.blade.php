@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">Start managing your properties with Open House</p>
        </div>

        <!-- Trial Status -->
        @if($onTrial)
            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-2xl p-6 mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">
                            Free Trial Active
                        </h3>
                        <p class="text-blue-700 dark:text-blue-200">
                            You have {{ $trialDaysRemaining }} {{ Str::plural('day', $trialDaysRemaining) }} left in your free trial.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error/Warning Messages -->
        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-6 py-4 rounded-2xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 px-6 py-4 rounded-2xl mb-6">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Pricing Card -->
        <div class="max-w-md mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 overflow-hidden card-shadow">
                <!-- Badge -->
                <div class="bg-primary text-white text-center py-3">
                    <span class="text-sm font-semibold">MOST POPULAR</span>
                </div>

                <div class="p-8">
                    <!-- Plan Details -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Professional</h3>
                        <div class="flex items-baseline justify-center mb-4">
                            <span class="text-5xl font-bold text-gray-900 dark:text-white">$4.99</span>
                            <span class="text-xl text-gray-500 dark:text-gray-400 ml-2">/month</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Perfect for real estate professionals</p>
                    </div>

                    <!-- Features -->
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">Unlimited property listings</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">Visitor sign-in management</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">Photo galleries & virtual tours</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">PDF exports & reports</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">Open house management</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">Public listing pages</span>
                        </li>
                    </ul>

                    <!-- Trial Notice -->
                    @if(!$hasSubscription)
                        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-800 dark:text-green-200">14-day free trial included</span>
                            </div>
                        </div>
                    @endif

                    <!-- Action Button -->
                    @if($hasSubscription)
                        <div class="text-center">
                            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl p-4 mb-4">
                                <span class="text-green-800 dark:text-green-200 font-medium">✓ Currently Subscribed</span>
                            </div>
                            <a href="{{ route('subscription.billing') }}"
                               class="block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 py-3 px-6 rounded-xl font-semibold text-center transition-colors duration-200">
                                Manage Billing
                            </a>
                        </div>
                    @else
                        <form action="{{ route('subscription.checkout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full btn-primary py-3 px-6 rounded-xl font-semibold transition-colors duration-200">
                                @if($onTrial)
                                    Subscribe Now
                                @else
                                    Start Free Trial
                                @endif
                            </button>
                        </form>
                    @endif

                    <!-- Back to Dashboard -->
                    @if($onTrial)
                        <div class="mt-4 text-center">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                Continue using trial
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Money Back Guarantee -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cancel anytime • Secure payment • No setup fees
            </p>
        </div>
    </div>
</div>
@endsection
