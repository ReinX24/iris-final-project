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
        // Create the 'admin_action_logs' table
        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->id(); // Primary key
            // Foreign key to the 'users' table, representing the admin who performed the action.
            // It's nullable and set to null on admin deletion to preserve the log entry.
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action_type'); // Stores the type of action (e.g., 'user_created', 'user_updated')
            // Polymorphic relationship columns:
            // 'target_id' stores the ID of the affected model (e.g., the user's ID).
            // 'target_type' stores the full class name of the affected model (e.g., 'App\Models\User').
            $table->morphs('target');
            $table->json('details')->nullable(); // Stores additional action-specific details as JSON
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'admin_action_logs' table if the migration is rolled back
        Schema::dropIfExists('admin_action_logs');
    }
};
