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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name (String)
            $table->integer('age'); // Age (Integer)
            $table->string('profile_photo')->nullable(); // Profile Photo (String - assuming URL or path, nullable)
            $table->string('curriculum_vitae')->nullable(); // Curriculum Vitae (Document - assuming URL or path, nullable)
            // $table->text('working_experience')->nullable(); // Working Experience (Text, nullable)
            // $table->enum('educational_attainment', ['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral']); // Educational Attainment (Enum)
            $table->enum('medical', ['Pending', 'Fit To Work'])->default('Pending'); // Medical (Enum, default to Pending)
            $table->enum('status', ['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'])->default('Line Up'); // Status (Enum, default to Line Up)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
