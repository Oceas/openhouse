<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class PopulatePropertyCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:geocode {--force : Force update all properties}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate latitude and longitude for all properties by geocoding their addresses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting property geocoding...');

        $query = Property::query();
        
        if (!$this->option('force')) {
            $query->whereNull('latitude')
                  ->orWhereNull('longitude');
        }

        $properties = $query->get();
        
        if ($properties->isEmpty()) {
            $this->info('No properties need geocoding.');
            return 0;
        }

        $this->info("Found {$properties->count()} properties to geocode.");
        
        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($properties as $property) {
            try {
                $coordinates = $this->geocodeAddress($property);
                
                if ($coordinates) {
                    $property->update([
                        'latitude' => $coordinates['lat'],
                        'longitude' => $coordinates['lng']
                    ]);
                    $successCount++;
                    $this->line("\n✅ Geocoded: {$property->title} - {$coordinates['lat']}, {$coordinates['lng']}");
                } else {
                    $errorCount++;
                    $this->line("\n❌ Failed to geocode: {$property->title}");
                }
                
                // Be respectful to the Nominatim API - add a small delay
                usleep(1000000); // 1 second delay
                
            } catch (\Exception $e) {
                $errorCount++;
                $this->line("\n❌ Error geocoding {$property->title}: " . $e->getMessage());
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Geocoding completed!");
        $this->info("✅ Successfully geocoded: {$successCount} properties");
        $this->info("❌ Failed to geocode: {$errorCount} properties");

        // Show summary of all properties with coordinates
        $this->newLine();
        $this->info('Properties with coordinates:');
        $propertiesWithCoords = Property::whereNotNull('latitude')
                                       ->whereNotNull('longitude')
                                       ->get(['title', 'latitude', 'longitude']);
        
        foreach ($propertiesWithCoords as $property) {
            $this->line("📍 {$property->title}: {$property->latitude}, {$property->longitude}");
        }

        return 0;
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
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'OpenHouse/1.0'
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return null;
            }
            
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
