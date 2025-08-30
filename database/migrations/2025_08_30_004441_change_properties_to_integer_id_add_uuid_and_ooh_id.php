<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Add new columns first without unique constraint
            $table->uuid('uuid')->nullable()->after('id');
            $table->string('ooh_id', 16)->nullable()->after('uuid'); // Open House ID for URLs
            
            // Add indexes
            $table->index('uuid');
            $table->index('ooh_id');
        });

        // Generate UUIDs and ooh_ids for existing records
        $properties = \DB::table('properties')->get();
        foreach ($properties as $property) {
            $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
            $oohId = Str::random(16);
            
            \DB::table('properties')
                ->where('id', $property->id)
                ->update([
                    'uuid' => $uuid,
                    'ooh_id' => $oohId,
                ]);
        }

        // Now add unique constraints after all records have values
        Schema::table('properties', function (Blueprint $table) {
            $table->unique('uuid');
            $table->unique('ooh_id');
        });

        // Now change the primary key structure
        Schema::table('properties', function (Blueprint $table) {
            // Drop the UUID primary key
            $table->dropPrimary();
            
            // Add auto-incrementing integer ID
            $table->bigIncrements('new_id')->first();
            
            // Set the new integer ID as primary key
            $table->primary('new_id');
        });

        // Copy data from old id to new_id and drop old id
        \DB::statement('UPDATE properties SET new_id = CAST(id AS UNSIGNED)');
        
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->renameColumn('new_id', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Add back UUID primary key
            $table->uuid('old_id')->primary()->first();
            
            // Drop integer primary key
            $table->dropPrimary();
            $table->dropColumn('id');
            
            // Rename old_id back to id
            $table->renameColumn('old_id', 'id');
            
            // Drop new columns
            $table->dropColumn(['uuid', 'ooh_id']);
        });
    }
};
