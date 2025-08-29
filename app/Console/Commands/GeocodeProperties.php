<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Services\GeocodingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GeocodeProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:geocode {--limit=50 : Number of properties to process at once} {--dry-run : Show what would be geocoded without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode properties that don\'t have latitude and longitude coordinates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $geocodingService = new GeocodingService();
        $limit = $this->option('limit');
        $dryRun = $this->option('dry-run');

        // Get properties without coordinates
        $properties = Property::whereNull('latitude')
            ->orWhereNull('longitude')
            ->orWhere('latitude', 0)
            ->orWhere('longitude', 0)
            ->limit($limit)
            ->get();

        if ($properties->isEmpty()) {
            $this->info('No properties found that need geocoding.');
            return 0;
        }

        $this->info("Found {$properties->count()} properties that need geocoding.");
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        $bar = $this->output->createProgressBar($properties->count());
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($properties as $property) {
            try {
                // Build the full address
                $address = $geocodingService->buildAddressFromProperty($property->toArray());
                
                if (empty($address)) {
                    $this->newLine();
                    $this->warn("Property ID {$property->id} has incomplete address information.");
                    $errorCount++;
                    $bar->advance();
                    continue;
                }

                $coordinates = $geocodingService->geocodeAddress($address);
                
                if ($coordinates) {
                    if (!$dryRun) {
                        $property->update([
                            'latitude' => $coordinates['latitude'],
                            'longitude' => $coordinates['longitude'],
                        ]);
                    }
                    
                    $successCount++;
                    $this->newLine();
                    $this->info("✓ Property ID {$property->id} geocoded: {$address} → {$coordinates['latitude']}, {$coordinates['longitude']}");
                } else {
                    $errorCount++;
                    $this->newLine();
                    $this->error("✗ Failed to geocode Property ID {$property->id}: {$address}");
                }
                
                // Add delay to respect OpenStreetMap's rate limit (1 request per second)
                sleep(1);
                
            } catch (\Exception $e) {
                $errorCount++;
                $this->newLine();
                $this->error("✗ Error geocoding Property ID {$property->id}: " . $e->getMessage());
                Log::error('Geocoding command error', [
                    'property_id' => $property->id,
                    'error' => $e->getMessage(),
                ]);
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("DRY RUN COMPLETE - Would have geocoded {$successCount} properties, {$errorCount} errors.");
        } else {
            $this->info("Geocoding complete! Successfully geocoded {$successCount} properties, {$errorCount} errors.");
        }

        return 0;
    }
}
