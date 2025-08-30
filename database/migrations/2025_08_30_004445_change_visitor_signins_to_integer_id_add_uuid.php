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
        Schema::table('visitor_signins', function (Blueprint $table) {
            // Add UUID column without unique constraint first
            $table->uuid('uuid')->nullable()->after('id');
            
            // Add index
            $table->index('uuid');
        });

        // Generate UUIDs for existing records
        $signins = \DB::table('visitor_signins')->get();
        foreach ($signins as $signin) {
            $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
            
            \DB::table('visitor_signins')
                ->where('id', $signin->id)
                ->update(['uuid' => $uuid]);
        }

        // Now add unique constraint after all records have values
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->unique('uuid');
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
            
            // Drop new columns
            $table->dropColumn('uuid');
        });
    }
};
