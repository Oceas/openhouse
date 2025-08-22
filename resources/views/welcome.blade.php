<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Open House - Professional Property Management Platform</title>
        <meta name="description" content="Transform your real estate business with Open House. Manage properties, track visitors, and close deals faster with our comprehensive platform.">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/open-house.png') }}">

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Custom styles -->
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .card-shadow {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            .hover-scale {
                transition: transform 0.2s ease-in-out;
            }
            .hover-scale:hover {
                transform: scale(1.02);
            }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                transition: all 0.2s ease-in-out;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #5855eb 0%, #7c3aed 100%);
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body class="bg-gray-50 font-sans">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center p-3">
                        <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-48 h-auto">
                    </div>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#features" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Features</a>
                        <a href="#pricing" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Pricing</a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2 rounded-xl font-medium hover-scale">
                            Get Started Free
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                        Transform Your
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                            Real Estate Business
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Open House is the complete property management platform that helps real estate professionals
                        manage listings, track visitors, and close deals faster than ever before.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-4 rounded-xl font-semibold text-lg hover-scale">
                            Start Your 14-Day Free Trial
                        </a>
                        <a href="#demo" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                            Watch Demo →
                        </a>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">No credit card required • Cancel anytime</p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Everything You Need to Succeed
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        From property listings to visitor management, Open House gives you the tools to
                        streamline your real estate business and close more deals.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl p-8 card-shadow hover-scale">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Property Management</h3>
                        <p class="text-gray-600">
                            Create stunning property listings with photos, virtual tours, and detailed descriptions.
                            Manage all your properties from one central dashboard.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl p-8 card-shadow hover-scale">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Visitor Tracking</h3>
                        <p class="text-gray-600">
                            Capture visitor information at open houses and track their interest levels.
                            Follow up with qualified leads and convert more prospects into clients.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl p-8 card-shadow hover-scale">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Analytics & Reports</h3>
                        <p class="text-gray-600">
                            Get insights into your property performance, visitor engagement, and conversion rates.
                            Make data-driven decisions to grow your business.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Simple, Transparent Pricing
                    </h2>
                    <p class="text-xl text-gray-600">
                        Start free, scale as you grow. No hidden fees, no surprises.
                    </p>
                </div>

                <div class="max-w-md mx-auto">
                    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden card-shadow">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center py-6">
                            <h3 class="text-2xl font-bold">Professional</h3>
                            <p class="text-indigo-100">Perfect for real estate professionals</p>
                        </div>

                        <div class="p-8">
                            <div class="text-center mb-8">
                                <div class="flex items-baseline justify-center mb-4">
                                    <span class="text-5xl font-bold text-gray-900">$4.99</span>
                                    <span class="text-xl text-gray-500 ml-2">/month</span>
                                </div>
                                <p class="text-gray-600">Start with a 14-day free trial</p>
                            </div>

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Unlimited property listings</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Visitor sign-in management</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Photo galleries & virtual tours</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">PDF exports & reports</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Open house management</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Public listing pages</span>
                                </li>
                            </ul>

                            <a href="{{ route('register') }}" class="block w-full btn-primary text-white py-4 px-6 rounded-xl font-semibold text-center hover-scale">
                                Start Free Trial
                            </a>

                            <p class="text-center mt-4 text-sm text-gray-500">
                                Cancel anytime • No setup fees
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-bold text-white mb-4">
                    Ready to Transform Your Business?
                </h2>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of real estate professionals who are already using Open House
                    to manage their properties and close more deals.
                </p>
                <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg hover-scale">
                    Get Started Today
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-32 h-auto mb-4">
                        <p class="text-gray-400">
                            The complete property management platform for real estate professionals.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Product</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                            <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Company</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Support</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 Open House. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
