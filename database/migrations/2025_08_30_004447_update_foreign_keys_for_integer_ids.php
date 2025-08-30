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
        // Update visitor_signins.property_id foreign key
        Schema::table('visitor_signins', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['property_id']);
            
            // Change the column type to bigInteger
            $table->unsignedBigInteger('property_id')->change();
            
            // Add the foreign key constraint back
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        // Update properties.user_id foreign key
        Schema::table('properties', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Change the column type to bigInteger
            $table->unsignedBigInteger('user_id')->change();
            
            // Add the foreign key constraint back
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Update properties.team_id foreign key
        Schema::table('properties', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['team_id']);
            
            // Change the column type to bigInteger
            $table->unsignedBigInteger('team_id')->change();
            
            // Add the foreign key constraint back
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });

        // Update visitor_signins.team_id foreign key (if it exists)
        if (Schema::hasColumn('visitor_signins', 'team_id')) {
            Schema::table('visitor_signins', function (Blueprint $table) {
                // Drop the existing foreign key constraint
                $table->dropForeign(['team_id']);
                
                // Change the column type to bigInteger
                $table->unsignedBigInteger('team_id')->change();
                
                // Add the foreign key constraint back
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert visitor_signins.property_id foreign key
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->uuid('property_id')->change();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        // Revert properties.user_id foreign key
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->uuid('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Revert properties.team_id foreign key
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->uuid('team_id')->change();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });

        // Revert visitor_signins.team_id foreign key (if it exists)
        if (Schema::hasColumn('visitor_signins', 'team_id')) {
            Schema::table('visitor_signins', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
                $table->uuid('team_id')->change();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            });
        }
    }
};
