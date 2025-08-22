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

                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-6">
                    <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Welcome to Open House!
                </h1>

                <!-- Message -->
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    Your subscription is now active. You have full access to all Open House features.
                </p>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                       class="block w-full btn-primary py-3 px-6 rounded-xl font-semibold text-center transition-colors duration-200">
                        Go to Dashboard
                    </a>

                    <a href="{{ route('properties.create') }}"
                       class="block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 py-3 px-6 rounded-xl font-semibold text-center transition-colors duration-200">
                        Create Your First Property
                    </a>
                </div>

                <!-- Features Reminder -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">What's included:</h3>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>✓ Unlimited property listings</li>
                        <li>✓ Visitor management system</li>
                        <li>✓ Photo galleries & virtual tours</li>
                        <li>✓ PDF exports & reports</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Need help getting started?
                <a href="#" class="text-primary hover:text-primary/80 font-medium">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection
