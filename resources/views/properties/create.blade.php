@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mls_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">MLS Number</label>
                        <input type="text" id="mls_number" name="mls_number" value="{{ old('mls_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter MLS number">
                        @error('mls_number')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Property Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter property title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Property Type *</label>
                        <select id="property_type" name="property_type" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            <option value="">Select property type</option>
                            @foreach($property->getPropertyTypeOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('property_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('property_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            @foreach($property->getStatusOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('status', 'active') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <div id="quill-editor" class="bg-white dark:bg-gray-700 rounded-xl border border-gray-300 dark:border-gray-600" style="min-height: 300px;">
                        {!! old('description') !!}
                    </div>
                    <input type="hidden" name="description" id="description-input">
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Address Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Street Address *</label>
                        <input type="text" id="street_address" name="street_address" value="{{ old('street_address') }}" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter street address">
                        @error('street_address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City *</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter city">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State *</label>
                        <input type="text" id="state" name="state" value="{{ old('state') }}" required maxlength="2"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus uppercase"
                               placeholder="CA">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ZIP Code *</label>
                        <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter ZIP code">
                        @error('zip_code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="county" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">County</label>
                        <input type="text" id="county" name="county" value="{{ old('county') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter county">
                        @error('county')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subdivision" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subdivision</label>
                        <input type="text" id="subdivision" name="subdivision" value="{{ old('subdivision') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter subdivision">
                        @error('subdivision')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Pricing</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="list_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">List Price *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" id="list_price" name="list_price" value="{{ old('list_price') }}" required step="0.01" min="0"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                   placeholder="0.00">
                        </div>
                        @error('list_price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Original Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" id="original_price" name="original_price" value="{{ old('original_price') }}" step="0.01" min="0"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                   placeholder="0.00">
                        </div>
                        @error('original_price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price_per_sqft" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price per Sq Ft</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="text" id="price_per_sqft" name="price_per_sqft" value="{{ old('price_per_sqft') }}"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                   placeholder="0.00">
                        </div>
                        @error('price_per_sqft')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Property Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bedrooms</label>
                        <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="0">
                        @error('bedrooms')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bathrooms</label>
                        <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0" step="0.5"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="0">
                        @error('bathrooms')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="half_bathrooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Half Bathrooms</label>
                        <input type="number" id="half_bathrooms" name="half_bathrooms" value="{{ old('half_bathrooms', 0) }}" min="0"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="0">
                        @error('half_bathrooms')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="square_feet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Square Feet</label>
                        <input type="number" id="square_feet" name="square_feet" value="{{ old('square_feet') }}" min="0"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="0">
                        @error('square_feet')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lot_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lot Size</label>
                        <input type="number" id="lot_size" name="lot_size" value="{{ old('lot_size') }}" min="0"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="0">
                        @error('lot_size')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lot_size_units" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lot Size Units</label>
                        <select id="lot_size_units" name="lot_size_units"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            @foreach($property->getLotSizeUnitsOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('lot_size_units', 'sqft') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('lot_size_units')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year_built" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Year Built</label>
                        <input type="number" id="year_built" name="year_built" value="{{ old('year_built') }}" min="1800" max="{{ date('Y') + 1 }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="2024">
                        @error('year_built')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="garage_spaces" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Garage Spaces</label>
                        <input type="text" id="garage_spaces" name="garage_spaces" value="{{ old('garage_spaces') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="2 car">
                        @error('garage_spaces')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Property Features -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Property Features</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="heating_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Heating Type</label>
                        <input type="text" id="heating_type" name="heating_type" value="{{ old('heating_type') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Central, Forced Air, etc.">
                        @error('heating_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cooling_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cooling Type</label>
                        <input type="text" id="cooling_type" name="cooling_type" value="{{ old('cooling_type') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Central AC, Window Units, etc.">
                        @error('cooling_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="appliances" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Appliances</label>
                        <input type="text" id="appliances" name="appliances" value="{{ old('appliances') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Refrigerator, Dishwasher, etc.">
                        @error('appliances')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="flooring" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Flooring</label>
                        <input type="text" id="flooring" name="flooring" value="{{ old('flooring') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Hardwood, Carpet, Tile, etc.">
                        @error('flooring')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="roof_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roof Type</label>
                        <input type="text" id="roof_type" name="roof_type" value="{{ old('roof_type') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Asphalt Shingle, Tile, etc.">
                        @error('roof_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parking_spaces" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parking Spaces</label>
                        <input type="text" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="2 spaces, Street parking, etc.">
                        @error('parking_spaces')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label for="exterior_features" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Exterior Features</label>
                        <textarea id="exterior_features" name="exterior_features" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                  placeholder="Patio, Deck, Pool, etc.">{{ old('exterior_features') }}</textarea>
                        @error('exterior_features')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="interior_features" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Interior Features</label>
                        <textarea id="interior_features" name="interior_features" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                  placeholder="Fireplace, Walk-in closet, etc.">{{ old('interior_features') }}</textarea>
                        @error('interior_features')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="community_features" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Community Features</label>
                        <textarea id="community_features" name="community_features" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                  placeholder="Pool, Gym, Clubhouse, etc.">{{ old('community_features') }}</textarea>
                        @error('community_features')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- MLS Information -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">MLS Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="listing_office" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Listing Office</label>
                        <input type="text" id="listing_office" name="listing_office" value="{{ old('listing_office') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter listing office">
                        @error('listing_office')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="listing_agent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Listing Agent</label>
                        <input type="text" id="listing_agent" name="listing_agent" value="{{ old('listing_agent') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter listing agent">
                        @error('listing_agent')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="buyer_agent_commission" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buyer Agent Commission</label>
                        <input type="text" id="buyer_agent_commission" name="buyer_agent_commission" value="{{ old('buyer_agent_commission') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="2.5%, $5,000, etc.">
                        @error('buyer_agent_commission')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="property_tax" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Property Tax</label>
                        <input type="text" id="property_tax" name="property_tax" value="{{ old('property_tax') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="$5,000/year">
                        @error('property_tax')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hoa_fees" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HOA Fees</label>
                        <input type="text" id="hoa_fees" name="hoa_fees" value="{{ old('hoa_fees') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="$200/month">
                        @error('hoa_fees')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hoa_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HOA Frequency</label>
                        <select id="hoa_frequency" name="hoa_frequency"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            <option value="">Select frequency</option>
                            @foreach($property->getHoaFrequencyOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('hoa_frequency') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('hoa_frequency')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="list_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">List Date</label>
                        <input type="date" id="list_date" name="list_date" value="{{ old('list_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                        @error('list_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiration Date</label>
                        <input type="date" id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                        @error('expiration_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Open House Information -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Open House Information</h3>

                <div class="space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="has_open_house" name="has_open_house" value="1" {{ old('has_open_house') ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="has_open_house" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            This property has an open house scheduled
                        </label>
                    </div>

                    <div id="open-house-details" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: {{ old('has_open_house') ? 'grid' : 'none' }};">
                        <div>
                            <label for="open_house_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Open House Start</label>
                            <input type="datetime-local" id="open_house_start" name="open_house_start" value="{{ old('open_house_start') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            @error('open_house_start')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="open_house_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Open House End</label>
                            <input type="datetime-local" id="open_house_end" name="open_house_end" value="{{ old('open_house_end') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                            @error('open_house_end')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="open_house_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Open House Notes</label>
                            <textarea id="open_house_notes" name="open_house_notes" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                      placeholder="Special instructions, refreshments, etc.">{{ old('open_house_notes') }}</textarea>
                            @error('open_house_notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Upload -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Media</h3>

                <div class="space-y-6">
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload the main image for this property (max 2MB)</p>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gallery_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gallery Images</label>
                        <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload additional images for the gallery (max 2MB each)</p>
                        @error('gallery_images.*')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="virtual_tour_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Virtual Tour URL</label>
                            <input type="url" id="virtual_tour_url" name="virtual_tour_url" value="{{ old('virtual_tour_url') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                   placeholder="https://example.com/virtual-tour">
                            @error('virtual_tour_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Video URL</label>
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                   placeholder="https://youtube.com/watch?v=...">
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div class="bg-white dark:bg-gray-800 card-shadow rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">SEO & Marketing</h3>

                <div class="space-y-6">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="60"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                               placeholder="Enter SEO title (max 60 characters)">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave blank to use property title</p>
                        @error('meta_title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white input-focus"
                                  placeholder="Enter SEO description (max 160 characters)">{{ old('meta_description') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave blank to auto-generate from description</p>
                        @error('meta_description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('properties.index') }}"
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 font-medium transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="btn-primary px-8 py-3 text-white font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Property
                </button>
            </div>
        </form>
    </div>

    <!-- Quill Editor Styles -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Initialize Quill Editor
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Enter property description...'
        });

        // Update hidden input when content changes
        quill.on('text-change', function() {
            document.getElementById('description-input').value = quill.root.innerHTML;
        });

        // Set initial content if editing
        @if(old('description'))
            quill.root.innerHTML = {!! json_encode(old('description')) !!};
        @endif

        // Toggle open house details
        document.getElementById('has_open_house').addEventListener('change', function() {
            const details = document.getElementById('open-house-details');
            details.style.display = this.checked ? 'grid' : 'none';
        });
    </script>
@endsection
