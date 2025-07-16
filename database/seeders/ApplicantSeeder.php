<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\JobOpening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (JobOpening::count() === 0) {
            $this->call(JobOpeningSeeder::class);
        }

        $jobOpeningIds = JobOpening::pluck('id')->all();

        Applicant::factory()->count(50)->create()->each(function ($applicant) use ($jobOpeningIds) {
            if (!empty($jobOpeningIds)) {
                $randomJobIds = collect($jobOpeningIds)->random(rand(1, min(3, count($jobOpeningIds))));
                $applicant->jobOpenings()->attach($randomJobIds);
            }
        });

        $this->command->info('Created 50 applicant records and attached them to job openings.');

        // Create 50 applicant records using the factory
        // Applicant::factory(50)->create();

        // $this->command->info('Created 50 applicant records.');
    }
}
