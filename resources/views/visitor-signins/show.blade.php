@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Visitor Details
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Information about this visitor's sign-in
                    </p>
                </div>
                <a href="{{ route('properties.visitors.index', $property) }}"
                   class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Visitors
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Visitor Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Visitor Information
                        </h2>

                        @if(isset($visitorSignin))
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            Full Name
                                        </label>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $visitorSignin->full_name }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            Email Address
                                        </label>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                                            <a href="mailto:{{ $visitorSignin->email }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                {{ $visitorSignin->email }}
                                            </a>
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            Phone Number
                                        </label>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                                            @if($visitorSignin->phone)
                                                <a href="tel:{{ $visitorSignin->phone }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                    {{ $visitorSignin->phone }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">Not provided</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            Sign-in Date & Time
                                        </label>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $visitorSignin->signed_in_at->format('M j, Y') }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $visitorSignin->signed_in_at->format('g:i A') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Interest Information -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                        Interest Details
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                Interest Level
                                            </label>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                @if($visitorSignin->interest_level === 'high')
                                                    bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                @elseif($visitorSignin->interest_level === 'medium')
                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                @else
                                                    bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif">
                                                {{ ucfirst($visitorSignin->interest_level ?? 'Not specified') }}
                                            </span>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                Timeline
                                            </label>
                                            <p class="text-lg font-medium text-gray-900 dark:text-white">
                                                {{ $visitorSignin->timeline ?? 'Not specified' }}
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                Financing
                                            </label>
                                            <p class="text-lg font-medium text-gray-900 dark:text-white">
                                                {{ ucfirst($visitorSignin->financing ?? 'Not specified') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                @if($visitorSignin->notes)
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            Additional Notes
                                        </label>
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <p class="text-gray-900 dark:text-white">
                                                {{ $visitorSignin->notes }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No visitor data found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Property Information Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Property Information
                        </h2>

                        @if(isset($property))
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Property Title
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $property->title }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Address
                                    </label>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ $property->full_address }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Price
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $property->formatted_price }}
                                    </p>
                                </div>

                                <div class="pt-4">
                                    <a href="{{ route('properties.show', $property) }}"
                                       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Property
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No property data found</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Follow-up Email
                    </button>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Visitor
                    </button>

                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Schedule Showing
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
