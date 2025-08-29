@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Subscription Banner (Dismissible) -->
            @if(Auth::user()->shouldShowSubscriptionBanner())
                <div id="subscription-banner" class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-2xl p-6 relative">
                    <button onclick="dismissBanner()" class="absolute top-4 right-4 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100">
                                    Subscription Active
                                </h3>
                                <p class="text-green-700 dark:text-green-200">
                                    Your subscription is active and in good standing. You have full access to all Open House features.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('subscription.billing') }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                                Manage Billing
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Subscription Status Section (Always visible for subscribed users) -->
            @if(Auth::user()->subscribed('default'))
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Subscription Status
                        </h2>
                        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-900 dark:text-green-100">
                                        Active Subscription
                                    </h3>
                                    <p class="text-sm text-green-700 dark:text-green-200">
                                        Your subscription is active and in good standing.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex space-x-3">
                                <a href="{{ route('subscription.billing') }}"
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Manage Billing
                                </a>
                                @if(Auth::user()->subscription('default')->canceled())
                                    <form method="POST" action="{{ route('subscription.resume') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                            Resume Subscription
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('subscription.cancel') }}" class="inline" onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                            Cancel Subscription
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function dismissBanner() {
            fetch('{{ route("subscription.dismiss-banner") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const banner = document.getElementById('subscription-banner');
                    if (banner) {
                        banner.style.transition = 'opacity 0.3s ease-out';
                        banner.style.opacity = '0';
                        setTimeout(() => {
                            banner.remove();
                        }, 300);
                    }
                }
            })
            .catch(error => {
                console.error('Error dismissing banner:', error);
            });
        }
    </script>
@endsection
