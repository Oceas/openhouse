@extends('docs.layout')

@section('title', 'Pricing & Plans')
@section('description', 'Learn about Open House pricing plans and what\'s included in your subscription.')

@section('content')
<div class="doc-content">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <div class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 mb-6">
            <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
            </svg>
            Special Early Bird Pricing
        </div>
        <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
            Pricing & Plans
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Open House offers simple, transparent pricing designed to help real estate professionals succeed.
            One plan, all features, no surprises.
        </p>
    </div>

    <!-- Pricing Card -->
    <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-12 mb-16 border border-indigo-100">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Professional Plan</h2>
            <p class="text-lg text-gray-600 mb-8">Everything you need to manage your real estate business</p>

            <div class="flex items-baseline justify-center gap-x-2 mb-6">
                <span class="text-6xl font-bold text-gray-900">$9.99</span>
                <span class="text-xl font-semibold text-gray-600">/month</span>
            </div>

            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium mb-6 inline-block">
                Special Early Bird Pricing (Normally $39.99)
            </div>

            <div class="flex items-center justify-center gap-x-4 text-sm text-gray-600 mb-8">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                    </svg>
                    All features included
                </div>
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                    </svg>
                    Cancel anytime
                </div>
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                    </svg>
                    No setup fees
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                    Get Started Now
                </a>
                <a href="#features" class="border border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-50 transition-colors">
                    View Features
                </a>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div id="features" class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Everything Included</h2>

        <div class="grid grid-cols-2 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m2.25-18v18m13.5-18v18m2.25-18v18M6.75 9h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.75m-.75 3h.75m-.75 1.5h.75m-3.75-6h.75m-.75 3h.75m-.75 3h.75" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Unlimited Properties</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Create and manage unlimited property listings with detailed information, photos, and virtual tours.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.375a2.25 2.25 0 01-2.25-2.25V6.108c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Visitor Tracking</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Capture and manage visitor information with our digital sign-in system. Perfect for open houses and showings.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Analytics & Reports</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Track performance with detailed analytics, visitor reports, and lead conversion metrics.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Interactive Search</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Advanced property search with interactive maps, filters, and property comparison tools.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Open House Management</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Schedule and manage open house events with visitor tracking and automated follow-ups.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Public Listings</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Beautiful public property pages with photo galleries, contact forms, and mobile optimization.</p>
            </div>
        </div>
    </div>

    <!-- Pricing Details -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Simple, Transparent Pricing</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Hidden Fees</h3>
                <p class="text-gray-600">One simple monthly price includes all features. No setup fees, no per-property charges, no surprises.</p>
            </div>

            <div class="text-center">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Cancel Anytime</h3>
                <p class="text-gray-600">No long-term contracts or commitments. Cancel your subscription at any time with just a few clicks.</p>
            </div>

            <div class="text-center">
                <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Instant Access</h3>
                <p class="text-gray-600">Start using all features immediately after signup. No waiting, no approval process, no delays.</p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>
        
        <div class="space-y-6">
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What's included in the $9.99/month plan?</h3>
                <p class="text-gray-600">Everything! Unlimited properties, visitor tracking, analytics, public listings, interactive search, and all platform features. There are no feature restrictions or additional charges.</p>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I cancel my subscription anytime?</h3>
                <p class="text-gray-600">Yes, absolutely. You can cancel your subscription at any time from your account settings. There are no cancellation fees or penalties.</p>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">How many properties can I add?</h3>
                <p class="text-gray-600">Unlimited! You can add as many properties as you need. There are no limits on the number of properties, photos, or visitor sign-ins.</p>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Is this a limited-time offer?</h3>
                <p class="text-gray-600">The $9.99 pricing is our special early bird pricing for new users. We recommend signing up now to lock in this rate.</p>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer team or agency pricing?</h3>
                <p class="text-gray-600">Currently, we offer individual subscriptions. Each team member can sign up for their own account at the same $9.99/month rate.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-12 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-indigo-100 mb-8">Join hundreds of real estate professionals who are already using Open House to grow their business.</p>
        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
            Start Your Free Trial
        </a>
        <p class="text-indigo-200 text-sm mt-4">No credit card required • Cancel anytime</p>
    </div>
</div>
@endsection
