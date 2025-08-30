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
        // First, ensure all UUID and ooh_id values are populated
        $properties = \DB::table('properties')->get();
        foreach ($properties as $property) {
            if (empty($property->uuid)) {
                \DB::table('properties')
                    ->where('slug', $property->slug)
                    ->update(['uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString()]);
            }
            if (empty($property->ooh_id)) {
                \DB::table('properties')
                    ->where('slug', $property->slug)
                    ->update(['ooh_id' => \Illuminate\Support\Str::random(16)]);
            }
        }

        // Drop all foreign key constraints that reference properties table
        $foreignKeys = \DB::select('SELECT CONSTRAINT_NAME, TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = "properties"');
        
        foreach ($foreignKeys as $fk) {
            try {
                \DB::statement("ALTER TABLE {$fk->TABLE_NAME} DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
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

        try {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropForeign(['team_id']);
            });
        } catch (\Exception $e) {
            // Foreign key might not exist
        }

        // Now change the primary key structure
        Schema::table('properties', function (Blueprint $table) {
            // Add auto-incrementing integer ID
            $table->bigIncrements('new_id')->first();
            
            // Set the new integer ID as primary key
            $table->primary('new_id');
        });

        // Generate sequential IDs for existing records
        $properties = \DB::table('properties')->orderBy('created_at')->get();
        $counter = 1;
        foreach ($properties as $property) {
            \DB::table('properties')
                ->where('slug', $property->slug)
                ->update(['new_id' => $counter++]);
        }
        
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->renameColumn('new_id', 'id');
        });

        // Re-add foreign key constraints with new integer IDs
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('communications', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all foreign key constraints
        $foreignKeys = \DB::select('SELECT CONSTRAINT_NAME, TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = "properties"');
        
        foreach ($foreignKeys as $fk) {
            try {
                \DB::statement("ALTER TABLE {$fk->TABLE_NAME} DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        }

        Schema::table('properties', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
            try {
                $table->dropForeign(['team_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        });

        Schema::table('properties', function (Blueprint $table) {
            // Drop integer primary key
            $table->dropPrimary();
            $table->dropColumn('id');
            
            // Add back slug primary key
            $table->primary('slug');
        });

        // Re-add foreign key constraints
        Schema::table('visitor_signins', function (Blueprint $table) {
            $table->foreign('property_id')->references('slug')->on('properties')->onDelete('cascade');
        });

        Schema::table('communications', function (Blueprint $table) {
            $table->foreign('property_id')->references('slug')->on('properties')->onDelete('cascade');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->foreign('property_id')->references('slug')->on('properties')->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('property_id')->references('slug')->on('properties')->onDelete('cascade');
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
