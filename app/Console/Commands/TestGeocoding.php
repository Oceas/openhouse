<?php

namespace App\Console\Commands;

use App\Services\GeocodingService;
use Illuminate\Console\Command;

class TestGeocoding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:geocoding {address? : Address to geocode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the geocoding service with a sample address using OpenStreetMap Nominatim';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $geocodingService = new GeocodingService();
        
        // Default test address if none provided
        $address = $this->argument('address') ?? '1600 Pennsylvania Avenue NW, Washington, DC 20500';
        
        $this->info("Testing geocoding for address: {$address}");
        $this->newLine();
        
        // Show service information
        $policy = $geocodingService->getUsagePolicy();
        $this->info("Using: {$policy['service']} (Free service)");
        $this->info("Rate limit: {$policy['rate_limit']}");
        $this->newLine();
        
        $this->info('Attempting to geocode...');
        $this->newLine();
        
        try {
            $coordinates = $geocodingService->geocodeAddress($address);
            
            if ($coordinates) {
                $this->info('✓ Geocoding successful!');
                $this->table(
                    ['Field', 'Value'],
                    [
                        ['Address', $address],
                        ['Latitude', $coordinates['latitude']],
                        ['Longitude', $coordinates['longitude']],
                    ]
                );
                
                // Show OpenStreetMap link
                $mapsUrl = "https://www.openstreetmap.org/?mlat={$coordinates['latitude']}&mlon={$coordinates['longitude']}&zoom=15";
                $this->info("View on OpenStreetMap: {$mapsUrl}");
                
                // Show Google Maps link as alternative
                $googleMapsUrl = "https://www.google.com/maps?q={$coordinates['latitude']},{$coordinates['longitude']}";
                $this->info("View on Google Maps: {$googleMapsUrl}");
                
            } else {
                $this->error('✗ Geocoding failed!');
                $this->info('Check the logs for more details.');
                $this->info('Try a different address or check the address format.');
            }
            
        } catch (\Exception $e) {
            $this->error('✗ Error during geocoding: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
