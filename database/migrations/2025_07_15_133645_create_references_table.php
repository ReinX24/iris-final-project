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
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the 'applicants' table
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->string('name'); // Name of the reference person
            $table->string('email')->nullable(); // Email address of the reference (optional)
            $table->string('phone_number')->nullable(); // Phone number of the reference (optional)
            $table->string('company'); // Company where the reference works
            $table->string('role'); // Role of the reference at the company
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('references');
    }
};
