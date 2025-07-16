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
        Schema::create('educational_attainments', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the 'applicants' table
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('school');
            $table->string('educational_level'); // e.g., "High School", "Bachelor's Degree", "Master's Degree"
            $table->year('start_year')->nullable(); // Using 'year' type for 4-digit year
            $table->year('end_year')->nullable();   // Using 'year' type for 4-digit year
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_attainments');
    }
};
