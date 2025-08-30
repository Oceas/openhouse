<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop all foreign key constraints that reference properties table first
        $foreignKeys = \DB::select('SELECT CONSTRAINT_NAME, TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = "properties"');
        
        foreach ($foreignKeys as $fk) {
            try {
                \DB::statement("ALTER TABLE {$fk->TABLE_NAME} DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        }

        // Create new properties table with integer ID
        Schema::create('properties_new', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('ooh_id', 16)->unique(); // Open House ID for URLs
            
            // Basic Property Information
            $table->string('mls_number')->unique()->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('property_type'); // Single Family, Condo, Townhouse, etc.
            $table->string('status')->default('active'); // active, pending, sold, withdrawn

            // Address Information
            $table->string('street_address');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip_code', 10);
            $table->string('county')->nullable();
            $table->string('subdivision')->nullable();

            // Pricing
            $table->decimal('list_price', 12, 2);
            $table->decimal('original_price', 12, 2)->nullable();
            $table->string('price_per_sqft')->nullable();

            // Property Details
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('half_bathrooms')->default(0);
            $table->integer('total_bathrooms')->nullable();
            $table->integer('square_feet')->nullable();
            $table->integer('lot_size')->nullable(); // in square feet
            $table->string('lot_size_units')->default('sqft'); // sqft, acres
            $table->integer('year_built')->nullable();
            $table->string('garage_spaces')->nullable();
            $table->string('parking_spaces')->nullable();

            // Property Features
            $table->string('heating_type')->nullable();
            $table->string('cooling_type')->nullable();
            $table->string('appliances')->nullable();
            $table->string('flooring')->nullable();
            $table->string('roof_type')->nullable();
            $table->string('exterior_features')->nullable();
            $table->string('interior_features')->nullable();
            $table->string('community_features')->nullable();

            // MLS Specific Fields
            $table->string('listing_office')->nullable();
            $table->string('listing_agent')->nullable();
            $table->string('buyer_agent_commission')->nullable();
            $table->date('list_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('days_on_market')->nullable();
            $table->string('property_tax')->nullable();
            $table->string('hoa_fees')->nullable();
            $table->string('hoa_frequency')->nullable(); // monthly, quarterly, annually

            // Open House Information
            $table->boolean('has_open_house')->default(false);
            $table->datetime('open_house_start')->nullable();
            $table->datetime('open_house_end')->nullable();
            $table->text('open_house_notes')->nullable();

            // Media
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->string('video_url')->nullable();

            // SEO and Marketing
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('slug')->unique();

            // Agent Information - keep as string for now
            $table->string('user_id');
            $table->string('team_id')->nullable();
            $table->boolean('is_public')->default(true);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['status', 'property_type']);
            $table->index(['city', 'state']);
            $table->index(['list_price']);
            $table->index(['bedrooms', 'bathrooms']);
            $table->index(['square_feet']);
            $table->index('uuid');
            $table->index('ooh_id');
        });

        // Copy data from old table to new table
        $properties = \DB::table('properties')->get();
        $counter = 1;
        $propertyIdMap = []; // Map old UUID to new integer ID
        
        foreach ($properties as $property) {
            $uuid = $property->uuid ?: \Ramsey\Uuid\Uuid::uuid4()->toString();
            $oohId = $property->ooh_id ?: \Illuminate\Support\Str::random(16);
            
            \DB::table('properties_new')->insert([
                'id' => $counter,
                'uuid' => $uuid,
                'ooh_id' => $oohId,
                'mls_number' => $property->mls_number,
                'title' => $property->title,
                'description' => $property->description,
                'property_type' => $property->property_type,
                'status' => $property->status,
                'street_address' => $property->street_address,
                'city' => $property->city,
                'state' => $property->state,
                'zip_code' => $property->zip_code,
                'county' => $property->county,
                'subdivision' => $property->subdivision,
                'list_price' => $property->list_price,
                'original_price' => $property->original_price,
                'price_per_sqft' => $property->price_per_sqft,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'half_bathrooms' => $property->half_bathrooms,
                'total_bathrooms' => $property->total_bathrooms,
                'square_feet' => $property->square_feet,
                'lot_size' => $property->lot_size,
                'lot_size_units' => $property->lot_size_units,
                'year_built' => $property->year_built,
                'garage_spaces' => $property->garage_spaces,
                'parking_spaces' => $property->parking_spaces,
                'heating_type' => $property->heating_type,
                'cooling_type' => $property->cooling_type,
                'appliances' => $property->appliances,
                'flooring' => $property->flooring,
                'roof_type' => $property->roof_type,
                'exterior_features' => $property->exterior_features,
                'interior_features' => $property->interior_features,
                'community_features' => $property->community_features,
                'listing_office' => $property->listing_office,
                'listing_agent' => $property->listing_agent,
                'buyer_agent_commission' => $property->buyer_agent_commission,
                'list_date' => $property->list_date,
                'expiration_date' => $property->expiration_date,
                'days_on_market' => $property->days_on_market,
                'property_tax' => $property->property_tax,
                'hoa_fees' => $property->hoa_fees,
                'hoa_frequency' => $property->hoa_frequency,
                'has_open_house' => $property->has_open_house,
                'open_house_start' => $property->open_house_start,
                'open_house_end' => $property->open_house_end,
                'open_house_notes' => $property->open_house_notes,
                'featured_image' => $property->featured_image,
                'gallery_images' => $property->gallery_images,
                'virtual_tour_url' => $property->virtual_tour_url,
                'video_url' => $property->video_url,
                'meta_title' => $property->meta_title,
                'meta_description' => $property->meta_description,
                'slug' => $property->slug,
                'user_id' => $property->user_id,
                'team_id' => $property->team_id,
                'is_public' => $property->is_public,
                'latitude' => $property->latitude,
                'longitude' => $property->longitude,
                'created_at' => $property->created_at,
                'updated_at' => $property->updated_at,
            ]);
            
            // Store mapping from old UUID to new integer ID
            $propertyIdMap[$property->id] = $counter;
            $counter++;
        }

        // Drop old table and rename new table
        Schema::dropIfExists('properties');
        Schema::rename('properties_new', 'properties');

        // Update all tables that reference properties to use integer property_id
        $tablesToUpdate = ['visitor_signins', 'communications', 'deals', 'tasks'];
        
        foreach ($tablesToUpdate as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('property_id_new');
                });

                // Update property_id references
                $records = \DB::table($tableName)->get();
                foreach ($records as $record) {
                    $newPropertyId = $propertyIdMap[$record->property_id] ?? 1; // Default to property ID 1 if not found
                    
                    \DB::table($tableName)
                        ->where('id', $record->id)
                        ->update(['property_id_new' => $newPropertyId]);
                }

                // Drop old property_id column and rename new one
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('property_id');
                    $table->renameColumn('property_id_new', 'property_id');
                });
            }
        }

        // Add foreign key constraints
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('communications', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive migration, so we'll just drop the table
        // In a real scenario, you'd want to backup the data first
        Schema::dropIfExists('properties');
    }
};
