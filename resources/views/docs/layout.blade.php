<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Documentation') - Open House</title>
    <meta name="description" content="@yield('description', 'Open House Documentation')">
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
        .doc-nav-link {
            @apply block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors;
        }
        .doc-nav-link.active {
            @apply bg-indigo-50 text-indigo-700 font-medium;
        }
        .doc-content h1 {
            @apply text-3xl font-bold text-gray-900 mb-6;
        }
        .doc-content h2 {
            @apply text-2xl font-semibold text-gray-900 mt-8 mb-4;
        }
        .doc-content h3 {
            @apply text-xl font-semibold text-gray-900 mt-6 mb-3;
        }
        .doc-content p {
            @apply text-gray-600 mb-4 leading-relaxed;
        }
        .doc-content ul {
            @apply list-disc list-inside text-gray-600 mb-4 space-y-1;
        }
        .doc-content ol {
            @apply list-decimal list-inside text-gray-600 mb-4 space-y-1;
        }
        .doc-content code {
            @apply bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm font-mono;
        }
        .doc-content pre {
            @apply bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto mb-4;
        }
        .doc-content pre code {
            @apply bg-transparent text-gray-100 p-0;
        }
        .doc-content blockquote {
            @apply border-l-4 border-indigo-200 pl-4 italic text-gray-600 mb-4;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center p-3">
                    <a href="/">
                        <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-32 h-auto">
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Home</a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Documentation</h2>
                <nav class="space-y-1">
                    <a href="/docs/getting-started" class="doc-nav-link {{ request()->is('docs/getting-started') ? 'active' : '' }}">
                        Getting Started
                    </a>
                    <a href="/docs/property-management" class="doc-nav-link {{ request()->is('docs/property-management') ? 'active' : '' }}">
                        Property Management
                    </a>
                    <a href="/docs/visitor-tracking" class="doc-nav-link {{ request()->is('docs/visitor-tracking') ? 'active' : '' }}">
                        Visitor Tracking
                    </a>
                    <a href="/docs/subscriptions" class="doc-nav-link {{ request()->is('docs/subscriptions') ? 'active' : '' }}">
                        Subscriptions & Billing
                    </a>
                    <a href="/docs/api" class="doc-nav-link {{ request()->is('docs/api') ? 'active' : '' }}">
                        API Reference
                    </a>
                    <a href="/docs/faq" class="doc-nav-link {{ request()->is('docs/faq') ? 'active' : '' }}">
                        FAQ
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-4xl">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
