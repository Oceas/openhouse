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
        Schema::create('deals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('client_id');
            $table->uuid('property_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['buy', 'sell', 'rent'])->default('buy');
            $table->enum('stage', [
                'prospecting',
                'qualification',
                'proposal',
                'negotiation',
                'closing',
                'closed_won',
                'closed_lost'
            ])->default('prospecting');
            $table->decimal('value', 15, 2)->nullable(); // Deal value
            $table->decimal('commission_rate', 5, 2)->nullable(); // Commission percentage
            $table->decimal('commission_amount', 12, 2)->nullable(); // Calculated commission
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            $table->decimal('probability', 5, 2)->default(0.0); // 0-100%
            $table->string('source')->nullable(); // How the deal came about
            $table->text('notes')->nullable();
            $table->json('activities')->nullable(); // Array of activities
            $table->string('assigned_to')->nullable(); // User ID of assigned agent
            $table->json('custom_fields')->nullable(); // For additional custom data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->index(['user_id', 'stage']);
            $table->index(['user_id', 'type']);
            $table->index('expected_close_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
