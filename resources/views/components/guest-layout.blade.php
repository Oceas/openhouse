<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Open House - {{ $title ?? 'Authentication' }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/open-house.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

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
                background: linear-gradient(135deg, #EBF4FF 0%, #FFFFFF 50%, #E0E7FF 100%);
            }
            .dark .gradient-bg {
                background: linear-gradient(135deg, #111827 0%, #1F2937 50%, #111827 100%);
            }
            .card-shadow {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            .input-focus {
                transition: all 0.2s ease-in-out;
            }
            .input-focus:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
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
    <body class="gradient-bg font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Header -->
            <div class="mb-8 p-4">
                <a href="/" class="flex justify-center">
                    <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-64 h-auto">
                </a>
            </div>

            <!-- Main Card -->
            <div class="w-full sm:max-w-md px-8 py-8 bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    © 2024 Open House. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Background Decoration -->
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl"></div>
        </div>
    </body>
</html>
