<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\JobOpening;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationFee>
 */
class ApplicationFeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = ['Cash', 'Bank Transfer', 'Credit Card', 'Online Gateway'];

        // Get a random existing applicant ID
        $applicantId = Applicant::inRandomOrder()->first()->id ?? Applicant::factory()->create()->id;

        // Get a random existing job opening ID, or null
        $jobOpeningId = JobOpening::inRandomOrder()->first()->id ?? null;
        if ($this->faker->boolean(20)) { // 20% chance of not associating with a job
            $jobOpeningId = null;
        }

        return [
            'applicant_id' => $applicantId,
            'job_opening_id' => $jobOpeningId,
            'amount' => $this->faker->randomFloat(2, 50, 500), // Random amount between 50.00 and 500.00
            'currency' => 'PHP', // Default currency
            'payment_date' => $this->faker->boolean(80) ? $this->faker->dateTimeBetween('-1 year', 'now') : null, // 80% chance of having a payment date
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null, // 30% chance of having notes
        ];
    }
}
