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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop the existing index
            $table->dropIndex(['user_id', 'stripe_status']);
            
            // Change the user_id column to uuid type
            $table->uuid('user_id')->change();
            
            // Re-add the index
            $table->index(['user_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop the index
            $table->dropIndex(['user_id', 'stripe_status']);
            
            // Change back to bigint
            $table->unsignedBigInteger('user_id')->change();
            
            // Re-add the index
            $table->index(['user_id', 'stripe_status']);
        });
    }
};
