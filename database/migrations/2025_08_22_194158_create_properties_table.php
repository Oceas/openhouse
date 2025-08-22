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
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();

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

            // Agent Information
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['status', 'property_type']);
            $table->index(['city', 'state']);
            $table->index(['list_price']);
            $table->index(['bedrooms', 'bathrooms']);
            $table->index(['square_feet']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
