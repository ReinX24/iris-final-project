<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOpening>
 */
class JobOpeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->city(),
            // Dates and status will be set by the specific states below
            'date_needed' => Carbon::now()->addDays(rand(-30, 30)), // Default, will be adjusted by states
            'date_expiry' => Carbon::now()->addDays(rand(30, 90)),  // Default, will be adjusted by states
            'status' => 'status', // Default, will be adjusted by states
        ];
    }

    /**
     * Indicate that the job opening is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            // Ensure date_needed is before date_expiry, and date_expiry is in the future
            $dateNeeded = Carbon::now()->addDays(rand(-60, 0)); // Up to 60 days in the past or today
            $dateExpiry = Carbon::parse($dateNeeded)->addDays(rand(30, 180)); // At least 30 days after date_needed, up to 6 months in future

            // Ensure expiry is truly in the future relative to 'now' for active status
            if ($dateExpiry->isPast()) {
                $dateExpiry = Carbon::now()->addDays(rand(30, 180));
            }

            return [
                'date_needed' => $dateNeeded->format('Y-m-d'),
                'date_expiry' => $dateExpiry->format('Y-m-d'),
                'status' => 'active',
            ];
        });
    }

    /**
     * Indicate that the job opening is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            // For inactive, date_expiry can be null or in the future
            return [
                'date_needed' => Carbon::now()->addDays(rand(-30, 30))->format('Y-m-d'),
                'date_expiry' => $this->faker->boolean(30) ? null : Carbon::now()->addDays(rand(60, 365))->format('Y-m-d'), // 30% chance of null expiry
                'status' => 'inactive',
            ];
        });
    }

    /**
     * Indicate that the job opening is expired.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function expired()
    {
        return $this->state(function (array $attributes) {
            // Ensure date_needed is greater than date_expiry, and date_expiry is in the past
            $dateExpiry = Carbon::now()->subDays(rand(60, 180)); // 2 to 6 months in the past
            $dateNeeded = Carbon::parse($dateExpiry)->addDays(rand(1, 30)); // A few days after expiry, still in the past

            return [
                'date_needed' => $dateNeeded->format('Y-m-d'),
                'date_expiry' => $dateExpiry->format('Y-m-d'),
                'status' => 'expired',
            ];
        });
    }

    public function expiresToday()
    {
        return $this->state(function (array $attributes) {
            $dateExpiry = Carbon::today();
            $dateNeeded = Carbon::today();

            return [
                'date_needed' => $dateNeeded->format('Y-m-d'),
                'date_expiry' => $dateExpiry->format('Y-m-d'),
                'status' => 'active',
            ];
        });
    }
}
