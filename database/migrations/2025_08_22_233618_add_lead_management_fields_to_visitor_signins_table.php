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
            $table->enum('lead_status', ['new', 'contacted', 'qualified', 'showing_scheduled', 'offer_made', 'closed', 'lost'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->integer('contact_attempts')->default(0);
            $table->string('assigned_to')->nullable(); // User ID of assigned agent
            $table->decimal('lead_score', 3, 1)->default(0.0); // 0.0 to 10.0
            $table->json('interaction_history')->nullable(); // Store interaction history
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->dropColumn([
                'lead_status',
                'notes',
                'last_contacted_at',
                'next_follow_up_at',
                'contact_attempts',
                'assigned_to',
                'lead_score',
                'interaction_history'
            ]);
        });
    }
};
