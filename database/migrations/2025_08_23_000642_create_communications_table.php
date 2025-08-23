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
        Schema::create('communications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('client_id');
            $table->uuid('deal_id')->nullable();
            $table->uuid('property_id')->nullable();
            $table->enum('type', [
                'email',
                'phone',
                'text',
                'meeting',
                'showing',
                'open_house',
                'follow_up',
                'proposal',
                'contract',
                'other'
            ]);
            $table->enum('direction', ['inbound', 'outbound'])->default('outbound');
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->string('duration')->nullable(); // For calls/meetings
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('completed');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // Array of attachment URLs
            $table->string('external_id')->nullable(); // For email/calendar integration
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->index(['user_id', 'client_id']);
            $table->index(['user_id', 'type']);
            $table->index('scheduled_at');
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
