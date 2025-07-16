<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $educationalAttainments = ['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'];
        $medicalStatuses = ['Pending', 'Fit To Work'];
        $applicantStatuses = ['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'];

        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 65),
            'profile_photo' => 'https://placehold.co/150x150/aabbcc/ffffff?text=Profile', // Placeholder image URL
            'curriculum_vitae' => 'https://example.com/cvs/' . Str::random(10) . '.pdf', // Placeholder document URL
            // 'working_experience' => $this->faker->paragraphs(rand(1, 3), true),
            // 'educational_attainment' => $this->faker->randomElement($educationalAttainments),
            'medical' => $this->faker->randomElement($medicalStatuses),
            'status' => $this->faker->randomElement($applicantStatuses),
        ];
    }
}
