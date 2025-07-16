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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the 'applicants' table
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->string('company_name'); // Renamed from 'Location' to be more specific for work
            $table->string('role');
            $table->year('start_year'); // Using 'year' type for 4-digit year
            $table->year('end_year')->nullable(); // Using 'year' type, nullable for current jobs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
