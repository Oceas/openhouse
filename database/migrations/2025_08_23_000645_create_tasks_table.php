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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('client_id')->nullable();
            $table->uuid('deal_id')->nullable();
            $table->uuid('property_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', [
                'call',
                'email',
                'meeting',
                'showing',
                'follow_up',
                'proposal',
                'contract',
                'closing',
                'other'
            ])->default('other');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('assigned_to')->nullable(); // User ID of assigned agent
            $table->text('notes')->nullable();
            $table->json('reminders')->nullable(); // Array of reminder settings
            $table->json('custom_fields')->nullable(); // For additional custom data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'priority']);
            $table->index('due_date');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
