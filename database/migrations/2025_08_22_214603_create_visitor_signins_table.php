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
        Schema::create('visitor_signins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('property_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('current_home_status')->nullable(); // own, rent, looking
            $table->string('timeline_to_buy')->nullable(); // immediately, 1-3 months, 3-6 months, 6+ months
            $table->decimal('budget_min', 12, 2)->nullable();
            $table->decimal('budget_max', 12, 2)->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('source')->nullable(); // how they found the property
            $table->boolean('interested_in_similar_properties')->default(false);
            $table->boolean('interested_in_financing_info')->default(false);
            $table->boolean('interested_in_market_analysis')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('signed_in_at');
            $table->timestamps();

            // Indexes for performance
            $table->index(['property_id', 'signed_in_at']);
            $table->index('email');
            $table->index('signed_in_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_signins');
    }
};
