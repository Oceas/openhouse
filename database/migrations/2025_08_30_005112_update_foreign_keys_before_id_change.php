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
        // Drop foreign key constraints that reference the properties table
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });

        // Drop foreign key constraints that reference the properties table from other tables
        // Check if teams table has properties foreign key
        if (Schema::hasTable('teams')) {
            try {
                Schema::table('properties', function (Blueprint $table) {
                    $table->dropForeign(['team_id']);
                });
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        }

        // Drop foreign key constraints that reference the users table
        try {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        } catch (\Exception $e) {
            // Foreign key might not exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add foreign key constraints
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        if (Schema::hasTable('teams')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            });
        }
    }
};
