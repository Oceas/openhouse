<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Property Search - Open House</title>
    <link rel="icon" type="image/png" href="{{ asset('images/open-house.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS and JS for OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .map-container {
            height: calc(100vh - 200px);
            min-height: 400px;
            width: 100%;
        }
        .property-card {
            transition: all 0.3s ease;
        }
        .property-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .filter-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .map-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
        .property-marker {
            background: #3B82F6;
            border: 2px solid white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .property-marker:hover {
            background: #1D4ED8;
            transform: scale(1.1);
        }
        .property-popup {
            max-width: 300px;
        }
        .property-popup img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <img src="{{ asset('images/open-house.png') }}" alt="Open House" class="w-32 h-auto">
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div x-data="mapData" class="relative">

        <!-- Search Header -->
        <div class="bg-white border-b border-gray-200 px-4 py-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Find Your Dream Home</h1>

                <!-- Search Form -->
                <form method="GET" action="{{ route('public.search') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-64">
                        <input type="text"
                               name="location"
                               placeholder="Enter city, state, or zip code"
                               value="{{ request('location') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex gap-2">
                        <select name="property_type" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Types</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', ucfirst($type)) }}
                                </option>
                            @endforeach
                        </select>

                        <select name="bedrooms" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Any Beds</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+ Bed</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+ Beds</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Beds</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+ Beds</option>
                        </select>

                        <select name="bathrooms" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Any Baths</option>
                            <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+ Bath</option>
                            <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+ Baths</option>
                            <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+ Baths</option>
                        </select>

                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700">
                            Search
                        </button>
                    </div>
                </form>

                <!-- Filter Toggle -->
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center space-x-4">
                        <button @click="showFilters = !showFilters"
                                class="flex items-center space-x-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span>More Filters</span>
                        </button>

                        <span class="text-gray-500">{{ $properties->total() }} properties found</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button @click="showMap = false"
                                :class="!showMap ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg font-medium">
                            List View
                        </button>
                        <button @click="showMap = true"
                                :class="showMap ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                                class="px-4 py-2 rounded-lg font-medium">
                            Map View
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div x-show="showFilters"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="bg-white border-b border-gray-200 px-4 py-6">
            <div class="max-w-7xl mx-auto">
                <form method="GET" action="{{ route('public.search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="flex space-x-2">
                            <input type="number"
                                   name="min_price"
                                   placeholder="Min"
                                   value="{{ request('min_price') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <input type="number"
                                   name="max_price"
                                   placeholder="Max"
                                   value="{{ request('max_price') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select name="property_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Types</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', ucfirst($type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <select name="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                        <select name="bathrooms" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex">
            <!-- Map View -->
            <div x-show="showMap"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex-1 relative">
                <div id="map" class="map-container"></div>
                <!-- Fallback message if map fails to load -->
                <div x-show="!map" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                    <div class="text-center">
                        <p class="text-gray-600">Loading map...</p>
                    </div>
                </div>

                <!-- Property Details Panel -->
                <div x-show="selectedProperty"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-x-full"
                     x-transition:enter-end="transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="transform translate-x-0"
                     x-transition:leave-end="transform translate-x-full"
                     class="absolute top-4 right-4 w-96 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900" x-text="selectedProperty?.title"></h3>
                            <button @click="selectedProperty = null" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mb-3">
                            <img :src="selectedProperty?.image || '/images/placeholder.jpg'"
                                 :alt="selectedProperty?.title"
                                 class="w-full h-32 object-cover rounded-lg">
                        </div>

                        <div class="text-2xl font-bold text-indigo-600 mb-2" x-text="selectedProperty?.price"></div>

                        <div class="text-gray-600 mb-2" x-text="selectedProperty?.address"></div>

                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                            <span x-text="selectedProperty?.bedrooms + ' beds'"></span>
                            <span x-text="selectedProperty?.bathrooms + ' baths'"></span>
                            <span x-text="selectedProperty?.property_type"></span>
                        </div>

                        <a :href="selectedProperty?.url"
                           class="block w-full bg-indigo-600 text-white text-center py-2 rounded-lg font-medium hover:bg-indigo-700">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- List View -->
            <div x-show="!showMap"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($properties as $property)
                            <div class="property-card bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="relative">
                                    @if($property->featured_image)
                                        <img src="{{ asset('storage/' . $property->featured_image) }}"
                                             alt="{{ $property->title }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 bg-indigo-600 text-white px-2 py-1 rounded text-sm font-medium">
                                        {{ $property->formatted_price }}
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                                    <p class="text-gray-600 mb-3">{{ $property->full_address }}</p>

                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $property->bedrooms ?? 'N/A' }} beds</span>
                                            <span>{{ $property->total_bathrooms ?? $property->bathrooms ?? 'N/A' }} baths</span>
                                            <span>{{ str_replace('_', ' ', ucfirst($property->property_type)) }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Listed by {{ $property->user->name }}</span>
                                        <a href="{{ route('public.property.show', $property->slug) }}"
                                           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($properties->hasPages())
                        <div class="mt-8">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Test if Leaflet is loaded
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, Leaflet available:', typeof L !== 'undefined');
        });
        
        // Initialize map when Alpine.js is ready
        document.addEventListener('alpine:init', () => {
            Alpine.data('mapData', () => ({
                showMap: true,
                showFilters: false,
                selectedProperty: null,
                map: null,
                markers: [],
                properties: [],
                loading: false,
                filters: {
                    location: '{{ request('location', '') }}',
                    min_price: '{{ request('min_price', '') }}',
                    max_price: '{{ request('max_price', '') }}',
                    property_type: '{{ request('property_type', '') }}',
                    bedrooms: '{{ request('bedrooms', '') }}',
                    bathrooms: '{{ request('bathrooms', '') }}'
                },

                init() {
                    // Initialize map when component is ready
                    this.$nextTick(() => {
                        if (this.showMap) {
                            this.initMap();
                            this.loadProperties();
                        }
                    });
                    
                    // Watch for map view changes
                    this.$watch('showMap', (newVal) => {
                        if (newVal && !this.map) {
                            this.$nextTick(() => {
                                this.initMap();
                                this.loadProperties();
                            });
                        }
                    });
                },

                initMap() {
                    try {
                        console.log('Initializing map...');
                        console.log('Leaflet available:', typeof L !== 'undefined');
                        
                        const mapContainer = document.getElementById('map');
                        console.log('Map container:', mapContainer);
                        console.log('Map container dimensions:', mapContainer?.offsetWidth, 'x', mapContainer?.offsetHeight);
                        
                        if (!mapContainer) {
                            console.error('Map container not found!');
                            return;
                        }
                        
                        if (typeof L === 'undefined') {
                            console.error('Leaflet not loaded!');
                            return;
                        }
                        
                        // Initialize the map with a default view, will be adjusted when properties load
                        this.map = L.map('map').setView([30.2639, -81.5246], 10);
                        console.log('Map initialized:', this.map);

                        // Add OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(this.map);
                        console.log('Map tiles added');
                        
                        // Map is ready for property markers
                        console.log('Map ready for property markers');
                        
                        // Add a simple marker to ensure map is working
                        const simpleMarker = L.marker([30.2639, -81.5246])
                            .addTo(this.map)
                            .bindPopup(`
                                <div class="property-popup" style="max-width: 280px;">
                                    <h3 class="font-semibold text-lg mb-1" style="color: #1f2937;">Anderson House</h3>
                                    <p class="text-indigo-600 font-bold text-lg mb-2">$375,000</p>
                                    <p class="text-gray-600 text-sm mb-3">4417 Ellipse Dr., Jacksonville, FL 32246</p>
                                    <div class="flex items-center space-x-3 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                            </svg>
                                            4 beds
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                            </svg>
                                            3 baths
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            2,200 sqft
                                        </span>
                                    </div>
                                    <a href="/p/anderson-house" class="block w-full bg-indigo-600 text-white text-center py-2 rounded font-medium hover:bg-indigo-700 transition-colors">
                                        View Details
                                    </a>
                                </div>
                            `);
                        console.log('Simple marker added to ensure map functionality');
                    } catch (error) {
                        console.error('Error initializing map:', error);
                    }
                },

                async loadProperties() {
                    try {
                        this.loading = true;
                        console.log('Loading properties...');
                        const response = await fetch('{{ route("public.search.map-properties") }}');
                        this.properties = await response.json();
                        console.log('Properties loaded:', this.properties.length, 'properties');
                        console.log('First property:', this.properties[0]);

                        // Only proceed if map is initialized
                        if (!this.map) {
                            console.warn('Map not initialized, skipping marker creation');
                            return;
                        }

                        // Clear existing markers
                        this.markers.forEach(marker => this.map.removeLayer(marker));
                        this.markers = [];

                        // Add markers for each property
                        this.properties.forEach(property => {
                            try {
                                console.log('Processing property:', property.title);
                                console.log('Property position:', property.position);

                                // Check if coordinates are valid
                                if (!property.position || !property.position.lat || !property.position.lng) {
                                    console.warn('Invalid coordinates for property:', property.title);
                                    return;
                                }

                                // Create marker with actual coordinates
                                const lat = parseFloat(property.position.lat);
                                const lng = parseFloat(property.position.lng);
                                console.log('Creating marker for:', property.title, 'at:', lat, lng);
                                
                                const marker = L.marker([lat, lng])
                                .addTo(this.map)
                                .bindPopup(`
                                    <div class="property-popup" style="max-width: 280px;">
                                        <div class="mb-3">
                                            <img src="${property.image || '/images/placeholder.jpg'}" alt="${property.title}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                        <h3 class="font-semibold text-lg mb-1" style="color: #1f2937;">${property.title}</h3>
                                        <p class="text-indigo-600 font-bold text-lg mb-2">${property.price}</p>
                                        <p class="text-gray-600 text-sm mb-3" style="line-height: 1.4;">${property.address}</p>
                                        <div class="flex items-center space-x-3 text-sm text-gray-500 mb-3">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                                </svg>
                                                ${property.bedrooms || 'N/A'} beds
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                                </svg>
                                                ${property.bathrooms || 'N/A'} baths
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                ${property.square_feet ? property.square_feet.toLocaleString() + ' sqft' : 'N/A'}
                                            </span>
                                        </div>
                                        <a href="${property.url}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded font-medium hover:bg-indigo-700 transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                `);

                            marker.on('click', () => {
                                this.selectedProperty = property;
                            });

                            this.markers.push(marker);
                            console.log('Marker created and added to map for:', property.title);
                            } catch (error) {
                                console.error('Error creating marker for property:', property.title, error);
                            }
                        });

                        // Fit map to show all markers if there are any
                        if (this.markers.length > 0) {
                            console.log('Fitting map to show', this.markers.length, 'markers');
                            const group = new L.featureGroup(this.markers);
                            const bounds = group.getBounds();
                            
                            // If we have multiple markers, fit to bounds with padding
                            if (this.markers.length > 1) {
                                this.map.fitBounds(bounds.pad(0.15));
                            } else {
                                // For single marker, center on it with appropriate zoom
                                this.map.setView(bounds.getCenter(), 14);
                            }
                            console.log('Map bounds adjusted');
                        } else {
                            console.warn('No markers were created');
                            // If no markers, center on default location
                            this.map.setView([30.2639, -81.5246], 10);
                        }

                    } catch (error) {
                        console.error('Error loading properties:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <div class="text-gray-500 text-sm">
                    © 2024 Open House. All rights reserved.
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Agent Sign In
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
