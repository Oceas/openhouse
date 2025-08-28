@extends('docs.layout')

@section('title', 'Subscriptions & Billing')
@section('description', 'Learn about Open House subscription plans, billing, and account management.')

@section('content')
<div class="doc-content">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <div class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 mb-6">
            <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
            </svg>
            Simple & Transparent Pricing
        </div>
        <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
            Subscriptions & Billing
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Open House offers a simple, transparent subscription model designed to help real estate professionals succeed.
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

            <div class="flex items-center justify-center gap-x-4 text-sm text-gray-600 mb-8">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                    </svg>
                    14-day free trial
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
                    Start Free Trial
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Photo Galleries</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Showcase properties with beautiful photo galleries, lightbox viewing, and professional image management.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Public Listings</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Share beautiful public listing pages with potential buyers. Includes map integration and search functionality.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Analytics & Reports</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Get detailed insights into your property performance, visitor trends, and lead conversion rates.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Team Collaboration</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">Invite team members and collaborate on properties. Perfect for real estate agencies and teams.</p>
            </div>
        </div>
    </div>

    <!-- Getting Started Section -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-3xl p-12 mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Getting Started is Easy</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Start your free trial today and experience the full power of Open House</p>
        </div>

        <div class="grid grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-indigo-600">1</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Create Account</h3>
                <p class="text-gray-600">Sign up with your name, email, and password. No credit card required.</p>
            </div>
            <div class="text-center">
                <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-indigo-600">2</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Start Using</h3>
                <p class="text-gray-600">Access all features immediately. Create properties and track visitors right away.</p>
            </div>
            <div class="text-center">
                <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-indigo-600">3</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Add Payment</h3>
                <p class="text-gray-600">Add your payment method before the trial ends to continue using Open House.</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                Start Your Free Trial
            </a>
        </div>
    </div>

    <!-- Billing Information -->
    <div class="grid grid-cols-2 gap-12 mb-16">
        <!-- Payment Methods -->
        <div class="bg-white rounded-2xl p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Payment Methods</h3>
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <svg class="h-8 w-8 text-blue-600 mr-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-900">Credit Cards</h4>
                        <p class="text-gray-600">Visa, Mastercard, American Express, Discover</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <svg class="h-8 w-8 text-green-600 mr-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-900">Debit Cards</h4>
                        <p class="text-gray-600">All major debit card networks</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <svg class="h-8 w-8 text-purple-600 mr-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-900">Secure Processing</h4>
                        <p class="text-gray-600">Powered by Stripe for maximum security</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing Cycle -->
        <div class="bg-white rounded-2xl p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Billing Cycle</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Billing Frequency</span>
                    <span class="text-gray-600">Monthly</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Charged On</span>
                    <span class="text-gray-600">Same date each month</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Pro-rated</span>
                    <span class="text-gray-600">Only pay for days used</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Auto-renewal</span>
                    <span class="text-gray-600">Continues until cancelled</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Security & Privacy -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-12 mb-16 text-white">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Security & Privacy First</h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">Your data and payments are protected with enterprise-grade security</p>
        </div>

        <div class="grid grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-white/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">PCI Compliance</h3>
                <p class="text-gray-300">Meets highest security standards for payment processing</p>
            </div>
            <div class="text-center">
                <div class="bg-white/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 7.5h.008v.008h-.008V7.5zm2.25 0h.008v.008h-.008V7.5zM16.5 11.25h.008v.008h-.008v-.008zm2.25 0h.008v.008h-.008v-.008zm-2.25 3.75h.008v.008h-.008v-.008zm2.25 0h.008v.008h-.008v-.008zm-2.25 3.75h.008v.008h-.008v-.008zm2.25 0h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Encryption</h3>
                <p class="text-gray-300">All data encrypted in transit and at rest</p>
            </div>
            <div class="text-center">
                <div class="bg-white/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Tokenization</h3>
                <p class="text-gray-300">Payment details never stored on our servers</p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>

        <div class="grid grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">When am I charged?</h3>
                <p class="text-gray-600">You're charged on the same date each month. For example, if you start on January 15th, you'll be charged on the 15th of every month.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Can I cancel anytime?</h3>
                <p class="text-gray-600">Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your current billing period.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">What if my payment fails?</h3>
                <p class="text-gray-600">We'll automatically retry your payment and notify you via email. You'll have a grace period to update your payment method.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Can I get a refund?</h3>
                <p class="text-gray-600">We don't provide refunds for partial months, but you can cancel anytime and won't be charged for future months.</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-12 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">Join thousands of real estate professionals who trust Open House to manage their properties and grow their business.</p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                Start Free Trial
            </a>
            <a href="/docs/faq" class="border border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/10 transition-colors">
                View FAQ
            </a>
        </div>
    </div>
</div>
@endsection
