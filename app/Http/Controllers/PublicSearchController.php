<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicSearchController extends Controller
{
    /**
     * Display the public property search page with map.
     */
    public function index(Request $request): View
    {
        $query = Property::where('status', 'active')
                        ->where('is_public', true);

        // Search by location
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('address', 'like', "%{$location}%")
                  ->orWhere('city', 'like', "%{$location}%")
                  ->orWhere('state', 'like', "%{$location}%")
                  ->orWhere('zip_code', 'like', "%{$location}%");
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        $properties = $query->with('user')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

        // Get property types for filter dropdown
        $propertyTypes = Property::where('status', 'active')
                                ->where('is_public', true)
                                ->distinct()
                                ->pluck('property_type')
                                ->filter()
                                ->values();

        // Get price ranges for filter
        $priceRanges = [
            '0-100000' => 'Under $100k',
            '100000-200000' => '$100k - $200k',
            '200000-300000' => '$200k - $300k',
            '300000-400000' => '$300k - $400k',
            '400000-500000' => '$400k - $500k',
            '500000-750000' => '$500k - $750k',
            '750000-1000000' => '$750k - $1M',
            '1000000-999999999' => 'Over $1M',
        ];

        return view('public.search', compact('properties', 'propertyTypes', 'priceRanges'));
    }

    /**
     * Get properties for map markers (AJAX).
     */
    public function getMapProperties(Request $request)
    {
        $properties = Property::where('status', 'active')
                             ->where('is_public', true)
                             ->select('id', 'title', 'street_address', 'city', 'state', 'zip_code', 'list_price', 'bedrooms', 'bathrooms', 'total_bathrooms', 'property_type', 'featured_image', 'latitude', 'longitude', 'slug')
                             ->get()
                             ->map(function($property) {
                                 // If property doesn't have coordinates, geocode the address
                                 if (!$property->latitude || !$property->longitude) {
                                     $coordinates = $this->geocodeAddress($property);
                                     if ($coordinates) {
                                         // Update the property with coordinates
                                         Property::where('id', $property->id)->update([
                                             'latitude' => $coordinates['lat'],
                                             'longitude' => $coordinates['lng']
                                         ]);
                                         $property->latitude = $coordinates['lat'];
                                         $property->longitude = $coordinates['lng'];
                                     }
                                 }

                                 return [
                                     'id' => $property->id,
                                     'title' => $property->title,
                                     'address' => $property->street_address . ', ' . $property->city . ', ' . $property->state . ' ' . $property->zip_code,
                                     'price' => $property->list_price ? '$' . number_format($property->list_price) : 'Price on request',
                                     'bedrooms' => $property->bedrooms,
                                     'bathrooms' => $property->total_bathrooms ?? $property->bathrooms,
                                     'property_type' => $property->property_type,
                                     'image' => $property->featured_image ? asset('storage/' . $property->featured_image) : null,
                                     'url' => route('public.property.show', $property->slug ?? 'property-' . $property->id),
                                     'position' => [
                                         'lat' => $property->latitude ?? 30.3322,
                                         'lng' => $property->longitude ?? -81.6557
                                     ]
                                 ];
                             });

        return response()->json($properties);
    }

    /**
     * Geocode an address using OpenStreetMap Nominatim API.
     */
    private function geocodeAddress($property)
    {
        $address = $property->street_address . ', ' . $property->city . ', ' . $property->state . ' ' . $property->zip_code;
        $address = urlencode($address);

        $url = "https://nominatim.openstreetmap.org/search?format=json&q={$address}&limit=1";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lng' => (float) $data[0]['lon']
                ];
            }
        } catch (\Exception $e) {
            // Log error if needed
        }

        return null;
    }
}
