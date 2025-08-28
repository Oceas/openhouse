<x-guest-layout>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 mb-6">
                    <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                    </svg>
                    Simple & Transparent Pricing
                </div>
                <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Choose the right plan for your real estate business
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Streamline your property management with our comprehensive platform designed specifically for real estate professionals.
                </p>

                @if($isNewUser)
                    <div class="mt-8 inline-flex items-center rounded-full bg-green-50 px-6 py-3 text-base font-medium text-green-700">
                        <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                        </svg>
                        Welcome! Complete your setup to get started
                    </div>
                @endif
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div class="mb-8 rounded-2xl bg-red-50 p-6 max-w-4xl mx-auto border border-red-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-base text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-8 rounded-2xl bg-yellow-50 p-6 max-w-4xl mx-auto border border-yellow-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-base text-yellow-700 font-medium">{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content: Features and Pricing -->
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-16 lg:items-start">

                <!-- Features Section (Left) -->
                <div class="lg:pr-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Everything you need to manage your real estate business</h2>
                    <p class="text-lg text-gray-600 mb-12 leading-relaxed">Our comprehensive platform is designed specifically for real estate professionals who want to streamline their operations and grow their business.</p>

                    <div class="space-y-8">
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
                                <h3 class="text-xl font-semibold text-gray-900">Visitor Sign-ins</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">Track property visitors and capture leads with our digital sign-in system. Perfect for open houses and showings.</p>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Analytics & Reports</h3>
                            </div>
                            <p class="text-gray-600 leading-relaxed">Get detailed insights into your property performance, visitor trends, and lead conversion rates.</p>
                        </div>

                        <!-- Feature 5 -->
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

                <!-- Pricing Section (Right) -->
                <div class="mt-12 lg:mt-0">
                    <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-12 border border-indigo-100 shadow-xl">
                        @if($hasSubscription)
                            <!-- Already Subscribed -->
                            <div class="text-center">
                                <div class="bg-green-50 rounded-2xl p-8 border border-green-200 mb-8">
                                    <div class="flex items-center justify-center mb-4">
                                        <div class="bg-green-100 rounded-full p-3">
                                            <svg class="h-8 w-8 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.179 10.5a.75.75 0 00-1.358.638l1.5 3.5a.75.75 0 001.358.058l4.5-6.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold text-green-900 mb-2">Active Subscription</h3>
                                    <p class="text-green-700 text-lg">You're all set! Your subscription is active and ready to use.</p>
                                </div>

                                <a href="{{ route('subscription.billing') }}"
                                   class="block w-full bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg text-center hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                                    Manage Subscription
                                </a>
                            </div>
                        @else
                            <!-- Subscription Plan -->
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional Plan</h3>
                                <p class="text-lg text-gray-600 mb-8">Perfect for real estate professionals and teams</p>

                                <div class="flex items-baseline justify-center gap-x-2 mb-6">
                                    <span class="text-6xl font-bold text-gray-900">$4.99</span>
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
                                </div>

                                <!-- Action Button -->
                                <form action="{{ route('subscription.checkout') }}" method="POST" class="mb-8">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                                        Get Started Today
                                    </button>
                                </form>

                                <!-- Plan Features -->
                                <div class="space-y-4 text-left">
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Unlimited properties</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Visitor tracking & leads</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Public listing pages</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Analytics & reports</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Team collaboration</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-indigo-600 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Priority support</span>
                                    </div>
                                </div>

                                <!-- Guarantee -->
                                <div class="mt-8 pt-6 border-t border-gray-200 text-sm text-gray-600">
                                    <p>Cancel anytime. No setup fees. Secure payments.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
