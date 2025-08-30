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
        // First, ensure all UUID values are populated
        $signins = \DB::table('visitor_signins')->get();
        foreach ($signins as $signin) {
            if (empty($signin->uuid)) {
                \DB::table('visitor_signins')
                    ->where('id', $signin->id)
                    ->update(['uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString()]);
            }
        }

        // Add unique constraint if it doesn't exist
        Schema::table('visitor_signins', function (Blueprint $table) {
            try {
                $table->unique('uuid');
            } catch (\Exception $e) {
                // Constraint might already exist
            }
        });

        // Now change the primary key structure
        Schema::table('visitor_signins', function (Blueprint $table) {
            // Drop the UUID primary key
            $table->dropPrimary();
            
            // Add auto-incrementing integer ID
            $table->bigIncrements('new_id')->first();
            
            // Set the new integer ID as primary key
            $table->primary('new_id');
        });

        // Copy data from old id to new_id and drop old id
        \DB::statement('UPDATE visitor_signins SET new_id = CAST(id AS UNSIGNED)');
        
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->renameColumn('new_id', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_signins', function (Blueprint $table) {
            // Add back UUID primary key
            $table->uuid('old_id')->primary()->first();
            
            // Drop integer primary key
            $table->dropPrimary();
            $table->dropColumn('id');
            
            // Rename old_id back to id
            $table->renameColumn('old_id', 'id');
        });
    }
};
