<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $property->title }}
            </h2>
                            <div class="flex space-x-3">
                    @if($property->status === 'active')
                        <a href="{{ route('public.property.show', $property->slug) }}"
                           target="_blank"
                           class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                            View Public Page
                        </a>
                    @endif
                               <a href="{{ route('properties.visitors.index', $property) }}"
              class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
               View Visitors ({{ $property->visitorSignins()->count() }})
           </a>
           <a href="{{ route('public.property.signin.form', $property->slug) }}"
              target="_blank"
              class="bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 hover:bg-purple-200 dark:hover:bg-purple-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
               View Sign-in Form
           </a>
                    <a href="{{ route('properties.edit', $property) }}"
                       class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                        Edit Property
                    </a>
                <a href="{{ route('properties.pdf', $property) }}"
                   class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                    Download PDF
                </a>
                <a href="{{ route('properties.index') }}"
                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium">
                    ← Back to Properties
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Property Header -->
        <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="relative h-96 bg-gray-200 dark:bg-gray-700">
                @if($property->featured_image)
                    <img src="{{ Storage::url($property->featured_image) }}"
                         alt="{{ $property->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif

                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
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
                    <span class="px-3 py-1 text-sm font-medium text-white rounded-full {{ $statusColor }}">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>

                <!-- Open House Badge -->
                @if($property->has_open_house && $property->is_open_house_active)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-full">
                            Open House Now
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $property->title }}</h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400 mb-4">{{ $property->full_address }}</p>

                        <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                            @if($property->mls_number)
                                <span><strong>MLS:</strong> {{ $property->mls_number }}</span>
                            @endif
                            @if($property->bedrooms)
                                <span><strong>{{ $property->bedrooms }}</strong> bed</span>
                            @endif
                            @if($property->bathrooms)
                                <span><strong>{{ $property->bathrooms }}</strong> bath</span>
                            @endif
                            @if($property->square_feet)
                                <span><strong>{{ number_format($property->square_feet) }}</strong> sqft</span>
                            @endif
                            @if($property->year_built)
                                <span><strong>{{ $property->year_built }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 lg:mt-0 text-right">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white">{{ $property->formatted_price }}</div>
                        @if($property->formatted_price_per_sqft !== 'N/A')
                            <div class="text-lg text-gray-600 dark:text-gray-400">{{ $property->formatted_price_per_sqft }} per sqft</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                @if($property->description)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Description</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $property->description !!}
                        </div>
                    </div>
                @endif

                <!-- Property Details -->
                <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Property Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Property Type</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</span>
                            </div>

                            @if($property->bedrooms)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Bedrooms</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->bedrooms }}</span>
                                </div>
                            @endif

                            @if($property->bathrooms)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Bathrooms</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->bathrooms }}</span>
                                </div>
                            @endif

                            @if($property->half_bathrooms)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Half Bathrooms</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->half_bathrooms }}</span>
                                </div>
                            @endif

                            @if($property->square_feet)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Square Feet</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($property->square_feet) }}</span>
                                </div>
                            @endif

                            @if($property->lot_size)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Lot Size</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->formatted_lot_size }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @if($property->year_built)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Year Built</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->year_built }}</span>
                                </div>
                            @endif

                            @if($property->garage_spaces)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Garage</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->garage_spaces }}</span>
                                </div>
                            @endif

                            @if($property->parking_spaces)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Parking</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->parking_spaces }}</span>
                                </div>
                            @endif

                            @if($property->heating_type)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Heating</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->heating_type }}</span>
                                </div>
                            @endif

                            @if($property->cooling_type)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Cooling</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->cooling_type }}</span>
                                </div>
                            @endif

                            @if($property->flooring)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Flooring</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $property->flooring }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Features -->
                @if($property->exterior_features || $property->interior_features || $property->community_features)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Features</h3>

                        <div class="space-y-6">
                            @if($property->exterior_features)
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Exterior Features</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $property->exterior_features }}</p>
                                </div>
                            @endif

                            @if($property->interior_features)
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Interior Features</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $property->interior_features }}</p>
                                </div>
                            @endif

                            @if($property->community_features)
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Community Features</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $property->community_features }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Gallery -->
                @if($property->gallery_images && count($property->gallery_images) > 0)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Gallery</h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($property->gallery_images as $image)
                                <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-xl overflow-hidden">
                                    <img src="{{ Storage::url($image) }}"
                                         alt="Gallery image"
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Quick Info -->
                <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Info</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">List Price</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $property->formatted_price }}</span>
                        </div>

                        @if($property->original_price && $property->original_price != $property->list_price)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Original Price</span>
                                <span class="font-medium text-gray-900 dark:text-white line-through">${{ number_format($property->original_price) }}</span>
                            </div>
                        @endif

                        @if($property->formatted_price_per_sqft !== 'N/A')
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Price per Sq Ft</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $property->formatted_price_per_sqft }}</span>
                            </div>
                        @endif

                        @if($property->property_tax)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Property Tax</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $property->property_tax }}</span>
                            </div>
                        @endif

                        @if($property->hoa_fees)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">HOA Fees</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $property->hoa_fees }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Open House Info -->
                @if($property->has_open_house)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Open House</h3>

                        <div class="space-y-3">
                            @if($property->open_house_start)
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Start</span>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $property->open_house_start->format('M j, Y g:i A') }}
                                    </div>
                                </div>
                            @endif

                            @if($property->open_house_end)
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">End</span>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $property->open_house_end->format('M j, Y g:i A') }}
                                    </div>
                                </div>
                            @endif

                            @if($property->open_house_notes)
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Notes</span>
                                    <div class="text-gray-900 dark:text-white">{{ $property->open_house_notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- MLS Info -->
                <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">MLS Information</h3>

                    <div class="space-y-3">
                        @if($property->listing_office)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Listing Office</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $property->listing_office }}</div>
                            </div>
                        @endif

                        @if($property->listing_agent)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Listing Agent</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $property->listing_agent }}</div>
                            </div>
                        @endif

                        @if($property->buyer_agent_commission)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Buyer Agent Commission</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $property->buyer_agent_commission }}</div>
                            </div>
                        @endif

                        @if($property->list_date)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">List Date</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $property->list_date->format('M j, Y') }}</div>
                            </div>
                        @endif

                        @if($property->expiration_date)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Expiration Date</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $property->expiration_date->format('M j, Y') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Media Links -->
                @if($property->virtual_tour_url || $property->video_url)
                    <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Media</h3>

                        <div class="space-y-3">
                            @if($property->virtual_tour_url)
                                <a href="{{ $property->virtual_tour_url }}" target="_blank"
                                   class="block w-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-800/50 px-4 py-2 rounded-xl font-medium text-center transition-colors duration-200">
                                    Virtual Tour
                                </a>
                            @endif

                            @if($property->video_url)
                                <a href="{{ $property->video_url }}" target="_blank"
                                   class="block w-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800/50 px-4 py-2 rounded-xl font-medium text-center transition-colors duration-200">
                                    Watch Video
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
