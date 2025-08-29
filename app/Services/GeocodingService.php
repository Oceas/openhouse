<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    protected $baseUrl = 'https://nominatim.openstreetmap.org/search';

    /**
     * Geocode an address to get latitude and longitude using OpenStreetMap Nominatim
     *
     * @param string $address
     * @return array|null ['latitude' => float, 'longitude' => float] or null if failed
     */
    public function geocodeAddress(string $address): ?array
    {
        if (empty($address)) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'OpenHouse-RealEstate-Platform/1.0',
            ])->get($this->baseUrl, [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                    return [
                        'latitude' => (float) $data[0]['lat'],
                        'longitude' => (float) $data[0]['lon'],
                    ];
                } else {
                    Log::warning('Geocoding failed for address: ' . $address, [
                        'response' => $data,
                    ]);
                }
            } else {
                Log::error('Geocoding API request failed', [
                    'status_code' => $response->status(),
                    'response' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Geocoding service error', [
                'address' => $address,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * Build a full address from property components
     *
     * @param array $propertyData
     * @return string
     */
    public function buildAddressFromProperty(array $propertyData): string
    {
        $parts = [];

        if (!empty($propertyData['street_address'])) {
            $parts[] = $propertyData['street_address'];
        }

        if (!empty($propertyData['city'])) {
            $parts[] = $propertyData['city'];
        }

        if (!empty($propertyData['state'])) {
            $parts[] = $propertyData['state'];
        }

        if (!empty($propertyData['zip_code'])) {
            $parts[] = $propertyData['zip_code'];
        }

        return implode(', ', $parts);
    }

    /**
     * Check if address components have changed
     *
     * @param array $newData
     * @param array $oldData
     * @return bool
     */
    public function hasAddressChanged(array $newData, array $oldData): bool
    {
        $addressFields = ['street_address', 'city', 'state', 'zip_code'];
        
        foreach ($addressFields as $field) {
            if (($newData[$field] ?? '') !== ($oldData[$field] ?? '')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get usage policy information
     *
     * @return array
     */
    public function getUsagePolicy(): array
    {
        return [
            'service' => 'OpenStreetMap Nominatim',
            'free' => true,
            'rate_limit' => '1 request per second',
            'usage_policy' => 'https://operations.osmfoundation.org/policies/nominatim/',
            'attribution' => '© OpenStreetMap contributors',
        ];
    }
}
