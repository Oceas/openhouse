@extends('layouts.app')

@section('content')

    <div class="space-y-6">
        <!-- Header with Add Property Button -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Properties</h2>
            <a href="{{ route('properties.create') }}" class="btn-primary px-6 py-3 text-white font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Property
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Property Image -->
                        <div class="relative h-48 bg-gray-200 dark:bg-gray-700">
                            @if($property->featured_image)
                                <img src="{{ Storage::url($property->featured_image) }}"
                                     alt="{{ $property->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-3 left-3">
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-500',
                                        'pending' => 'bg-yellow-500',
                                        'sold' => 'bg-blue-500',
                                        'withdrawn' => 'bg-red-500',
                                        'expired' => 'bg-gray-500'
                                    ];
                                    $statusColor = $statusColors[$property->status] ?? 'bg-gray-500';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium text-white rounded-full {{ $statusColor }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>

                            <!-- Open House Badge -->
                            @if($property->has_open_house && $property->is_open_house_active)
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-1 text-xs font-medium text-white bg-red-500 rounded-full">
                                        Open House
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Property Details -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $property->title }}
                                </h3>
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                {{ $property->full_address }}
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $property->formatted_price }}
                                </span>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($property->bedrooms)
                                        <span class="mr-2">{{ $property->bedrooms }} bed</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span class="mr-2">{{ $property->bathrooms }} bath</span>
                                    @endif
                                    @if($property->square_feet)
                                        <span>{{ number_format($property->square_feet) }} sqft</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Primary Action Buttons -->
                            <div class="flex space-x-2 mb-3">
                                <a href="{{ route('properties.show', $property) }}"
                                   class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium py-2 px-3 rounded-lg text-center transition-colors duration-200">
                                    View
                                </a>
                                <a href="{{ route('properties.edit', $property) }}"
                                   class="flex-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 text-sm font-medium py-2 px-3 rounded-lg text-center transition-colors duration-200">
                                    Edit
                                </a>
                                <a href="{{ route('properties.pdf', $property) }}"
                                   class="flex-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800/50 text-sm font-medium py-2 px-3 rounded-lg text-center transition-colors duration-200">
                                    PDF
                                </a>
                            </div>

                            <!-- Secondary Action Buttons -->
                            <div class="flex space-x-2 mb-3">
                                <a href="{{ route('properties.visitors.index', $property) }}"
                                   class="flex-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800/50 text-sm font-medium py-2 px-3 rounded-lg text-center transition-colors duration-200">
                                    Visitors ({{ $property->visitorSignins()->count() }})
                                </a>
                                <a href="{{ route('public.property.signin.form', ['address' => $property->url_address, 'ooh_id' => $property->ooh_id]) }}"
                                   target="_blank"
                                   class="flex-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 hover:bg-purple-200 dark:hover:bg-purple-800/50 text-sm font-medium py-2 px-3 rounded-lg text-center transition-colors duration-200">
                                    Sign-in Form
                                </a>
                            </div>

                            <!-- Public Link -->
                            @if($property->status === 'active')
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Public Link:</span>
                                        <div class="flex items-center space-x-2">
                                            <input type="text"
                                                   value="{{ route('public.property.show', ['address' => $property->url_address, 'ooh_id' => $property->ooh_id]) }}"
                                                   readonly
                                                   class="text-xs bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-gray-600 dark:text-gray-400 w-48">
                                            <button onclick="copyToClipboard(this)"
                                                    class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800/50 px-2 py-1 rounded transition-colors duration-200">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No properties yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Get started by adding your first property listing.</p>
                <a href="{{ route('properties.create') }}" class="btn-primary px-6 py-3 text-white font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Your First Property
                </a>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard(button) {
            const input = button.previousElementSibling;
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices

            try {
                document.execCommand('copy');
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-green-100', 'text-green-700');
                button.classList.remove('bg-blue-100', 'text-blue-700');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-100', 'text-green-700');
                    button.classList.add('bg-blue-100', 'text-blue-700');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
    </script>
@endsection
