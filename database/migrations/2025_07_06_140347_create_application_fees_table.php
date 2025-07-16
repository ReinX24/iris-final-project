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
        Schema::create('application_fees', function (Blueprint $table) {
            $table->id(); // Primary Key, Auto-incrementing

            // Paid fee is connected to an applicant
            $table->foreignId('applicant_id')->constrained('applicants')
                ->cascadeOnDelete();

            // Paid fee is connected to a job opening
            $table->foreignId('job_opening_id')->nullable()
                ->constrained('job_openings')
                ->nullOnDelete();

            $table->decimal('amount', 8, 2); // 123456.78
            $table->string('currency', 3)->default('PHP'); // PHP, USA

            // Date when the payment was made (should be as the record was made)
            $table->timestamp('payment_date')->nullable();
            $table->enum('payment_method', ['Cash', 'Bank Transfer', 'Credit Card', 'Online Gateway']);
            $table->text('notes')->nullable(); // Additional notes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_fees');
    }
};
